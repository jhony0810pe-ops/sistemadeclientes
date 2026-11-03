
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Clientes PPPoE</title>

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            width: 100%;
            min-height: 100%;
            -webkit-text-size-adjust: 100%;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #050505;
            color: #ffffff;
        }

        .barra {
            width: 100%;
            background: #000000;
            border-bottom: 1px solid #222222;
            padding: 18px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
            letter-spacing: 2px;
            white-space: nowrap;
        }

        .logo span {
            color: #45CF20;
        }

        .titulo {
            color: #ffffff;
            font-size: 14px;
            text-align: right;
        }

        .contenedor {
            width: 100%;
            max-width: 1250px;
            margin: 40px auto;
            padding: 0 25px;
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0;
            font-size: 32px;
            line-height: 1.2;
            overflow-wrap: anywhere;
        }

        .subtitulo {
            color: #999999;
            margin-top: 8px;
            line-height: 1.5;
        }

        /* AVISOS */

        .aviso-error {
            background: #1a1a1a;
            color: #ff7777;
            border: 1px solid #ff4444;
            padding: 15px;
            border-radius: 8px;
            margin: 0 0 20px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .aviso-exito {
            background: #101a0d;
            color: #45CF20;
            border: 1px solid #45CF20;
            padding: 15px;
            border-radius: 8px;
            margin: 0 0 20px;
            line-height: 1.5;
        }

        .crear {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-height: 46px;
            padding: 12px 20px;
            background: #45CF20;
            color: #000000;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #45CF20;
            border-radius: 7px;
            white-space: nowrap;
            transition: background 0.2s, color 0.2s;
        }

        .crear:hover {
            background: #ffffff;
            border-color: #ffffff;
            color: #000000;
        }

        .crear:focus-visible {
            outline: 2px solid #ffffff;
            outline-offset: 3px;
        }

        .tabla-contenedor {
            width: 100%;
            background: #0d0d0d;
            border: 1px solid #242424;
            border-radius: 12px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #151515;
            color: #45CF20;
            padding: 16px;
            text-align: left;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            white-space: nowrap;
        }

        td {
            padding: 16px;
            border-top: 1px solid #242424;
            color: #dddddd;
            overflow-wrap: anywhere;
            line-height: 1.5;
        }

        tbody tr:hover td {
            background: #151515;
        }

        .activo,
        .deshabilitado {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .activo {
            background: rgba(69, 207, 32, 0.12);
            color: #45CF20;
            border: 1px solid #45CF20;
        }

        .deshabilitado {
            background: #1a1a1a;
            color: #bbbbbb;
            border: 1px solid #444444;
        }

        .sin-clientes {
            padding: 30px 20px;
            text-align: center;
            color: #999999;
            line-height: 1.6;
        }

        .clientes-movil {
            display: none;
        }

        .cliente-card {
            min-width: 0;
            padding: 20px;
            background: #0d0d0d;
            border: 1px solid #242424;
            border-radius: 12px;
        }

        .cliente-card + .cliente-card {
            margin-top: 14px;
        }

        .cliente-card h2 {
            margin: 0 0 16px;
            color: #ffffff;
            font-size: 19px;
            overflow-wrap: anywhere;
        }

        .dato {
            display: grid;
            grid-template-columns: minmax(95px, 0.8fr) minmax(0, 1.2fr);
            gap: 12px;
            padding: 11px 0;
            border-top: 1px solid #242424;
            line-height: 1.5;
        }

        .dato-nombre {
            color: #999999;
            font-size: 13px;
        }

        .dato-valor {
            min-width: 0;
            color: #dddddd;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        @media (max-width: 900px) {
            .barra {
                padding: 18px 22px;
            }

            .contenedor {
                margin-top: 30px;
                padding: 0 20px;
            }

            .encabezado {
                align-items: flex-start;
            }

            h1 {
                font-size: 29px;
            }

            th,
            td {
                padding: 13px 10px;
            }

            th {
                font-size: 12px;
            }
        }

        @media (max-width: 650px) {
            .barra {
                padding: 16px;
            }

            .logo {
                font-size: 23px;
            }

            .titulo {
                max-width: 165px;
                font-size: 12px;
                line-height: 1.4;
            }

            .contenedor {
                margin: 25px auto;
                padding: 0 14px;
            }

            .encabezado {
                flex-direction: column;
                align-items: stretch;
                gap: 18px;
                margin-bottom: 22px;
            }

            h1 {
                font-size: 27px;
            }

            .subtitulo {
                font-size: 14px;
            }

            .crear {
                width: 100%;
                min-height: 48px;
            }

            .tabla-contenedor {
                display: none;
            }

            .clientes-movil {
                display: block;
            }
        }

        @media (max-width: 380px) {
            .barra {
                padding: 14px 12px;
            }

            .logo {
                font-size: 21px;
            }

            .titulo {
                max-width: 145px;
                font-size: 11px;
            }

            .contenedor {
                padding: 0 10px;
                margin-top: 20px;
            }

            h1 {
                font-size: 24px;
            }

            .cliente-card {
                padding: 15px;
            }

            .cliente-card h2 {
                font-size: 17px;
            }

            .dato {
                grid-template-columns: minmax(80px, 0.8fr) minmax(0, 1.2fr);
                gap: 8px;
            }
        }
    </style>
</head>

<body>

    <header class="barra">
        <div class="logo">
            TV<span>+</span>
        </div>

        <div class="titulo">
            Administración PPPoE
        </div>
    </header>

    <main class="contenedor">

        <div class="encabezado">
            <div>
                <h1>Clientes PPPoE</h1>

                <div class="subtitulo">
                    Administración de cuentas de Internet
                </div>
            </div>

            <a href="{{ url('/mikrotik/crearPPoe') }}" class="crear">
                + Crear cliente
            </a>
        </div>

        {{-- AVISO DE ERROR DE CONEXIÓN --}}

        @if (!empty($error))
            <div class="aviso-error">
                <strong>Atención:</strong>
                {{ $error }}
            </div>
        @endif

        {{-- MENSAJE DE ÉXITO --}}

        @if (session('mensaje'))
            <div class="aviso-exito">
                {{ session('mensaje') }}
            </div>
        @endif

        {{-- TABLA PARA COMPUTADORA --}}

        <div class="tabla-contenedor">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Servicio</th>
                        <th>Perfil</th>
                        <th>Comentario</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente['name'] ?? 'Sin nombre' }}</td>
                            <td>{{ $cliente['service'] ?? 'Sin servicio' }}</td>
                            <td>{{ $cliente['profile'] ?? 'Sin perfil' }}</td>
                            <td>{{ $cliente['comment'] ?? 'Sin comentario' }}</td>
                            <td>
                                @if (in_array($cliente['disabled'] ?? false, [true, 'true', 1, '1'], true))
                                    <span class="deshabilitado">Deshabilitado</span>
                                @else
                                    <span class="activo">Activo</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="sin-clientes">
                                @if (!empty($error))
                                    No se puede mostrar la lista porque el router no está disponible.
                                @else
                                    No hay clientes PPPoE registrados.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- TARJETAS PARA CELULAR --}}

        <div class="clientes-movil">
            @forelse ($clientes as $cliente)
                <article class="cliente-card">
                    <h2>{{ $cliente['name'] ?? 'Sin nombre' }}</h2>

                    <div class="dato">
                        <span class="dato-nombre">Servicio</span>
                        <span class="dato-valor">{{ $cliente['service'] ?? 'Sin servicio' }}</span>
                    </div>

                    <div class="dato">
                        <span class="dato-nombre">Perfil</span>
                        <span class="dato-valor">{{ $cliente['profile'] ?? 'Sin perfil' }}</span>
                    </div>

                    <div class="dato">
                        <span class="dato-nombre">Comentario</span>
                        <span class="dato-valor">{{ $cliente['comment'] ?? 'Sin comentario' }}</span>
                    </div>

                    <div class="dato">
                        <span class="dato-nombre">Estado</span>
                        <span class="dato-valor">
                            @if (in_array($cliente['disabled'] ?? false, [true, 'true', 1, '1'], true))
                                <span class="deshabilitado">Deshabilitado</span>
                            @else
                                <span class="activo">Activo</span>
                            @endif
                        </span>
                    </div>
                </article>
            @empty
                <div class="cliente-card sin-clientes">
                    @if (!empty($error))
                        No se puede mostrar la lista porque el router no está disponible.
                    @else
                        No hay clientes PPPoE registrados.
                    @endif
                </div>
            @endforelse
        </div>

    </main>

</body>
</html>
