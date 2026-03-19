<?php

namespace App\Http\Controllers\RH;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RH\UserRequest;
use Illuminate\Support\Facades\Hash;

use App\Exports\UsuariosExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Obtener usuarios (solo los que no están eliminados soft delete)
            $usuarios = User::whereNull('deleted_at')->get();
            $totalUsuarios = $usuarios->count();
            $usuariosActivos = $usuarios->where('estatus', 'Activo')->count();
            $usuariosInactivos = $usuarios->where('estatus', 'Inactivo')->count();

            \Log::info('UserController@index - Datos cargados', [
                'usuarios_count' => $usuarios->count()
            ]);

            // Si es petición API
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'usuarios' => $usuarios,
                        'totalUsuarios' => $totalUsuarios,
                        'usuariosActivos' => $usuariosActivos,
                        'usuariosInactivos' => $usuariosInactivos
                    ]
                ]);
            }

            // Si es vista web
            return view('rh.catalogos.usuarios', compact('usuarios', 'totalUsuarios', 'usuariosActivos', 'usuariosInactivos'));

        } catch (\Exception $e) {
            \Log::error('Error en UserController@index: ' . $e->getMessage());
            
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
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            \Log::info('Intentando crear usuario con datos:', $request->validated());
            
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            
            $usuario = User::create($data);

            \Log::info('Usuario creado exitosamente:', ['id' => $usuario->id, 'folio' => $usuario->folio]);

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario creado exitosamente',
                    'data' => $usuario
                ], 201);
            }

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario creado exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Error de validación al crear usuario:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Error al crear usuario: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el usuario: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al crear el usuario: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        try {
            \Log::info('Mostrando usuario ID: ' . $id);
            
            $usuario = User::find($id);
            
            if (!$usuario) {
                \Log::error('Usuario no encontrado con ID: ' . $id);
                
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Usuario no encontrado'
                    ], 404);
                }
                
                return abort(404, 'Usuario no encontrado');
            }
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $usuario
                ]);
            }

            return view('rh.catalogos.usuarios-show', compact('usuario'));
            
        } catch (\Exception $e) {
            \Log::error('Error al mostrar usuario: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar el usuario: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cargar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        try {
            \Log::info('=== INICIO ACTUALIZACIÓN USUARIO ===');
            \Log::info('ID recibido en URL: ' . $id);
            
            if (is_numeric($id)) {
                $id = (int) $id;
            }
            
            $usuario = User::find($id);
            
            if (!$usuario) {
                \Log::error('Usuario no encontrado con ID: ' . $id);
                
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Usuario no encontrado'
                    ], 404);
                }
                
                return back()->with('error', 'Usuario no encontrado');
            }
            
            $data = $request->validated();
            
            // Solo actualizar contraseña si se proporcionó
            if (isset($data['password']) && $data['password']) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            
            $usuario->update($data);

            \Log::info('Usuario actualizado exitosamente');

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario actualizado exitosamente',
                    'data' => $usuario
                ]);
            }

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario actualizado exitosamente');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Error de validación al actualizar usuario:', $e->errors());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Error al actualizar usuario: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el usuario: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el usuario: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            \Log::info('=== INICIO ELIMINACIÓN USUARIO ===');
            \Log::info('ID recibido: ' . $id);
            
            if (is_numeric($id)) {
                $id = (int) $id;
            }
            
            $usuario = User::find($id);
            
            if (!$usuario) {
                \Log::error('Usuario no encontrado con ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }
            
            \Log::info('Usuario: ' . $usuario->name);
            
            if ($usuario->trashed()) {
                $usuario->forceDelete();
                \Log::info('Eliminación física forzada realizada');
            } else {
                $deleted = $usuario->delete();
                \Log::info('Resultado de delete(): ' . ($deleted ? 'true' : 'false'));
            }
            
            $existeDespues = User::withTrashed()->find($id);
            \Log::info('¿Existe después? ' . ($existeDespues ? 'SÍ' : 'NO'));
            
            \Log::info('=== FIN ELIMINACIÓN USUARIO ===');

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario eliminado exitosamente'
                ]);
            }

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario eliminado exitosamente');
            
        } catch (\Exception $e) {
            \Log::error('Error al eliminar usuario: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el usuario: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Reset password
     */
    public function resetPassword($id, Request $request)
    {
        try {
            \Log::info('=== INICIO RESET PASSWORD USUARIO ===');
            \Log::info('ID recibido: ' . $id);
            
            $usuario = User::find($id);
            
            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }
            
            // Generar contraseña aleatoria
            $newPassword = \Str::random(10);
            $usuario->password = Hash::make($newPassword);
            $usuario->save();
            
            \Log::info('Contraseña restablecida para usuario: ' . $usuario->email);

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Contraseña restablecida exitosamente',
                    'new_password' => $newPassword // Solo para desarrollo, en producción no enviar
                ]);
            }

            return back()->with('success', 'Contraseña restablecida exitosamente');
            
        } catch (\Exception $e) {
            \Log::error('Error al restablecer contraseña: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al restablecer contraseña: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al restablecer contraseña: ' . $e->getMessage());
        }
    }

/**
 * Export to Excel
 */
public function exportExcel(Request $request)
{
    try {
        $buscar = $request->buscar;
        
        \Log::info('Exportando usuarios a Excel', ['buscar' => $buscar]);
        
        $nombreArchivo = 'usuarios_' . date('Y-m-d_His') . '.xlsx';
        
        // Si es petición API, devolver JSON con mensaje
        if ($request->wantsJson() || $request->is('api/*')) {
            $usuarios = User::whereNull('deleted_at')
                           ->buscar($buscar)
                           ->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Exportación completada',
                'data' => $usuarios,
                'download_url' => route('usuarios.export.download', ['buscar' => $buscar])
            ]);
        }
        
        // Para descarga directa desde el navegador
        return Excel::download(new UsuariosExport($buscar), $nombreArchivo);
        
    } catch (\Exception $e) {
        \Log::error('Error al exportar usuarios: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
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
        $nombreArchivo = 'usuarios_' . date('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new UsuariosExport($buscar), $nombreArchivo);
        
    } catch (\Exception $e) {
        \Log::error('Error al descargar Excel: ' . $e->getMessage());
        return back()->with('error', 'Error al descargar: ' . $e->getMessage());
    }
}
}