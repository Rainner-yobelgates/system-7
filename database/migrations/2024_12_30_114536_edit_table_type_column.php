<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('r_sph', 8)->nullable()->default(0)->change();
            $table->string('r_cyl', 8)->nullable()->default(0)->change();
            $table->string('r_axis', 8)->nullable()->default(0)->change();
            $table->string('r_add', 8)->nullable()->default(0)->change();
            $table->string('r_pd', 8)->nullable()->default(0)->change();
            $table->string('l_sph', 8)->nullable()->default(0)->change();
            $table->string('l_cyl', 8)->nullable()->default(0)->change();
            $table->string('l_axis', 8)->nullable()->default(0)->change();
            $table->string('l_add', 8)->nullable()->default(0)->change();
            $table->string('l_pd', 8)->nullable()->default(0)->change();
    
            $table->decimal('harga_frame', 10, 2)->nullable()->default(0)->change();
            $table->decimal('harga_lensa', 10, 2)->nullable()->default(0)->change();
            $table->decimal('total', 10, 2)->nullable()->default(0)->change();
            $table->decimal('bayar', 10, 2)->nullable()->default(0)->change();
            $table->decimal('kurang', 10, 2)->nullable()->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('r_sph', 4, 1)->default(0)->change();
            $table->decimal('r_cyl', 4, 1)->default(0)->change();
            $table->decimal('r_axis', 4, 1)->default(0)->change();
            $table->decimal('r_add', 4, 1)->default(0)->change();
            $table->decimal('r_pd', 4, 1)->default(0)->change();
            $table->decimal('l_sph', 4, 1)->default(0)->change();
            $table->decimal('l_cyl', 4, 1)->default(0)->change();
            $table->decimal('l_axis', 4, 1)->default(0)->change();
            $table->decimal('l_add', 4, 1)->default(0)->change();
            $table->decimal('l_pd', 4, 1)->default(0)->change();
    
            $table->decimal('harga_frame', 10, 2)->default(0)->change();
            $table->decimal('harga_lensa', 10, 2)->default(0)->change();
            $table->decimal('total', 10, 2)->default(0)->change();
            $table->decimal('bayar', 10, 2)->default(0)->change();
            $table->decimal('kurang', 10, 2)->default(0)->change();
        });
    }
};
