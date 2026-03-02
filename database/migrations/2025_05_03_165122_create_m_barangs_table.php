<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique(); // unik supaya tidak ada barang ganda
            $table->string('nama_barang');
            $table->string('kategori')->nullable(); // boleh kosong jika belum dikelompokkan
            $table->integer('stok')->default(0); // default 0 supaya aman
            $table->integer('stok_sekarang')->default(0);
            $table->string('satuan')->nullable();
            $table->string('lokasi')->nullable(); // gudang / rak
            $table->enum('kondisi', ['Baru', 'Rusak', 'Bekas'])->default('Baru');
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
        Schema::dropIfExists('m_barangs');
    }
}
