<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBarangKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_barang_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->string('tujuan');
            $table->string('input_by');
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
        Schema::dropIfExists('m_barang_keluars');
    }
}
