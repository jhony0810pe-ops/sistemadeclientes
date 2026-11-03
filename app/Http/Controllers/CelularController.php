<?php

namespace App\Http\Controllers;

use App\Models\Celular;
use Illuminate\Http\Request;

class CelularController extends Controller
{
    public function crear()
    {
        return view('crear');
    }

    public function guardar(Request $request)
    {
        Celular::create([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'precio' => $request->precio,
            'stock' => $request->stock
        ]);

        return redirect('/celulares/listar');
    }

    public function listar()
    {
        $celulares = Celular::all();

        return view('listar', compact('celulares'));
    }

    public function editar($id)
    {
        $celular = Celular::findOrFail($id);

        return view('actualizar', compact('celular'));
    }

    public function actualizar(Request $request, $id)
    {
        $celular = Celular::findOrFail($id);

        $celular->update([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'precio' => $request->precio,
            'stock' => $request->stock
        ]);

        return redirect('/celulares/listar');
    }

    public function eliminar($id)
    {
        $celular = Celular::findOrFail($id);

        $celular->delete();

        return redirect('/celulares/listar');
    }
}