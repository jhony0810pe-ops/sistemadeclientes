<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class MikroTikService
{
    private function host(): string
    {
        return rtrim(
            preg_replace(
                '#^https?://#',
                '',
                env('MIKROTIK_HOST', '192.168.9.20')
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

    

public function obtenerClientes()
{
    return $this->conexion()->get(
        $this->url('ppp/secret')
    );
}



    public function obtenerActivos()
    {
        return $this->conexion()->get(
            $this->url('ppp/active')
        );
    }

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