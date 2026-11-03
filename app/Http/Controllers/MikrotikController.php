<?php

namespace App\Http\Controllers;

use App\Services\MikroTikService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MikroTikController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CONEXIÓN CON MIKROTIK
    |--------------------------------------------------------------------------
    */

    private function mikrotik()
    {
        return Http::withBasicAuth(
            env('MIKROTIK_USER'),
            env('MIKROTIK_PASSWORD')
        )
        ->acceptJson()
        ->connectTimeout(5)
        ->timeout(15);
    }

    /*
    |--------------------------------------------------------------------------
    | DIRECCIÓN IP Y URL DEL ROUTER
    |--------------------------------------------------------------------------
    */

    private function ip(): string
    {
        $host = env('MIKROTIK_HOST', '192.168.9.20');

        $host = preg_replace('#^https?://#i', '', $host);

        return rtrim($host, '/');
    }

    private function urlMikroTik(string $ruta): string
    {
        return 'http://' . $this->ip()
            . '/rest/' . ltrim($ruta, '/');
    }

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR REGLAS E IP DE MOROSOS
    |--------------------------------------------------------------------------
    */

    private function obtenerReglasFirewall(): array
    {
        $respuesta = $this->mikrotik()->get(
            $this->urlMikroTik('ip/firewall/filter')
        );

        if (!$respuesta->successful()) {
            throw new \RuntimeException(
                'No se pudieron consultar las reglas: '
                . $respuesta->body()
            );
        }

        return $respuesta->json() ?? [];
    }

    private function obtenerListaMorosos(): array
    {
        $respuesta = $this->mikrotik()->get(
            $this->urlMikroTik('ip/firewall/address-list')
        );

        if (!$respuesta->successful()) {
            throw new \RuntimeException(
                'No se pudo consultar MOROSOS: '
                . $respuesta->body()
            );
        }

        return collect($respuesta->json() ?? [])
            ->filter(fn ($item) => ($item['list'] ?? '') === 'MOROSOS')
            ->values()
            ->all();
    }

    private function obtenerIpDeRegla(string $id): ?string
    {
        foreach ($this->obtenerReglasFirewall() as $regla) {
            if (($regla['.id'] ?? '') !== $id) {
                continue;
            }

            $comentario = $regla['comment'] ?? '';

            if (str_starts_with($comentario, 'CORTE_IP_')) {
                return substr($comentario, strlen('CORTE_IP_'));
            }

            return null;
        }

        return null;
    }

    private function buscarEntradaMorosos(string $ip): ?array
    {
        foreach ($this->obtenerListaMorosos() as $entrada) {
            if (($entrada['address'] ?? '') === $ip) {
                return $entrada;
            }
        }

        return null;
    }

    private function actualizarReglaIp(string $id, string $deshabilitada)
    {
        return $this->mikrotik()->patch(
            $this->urlMikroTik(
                'ip/firewall/filter/' . rawurlencode($id)
            ),
            ['disabled' => $deshabilitada]
        );
    }

    private function actualizarEntradaMorosos(
        string $id,
        string $deshabilitada
    ) {
        return $this->mikrotik()->patch(
            $this->urlMikroTik(
                'ip/firewall/address-list/' . rawurlencode($id)
            ),
            ['disabled' => $deshabilitada]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PÁGINA WIFI
    |--------------------------------------------------------------------------
    */

    public function wifi()
    {
        try {
            $lista = $this->obtenerListaMorosos();
            $reglas = $this->obtenerReglasFirewall();

            $clientes = collect($lista)
                ->map(function ($entrada) use ($reglas) {
                    $ip = $entrada['address'] ?? '';

                    $regla = collect($reglas)->first(
                        fn ($item) =>
                            ($item['comment'] ?? '') === 'CORTE_IP_' . $ip
                    );

                    $comentarioEntrada = $entrada['comment'] ?? '';
                    $nombre = '';

                    if (str_starts_with($comentarioEntrada, 'NOMBRE:')) {
                        $nombre = substr($comentarioEntrada, strlen('NOMBRE:'));
                    } elseif (str_starts_with($comentarioEntrada, 'IP_CONTROLADA_')) {
                        // Las IP registradas antes de agregar el campo Nombre no tenían nombre.
                        $nombre = '';
                    } else {
                        // Compatibilidad con entradas donde el comentario ya sea el nombre.
                        $nombre = $comentarioEntrada;
                    }

                    return [
                        'id' => $regla['.id'] ?? '',
                        'nombre' => $nombre,
                        'ip' => $ip,
                        'disabled' => $regla['disabled'] ?? 'yes',
                        'address_id' => $entrada['.id'] ?? '',
                        'lista_disabled' => $entrada['disabled'] ?? 'no',
                    ];
                })
                ->values()
                ->all();

            return view('mikrotik.wifi', [
                'clientes' => $clientes,
                'error' => null,
            ]);

        } catch (\Throwable $e) {
            return view('mikrotik.wifi', [
                'clientes' => [],
                'error' => 'Error de conexión con MikroTik: '
                    . $e->getMessage(),
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | AGREGAR IP A MOROSOS
    |--------------------------------------------------------------------------
    */

    public function agregarIp(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'ip' => ['required', 'ip'],
        ]);

        $nombre = trim($datos['nombre']);
        $ip = $datos['ip'];

        try {
            $entradaExistente = $this->buscarEntradaMorosos($ip);

            if ($entradaExistente) {
                return back()->with(
                    'error',
                    "La IP {$ip} ya está registrada en MOROSOS."
                );
            }

            $reglas = $this->obtenerReglasFirewall();

            $reglaExistente = collect($reglas)->first(
                fn ($regla) =>
                    ($regla['comment'] ?? '') === 'CORTE_IP_' . $ip
            );

            if (!$reglaExistente) {
                $crearRegla = $this->mikrotik()->put(
                    $this->urlMikroTik('ip/firewall/filter'),
                    [
                        'chain' => 'forward',
                        'src-address' => $ip,
                        'action' => 'drop',
                        'comment' => 'CORTE_IP_' . $ip,
                        'disabled' => 'yes',
                    ]
                );

                if (!$crearRegla->successful()) {
                    return back()->with(
                        'error',
                        'No se pudo crear la regla de bloqueo: '
                            . $crearRegla->body()
                    );
                }
            } else {
                // Si la regla ya existía, dejarla apagada inicialmente.
                $idRegla = $reglaExistente['.id'] ?? null;

                if ($idRegla) {
                    $actualizar = $this->actualizarReglaIp(
                        $idRegla,
                        'yes'
                    );

                    if (!$actualizar->successful()) {
                        return back()->with(
                            'error',
                            'No se pudo preparar la regla de la IP.'
                        );
                    }
                }
            }

            $crearEntrada = $this->mikrotik()->put(
                $this->urlMikroTik('ip/firewall/address-list'),
                [
                    'list' => 'MOROSOS',
                    'address' => $ip,
                    // Guardamos el nombre en el comentario de la entrada MOROSOS.
                    'comment' => 'NOMBRE:' . $nombre,
                    'disabled' => 'no',
                ]
            );

            if (!$crearEntrada->successful()) {
                return back()->with(
                    'error',
                    'No se pudo agregar la IP a MOROSOS: '
                        . $crearEntrada->body()
                );
            }

            return back()->with(
                'success',
                "El cliente {$nombre} ({$ip}) se agregó a MOROSOS con internet habilitado."
            );

        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'Error al agregar la IP: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | COMPATIBILIDAD CON LA RUTA AGREGAR MOROSO
    |--------------------------------------------------------------------------
    */

    public function agregarMoroso(Request $request)
    {
        return $this->agregarIp($request);
    }

    /*
    |--------------------------------------------------------------------------
    | HABILITAR INTERNET
    |--------------------------------------------------------------------------
    */

    public function enableWifi($id)
    {
        try {
            $ip = $this->obtenerIpDeRegla((string) $id);

            if (!$ip) {
                return back()->with(
                    'error',
                    'No se encontró la regla de bloqueo de esa IP.'
                );
            }

            // Apagar la regla DROP permite el acceso a internet.
            $respuesta = $this->actualizarReglaIp(
                (string) $id,
                'yes'
            );

            if (!$respuesta->successful()) {
                return back()->with(
                    'error',
                    'No se pudo habilitar internet: '
                        . $respuesta->body()
                );
            }

            // Conservar y activar la entrada de MOROSOS.
            $entrada = $this->buscarEntradaMorosos($ip);

            if ($entrada && !empty($entrada['.id'])) {
                $listaRespuesta = $this->actualizarEntradaMorosos(
                    $entrada['.id'],
                    'no'
                );

                if (!$listaRespuesta->successful()) {
                    return back()->with(
                        'error',
                        'Internet se habilitó, pero no se pudo activar la entrada de MOROSOS.'
                    );
                }
            }

            return back()->with(
                'success',
                "Internet habilitado para {$ip}. La IP permanece en MOROSOS."
            );

        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'Error al habilitar: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CORTAR SERVICIO
    |--------------------------------------------------------------------------
    */

    public function disableWifi($id)
    {
        try {
            $ip = $this->obtenerIpDeRegla((string) $id);

            if (!$ip) {
                return back()->with(
                    'error',
                    'No se encontró la regla de bloqueo de esa IP.'
                );
            }

            // Activar la regla DROP corta el acceso a internet.
            $respuesta = $this->actualizarReglaIp(
                (string) $id,
                'no'
            );

            if (!$respuesta->successful()) {
                return back()->with(
                    'error',
                    'No se pudo cortar el servicio: '
                        . $respuesta->body()
                );
            }

            // Mantener la entrada de MOROSOS activa y sin borrarla.
            $entrada = $this->buscarEntradaMorosos($ip);

            if ($entrada && !empty($entrada['.id'])) {
                $listaRespuesta = $this->actualizarEntradaMorosos(
                    $entrada['.id'],
                    'no'
                );

                if (!$listaRespuesta->successful()) {
                    return back()->with(
                        'error',
                        'El servicio se cortó, pero no se pudo actualizar la entrada de MOROSOS.'
                    );
                }
            }

            return back()->with(
                'success',
                "Servicio cortado para {$ip}. La IP permanece en MOROSOS."
            );

        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'Error al cortar el servicio: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DESHABILITAR SIN ELIMINAR LA IP
    |--------------------------------------------------------------------------
    */

    public function deshabilitarWifi($id)
    {
        try {
            $ip = $this->obtenerIpDeRegla((string) $id);

            if (!$ip) {
                return back()->with(
                    'error',
                    'No se encontró la regla de esa IP.'
                );
            }

            // Dejar apagada la regla DROP.
            $respuestaRegla = $this->actualizarReglaIp(
                (string) $id,
                'yes'
            );

            if (!$respuestaRegla->successful()) {
                return back()->with(
                    'error',
                    'No se pudo deshabilitar la regla: '
                        . $respuestaRegla->body()
                );
            }

            // Deshabilitar la entrada, pero no eliminarla de MOROSOS.
            $entrada = $this->buscarEntradaMorosos($ip);

            if ($entrada && !empty($entrada['.id'])) {
                $respuestaLista = $this->actualizarEntradaMorosos(
                    $entrada['.id'],
                    'yes'
                );

                if (!$respuestaLista->successful()) {
                    return back()->with(
                        'error',
                        'La regla se deshabilitó, pero no se pudo deshabilitar la entrada de MOROSOS.'
                    );
                }
            }

            return back()->with(
                'success',
                "La IP {$ip} quedó deshabilitada y permanece en MOROSOS."
            );

        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'Error al deshabilitar: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PÁGINA PPPoE
    |--------------------------------------------------------------------------
    */

    public function ppp()
    {
        try {
            $respuesta = $this->mikrotik()->get(
                $this->urlMikroTik('ppp/secret')
            );

            if (!$respuesta->successful()) {
                return view('mikrotik.ppp', [
                    'usuarios' => [],
                    'error' => 'MikroTik respondió con código: '
                        . $respuesta->status(),
                ]);
            }

            return view('mikrotik.ppp', [
                'usuarios' => $respuesta->json() ?? [],
                'error' => null,
            ]);

        } catch (\Throwable $e) {
            return view('mikrotik.ppp', [
                'usuarios' => [],
                'error' => 'Error de conexión: ' . $e->getMessage(),
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | HABILITAR USUARIO PPPoE
    |--------------------------------------------------------------------------
    */

    public function habilitarPPP($id)
    {
        try {
            $respuesta = $this->mikrotik()->patch(
                $this->urlMikroTik(
                    'ppp/secret/' . rawurlencode((string) $id)
                ),
                ['disabled' => 'no']
            );

            if (!$respuesta->successful()) {
                return back()->with(
                    'error',
                    'No se pudo habilitar el usuario: '
                        . $respuesta->body()
                );
            }

            return back()->with(
                'success',
                'Usuario PPPoE habilitado correctamente.'
            );

        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'Error: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DESHABILITAR USUARIO PPPoE
    |--------------------------------------------------------------------------
    */

    public function deshabilitarPPP($id)
    {
        try {
            $respuesta = $this->mikrotik()->patch(
                $this->urlMikroTik(
                    'ppp/secret/' . rawurlencode((string) $id)
                ),
                ['disabled' => 'yes']
            );

            if (!$respuesta->successful()) {
                return back()->with(
                    'error',
                    'No se pudo deshabilitar el usuario: '
                        . $respuesta->body()
                );
            }

            return back()->with(
                'success',
                'Usuario PPPoE deshabilitado correctamente.'
            );

        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'Error: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LISTA DE MOROSOS
    |--------------------------------------------------------------------------
    */

    public function morosos()
    {
        try {
            $morosos = $this->obtenerListaMorosos();

            return view('mikrotik.morosos', [
                'morosos' => $morosos,
                'error' => null,
            ]);

        } catch (\Throwable $e) {
            return view('mikrotik.morosos', [
                'morosos' => [],
                'error' => 'Error de conexión: ' . $e->getMessage(),
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | HABILITAR ENTRADA DE MOROSOS
    |--------------------------------------------------------------------------
    */

    public function habilitarMoroso($id)
    {
        try {
            $respuesta = $this->actualizarEntradaMorosos(
                (string) $id,
                'no'
            );

            if (!$respuesta->successful()) {
                return back()->with(
                    'error',
                    'No se pudo habilitar la entrada: '
                        . $respuesta->body()
                );
            }

            return back()->with(
                'success',
                'Entrada de MOROSOS habilitada correctamente.'
            );

        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'Error: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DESHABILITAR ENTRADA DE MOROSOS SIN ELIMINARLA
    |--------------------------------------------------------------------------
    */

    public function deshabilitarMoroso($id)
    {
        try {
            $respuesta = $this->actualizarEntradaMorosos(
                (string) $id,
                'yes'
            );

            if (!$respuesta->successful()) {
                return back()->with(
                    'error',
                    'No se pudo deshabilitar la entrada: '
                        . $respuesta->body()
                );
            }

            return back()->with(
                'success',
                'Entrada deshabilitada; la IP sigue registrada en MOROSOS.'
            );

        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'Error: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR MOROSO
    |--------------------------------------------------------------------------
    */

    public function eliminarMoroso($id)
    {
        try {
            $lista = $this->obtenerListaMorosos();

            $entrada = collect($lista)->first(
                fn ($item) => ($item['.id'] ?? '') === (string) $id
            );

            if (!$entrada) {
                return back()->with(
                    'error',
                    'No se encontró la IP en MOROSOS.'
                );
            }

            $ip = $entrada['address'] ?? '';

            // Eliminar la entrada de la lista.
            $respuesta = $this->mikrotik()->delete(
                $this->urlMikroTik(
                    'ip/firewall/address-list/' . rawurlencode((string) $id)
                )
            );

            if (!$respuesta->successful()) {
                return back()->with(
                    'error',
                    'No se pudo eliminar la entrada: '
                        . $respuesta->body()
                );
            }

            // Si existe la regla individual, eliminarla también.
            $reglas = $this->obtenerReglasFirewall();

            $regla = collect($reglas)->first(
                fn ($item) =>
                    ($item['comment'] ?? '') === 'CORTE_IP_' . $ip
            );

            if ($regla && !empty($regla['.id'])) {
                $this->mikrotik()->delete(
                    $this->urlMikroTik(
                        'ip/firewall/filter/'
                        . rawurlencode($regla['.id'])
                    )
                );
            }

            return back()->with(
                'success',
                "La IP {$ip} fue eliminada de MOROSOS y su regla individual fue retirada."
            );

        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'Error al eliminar: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LISTAR CLIENTES PPPoE
    |--------------------------------------------------------------------------
    */

    public function listarPPoe(MikroTikService $mikrotik)
    {
        try {
            $respuesta = $mikrotik->obtenerClientes();

            if (!$respuesta->successful()) {
                return view('listarPPoe', [
                    'clientes' => [],
                    'error' => 'MikroTik respondió con código: '
                        . $respuesta->status(),
                ]);
            }

            return view('listarPPoe', [
                'clientes' => $respuesta->json() ?? [],
                'error' => null,
            ]);

        } catch (\Throwable $e) {
            return view('listarPPoe', [
                'clientes' => [],
                'error' => 'No se pudo consultar el router: '
                    . $e->getMessage(),
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MOSTRAR FORMULARIO PARA CREAR PPPoE
    |--------------------------------------------------------------------------
    */

    public function mostrarCrearPPoe()
    {
        return view('CrearPpoe');
    }

    /*
    |--------------------------------------------------------------------------
    | CREAR CLIENTE PPPoE
    |--------------------------------------------------------------------------
    */

    public function crearPPoe(
        Request $request,
        MikroTikService $mikrotik
    ) {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'clave' => 'required|string|max:100',
            'perfil' => 'required|string|max:100',
            'comentario' => 'nullable|string|max:200',
        ]);

        try {
            $respuesta = $mikrotik->crearClientePPPoE($datos);

            if ($respuesta->successful()) {
                return redirect('/mikrotik/listarPPoe')->with(
                    'mensaje',
                    'Cliente PPPoE creado correctamente en MikroTik.'
                );
            }

            return back()
                ->withInput()
                ->with(
                    'mensaje',
                    'No se pudo crear el cliente: ' . $respuesta->body()
                );

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with(
                    'mensaje',
                    'Error al crear el cliente: ' . $e->getMessage()
                );
        }
    }
}