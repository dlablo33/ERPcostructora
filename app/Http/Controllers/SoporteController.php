<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SoporteController extends Controller
{
    /**
     * Muestra la página principal de soporte (FAQ/Tutorial)
     */
    public function index()
    {
        return $this->faq();
    }

    /**
     * Muestra la página de preguntas frecuentes
     */
    public function faq()
    {
        return view('soporte.faq');
    }
}