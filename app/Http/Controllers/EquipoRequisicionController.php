<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Activo;
use Illuminate\Http\Request;

class EquipoRequisicionController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $activos = Activo::orderBy('codigo')->get();
        
        return view('almacen.movimiento.requisiciones_devoluciones_equipo', compact('proyectos', 'activos'));
    }
}