<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Editar Factura</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body>

<div class="container py-5">

    <div class="card shadow">

        <div class="card-header">

            <h3>
                Editar Factura
            </h3>

        </div>


        <div class="card-body">

            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form action="{{ route('facturas.update', $factura) }}"
                  method="POST">

                @csrf

                @method('PUT')


                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Número de factura
                        </label>

                        <input type="text"
                               name="numero_factura"
                               class="form-control"
                               value="{{ old('numero_factura', $factura->numero_factura) }}"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Cliente
                        </label>

                        <input type="text"
                               name="cliente"
                               class="form-control"
                               value="{{ old('cliente', $factura->cliente) }}"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Fecha de emisión
                        </label>

                        <input type="date"
                               name="fecha_emision"
                               class="form-control"
                               value="{{ old('fecha_emision', $factura->fecha_emision->format('Y-m-d')) }}"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Fecha de vencimiento
                        </label>

                        <input type="date"
                               name="fecha_vencimiento"
                               class="form-control"
                               value="{{ old('fecha_vencimiento', $factura->fecha_vencimiento->format('Y-m-d')) }}"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Periodo facturado
                        </label>

                        <input type="text"
                               name="periodo_facturado"
                               class="form-control"
                               value="{{ old('periodo_facturado', $factura->periodo_facturado) }}"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Método de pago
                        </label>

                        <select name="metodo_pago"
                                class="form-select"
                                required>

                            <option value="Efectivo"
                                {{ $factura->metodo_pago == 'Efectivo' ? 'selected' : '' }}>
                                Efectivo
                            </option>

                            <option value="Transferencia"
                                {{ $factura->metodo_pago == 'Transferencia' ? 'selected' : '' }}>
                                Transferencia
                            </option>

                            <option value="Tarjeta"
                                {{ $factura->metodo_pago == 'Tarjeta' ? 'selected' : '' }}>
                                Tarjeta
                            </option>

                            <option value="Depósito"
                                {{ $factura->metodo_pago == 'Depósito' ? 'selected' : '' }}>
                                Depósito
                            </option>

                        </select>

                    </div>


                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Concepto
                        </label>

                        <textarea name="concepto"
                                  class="form-control"
                                  rows="3"
                                  required>{{ old('concepto', $factura->concepto) }}</textarea>

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Subtotal
                        </label>

                        <input type="number"
                               name="subtotal"
                               id="subtotal"
                               class="form-control"
                               step="0.01"
                               min="0"
                               value="{{ old('subtotal', $factura->subtotal) }}"
                               required>

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            IVA (16%)
                        </label>

                        <input type="text"
                               id="iva"
                               class="form-control"
                               value="{{ number_format($factura->iva, 2) }}"
                               readonly>

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Total
                        </label>

                        <input type="text"
                               id="total"
                               class="form-control"
                               value="{{ number_format($factura->total, 2) }}"
                               readonly>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Estado
                        </label>

                        <select name="estado"
                                class="form-select"
                                required>

                            <option value="Pendiente"
                                {{ $factura->estado == 'Pendiente' ? 'selected' : '' }}>
                                Pendiente
                            </option>

                            <option value="Pagada"
                                {{ $factura->estado == 'Pagada' ? 'selected' : '' }}>
                                Pagada
                            </option>

                            <option value="Vencida"
                                {{ $factura->estado == 'Vencida' ? 'selected' : '' }}>
                                Vencida
                            </option>

                            <option value="Cancelada"
                                {{ $factura->estado == 'Cancelada' ? 'selected' : '' }}>
                                Cancelada
                            </option>

                        </select>

                    </div>


                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Observaciones
                        </label>

                        <textarea name="observaciones"
                                  class="form-control"
                                  rows="3">{{ old('observaciones', $factura->observaciones) }}</textarea>

                    </div>

                </div>


                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">

                        Actualizar factura

                    </button>


                    <a href="{{ route('facturas.index') }}"
                       class="btn btn-secondary">

                        Cancelar

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>


<script>

    const subtotal = document.getElementById('subtotal');
    const iva = document.getElementById('iva');
    const total = document.getElementById('total');

    function calcularFactura()
    {
        let valor = parseFloat(subtotal.value) || 0;

        let impuesto = valor * 0.16;

        let totalFactura = valor + impuesto;

        iva.value = impuesto.toFixed(2);

        total.value = totalFactura.toFixed(2);
    }

    subtotal.addEventListener('input', calcularFactura);

</script>

</body>

</html>