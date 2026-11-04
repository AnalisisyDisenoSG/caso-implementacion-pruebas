<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function store(Request $request)
    {
        Carrera::create($request->all());
        
        return response()->json([
            'message' => 'Carrera creada exitosamente',
            'data' => $request->all()
        ], 201);
    }
}
