<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pisos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('titulo');
            $table->string('ciudad');
            $table->string('zona');
            $table->float('precio');
            $table->string('planta');
            $table->integer('extension');
            $table->integer('habitaciones');
            $table->integer('baños');
            $table->longText('descripcion');
            $table->json('caracteristicas')->nullable();
            $table->json('fotos')->nullable();
            $table->boolean('isFavorite');
            $table->string('propietario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pisos');
    }
};
