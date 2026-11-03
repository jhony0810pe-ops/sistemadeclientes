<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Crear cliente PPPoE</title>

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
            width: 100%;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #050505;
            color: #ffffff;
        }

        /* BARRA SUPERIOR */

        .barra {
            width: 100%;
            background: #000000;
            border-bottom: 1px solid #222;
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

        /* CONTENEDOR */

        .contenedor {
            width: calc(100% - 40px);
            max-width: 650px;
            margin: 45px auto;
            padding: 35px;
            background: #0d0d0d;
            border: 1px solid #242424;
            border-radius: 14px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 30px;
            line-height: 1.2;
            overflow-wrap: anywhere;
        }

        .subtitulo {
            color: #999999;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        /* MENSAJES */

        .mensaje {
            background: rgba(69, 207, 32, 0.10);
            border: 1px solid #45CF20;
            color: #45CF20;
            padding: 14px;
            border-radius: 7px;
            margin-bottom: 20px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .error {
            background: #1a1a1a;
            border: 1px solid #555;
            color: #ffffff;
            padding: 14px;
            border-radius: 7px;
            margin-bottom: 20px;
            overflow-wrap: anywhere;
        }

        .error strong {
            color: #45CF20;
        }

        .error ul {
            padding-left: 22px;
            margin-bottom: 0;
        }

        .error li + li {
            margin-top: 7px;
        }

        /* CAMPOS */

        label {
            display: block;
            margin: 20px 0 8px;
            font-weight: bold;
            color: #ffffff;
            line-height: 1.4;
        }

        input,
        select {
            display: block;
            width: 100%;
            min-width: 0;
            min-height: 48px;
            padding: 12px 14px;
            background: #050505;
            border: 1px solid #333333;
            border-radius: 7px;
            color: #ffffff;
            font-family: inherit;
            font-size: 16px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input::placeholder {
            color: #777777;
        }

        input:focus,
        select:focus {
            border-color: #45CF20;
            box-shadow: 0 0 0 2px rgba(69, 207, 32, 0.12);
        }

        select {
            cursor: pointer;
        }

        /* BOTONES */

        .botones {
            display: flex;
            align-items: stretch;
            gap: 12px;
            margin-top: 30px;
        }

        button,
        .volver {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-height: 48px;
            padding: 12px 20px;
            border-radius: 7px;
            font-family: inherit;
            font-size: 15px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }

        button {
            flex: 1;
            background: #45CF20;
            color: #000000;
            border: 1px solid #45CF20;
        }

        button:hover {
            background: #ffffff;
            border-color: #ffffff;
        }

        .volver {
            flex: 0 0 auto;
            color: #ffffff;
            background: transparent;
            border: 1px solid #333333;
        }

        .volver:hover {
            border-color: #45CF20;
            color: #45CF20;
        }

        button:focus-visible,
        .volver:focus-visible {
            outline: 2px solid #ffffff;
            outline-offset: 3px;
        }

        /* TABLET Y CELULAR */

        @media (max-width: 700px) {
            .barra {
                padding: 16px 20px;
            }

            .logo {
                font-size: 23px;
            }

            .titulo {
                font-size: 12px;
            }

            .contenedor {
                width: calc(100% - 30px);
                max-width: 500px;
                margin: 25px auto;
                padding: 25px 22px;
                border-radius: 12px;
            }

            h1 {
                font-size: 26px;
            }

            .subtitulo {
                font-size: 14px;
                margin-bottom: 24px;
            }
        }

        /* CELULARES ESTRECHOS */

        @media (max-width: 400px) {
            .barra {
                padding: 15px;
            }

            .logo {
                font-size: 21px;
            }

            .titulo {
                max-width: 145px;
                line-height: 1.4;
            }

            .contenedor {
                width: calc(100% - 20px);
                margin: 15px auto;
                padding: 22px 16px;
            }

            h1 {
                font-size: 24px;
            }

            .botones {
                flex-direction: column;
                gap: 10px;
            }

            button,
            .volver {
                width: 100%;
                flex: auto;
            }
        }

        /* PANTALLAS CON POCA ALTURA */

        @media (max-height: 500px) {
            .contenedor {
                margin-top: 15px;
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body>

    <!-- BARRA SUPERIOR -->

    <header class="barra">
        <div class="logo">
            TV<span>+</span>
        </div>

        <div class="titulo">
            Administración PPPoE
        </div>
    </header>

    <!-- CONTENEDOR -->

    <main class="contenedor">

        <h1>Crear cliente PPPoE</h1>

        <div class="subtitulo">
            Registrar una nueva cuenta de Internet
        </div>

        {{-- ERRORES DE VALIDACIÓN --}}

        @if ($errors->any())
            <div class="error">
                <strong>Revisa los siguientes datos:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- MENSAJE --}}

        @if (session('mensaje'))
            <div class="mensaje">
                {{ session('mensaje') }}
            </div>
        @endif

        <!-- FORMULARIO -->

        <form
            action="{{ url('/mikrotik/crearPPoe') }}"
            method="POST"
        >
            @csrf

            <!-- NOMBRE -->

            <label for="nombre">Nombre de usuario</label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                value="{{ old('nombre') }}"
                placeholder="Ej. cliente-prueba"
                autocomplete="username"
                autocapitalize="none"
                required
            >

            <!-- CONTRASEÑA -->

            <label for="clave">Contraseña</label>

            <input
                type="password"
                id="clave"
                name="clave"
                placeholder="Contraseña del cliente"
                autocomplete="new-password"
                required
            >

            <!-- PERFIL -->

            <label for="perfil">Perfil</label>

            <select name="perfil" id="perfil" required>
                <option
                    value="default"
                    {{ old('perfil') == 'default' ? 'selected' : '' }}
                >
                    default
                </option>

                <option
                    value="casa-plus"
                    {{ old('perfil') == 'casa-plus' ? 'selected' : '' }}
                >
                    casa-plus
                </option>
            </select>

            <!-- COMENTARIO -->

            <label for="comentario">Comentario</label>

            <input
                type="text"
                id="comentario"
                name="comentario"
                value="{{ old('comentario') }}"
                placeholder="Información adicional"
            >

            <!-- BOTONES -->

            <div class="botones">
                <button type="submit">
                    Crear cliente
                </button>

                <a
                    href="{{ url('/mikrotik/listarPPoe') }}"
                    class="volver"
                >
                    Cancelar
                </a>
            </div>

        </form>

    </main>

</body>
</html>