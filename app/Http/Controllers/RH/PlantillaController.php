<?php

namespace App\Http\Controllers\RH;

use App\Models\Plantilla;
use App\Models\Area;
use App\Models\Puesto;
use App\Models\EmpleadoDocumento;
use App\Models\CatTipoOperador;
use App\Models\CatTipoLicencia;
use App\Models\CatBanco;
use App\Models\CatTipoCuenta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RH\PlantillaRequest;
use App\Exports\PlantillaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PlantillaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Obtener plantillas con el scope DataGrid
            $plantillas = Plantilla::dataGrid()->get();
            
            $totalPlantillas = $plantillas->count();
            $activos = $plantillas->whereIn('estatus', ['1', 'Activo'])->count();
            $inactivos = $plantillas->whereIn('estatus', ['0', 'Inactivo', 'Baja'])->count();

            // Obtener áreas para el select
            $areas = Area::whereNull('deleted_at')
                        ->orderBy('nombre')
                        ->get(['id', 'nombre', 'folio']);

            // Obtener puestos con sus áreas relacionadas
            $puestos = Puesto::with('area')
                            ->whereNull('deleted_at')
                            ->orderBy('nombre')
                            ->get(['id', 'nombre', 'area_id', 'folio']);

            // Obtener catálogos adicionales
            $tiposOperador = CatTipoOperador::where('activo', true)
                                            ->where('borrado_logico', false)
                                            ->get();
            $tiposLicencia = CatTipoLicencia::where('activo', true)
                                            ->where('borrado_logico', false)
                                            ->get();
            $bancos = CatBanco::activos()
                              ->ordenado('nombre_corto')
                              ->get();
            $tiposCuenta = CatTipoCuenta::activos()
                                        ->orderBy('descripcion')
                                        ->get();

            Log::info('PlantillaController@index - Datos cargados', [
                'plantillas_count' => $plantillas->count(),
                'areas_count' => $areas->count(),
                'puestos_count' => $puestos->count(),
                'bancos_count' => $bancos->count(),
                'tipos_cuenta_count' => $tiposCuenta->count()
            ]);

            // Si es petición API
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'plantillas' => $plantillas,
                        'totalPlantillas' => $totalPlantillas,
                        'activos' => $activos,
                        'inactivos' => $inactivos,
                        'areas' => $areas,
                        'puestos' => $puestos,
                        'tiposOperador' => $tiposOperador,
                        'tiposLicencia' => $tiposLicencia,
                        'bancos' => $bancos,
                        'tiposCuenta' => $tiposCuenta
                    ]
                ]);
            }

            // Vista web
            return view('rh.gestion.plantilla', compact(
                'plantillas', 
                'totalPlantillas', 
                'activos', 
                'inactivos',
                'areas',
                'puestos',
                'tiposOperador',
                'tiposLicencia',
                'bancos',
                'tiposCuenta'
            ));

        } catch (\Exception $e) {
            Log::error('Error en PlantillaController@index: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar los datos: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cargar los datos: ' . $e->getMessage());
        }
    }

    /**
     * Get all areas for select (API)
     */
    public function getAreas(Request $request)
    {
        try {
            $areas = Area::whereNull('deleted_at')
                        ->orderBy('nombre')
                        ->get(['id', 'nombre', 'folio']);

            Log::info('Áreas obtenidas vía API:', ['count' => $areas->count()]);

            return response()->json([
                'success' => true,
                'data' => $areas
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener áreas: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar áreas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all bancos for select (API)
     */
    public function getBancos(Request $request)
    {
        try {
            $bancos = CatBanco::activos()
                              ->ordenado('nombre_corto')
                              ->get(['clave', 'nombre_corto', 'descripcion']);

            Log::info('Bancos obtenidos vía API:', ['count' => $bancos->count()]);

            return response()->json([
                'success' => true,
                'data' => $bancos
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener bancos: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar bancos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all tipos de cuenta for select (API)
     */
    public function getTiposCuenta(Request $request)
    {
        try {
            $tiposCuenta = CatTipoCuenta::activos()
                                        ->orderBy('descripcion')
                                        ->get(['cat_tipo_cuenta_id', 'descripcion', 'clave_sat']);

            Log::info('Tipos de cuenta obtenidos vía API:', ['count' => $tiposCuenta->count()]);

            return response()->json([
                'success' => true,
                'data' => $tiposCuenta
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener tipos de cuenta: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar tipos de cuenta: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all coordinadores for select
     */
    public function getCoordinadores(Request $request)
    {
        try {
            $coordinadores = Plantilla::select('plantilla_id', 'nombre', 'apellido_paterno', 'apellido_materno')
                ->whereNull('deleted_at')
                ->where('estatus', 'Activo')
                ->get()
                ->map(function($item) {
                    $item->nombre_completo = trim($item->nombre . ' ' . $item->apellido_paterno . ' ' . $item->apellido_materno);
                    return $item;
                });

            return response()->json([
                'success' => true,
                'data' => $coordinadores
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener coordinadores: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar coordinadores: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            Log::info('=== INICIO CREACIÓN EMPLEADO ===');
            Log::info('Datos recibidos:', $request->all());
            
            // Obtener datos del request
            $data = $this->prepareData($request);
            
            Log::info('Datos preparados para guardar:', $data);
            
            // Crear empleado
            $plantilla = Plantilla::create($data);
            
            // Procesar documentos
            $this->processDocuments($request, $plantilla);
            
            DB::commit();
            
            Log::info('Empleado creado exitosamente:', ['id' => $plantilla->plantilla_id]);
            
            if ($request->wantsJson() || $request->is('api/*')) {
                $plantilla->load([
                    'area', 
                    'puesto', 
                    'documentos', 
                    'tipoOperador', 
                    'tipoLicencia', 
                    'banco', 
                    'tipoCuenta',
                    'coordinador'
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Empleado creado exitosamente',
                    'data' => $plantilla
                ], 201);
            }
            
            return redirect()->route('plantilla.index')
                ->with('success', 'Empleado creado exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::warning('Error de validación al crear empleado:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear empleado: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el empleado: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al crear el empleado: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        try {
            Log::info('Mostrando empleado ID: ' . $id);
            
            $plantilla = Plantilla::with([
                'area', 
                'puesto', 
                'documentos',
                'tipoOperador',
                'tipoLicencia',
                'banco',
                'tipoCuenta',
                'coordinador',
                'pais',
                'estadoRel',
                'municipioRel',
                'colonia',
                'localidad',
                'codigoPostal',
                'tipoContrato',
                'tipoJornada',
                'periodicidadPago',
                'regimen'
            ])->find($id);
            
            if (!$plantilla) {
                Log::error('Empleado no encontrado con ID: ' . $id);
                
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Empleado no encontrado'
                    ], 404);
                }
                
                return abort(404, 'Empleado no encontrado');
            }
            
            // Log para depuración
            Log::info('Datos del empleado cargados:', [
                'id' => $plantilla->plantilla_id,
                'banco' => $plantilla->banco?->nombre_corto,
                'tipo_cuenta' => $plantilla->tipoCuenta?->descripcion,
                'area' => $plantilla->area?->nombre,
                'puesto' => $plantilla->puesto?->nombre
            ]);
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $plantilla
                ]);
            }
            
            return view('rh.gestion.plantilla-show', compact('plantilla'));
            
        } catch (\Exception $e) {
            Log::error('Error al mostrar empleado: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar el empleado: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al cargar el empleado: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            Log::info('=== INICIO ACTUALIZACIÓN EMPLEADO ===');
            Log::info('ID recibido: ' . $id);
            Log::info('Datos recibidos:', $request->all());
            
            if (is_numeric($id)) {
                $id = (int) $id;
            }
            
            $plantilla = Plantilla::find($id);
            
            if (!$plantilla) {
                Log::error('Empleado no encontrado con ID: ' . $id);
                
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Empleado no encontrado'
                    ], 404);
                }
                
                return back()->with('error', 'Empleado no encontrado');
            }
            
            // Preparar datos
            $data = $this->prepareData($request);
            
            // Actualizar empleado
            $plantilla->update($data);
            
            // Procesar nuevos documentos
            $this->processDocuments($request, $plantilla);
            
            DB::commit();
            
            Log::info('Empleado actualizado exitosamente');
            
            if ($request->wantsJson() || $request->is('api/*')) {
                $plantilla->load([
                    'area', 
                    'puesto', 
                    'documentos', 
                    'tipoOperador', 
                    'tipoLicencia', 
                    'banco', 
                    'tipoCuenta',
                    'coordinador'
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Empleado actualizado exitosamente',
                    'data' => $plantilla
                ]);
            }
            
            return redirect()->route('plantilla.index')
                ->with('success', 'Empleado actualizado exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::warning('Error de validación al actualizar empleado:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar empleado: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el empleado: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al actualizar el empleado: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            Log::info('=== INICIO ELIMINACIÓN EMPLEADO ===');
            Log::info('ID recibido: ' . $id);
            
            if (is_numeric($id)) {
                $id = (int) $id;
            }
            
            $plantilla = Plantilla::find($id);
            
            if (!$plantilla) {
                Log::error('Empleado no encontrado con ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Empleado no encontrado'
                ], 404);
            }
            
            // Eliminar documentos asociados y sus archivos físicos
            $documentos = $plantilla->documentos;
            foreach ($documentos as $documento) {
                if ($documento->archivo && Storage::disk('public')->exists($documento->archivo)) {
                    Storage::disk('public')->delete($documento->archivo);
                }
                $documento->delete();
            }
            
            // Eliminar directorio del empleado si está vacío
            $directorio = storage_path('app/public/documentos/empleados/' . $plantilla->plantilla_id);
            if (File::exists($directorio) && File::isEmptyDirectory($directorio)) {
                File::deleteDirectory($directorio);
            }
            
            $plantilla->delete();
            
            Log::info('Empleado eliminado exitosamente');
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Empleado eliminado exitosamente'
                ]);
            }
            
            return redirect()->route('plantilla.index')
                ->with('success', 'Empleado eliminado exitosamente');
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar empleado: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el empleado: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al eliminar el empleado: ' . $e->getMessage());
        }
    }

    /**
     * Prepare data from request for save/update
     */
    private function prepareData(Request $request)
    {
        $data = $request->all();
        
        // Convertir campos booleanos
        $booleanFields = [
            'operador', 'bono_asistencia', 'bono_productividad', 
            'pension_alimenticia', 'reserva', 'bono_federal', 
            'bono_administrativo', 'aplica_asistencia', 'fonacot', 
            'pagar_por_liquidacion', 'borrado_logico'
        ];
        
        foreach ($booleanFields as $field) {
            if ($request->has($field)) {
                $value = $request->$field;
                if (is_string($value)) {
                    $data[$field] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                } else {
                    $data[$field] = (bool) $value;
                }
            } else {
                $data[$field] = false;
            }
        }
        
        // Limpiar campos vacíos
        foreach ($data as $key => $value) {
            if ($value === '' || $value === null) {
                $data[$key] = null;
            }
        }
        
        // Manejar arrays JSON (nomina_percepciones, nomina_deducciones, nomina_otros_pagos)
        $jsonFields = ['nomina_percepciones', 'nomina_deducciones', 'nomina_otros_pagos'];
        foreach ($jsonFields as $field) {
            if ($request->has($field)) {
                $value = $request->$field;
                if (is_array($value)) {
                    $data[$field] = json_encode($value);
                }
            }
        }
        
        // Asegurar que los campos de texto estén en el formato correcto
        if (isset($data['correo']) && $data['correo']) {
            $data['correo'] = strtolower(trim($data['correo']));
        }
        
        if (isset($data['rfc']) && $data['rfc']) {
            $data['rfc'] = strtoupper(trim($data['rfc']));
        }
        
        if (isset($data['curp']) && $data['curp']) {
            $data['curp'] = strtoupper(trim($data['curp']));
        }
        
        return $data;
    }

    /**
     * Process documents from request
     */
    private function processDocuments(Request $request, Plantilla $plantilla)
    {
        $documentos = [];
        if ($request->has('documentos')) {
            $documentos = is_string($request->documentos) ? json_decode($request->documentos, true) : $request->documentos;
        }
        
        if (empty($documentos) || !is_array($documentos)) {
            return;
        }
        
        // Asegurar que el directorio existe
        $directorio = storage_path('app/public/documentos/empleados/' . $plantilla->plantilla_id);
        if (!File::exists($directorio)) {
            File::makeDirectory($directorio, 0777, true);
        }
        
        foreach ($documentos as $index => $doc) {
            if (isset($doc['nombre']) && !empty($doc['nombre'])) {
                // Verificar si ya existe un documento con ese nombre
                $existe = EmpleadoDocumento::where('plantilla_id', $plantilla->plantilla_id)
                                           ->where('nombre_documento', $doc['nombre'])
                                           ->exists();
                
                if (!$existe) {
                    $documentoCreado = EmpleadoDocumento::create([
                        'plantilla_id' => $plantilla->plantilla_id,
                        'nombre_documento' => $doc['nombre'],
                        'archivo' => null,
                        'tipo_archivo' => 'pending',
                        'tamanio' => 0
                    ]);
                    
                    // Subir archivo si existe
                    if (isset($doc['tieneArchivo']) && $doc['tieneArchivo']) {
                        foreach ($request->allFiles() as $key => $file) {
                            if (strpos($key, 'documentos_archivo_') === 0 && $file) {
                                $nombreArchivo = time() . '_' . $documentoCreado->id . '.' . $file->getClientOriginalExtension();
                                $ruta = $file->storeAs('documentos/empleados/' . $plantilla->plantilla_id, $nombreArchivo, 'public');
                                
                                $documentoCreado->update([
                                    'archivo' => $ruta,
                                    'tipo_archivo' => $file->getClientOriginalExtension(),
                                    'tamanio' => $file->getSize()
                                ]);
                                break;
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Get data for grid view with filters
     */
    public function getDataGrid(Request $request)
    {
        try {
            $query = Plantilla::dataGrid();
            
            // Aplicar filtros
            if ($request->has('buscar') && $request->buscar) {
                $query->buscar($request->buscar);
            }
            
            if ($request->has('estatus') && $request->estatus !== '') {
                if ($request->estatus === 'Activo') {
                    $query->whereIn('estatus', ['1', 'Activo']);
                } elseif ($request->estatus === 'Inactivo') {
                    $query->whereIn('estatus', ['0', 'Inactivo', 'Baja']);
                }
            }
            
            if ($request->has('operador') && $request->operador !== '') {
                $query->where('operador', $request->operador === 'true');
            }
            
            $plantillas = $query->get();
            
            return response()->json([
                'success' => true,
                'data' => $plantillas,
                'total' => $plantillas->count(),
                'activos' => $plantillas->whereIn('estatus', ['1', 'Activo'])->count(),
                'inactivos' => $plantillas->whereIn('estatus', ['0', 'Inactivo', 'Baja'])->count(),
                'operadores' => $plantillas->where('operador', true)->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getDataGrid: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get puestos by area for dynamic select
     */
    public function getPuestosByArea(Request $request)
    {
        try {
            $areaId = $request->area_id;
            
            Log::info('Obteniendo puestos para área ID: ' . $areaId);
            
            if (!$areaId) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de área no proporcionado'
                ], 400);
            }
            
            $puestos = Puesto::where('area_id', $areaId)
                            ->whereNull('deleted_at')
                            ->where('estatus', 'Activo')
                            ->orderBy('nombre')
                            ->get(['id', 'nombre', 'folio']);
            
            Log::info('Puestos encontrados: ' . $puestos->count());
            
            return response()->json([
                'success' => true,
                'data' => $puestos
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al obtener puestos por área: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar puestos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        try {
            $buscar = $request->buscar;
            
            Log::info('Exportando plantilla a Excel', ['buscar' => $buscar]);
            
            $nombreArchivo = 'plantilla_' . date('Y-m-d_His') . '.xlsx';
            
            // Para peticiones API, devolver JSON
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Exportación completada',
                    'download_url' => route('plantilla.export.download', ['buscar' => $buscar])
                ]);
            }
            
            // Para peticiones web, devolver el archivo directamente
            return Excel::download(new PlantillaExport($buscar), $nombreArchivo);
            
        } catch (\Exception $e) {
            Log::error('Error al exportar plantilla: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al exportar: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al exportar: ' . $e->getMessage());
        }
    }

    /**
     * Download Excel file
     */
    public function downloadExcel(Request $request)
    {
        try {
            $buscar = $request->buscar;
            $nombreArchivo = 'plantilla_' . date('Y-m-d_His') . '.xlsx';
            
            return Excel::download(new PlantillaExport($buscar), $nombreArchivo);
            
        } catch (\Exception $e) {
            Log::error('Error al descargar Excel: ' . $e->getMessage());
            return back()->with('error', 'Error al descargar: ' . $e->getMessage());
        }
    }
    
    /**
     * Subir archivo físico de documento (endpoint separado)
     */
    public function subirArchivoDocumento(Request $request, $id)
    {
        try {
            $request->validate([
                'documento_id' => 'required|exists:empleado_documentos,id',
                'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'
            ]);
            
            $documento = EmpleadoDocumento::find($request->documento_id);
            
            if (!$documento || $documento->plantilla_id != $id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Documento no encontrado'
                ], 404);
            }
            
            // Crear directorio si no existe
            $directorio = storage_path('app/public/documentos/empleados/' . $id);
            if (!File::exists($directorio)) {
                File::makeDirectory($directorio, 0777, true);
            }
            
            // Subir archivo
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $documento->id . '.' . $archivo->getClientOriginalExtension();
            $ruta = $archivo->storeAs('documentos/empleados/' . $id, $nombreArchivo, 'public');
            
            // Actualizar registro
            $documento->update([
                'archivo' => $ruta,
                'tipo_archivo' => $archivo->getClientOriginalExtension(),
                'tamanio' => $archivo->getSize()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Archivo subido correctamente',
                'data' => [
                    'id' => $documento->id,
                    'ruta' => Storage::url($ruta)
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al subir archivo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al subir archivo: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener documentos de un empleado
     */
    public function getDocumentos($id)
    {
        try {
            $plantilla = Plantilla::find($id);
            
            if (!$plantilla) {
                return response()->json([
                    'success' => false,
                    'message' => 'Empleado no encontrado'
                ], 404);
            }
            
            $documentos = $plantilla->documentos()->get();
            
            return response()->json([
                'success' => true,
                'data' => $documentos,
                'message' => 'Documentos obtenidos correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al obtener documentos: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener documentos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Eliminar un documento
     */
    public function eliminarDocumento($empleadoId, $documentoId)
    {
        try {
            $documento = EmpleadoDocumento::where('id', $documentoId)
                                      ->where('plantilla_id', $empleadoId)
                                      ->first();
            
            if (!$documento) {
                return response()->json([
                    'success' => false,
                    'message' => 'Documento no encontrado'
                ], 404);
            }
            
            // Eliminar archivo físico si existe
            if ($documento->archivo && Storage::disk('public')->exists($documento->archivo)) {
                Storage::disk('public')->delete($documento->archivo);
            }
            
            $documento->delete();
            
            // Eliminar directorio si está vacío
            $directorio = storage_path('app/public/documentos/empleados/' . $empleadoId);
            if (File::exists($directorio) && File::isEmptyDirectory($directorio)) {
                File::deleteDirectory($directorio);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Documento eliminado correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar documento: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar documento: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Descargar un documento
     */
    public function descargarDocumento($empleadoId, $documentoId)
    {
        try {
            Log::info('Descargando documento', ['empleadoId' => $empleadoId, 'documentoId' => $documentoId]);
            
            $documento = EmpleadoDocumento::where('id', $documentoId)
                                      ->where('plantilla_id', $empleadoId)
                                      ->first();
            
            if (!$documento) {
                Log::error('Documento no encontrado', ['empleadoId' => $empleadoId, 'documentoId' => $documentoId]);
                return response()->json([
                    'success' => false,
                    'message' => 'Documento no encontrado'
                ], 404);
            }
            
            if (!$documento->archivo) {
                Log::error('Documento sin archivo', ['documento' => $documento]);
                return response()->json([
                    'success' => false,
                    'message' => 'El documento no tiene archivo asociado'
                ], 404);
            }
            
            $rutaCompleta = storage_path('app/public/' . $documento->archivo);
            
            if (!file_exists($rutaCompleta)) {
                Log::error('Archivo físico no existe', ['ruta' => $rutaCompleta]);
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo físico no existe'
                ], 404);
            }
            
            $nombreDescarga = $documento->nombre_documento . '.' . $documento->tipo_archivo;
            
            return response()->download($rutaCompleta, $nombreDescarga, [
                'Content-Type' => mime_content_type($rutaCompleta),
                'Content-Disposition' => 'attachment; filename="' . $nombreDescarga . '"'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al descargar documento: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al descargar documento: ' . $e->getMessage()
            ], 500);
        }
    }
}