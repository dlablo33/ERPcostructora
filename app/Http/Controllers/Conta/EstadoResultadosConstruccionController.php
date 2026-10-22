<?php

namespace App\Http\Controllers\Conta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstadoResultadosConstruccionController extends Controller
{
    public function getPeriodos(Request $request)
    {
        return response()->json(['success' => true, 'data' => []]);
    }

    public function getData(Request $request)
    {
        return response()->json(['success' => true, 'data' => []]);
    }
}