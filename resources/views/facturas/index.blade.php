<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Facturas</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background-color: #f5f6f8;
        }

        .contenedor {
            margin-top: 40px;
        }

        .titulo {
            font-size: 38px;
            font-weight: 700;
        }

        .subtitulo {
            color: #6c757d;
        }

        .card {
            border-radius: 10px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            vertical-align: middle;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .btn {
            border-radius: 5px;
        }

        .total-box {
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
        }

        .total-numero {
            font-size: 28px;
            font-weight: bold;
        }

    </style>

</head>


<body>


<div class="container contenedor">


    <!-- ENCABEZADO -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="titulo">
                Facturas
            </h1>

            <p class="subtitulo">
                Administración de facturas del sistema ISP
            </p>

        </div>


        <div class="d-flex gap-2">

            <!-- BOTÓN SUMAR -->

            <button
                type="button"
                class="btn btn-success"
                onclick="sumarFacturas()"
            >
                🧮 Sumar totales
            </button>


            <!-- NUEVA FACTURA -->

            <a
                href="{{ route('facturas.create') }}"
                class="btn btn-primary"
            >
                + Nueva factura
            </a>

        </div>

    </div>


    <!-- MENSAJE DE ÉXITO -->

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif


    <!-- ERRORES -->

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                Hay algunos errores:
            </strong>

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif



    <!-- TABLA -->

    <div class="card shadow">

        <div class="card-body p-3">

            <div class="table-responsive">


                <table class="table table-bordered table-hover align-middle">


                    <!-- ENCABEZADOS -->

                    <thead class="table-dark">

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Número
                            </th>

                            <th>
                                Cliente
                            </th>

                            <th>
                                Emisión
                            </th>

                            <th>
                                Vencimiento
                            </th>

                            <th>
                                Periodo
                            </th>

                            <th>
                                Total
                            </th>

                            <th>
                                Estado
                            </th>

                            <th>
                                Acciones
                            </th>

                        </tr>

                    </thead>


                    <!-- CUERPO -->

                    <tbody>


                        @forelse($facturas as $factura)


                            <tr>


                                <!-- ID -->

                                <td>
                                    {{ $factura->id }}
                                </td>


                                <!-- NUMERO -->

                                <td>

                                    <strong>
                                        {{ $factura->numero_factura }}
                                    </strong>

                                </td>


                          <!-- CLIENTE -->

<td>

    {{ $factura->cliente }}

</td>

                                <!-- EMISION -->

                                <td>

                                    {{ $factura->fecha_emision->format('d/m/Y') }}

                                </td>


                                <!-- VENCIMIENTO -->

                                <td>

                                    {{ $factura->fecha_vencimiento->format('d/m/Y') }}

                                </td>


                                <!-- PERIODO -->

                                <td>

                                    {{ $factura->periodo_facturado }}

                                </td>


                                <!-- TOTAL -->

                                <td>

                                    <strong
                                        class="total-factura"
                                        data-total="{{ $factura->total }}"
                                    >

                                        ${{ number_format($factura->total, 2) }}

                                    </strong>

                                </td>


                                <!-- ESTADO -->

                                <td>


                                    @if($factura->estado == 'Pagada')

                                        <span class="badge bg-success">
                                            Pagada
                                        </span>


                                    @elseif($factura->estado == 'Pendiente')

                                        <span class="badge bg-warning text-dark">
                                            Pendiente
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

                                        <span class="badge bg-secondary">
                                            {{ $factura->estado }}
                                        </span>

                                    @endif


                                </td>


                                <!-- ACCIONES -->

                                <td>


                                    <div class="d-flex gap-1">


                                        <!-- VER -->

                                        <a
                                            href="{{ route('facturas.show', $factura) }}"
                                            class="btn btn-info btn-sm text-white"
                                        >
                                            Ver
                                        </a>


                                        <!-- EDITAR -->

                                        <a
                                            href="{{ route('facturas.edit', $factura) }}"
                                            class="btn btn-warning btn-sm"
                                        >
                                            Editar
                                        </a>


                                        <!-- ELIMINAR -->

                                        <form
                                            action="{{ route('facturas.destroy', $factura) }}"
                                            method="POST"
                                            onsubmit="return confirmarEliminar();"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm"
                                            >
                                                Eliminar
                                            </button>

                                        </form>


                                    </div>


                                </td>


                            </tr>


                        @empty


                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center py-5"
                                >

                                    <h5>
                                        No hay facturas registradas
                                    </h5>

                                    <p class="text-muted">
                                        Todavía no tienes facturas.
                                    </p>


                                    <a
                                        href="{{ route('facturas.create') }}"
                                        class="btn btn-primary"
                                    >
                                        + Crear factura
                                    </a>

                                </td>

                            </tr>


                        @endforelse


                    </tbody>


                </table>


            </div>


            <!-- RESULTADO DE LA SUMA -->

            <div
                id="resultadoTotal"
                class="alert alert-success total-box d-none"
            >

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <strong>
                            TOTAL DE FACTURAS
                        </strong>

                        <br>

                        <span class="text-muted">
                            Suma de todos los registros mostrados
                        </span>

                    </div>


                    <div
                        id="totalFacturas"
                        class="total-numero"
                    >
                        $0.00
                    </div>

                </div>

            </div>


        </div>

    </div>


</div>



<!-- JAVASCRIPT -->

<script>


/*
|--------------------------------------------------------------------------
| SUMAR TODAS LAS FACTURAS
|--------------------------------------------------------------------------
*/

function sumarFacturas()
{

    // Buscar todos los totales
    let facturas =
        document.querySelectorAll('.total-factura');


    // Variable para almacenar la suma
    let total = 0;


    // Recorrer todas las facturas
    facturas.forEach(function(factura)
    {

        let cantidad =
            parseFloat(factura.dataset.total) || 0;


        total += cantidad;

    });


    // Mostrar el resultado
    document.getElementById('totalFacturas').textContent =
        '$' + total.toLocaleString('es-MX', {

            minimumFractionDigits: 2,

            maximumFractionDigits: 2

        });


    // Mostrar la caja
    document
        .getElementById('resultadoTotal')
        .classList.remove('d-none');

}



/*
|--------------------------------------------------------------------------
| CONFIRMAR ELIMINACIÓN
|--------------------------------------------------------------------------
*/

function confirmarEliminar()
{

    return confirm(
        '¿Seguro que quieres eliminar esta factura?'
    );

}


</script>


</body>

</html>