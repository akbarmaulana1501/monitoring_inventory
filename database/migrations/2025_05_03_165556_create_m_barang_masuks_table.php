<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBarangMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang'); // relasi ke m_barangs
            $table->string('kode_transaksi')->unique();
            $table->integer('jumlah');
            $table->string('satuan');
            $table->date('tanggal_masuk');
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
        Schema::dropIfExists('m_barang_masuks');
    }
}
