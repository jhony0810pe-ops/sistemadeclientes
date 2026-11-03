<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Nueva Factura</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body>

<div class="container py-5">

    <div class="card shadow">

        <div class="card-header">

            <h3 class="mb-0">
                Nueva Factura
            </h3>

        </div>

        <div class="card-body">

            @if($errors->any())

                <div class="alert alert-danger">

                    <strong>Hay algunos errores:</strong>

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form action="{{ route('facturas.store') }}"
                  method="POST">

                @csrf


                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Número de factura
                        </label>

                        <input type="text"
                               name="numero_factura"
                               class="form-control"
                               value="{{ old('numero_factura') }}"
                               placeholder="FAC-0001"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Cliente
                        </label>

                        <input type="text"
                               name="cliente"
                               class="form-control"
                               value="{{ old('cliente') }}"
                               placeholder="Nombre del cliente"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Fecha de emisión
                        </label>

                        <input type="date"
                               name="fecha_emision"
                               class="form-control"
                               value="{{ old('fecha_emision') }}"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Fecha de vencimiento
                        </label>

                        <input type="date"
                               name="fecha_vencimiento"
                               class="form-control"
                               value="{{ old('fecha_vencimiento') }}"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Periodo facturado
                        </label>

                        <input type="text"
                               name="periodo_facturado"
                               class="form-control"
                               value="{{ old('periodo_facturado') }}"
                               placeholder="Agosto 2026"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Método de pago
                        </label>

                        <select name="metodo_pago"
                                class="form-select"
                                required>

                            <option value="">
                                Seleccionar
                            </option>

                            <option value="Efectivo">
                                Efectivo
                            </option>

                            <option value="Transferencia">
                                Transferencia
                            </option>

                            <option value="Tarjeta">
                                Tarjeta
                            </option>

                            <option value="Depósito">
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
                                  required>{{ old('concepto') }}</textarea>

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
                               value="{{ old('subtotal') }}"
                               required>

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            IVA (16%)
                        </label>

                        <input type="text"
                               id="iva"
                               class="form-control"
                               readonly>

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Total
                        </label>

                        <input type="text"
                               id="total"
                               class="form-control"
                               readonly>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Estado
                        </label>

                        <select name="estado"
                                class="form-select"
                                required>

                            <option value="Pendiente">
                                Pendiente
                            </option>

                            <option value="Pagada">
                                Pagada
                            </option>

                            <option value="Vencida">
                                Vencida
                            </option>

                            <option value="Cancelada">
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
                                  rows="3"
                                  placeholder="Observaciones adicionales">{{ old('observaciones') }}</textarea>

                    </div>

                </div>


                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-success">

                        Guardar factura

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