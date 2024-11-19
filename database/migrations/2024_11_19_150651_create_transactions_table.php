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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_telp', 15);
            $table->text('alamat')->nullable();
            $table->string('merk_frame')->nullable();
            $table->string('jenis_lensa')->nullable();
            $table->decimal('harga_frame', 10, 2)->nullable();
            $table->decimal('harga_lensa', 10, 2)->nullable();
            $table->decimal('r_sph', 4, 2)->nullable();
            $table->decimal('r_cyl', 4, 2)->nullable();
            $table->decimal('r_axis', 4, 2)->nullable();
            $table->decimal('r_add', 4, 2)->nullable();
            $table->decimal('r_pd', 4, 2)->nullable();
            $table->decimal('l_sph', 4, 2)->nullable();
            $table->decimal('l_cyl', 4, 2)->nullable();
            $table->decimal('l_axis', 4, 2)->nullable();
            $table->decimal('l_add', 4, 2)->nullable();
            $table->decimal('l_pd', 4, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('bayar', 10, 2)->nullable();
            $table->decimal('kurang', 10, 2)->default(0);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
