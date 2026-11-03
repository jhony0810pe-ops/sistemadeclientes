<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();

            $table->string('numero_factura')->unique();

            $table->string('cliente');

            $table->date('fecha_emision');

            $table->date('fecha_vencimiento');

            $table->string('periodo_facturado');

            $table->text('concepto');

            $table->decimal('subtotal', 10, 2);

            $table->decimal('iva', 10, 2);

            $table->decimal('total', 10, 2);

            $table->string('estado')->default('Pendiente');

            $table->string('metodo_pago');

            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};