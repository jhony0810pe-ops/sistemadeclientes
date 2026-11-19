<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MikroTikService
{
    private function host(): string
    {
        return rtrim(
            preg_replace(
                '#^https?://#',
                '',
                env('MIKROTIK_HOST', '10.0.0.1')
            ),
            '/'
        );
    }

    private function conexion()
    {
        return Http::withBasicAuth(
            env('MIKROTIK_USER'),
            env('MIKROTIK_PASSWORD')
        )
        ->acceptJson()
        ->connectTimeout(5)
        ->timeout(10);
    }

    private function url(string $ruta): string
    {
        return 'http://' . $this->host() . '/rest/' . ltrim($ruta, '/');
    }

    // OBTENER CLIENTES PPPOE
    public function obtenerClientes()
    {
        return $this->conexion()->get(
            $this->url('ppp/secret')
        );
    }

    // OBTENER CLIENTES ACTIVOS
    public function obtenerActivos()
    {
        return $this->conexion()->get(
            $this->url('ppp/active')
        );
    }

    // CREAR CLIENTE PPPOE
    public function crearClientePPPoE($datos)
    {
        return $this->conexion()->post(
            $this->url('ppp/secret'),
            [
                'name' => $datos['nombre'],
                'password' => $datos['clave'],
                'service' => 'pppoe',
                'profile' => $datos['perfil'],
                'comment' => $datos['comentario'] ?? '',
            ]
        );
    }
}
