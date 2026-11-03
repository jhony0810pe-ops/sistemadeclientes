<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    /**
     * Mostrar todas las facturas
     */
    public function index()
    {
        $facturas = Factura::orderBy('id', 'desc')->get();

        return view('facturas.index', compact('facturas'));
    }

    /**
     * Mostrar formulario para crear factura
     */
    public function create()
    {
        return view('facturas.create');
    }

    /**
     * Guardar factura
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero_factura' => 'required|string|max:100|unique:facturas,numero_factura',
            'cliente' => 'required|string|max:255',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
            'periodo_facturado' => 'required|string|max:50',
            'concepto' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
            'estado' => 'required|string|max:50',
            'metodo_pago' => 'required|string|max:100',
            'observaciones' => 'nullable|string',
        ], [
            'numero_factura.required' => 'El número de factura es obligatorio.',
            'numero_factura.unique' => 'Ese número de factura ya existe.',
            'cliente.required' => 'El cliente es obligatorio.',
            'fecha_emision.required' => 'La fecha de emisión es obligatoria.',
            'fecha_vencimiento.required' => 'La fecha de vencimiento es obligatoria.',
            'fecha_vencimiento.after_or_equal' => 'La fecha de vencimiento no puede ser anterior a la fecha de emisión.',
            'periodo_facturado.required' => 'El periodo facturado es obligatorio.',
            'concepto.required' => 'El concepto es obligatorio.',
            'subtotal.required' => 'El subtotal es obligatorio.',
            'subtotal.numeric' => 'El subtotal debe ser numérico.',
            'metodo_pago.required' => 'El método de pago es obligatorio.',
        ]);

        // Calcular IVA 16%
        $subtotal = (float) $request->subtotal;
        $iva = $subtotal * 0.16;
        $total = $subtotal + $iva;

        Factura::create([
            'numero_factura' => $request->numero_factura,
            'cliente' => $request->cliente,
            'fecha_emision' => $request->fecha_emision,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'periodo_facturado' => $request->periodo_facturado,
            'concepto' => $request->concepto,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
            'estado' => $request->estado,
            'metodo_pago' => $request->metodo_pago,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('facturas.index')
            ->with('success', 'Factura creada correctamente.');
    }

    /**
     * Mostrar una factura
     */
    public function show(Factura $factura)
    {
        return view('facturas.show', compact('factura'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Factura $factura)
    {
        return view('facturas.edit', compact('factura'));
    }

    /**
     * Actualizar factura
     */
    public function update(Request $request, Factura $factura)
    {
        $request->validate([
            'numero_factura' => 'required|string|max:100|unique:facturas,numero_factura,' . $factura->id,
            'cliente' => 'required|string|max:255',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
            'periodo_facturado' => 'required|string|max:50',
            'concepto' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
            'estado' => 'required|string|max:50',
            'metodo_pago' => 'required|string|max:100',
            'observaciones' => 'nullable|string',
        ]);

        $subtotal = (float) $request->subtotal;
        $iva = $subtotal * 0.16;
        $total = $subtotal + $iva;

        $factura->update([
            'numero_factura' => $request->numero_factura,
            'cliente' => $request->cliente,
            'fecha_emision' => $request->fecha_emision,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'periodo_facturado' => $request->periodo_facturado,
            'concepto' => $request->concepto,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
            'estado' => $request->estado,
            'metodo_pago' => $request->metodo_pago,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('facturas.index')
            ->with('success', 'Factura actualizada correctamente.');
    }

    /**
     * Eliminar factura
     */
    public function destroy(Factura $factura)
    {
        $factura->delete();

        return redirect()
            ->route('facturas.index')
            ->with('success', 'Factura eliminada correctamente.');
    }
}