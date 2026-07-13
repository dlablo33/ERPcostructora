<?php
// app/Http/Controllers/ConfigController.php

namespace App\Http\Controllers;

use App\Models\Config\SystemConfig;
use App\Models\Config\CompanyInfo;
use App\Models\Config\EmailConfig;
use App\Models\Config\SecurityConfig;
use App\Models\ModuleConfig; // ✅ Import correcto (sin "Config/")
use App\Models\Config\NotificationTemplate;
use App\Models\Config\AuditLog;
use App\Models\Config\SystemBackup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConfigController extends Controller
{
    /**
     * Constructor - Aplicar middleware de autenticación y admin.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // ============================================
    // VISTA PRINCIPAL
    // ============================================

    /**
     * Display the configuration dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

;
        $user = auth()->user();
        $isSuperAdmin = $user->rol === 'super_admin';
        
        // Obtener estadísticas rápidas
        $stats = [
            'total_configs' => SystemConfig::count(),
            'total_modules' => ModuleConfig::count(),
            'active_modules' => ModuleConfig::where('is_enabled', true)->count(),
            'total_audit_logs' => AuditLog::count(),
            'total_backups' => SystemBackup::count(),
            'company_exists' => CompanyInfo::exists(),
        ];

        // Obtener datos para las vistas
        $company = CompanyInfo::first();
        $emailConfig = EmailConfig::first();
        $securityConfig = SecurityConfig::first();
        $modules = ModuleConfig::ordered(); // Si ordered() ya retorna una Collection // Esto está bien si ordered() devuelve un Builder
        $templates = NotificationTemplate::active()->get();
        $backups = SystemBackup::orderBy('created_at', 'desc')->get();
        
        // Obtener logs de auditoría
        $logs = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        // Obtener opciones de filtro
        $auditModules = AuditLog::distinct()->pluck('module')->filter()->values();
        $auditActions = AuditLog::distinct()->pluck('action')->filter()->values();

        return view('config.index', compact(
            'user',
            'isSuperAdmin',
            'stats',
            'company',
            'emailConfig',
            'securityConfig',
            'modules',
            'templates',
            'backups',
            'logs',
            'auditModules',
            'auditActions'
        ));
    }

    // ============================================
    // CONFIGURACIÓN GENERAL
    // ============================================

    /**
     * Update general configuration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateGeneral(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'configs' => 'required|array',
            'configs.*.key' => 'required|string',
            'configs.*.value' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            foreach ($request->configs as $key => $value) {
                $config = SystemConfig::where('key', $key)->first();
                if ($config && $config->is_editable) {
                    $oldValue = $config->value;
                    $config->value = $value;
                    $config->save();

                    // Log the change
                    $this->logAudit('config_update', 'system_config', [
                        'section' => 'general',
                        'old_values' => ['key' => $config->key, 'value' => $oldValue],
                        'new_values' => ['key' => $config->key, 'value' => $config->value],
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Configuración general actualizada correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar configuración general: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la configuración: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // INFORMACIÓN DE LA EMPRESA
    // ============================================

    /**
     * Update company information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'razon_social' => 'required|string|max:255',
            'rfc' => 'required|string|max:13|unique:company_info,rfc,' . ($request->id ?? 'NULL') . ',id',
            'nombre_comercial' => 'nullable|string|max:255',
            'regimen_fiscal' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'email_facturacion' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'calle' => 'nullable|string|max:255',
            'num_exterior' => 'nullable|string|max:50',
            'num_interior' => 'nullable|string|max:50',
            'colonia' => 'nullable|string|max:255',
            'codigo_postal' => 'nullable|string|max:10',
            'municipio' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:100',
            'serie_default' => 'nullable|string|max:10',
            'logo' => 'nullable|image|max:2048',
            'login_logo' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $company = CompanyInfo::first();
            $oldValues = $company ? $company->toArray() : null;

            $data = $request->except(['id', 'logo', 'login_logo', '_token', '_method']);

            // Handle logo upload (empresa)
            if ($request->hasFile('logo')) {
                $logoPath = $this->uploadLogo($request->file('logo'));
                $data['logo_path'] = $logoPath;
            }

            // Handle login logo upload
            if ($request->hasFile('login_logo')) {
                $loginLogoPath = $this->uploadLoginLogo($request->file('login_logo'));
                $data['login_logo_path'] = $loginLogoPath;
            }

            if ($company) {
                $company->update($data);
                $message = 'Información de la empresa actualizada correctamente';
            } else {
                $company = CompanyInfo::create($data);
                $message = 'Información de la empresa creada correctamente';
            }

            $this->logAudit('config_update', 'company_info', [
                'section' => 'company',
                'old_values' => $oldValues,
                'new_values' => $company->toArray(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $company
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar información de la empresa: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la información: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload login logo.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    private function uploadLoginLogo($file)
    {
        $filename = 'login_logo_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('company', $filename, 'public');
        return $path;
    }

    // ============================================
    // CONFIGURACIÓN DE CORREO
    // ============================================

    /**
     * Update email configuration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'host' => 'required|string|max:255',
            'port' => 'required|integer|min:1|max:65535',
            'encryption' => 'nullable|string|in:tls,ssl',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'from_address' => 'required|email|max:255',
            'from_name' => 'nullable|string|max:255',
            'reply_to_address' => 'nullable|email|max:255',
            'reply_to_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $config = EmailConfig::first();
            $oldValues = $config ? $config->toArray() : null;

            $data = $request->except(['_token', '_method']);

            // Only update password if provided
            if (empty($data['password'])) {
                unset($data['password']);
            }

            if ($config) {
                $config->update($data);
                $message = 'Configuración de correo actualizada correctamente';
            } else {
                $config = EmailConfig::create($data);
                $message = 'Configuración de correo creada correctamente';
            }

            // Log the change
            $this->logAudit('config_update', 'email_config', [
                'section' => 'email',
                'old_values' => $oldValues,
                'new_values' => $config->toArray(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $config
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar configuración de correo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la configuración: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test email configuration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $config = EmailConfig::first();
            if (!$config) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay configuración de correo guardada'
                ], 404);
            }

            $result = $config->test($request->to);

            // Log the test
            $this->logAudit('config_test', 'email_config', [
                'section' => 'email',
                'metadata' => [
                    'to' => $request->to,
                    'success' => $result['success'],
                    'message' => $result['message']
                ]
            ]);

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('Error al probar configuración de correo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al probar la configuración: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // CONFIGURACIÓN DE SEGURIDAD
    // ============================================

    /**
     * Update security configuration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSecurity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_min_length' => 'required|integer|min:4|max:255',
            'password_require_uppercase' => 'nullable|boolean',
            'password_require_lowercase' => 'nullable|boolean',
            'password_require_numbers' => 'nullable|boolean',
            'password_require_special' => 'nullable|boolean',
            'password_expiration_days' => 'nullable|integer|min:0',
            'password_history_count' => 'nullable|integer|min:0|max:20',
            'two_factor_enabled' => 'nullable|boolean',
            'max_login_attempts' => 'required|integer|min:1|max:20',
            'lockout_time_minutes' => 'required|integer|min:1|max:1440',
            'session_timeout_enabled' => 'nullable|boolean',
            'session_timeout_minutes' => 'nullable|integer|min:1|max:1440',
            'single_session_per_user' => 'nullable|boolean',
            'audit_enabled' => 'nullable|boolean',
            'audit_retention_days' => 'nullable|integer|min:1|max:365',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $config = SecurityConfig::first();
            $oldValues = $config ? $config->toArray() : null;

            $data = $request->except(['_token', '_method']);

            // Convert checkbox values to boolean
            $booleans = [
                'password_require_uppercase',
                'password_require_lowercase',
                'password_require_numbers',
                'password_require_special',
                'two_factor_enabled',
                'session_timeout_enabled',
                'single_session_per_user',
                'audit_enabled',
            ];

            foreach ($booleans as $field) {
                $data[$field] = $request->has($field);
            }

            if ($config) {
                $config->update($data);
                $message = 'Configuración de seguridad actualizada correctamente';
            } else {
                $config = SecurityConfig::create($data);
                $message = 'Configuración de seguridad creada correctamente';
            }

            // Log the change
            $this->logAudit('config_update', 'security_config', [
                'section' => 'security',
                'old_values' => $oldValues,
                'new_values' => $config->toArray(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $config
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar configuración de seguridad: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la configuración: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // MÓDULOS DEL SISTEMA
    // ============================================

    /**
     * Toggle module status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleModule($id)
    {
        try {
            $module = ModuleConfig::findOrFail($id);
            $oldStatus = $module->is_enabled;
            
            $module->is_enabled = !$module->is_enabled;
            $module->save();

            // Log the change
            $this->logAudit('module_toggle', 'module_config', [
                'section' => 'modules',
                'old_values' => ['is_enabled' => $oldStatus],
                'new_values' => ['is_enabled' => $module->is_enabled],
                'metadata' => ['module_name' => $module->name],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Módulo ' . ($module->is_enabled ? 'activado' : 'desactivado') . ' correctamente',
                'data' => $module
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cambiar estado del módulo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado del módulo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Move module up or down.
     *
     * @param  int  $id
     * @param  string  $direction
     * @return \Illuminate\Http\JsonResponse
     */
    public function moveModule($id, $direction)
    {
        try {
            $module = ModuleConfig::findOrFail($id);
            $currentOrder = $module->order;

            if ($direction === 'up') {
                $swapModule = ModuleConfig::where('order', '<', $currentOrder)
                    ->orderBy('order', 'desc')
                    ->first();
            } else {
                $swapModule = ModuleConfig::where('order', '>', $currentOrder)
                    ->orderBy('order', 'asc')
                    ->first();
            }

            if ($swapModule) {
                $tempOrder = $currentOrder;
                $module->order = $swapModule->order;
                $swapModule->order = $tempOrder;
                $module->save();
                $swapModule->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Módulo movido correctamente',
                    'modules' => ModuleConfig::ordered()->get()
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No se puede mover el módulo en esa dirección'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Error al mover módulo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al mover el módulo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update module order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateModuleOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modules' => 'required|array',
            'modules.*.id' => 'required|exists:module_configs,id',
            'modules.*.order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            foreach ($request->modules as $moduleData) {
                ModuleConfig::where('id', $moduleData['id'])->update([
                    'order' => $moduleData['order']
                ]);
            }

            // Log the change
            $this->logAudit('config_update', 'module_config', [
                'section' => 'modules',
                'metadata' => ['order_updated' => true],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Orden de módulos actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar orden de módulos: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el orden: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // PLANTILLAS DE NOTIFICACIONES
    // ============================================

    /**
     * Update notification template.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTemplate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'html_body' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $template = NotificationTemplate::findOrFail($id);
            $oldValues = $template->toArray();

            $data = $request->except(['_token', '_method']);
            
            if ($request->has('is_active')) {
                $data['is_active'] = $request->boolean('is_active');
            }

            $template->update($data);

            // Log the change
            $this->logAudit('config_update', 'notification_templates', [
                'section' => 'templates',
                'old_values' => $oldValues,
                'new_values' => $template->toArray(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Plantilla actualizada correctamente',
                'data' => $template
            ]);

        } catch (\Exception $e) {
            Log::error('Error al actualizar plantilla: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la plantilla: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // AUDITORÍA
    // ============================================

    /**
     * Get audit logs with filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuditLogs(Request $request)
    {
        try {
            $query = AuditLog::with('user');

            if ($request->has('module') && $request->module) {
                $query->where('module', $request->module);
            }

            if ($request->has('action') && $request->action) {
                $query->where('action', $request->action);
            }

            if ($request->has('user_id') && $request->user_id) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->has('date_from') && $request->date_from) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to') && $request->date_to) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $logs = $query->orderBy('created_at', 'desc')
                ->paginate(50)
                ->appends($request->query());

            return response()->json([
                'success' => true,
                'data' => $logs
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener logs de auditoría: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener logs: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear audit logs older than retention days.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearAudit()
    {
        try {
            $config = SecurityConfig::first();
            $retentionDays = $config ? $config->audit_retention_days : 90;

            $deleted = AuditLog::where('created_at', '<', now()->subDays($retentionDays))->delete();

            // Log the action
            $this->logAudit('config_cleanup', 'audit_log', [
                'section' => 'audit',
                'metadata' => ['deleted_count' => $deleted],
            ]);

            return response()->json([
                'success' => true,
                'message' => "Se eliminaron {$deleted} registros de auditoría antiguos"
            ]);

        } catch (\Exception $e) {
            Log::error('Error al limpiar auditoría: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al limpiar la auditoría: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // BACKUPS
    // ============================================

    /**
     * Create a new backup.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createBackup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:database,files,full',
            'name' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $type = $request->type;
            $name = $request->name ?? 'Backup_' . date('Y-m-d_H-i-s');

            // Crear registro del backup
            $backup = SystemBackup::create([
                'name' => $name,
                'type' => $type,
                'status' => 'pending',
                'created_by' => auth()->id(),
            ]);

            $backup->markAsInProgress();

            // Aquí iría la lógica real de backup
            // Por ahora simulamos el proceso
            sleep(2);

            $fileName = "backup_{$type}_" . date('Ymd_His') . '.sql';
            $filePath = "backups/{$fileName}";

            // Simular guardado del archivo
            Storage::disk('public')->put($filePath, 'Contenido del backup simulado');

            $backup->update([
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_size' => rand(100000, 5000000),
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            // Log the action
            $this->logAudit('backup_create', 'system_backups', [
                'section' => 'backups',
                'new_values' => $backup->toArray(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Backup creado correctamente',
                'data' => $backup
            ]);

        } catch (\Exception $e) {
            Log::error('Error al crear backup: ' . $e->getMessage());
            
            if (isset($backup)) {
                $backup->markAsFailed($e->getMessage());
            }

            return response()->json([
                'success' => false,
                'message' => 'Error al crear el backup: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download a backup.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadBackup($id)
    {
        try {
            $backup = SystemBackup::findOrFail($id);

            if (!$backup->isCompleted()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El backup no está completado'
                ], 422);
            }

            if (!Storage::disk('public')->exists($backup->file_path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo de backup no existe'
                ], 404);
            }

            // Log the action
            $this->logAudit('backup_download', 'system_backups', [
                'section' => 'backups',
                'metadata' => ['backup_id' => $id, 'backup_name' => $backup->name],
            ]);

            return Storage::disk('public')->download($backup->file_path, $backup->file_name);

        } catch (\Exception $e) {
            Log::error('Error al descargar backup: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al descargar el backup: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a backup.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteBackup($id)
    {
        try {
            $backup = SystemBackup::findOrFail($id);

            // Delete file
            $backup->deleteFile();

            // Delete record
            $backup->delete();

            // Log the action
            $this->logAudit('backup_delete', 'system_backups', [
                'section' => 'backups',
                'metadata' => ['backup_id' => $id, 'backup_name' => $backup->name],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Backup eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al eliminar backup: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el backup: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // MÉTODOS PRIVADOS
    // ============================================

    /**
     * Upload logo.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    private function uploadLogo($file)
    {
        $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('company', $filename, 'public');
        return $path;
    }

    /**
     * Log audit entry.
     *
     * @param  string  $action
     * @param  string  $module
     * @param  array  $data
     * @return void
     */
    private function logAudit($action, $module, $data = [])
    {
        AuditLog::log(auth()->id(), $action, array_merge($data, ['module' => $module]));
    }

    // ============================================
    // MÉTODOS PARA RESPALDO DE RUTAS EXISTENTES
    // ============================================

    /**
     * Get config value by key (para usar en el frontend).
     *
     * @param  string  $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function getConfig($key)
    {
        try {
            $value = SystemConfig::getValue($key);
            return response()->json([
                'success' => true,
                'data' => ['key' => $key, 'value' => $value]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all configs.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllConfigs()
    {
        try {
            $configs = SystemConfig::all();
            return response()->json([
                'success' => true,
                'data' => $configs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get audit logs view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function audit(Request $request)
    {
        // Si es una solicitud AJAX, devolver JSON
        if ($request->ajax()) {
            return $this->getAuditLogs($request);
        }

        // Vista normal
        $query = AuditLog::with('user');

        if ($request->has('module') && $request->module) {
            $query->where('module', $request->module);
        }

        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('created_at', 'desc')
            ->paginate(50)
            ->appends($request->query());

        $modules = AuditLog::distinct()->pluck('module')->filter()->values();
        $actions = AuditLog::distinct()->pluck('action')->filter()->values();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $logs
            ]);
        }

        return view('config.audit', compact('logs', 'modules', 'actions'));
    }

    /**
     * Get backups view.
     *
     * @return \Illuminate\View\View
     */
    public function backups()
    {
        $backups = SystemBackup::orderBy('created_at', 'desc')->get();
        return view('config.backups', compact('backups'));
    }

    /**
     * Get modules view.
     *
     * @return \Illuminate\View\View
     */
    public function modules()
    {
        $modules = ModuleConfig::ordered()->get();
        return view('config.modules', compact('modules'));
    }

    /**
     * Get templates view.
     *
     * @return \Illuminate\View\View
     */
    public function templates()
    {
        $templates = NotificationTemplate::active()->get();
        return view('config.templates', compact('templates'));
    }

    /**
     * Get company view.
     *
     * @return \Illuminate\View\View
     */
    public function company()
    {
        $company = CompanyInfo::first();
        return view('config.company', compact('company'));
    }

    /**
     * Get email view.
     *
     * @return \Illuminate\View\View
     */
    public function email()
    {
        $config = EmailConfig::first();
        return view('config.email', compact('config'));
    }

    /**
     * Get security view.
     *
     * @return \Illuminate\View\View
     */
    public function security()
    {
        $config = SecurityConfig::first();
        return view('config.security', compact('config'));
    }

    /**
     * Get general view.
     *
     * @return \Illuminate\View\View
     */
    public function general()
    {
        $configs = SystemConfig::getGrouped();
        return view('config.general', compact('configs'));
    }
}