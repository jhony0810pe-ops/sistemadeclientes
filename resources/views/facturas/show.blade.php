<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Detalle de Factura</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body>

<div class="container py-5">

    <div class="card shadow">

        <div class="card-header">

            <div class="d-flex justify-content-between">

                <h3>
                    Detalle de Factura
                </h3>

                <strong>
                    {{ $factura->numero_factura }}
                </strong>

            </div>

        </div>


        <div class="card-body">

            <div class="row">


                <div class="col-md-6 mb-3">

                    <strong>
                        Cliente:
                    </strong>

                    <br>

                    {{ $factura->cliente }}

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Número de factura:
                    </strong>

                    <br>

                    {{ $factura->numero_factura }}

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Fecha de emisión:
                    </strong>

                    <br>

                    {{ $factura->fecha_emision->format('d/m/Y') }}

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Fecha de vencimiento:
                    </strong>

                    <br>

                    {{ $factura->fecha_vencimiento->format('d/m/Y') }}

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Periodo facturado:
                    </strong>

                    <br>

                    {{ $factura->periodo_facturado }}

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Método de pago:
                    </strong>

                    <br>

                    {{ $factura->metodo_pago }}

                </div>


                <div class="col-md-12 mb-3">

                    <strong>
                        Concepto:
                    </strong>

                    <br>

                    {{ $factura->concepto }}

                </div>


                <div class="col-md-4 mb-3">

                    <strong>
                        Subtotal:
                    </strong>

                    <br>

                    ${{ number_format($factura->subtotal, 2) }}

                </div>


                <div class="col-md-4 mb-3">

                    <strong>
                        IVA:
                    </strong>

                    <br>

                    ${{ number_format($factura->iva, 2) }}

                </div>


                <div class="col-md-4 mb-3">

                    <strong>
                        Total:
                    </strong>

                    <br>

                    <h4>

                        ${{ number_format($factura->total, 2) }}

                    </h4>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Estado:
                    </strong>

                    <br>

                    @if($factura->estado == 'Pagada')

                        <span class="badge bg-success">
                            Pagada
                        </span>

                    @elseif($factura->estado == 'Vencida')

                        <span class="badge bg-danger">
                            Vencida
                        </span>

                    @elseif($factura->estado == 'Cancelada')

                        <span class="badge bg-secondary">
                            Cancelada
                        </span>

                    @else

                        <span class="badge bg-warning text-dark">
                            Pendiente
                        </span>

                    @endif

                </div>


                <div class="col-md-12 mb-3">

                    <strong>
                        Observaciones:
                    </strong>

                    <br>

                    {{ $factura->observaciones ?: 'Sin observaciones' }}

                </div>

            </div>


            <hr>


            <div class="d-flex gap-2">

                <a href="{{ route('facturas.index') }}"
                   class="btn btn-secondary">

                    Regresar

                </a>


                <a href="{{ route('facturas.edit', $factura) }}"
                   class="btn btn-warning">

                    Editar

                </a>


                <form action="{{ route('facturas.destroy', $factura) }}"
                      method="POST"
                      onsubmit="return confirm('¿Seguro que deseas eliminar esta factura?');">

                    @csrf

                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger">

                        Eliminar

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>

</html>