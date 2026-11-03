<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Control de Internet</title>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 20px;
        font-family: Arial, sans-serif;
        background: #f2f2f2;
    }

    .contenedor {
        max-width: 1000px;
        margin: auto;
    }

    .tarjeta {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
    }

    h1 {
        text-align: center;
        margin-top: 0;
        margin-bottom: 25px;
    }

    .mensaje {
        padding: 13px;
        border-radius: 7px;
        margin-bottom: 20px;
    }

    .success {
        background: #d1e7dd;
        color: #0f5132;
    }

    .error {
        background: #f8d7da;
        color: #842029;
    }

    .tabla-contenedor {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    th {
        background: #212529;
        color: white;
        padding: 14px;
        text-align: center;
    }

    td {
        padding: 15px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    tr:hover {
        background: #f8f9fa;
    }

    .ip {
        font-weight: bold;
        font-size: 17px;
    }

    .estado-habilitado {
        color: #198754;
        font-weight: bold;
    }

    .estado-cortado {
        color: #dc3545;
        font-weight: bold;
    }

    .acciones {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    button {
        border: none;
        border-radius: 6px;
        padding: 11px 18px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-cortar {
        background: #dc3545;
        color: white;
    }

    .btn-cortar:hover {
        background: #bb2d3b;
    }

    .btn-habilitar {
        background: #198754;
        color: white;
    }

    .btn-habilitar:hover {
        background: #157347;
    }

    .btn-volver {
        display: inline-block;
        margin-top: 20px;
        background: #343a40;
        color: white;
        text-decoration: none;
        padding: 12px 18px;
        border-radius: 7px;
    }

    @media (max-width: 600px) {

        body {
            padding: 10px;
        }

        .tarjeta {
            padding: 15px;
        }

        table {
            min-width: 600px;
        }
    }
</style>
```

</head>

<body>

<div class="contenedor">

```
<div class="tarjeta">

    <h1>
        CONTROL DE INTERNET
    </h1>


    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))

        <div class="mensaje success">
            {{ session('success') }}
        </div>

    @endif


    {{-- MENSAJE DE ERROR --}}
    @if(session('error'))

        <div class="mensaje error">
            {!! session('error') !!}
        </div>

    @endif


    {{-- ERROR DE CONEXIÓN --}}
    @if(isset($error))

        <div class="mensaje error">
            {!! $error !!}
        </div>

    @endif


    <div class="tabla-contenedor">

        <table>

            <thead>

                <tr>
                    <th>#</th>
                    <th>IP</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>
                        1
                    </td>

                    <td class="ip">
                        192.168.25.2
                    </td>

                    <td>

                        @if(isset($estado) && $estado === 'habilitado')

                            <span class="estado-habilitado">
                                🟢 HABILITADO
                            </span>

                        @elseif(isset($estado) && $estado === 'deshabilitado')

                            <span class="estado-cortado">
                                🔴 CORTADO
                            </span>

                        @else

                            <span class="estado-cortado">
                                ⚠️ ERROR
                            </span>

                        @endif

                    </td>

                    <td>

                        <div class="acciones">

                            @if(isset($estado) && $estado === 'habilitado')

                                <form
                                    action="{{ route('mikrotik.wifi.disable') }}"
                                    method="POST">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn-cortar">

                                        🔴 CORTAR

                                    </button>

                                </form>

                            @elseif(isset($estado) && $estado === 'deshabilitado')

                                <form
                                    action="{{ route('mikrotik.wifi.enable') }}"
                                    method="POST">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn-habilitar">

                                        🟢 HABILITAR

                                    </button>

                                </form>

                            @endif

                        </div>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>


    <a
        href="{{ route('mikrotik.ppp') }}"
        class="btn-volver">

        ← USUARIOS PPP

    </a>


    <a
        href="{{ route('mikrotik.morosos') }}"
        class="btn-volver">

        📋 MOROSOS

    </a>

</div>
```

</div>

</body>

</html>
