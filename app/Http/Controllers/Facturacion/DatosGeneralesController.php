<?php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
use App\Models\Facturacion\DatosGenerales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DatosGeneralesController extends Controller
{
    public function index()
    {
        $empresas = DatosGenerales::where('activo', true)->get();
        return response()->json(['status' => 'ok', 'data' => $empresas]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'razon_social' => 'required|string|max:150',
            'rfc' => 'required|string|max:13|unique:datos_generales,rfc',
            'calle' => 'required|string',
            'num_exterior' => 'required|string',
            'colonia' => 'required|string',
            'codigo_postal' => 'required|string|max:10',
            'municipio' => 'required|string',
            'estado' => 'required|string',
            'satcat_regimen_fiscal_clave' => 'required|exists:satcat_regimen_fiscal,clave',
            'logo' => 'nullable|image',
            'certificado_cer' => 'nullable|file|mimes:cer',
            'certificado_key' => 'nullable|file',
            'certificado_password' => 'nullable|string',
        ]);
        
        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('logos', 'public');
        }
        if ($request->hasFile('certificado_cer')) {
            $validated['certificado_cer'] = $request->file('certificado_cer')->store('certificados', 'private');
        }
        if ($request->hasFile('certificado_key')) {
            $validated['certificado_key'] = $request->file('certificado_key')->store('certificados', 'private');
        }
        
        $empresa = DatosGenerales::create($validated);
        return response()->json(['status' => 'ok', 'data' => $empresa], 201);
    }
    
    public function show($id)
    {
        $empresa = DatosGenerales::with(['series', 'sucursales'])->findOrFail($id);
        return response()->json(['status' => 'ok', 'data' => $empresa]);
    }
    
    public function update(Request $request, $id)
    {
        $empresa = DatosGenerales::findOrFail($id);
        $validated = $request->validate([
            'razon_social' => 'sometimes|string|max:150',
            'calle' => 'sometimes|string',
            'num_exterior' => 'sometimes|string',
            'colonia' => 'sometimes|string',
            'codigo_postal' => 'sometimes|string|max:10',
            'municipio' => 'sometimes|string',
            'estado' => 'sometimes|string',
            'satcat_regimen_fiscal_clave' => 'sometimes|exists:satcat_regimen_fiscal,clave',
            'certificado_password' => 'nullable|string',
        ]);
        
        $empresa->update($validated);
        return response()->json(['status' => 'ok', 'data' => $empresa]);
    }
    
    public function destroy($id)
    {
        $empresa = DatosGenerales::findOrFail($id);
        $empresa->delete();
        return response()->json(['status' => 'ok', 'message' => 'Empresa eliminada']);
    }
}