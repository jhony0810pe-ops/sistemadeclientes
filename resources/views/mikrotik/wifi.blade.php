<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Control de Internet</title>


    <style>
    :root {
        --verde: #65B32E;
        --verde-hover: #4F8F24;
        --verde-oscuro: #203B12;
        --negro: #000000;
        --fondo: #101010;
        --gris: #C6C6C6;
        --blanco: #FFFFFF;
    }

    * { box-sizing: border-box; }

    body { margin: 0; padding: 20px; font-family: Arial, sans-serif; background: var(--negro); color: var(--blanco); }
    .contenedor { max-width: 1100px; margin: auto; }
    .tarjeta { background: var(--fondo); padding: 25px; border-radius: 12px; border: 2px solid var(--verde); box-shadow: 0 0 15px rgba(101,179,46,.20); }
    h1 { text-align: center; margin-top: 0; margin-bottom: 25px; color: var(--verde); font-weight: bold; }
    h1::after { content: ""; display: block; width: 100px; height: 4px; background: var(--verde); margin: 10px auto 0; border-radius: 5px; }
    .mensaje { padding: 13px; border-radius: 7px; margin-bottom: 20px; font-weight: bold; }
    .success { background: var(--verde-oscuro); color: var(--verde); border: 1px solid var(--verde); }
    .error { background: #202020; color: var(--gris); border: 1px solid var(--gris); }
    .agregar { display: flex; gap: 10px; margin-bottom: 25px; }
    .agregar input { flex: 1; padding: 13px; border: 2px solid var(--verde); border-radius: 6px; font-size: 16px; background: var(--negro); color: var(--blanco); outline: none; }
    .agregar input::placeholder { color: var(--gris); }
    .agregar input:focus { border-color: var(--verde); box-shadow: 0 0 8px rgba(101,179,46,.35); }
    button { border-radius: 6px; padding: 9px 13px; font-weight: bold; cursor: pointer; transition: .2s; }
    .btn-agregar { border: 2px solid var(--verde); background: var(--verde); color: var(--negro); padding: 13px 20px; }
    .btn-agregar:hover { background: var(--verde-hover); border-color: var(--verde-hover); color: var(--blanco); }
    .tabla-contenedor { width: 100%; overflow-x: auto; border-radius: 8px; border: 2px solid var(--verde); }
    table { width: 100%; border-collapse: collapse; min-width: 900px; }
    th { background: var(--verde); color: var(--negro); padding: 15px; text-align: center; font-size: 15px; border-right: 1px solid var(--verde-oscuro); }
    th:last-child { border-right: none; }
    td { padding: 15px; text-align: center; background: var(--negro); color: var(--blanco); border-bottom: 1px solid var(--verde-oscuro); border-right: 1px solid var(--verde-oscuro); }
    tbody tr:nth-child(even) td { background: #101A0B; }
    tbody tr:hover td { background: var(--verde-oscuro); transition: .2s; }
    .ip { font-weight: bold; font-size: 17px; color: var(--verde); }
    .estado-habilitado { color: var(--verde); font-weight: bold; }
    .estado-cortado { color: var(--gris); font-weight: bold; }
    .acciones { display: flex; justify-content: center; gap: 7px; flex-wrap: wrap; }
    .btn-habilitar { background: var(--verde); color: var(--negro); border: 2px solid var(--verde); }
    .btn-habilitar:hover { background: var(--verde-hover); color: var(--blanco); transform: translateY(-1px); }
    .btn-cortar, .btn-deshabilitar { background: var(--negro); color: var(--verde); border: 2px solid var(--verde); }
    .btn-cortar:hover, .btn-deshabilitar:hover { background: var(--verde); color: var(--negro); transform: translateY(-1px); }
    .btn-volver { display: inline-block; margin-top: 20px; margin-right: 8px; background: var(--verde); color: var(--negro); text-decoration: none; padding: 12px 18px; border-radius: 7px; border: 2px solid var(--verde); font-weight: bold; transition: .2s; }
    .btn-volver:hover { background: var(--verde-hover); color: var(--blanco); transform: translateY(-1px); }
    .sin-id { color: var(--gris); font-weight: bold; }
    @media (max-width: 700px) { body { padding: 10px; } .tarjeta { padding: 15px; } .agregar { flex-direction: column; } .btn-agregar { width: 100%; } }

/* ADAPTACIÓN PARA CELULARES */
@media (max-width: 600px) {

    body {
        padding: 8px;
    }

    .contenedor {
        width: 100%;
    }

    .tarjeta {
        padding: 12px;
        border-radius: 8px;
    }

    h1 {
        font-size: 21px;
    }

    .tabla-contenedor {
        overflow-x: visible;
        border: none;
    }

    table {
        width: 100%;
        min-width: 0;
        display: block;
    }

    thead {
        display: none;
    }

    tbody {
        display: block;
        width: 100%;
    }

    tbody tr {
        display: block;
        margin-bottom: 14px;
        border: 1px solid #65B32E;
        border-radius: 8px;
        overflow: hidden;
    }

    tbody td {
        display: block;
        width: 100%;
        min-height: 40px;
        padding: 10px 8px 10px 35%;
        position: relative;
        text-align: right;
        overflow-wrap: anywhere;
        font-size: 13px;
        border-right: none;
        border-bottom: 1px solid #203B12;
    }

    tbody td::before {
        position: absolute;
        left: 8px;
        top: 10px;
        width: 30%;
        text-align: left;
        font-weight: bold;
        color: #65B32E;
    }

    tbody td:nth-child(1)::before {
        content: "#";
    }

    tbody td:nth-child(2)::before {
        content: "Nombre";
    }

    tbody td:nth-child(3)::before {
        content: "IP";
    }

    tbody td:nth-child(4)::before {
        content: "Estado";
    }

    tbody td:nth-child(5)::before {
        content: "Acciones";
    }

    tbody td[colspan] {
        padding: 14px;
        text-align: center;
    }

    tbody td[colspan]::before {
        content: none;
    }

    .acciones {
        display: flex;
        flex-direction: column;
        gap: 8px;
        width: 100%;
    }

    .acciones form {
        width: 100%;
    }

    .acciones button {
        width: 100%;
        padding: 10px 5px;
        font-size: 12px;
        white-space: normal;
    }

    .agregar {
        flex-direction: column;
    }

    .agregar input,
    .btn-agregar {
        width: 100%;
        min-width: 0;
    }

    .btn-volver {
        display: block;
        text-align: center;
    }
}
</style>

</head>


<body>


<div class="contenedor">


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

                {{ session('error') }}

            </div>

        @endif


        {{-- ERROR DE CONEXIÓN --}}

        @if(isset($error))

            <div class="mensaje error">

                {{ $error }}

            </div>

        @endif


        {{-- AGREGAR IP --}}

        
<form action="{{ route('mikrotik.wifi.agregar') }}" method="POST" class="agregar">
    @csrf

    <input
        type="text"
        name="nombre"
        placeholder="Nombre del cliente"
        required>

    <input
        type="text"
        name="ip"
        placeholder="IP del cliente. Ejemplo: 10.0.0.10"
        required>

    <button type="submit" class="btn-agregar">
        ➕ AGREGAR CLIENTE
    </button>
</form>


<div style="margin-bottom: 15px;">
    <input
        type="search"
        id="buscarCliente"
        placeholder="🔎 Buscar por nombre o IP..."
        style="width:100%; padding:13px; border:2px solid #65B32E;
        border-radius:6px; background:#000; color:#fff; font-size:16px;">
</div>

        {{-- TABLA --}}

        <div class="tabla-contenedor">

            <table>

                
<thead>
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>IP</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
</thead>

                <tbody>


                    @forelse($clientes as $cliente)


                        <tr>


                            <td>

                                {{ $loop->iteration }}

                            </td>


                            <td>
                                {{ $cliente['nombre'] ?? 'Sin nombre' }}
                            </td>

                            <td class="ip">
                                {{ $cliente['ip'] }}
                            </td>


                            <td>


                                @if(($cliente['disabled'] ?? 'yes') === 'yes')

                                    <span class="estado-habilitado">

                                        🟢 HABILITADO

                                    </span>

                                @else

                                    <span class="estado-cortado">

                                        🔴 CORTADO

                                    </span>

                                @endif


                            </td>


                            <td>


                                <div class="acciones">


                                    @if(!empty($cliente['id']))


                                        {{-- HABILITAR --}}

                                        @if(($cliente['disabled'] ?? 'yes') === 'no')


                                            <form
                                                action="{{ route('mikrotik.wifi.enable', $cliente['id']) }}"
                                                method="POST">

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="btn-habilitar">

                                                    🟢 HABILITAR

                                                </button>

                                            </form>


                                        @else


                                            {{-- CORTAR --}}

                                            <form
                                                action="{{ route('mikrotik.wifi.disable', $cliente['id']) }}"
                                                method="POST">

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="btn-cortar">

                                                    🔴 CORTAR SERVICIO

                                                </button>

                                            </form>


                                        @endif


                                        {{-- DESHABILITAR --}}

                                        <form
                                            action="{{ route('mikrotik.wifi.deshabilitar', $cliente['id']) }}"
                                            method="POST"

                                            onsubmit="return confirm('¿Seguro que quieres deshabilitar esta IP?');">


                                            @csrf


                                            <button
                                                type="submit"
                                                class="btn-deshabilitar">

                                                ⚫ DESHABILITAR

                                            </button>


                                        </form>


                                    @else


                                        <span class="sin-id">

                                            Sin ID de MikroTik

                                        </span>


                                    @endif


                                </div>


                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td colspan="5">

                                No hay IPs agregadas.

                            </td>

                        </tr>


                    @endforelse


                </tbody>

            </table>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const buscador = document.getElementById('buscarCliente');
    if (!buscador) return;

    buscador.addEventListener('input', function () {
        const busqueda = this.value.toLocaleLowerCase('es').trim();

        document.querySelectorAll('tbody tr').forEach(function (fila) {
            // La fila vacía se mantiene visible si no hay búsqueda.
            const contenido = fila.innerText.toLocaleLowerCase('es');
            fila.style.display = contenido.includes(busqueda) ? '' : 'none';
        });
    });
});
</script>

</body>

</html>