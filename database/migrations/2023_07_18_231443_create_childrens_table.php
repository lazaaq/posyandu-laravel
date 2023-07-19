<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('childrens', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('nik');
            $table->string('kk');
            $table->float('bb_lahir');
            $table->float('tb_lahir');
            $table->string('ibu_nama');
            $table->string('ibu_nik');
            $table->string('ibu_hp');
            $table->string('alamat_padukuhan');
            $table->string('alamat_rt');
            $table->string('alamat_rw');
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('childrens');
    }
};
