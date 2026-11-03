<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morosos</title>
    <style>
        :root { --verde: #65B32E; --verde-hover: #4F8F24; --verde-oscuro: #203B12; --negro: #000000; --fondo: #101010; --gris: #C6C6C6; --blanco: #FFFFFF; }
        * { box-sizing: border-box; }
        body { margin: 0; padding: 20px; font-family: Arial, sans-serif; background: var(--negro); color: var(--blanco); }
        .contenedor { max-width: 1000px; margin: auto; }
        .tarjeta { background: var(--fondo); padding: 25px; border-radius: 12px; border: 2px solid var(--verde); box-shadow: 0 0 15px rgba(101,179,46,.20); }
        h1 { text-align: center; margin-top: 0; margin-bottom: 25px; color: var(--verde); }
        h1::after { content: ""; display: block; width: 100px; height: 4px; background: var(--verde); margin: 10px auto 0; border-radius: 5px; }
        .formulario { display: flex; gap: 10px; margin-bottom: 25px; }
        .formulario input { flex: 1; padding: 12px; border: 2px solid var(--verde); border-radius: 6px; font-size: 16px; background: var(--negro); color: var(--blanco); outline: none; }
        .formulario input::placeholder { color: var(--gris); }
        .formulario input:focus { border-color: var(--verde); box-shadow: 0 0 8px rgba(101,179,46,.35); }
        .btn-agregar { background: var(--verde); color: var(--negro); border: 2px solid var(--verde); padding: 12px 20px; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-agregar:hover { background: var(--verde-hover); color: var(--blanco); }
        .tabla-contenedor { width: 100%; overflow-x: auto; border: 2px solid var(--verde); border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; min-width: 700px; }
        th { background: var(--verde); color: var(--negro); padding: 14px; text-align: center; border-right: 1px solid var(--verde-oscuro); }
        td { padding: 14px; border-bottom: 1px solid var(--verde-oscuro); border-right: 1px solid var(--verde-oscuro); text-align: center; background: var(--negro); color: var(--blanco); }
        tbody tr:nth-child(even) td { background: #101A0B; }
        tbody tr:hover td { background: var(--verde-oscuro); }
        .ip { font-weight: bold; font-size: 17px; color: var(--verde); }
        .estado-habilitado { color: var(--verde); font-weight: bold; }
        .estado-cortado { color: var(--gris); font-weight: bold; }
        .acciones { display: flex; justify-content: center; gap: 7px; flex-wrap: wrap; }
        button { border-radius: 6px; padding: 9px 14px; font-weight: bold; cursor: pointer; transition: .2s; }
        .btn-habilitar { background: var(--verde); color: var(--negro); border: 2px solid var(--verde); }
        .btn-habilitar:hover { background: var(--verde-hover); color: var(--blanco); }
        .btn-cortar { background: var(--negro); color: var(--verde); border: 2px solid var(--verde); }
        .btn-cortar:hover { background: var(--verde); color: var(--negro); }
        .btn-eliminar { background: var(--negro); color: var(--gris); border: 2px solid var(--gris); }
        .btn-eliminar:hover { background: var(--gris); color: var(--negro); }
        .btn-volver { display: inline-block; margin-top: 20px; background: var(--verde); color: var(--negro); text-decoration: none; padding: 12px 18px; border-radius: 7px; border: 2px solid var(--verde); font-weight: bold; }
        .btn-volver:hover { background: var(--verde-hover); color: var(--blanco); }
        .mensaje { padding: 13px; border-radius: 7px; margin-bottom: 20px; font-weight: bold; }
        .success { background: var(--verde-oscuro); color: var(--verde); border: 1px solid var(--verde); }
        .error { background: #202020; color: var(--gris); border: 1px solid var(--gris); }
        @media (max-width: 600px) { body { padding: 10px; } .tarjeta { padding: 15px; } .formulario { flex-direction: column; } .btn-agregar { width: 100%; } }
    
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
        content: "IP";
    }

    tbody td:nth-child(3)::before {
        content: "Estado";
    }

    tbody td:nth-child(4)::before {
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

    .formulario {
        flex-direction: column;
    }

    .formulario input,
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
        <h1>📋 MOROSOS</h1>
        @if(session('success'))
            <div class="mensaje success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mensaje error">{!! session('error') !!}</div>
        @endif
        <form action="{{ route('mikrotik.morosos.agregar') }}" method="POST" class="formulario">
            @csrf
            <input type="text" name="ip" placeholder="Ejemplo: 192.168.25.10" required>
            <button type="submit" class="btn-agregar">➕ AGREGAR IP</button>
        </form>
        <div class="tabla-contenedor">
            <table>
                <thead><tr><th>#</th><th>IP</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($morosos as $moroso)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="ip">{{ $moroso['address'] ?? 'Sin IP' }}</td>
                            <td>
                                @if(($moroso['disabled'] ?? 'no') === 'yes')
                                    <span class="estado-habilitado">🟢 HABILITADO</span>
                                @else
                                    <span class="estado-cortado">🔴 CORTADO</span>
                                @endif
                            </td>
                            <td>
                                <div class="acciones">
                                    @if(($moroso['disabled'] ?? 'no') === 'yes')
                                        <form action="{{ route('mikrotik.morosos.deshabilitar', $moroso['.id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-cortar">🔴 CORTAR</button>
                                        </form>
                                    @else
                                        <form action="{{ route('mikrotik.morosos.habilitar', $moroso['.id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-habilitar">🟢 HABILITAR</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('mikrotik.morosos.eliminar', $moroso['.id']) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta IP de MOROSOS?');">
                                        @csrf
                                        <button type="submit" class="btn-eliminar">🗑️ ELIMINAR</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No hay IPs agregadas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <a href="{{ route('mikrotik.wifi') }}" class="btn-volver">← CONTROL DE INTERNET</a>
    </div>
</div>
</body>
</html>
