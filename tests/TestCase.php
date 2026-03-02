<?php

namespace Tests;

use App\Models\M_barang;
use App\Models\M_kategori;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    use RefreshDatabase;

    // public function it_can_create_m_barang()
    // {
    //     $data = [
    //         'kode_barang' => 'BRG001',
    //         'nama_barang' => 'Laptop Lenovo',
    //         'kategori' => 'Elektronik',
    //         'stok' => 10,
    //         'satuan' => 'Unit',
    //         'lokasi' => 'Gudang A',
    //         'kondisi' => 'Baru',
    //     ];

    //     $barang = M_barang::create($data);

    //     $this->assertDatabaseHas('m_barangs', $data);
    //     $this->assertEquals('BRG001', $barang->kode_barang);
    //     $this->assertEquals('Laptop Lenovo', $barang->nama_barang);
    // }

    // /** @test */
    // public function it_can_update_m_barang()
    // {
    //     $barang = M_barang::create([
    //         'kode_barang' => 'BRG002',
    //         'nama_barang' => 'Monitor Samsung',
    //         'kategori' => 'Elektronik',
    //         'stok' => 5,
    //         'satuan' => 'Unit',
    //         'lokasi' => 'Gudang B',
    //         'kondisi' => 'Bekas',
    //     ]);

    //     $barang->update([
    //         'stok' => 8,
    //         'kondisi' => 'Baru',
    //     ]);

    //     $this->assertEquals(8, $barang->stok);
    //     $this->assertEquals('Baru', $barang->kondisi);
    //     $this->assertDatabaseHas('m_barangs', [
    //         'kode_barang' => 'BRG002',
    //         'stok' => 8,
    //         'kondisi' => 'Baru',
    //     ]);
    // }

    // /** @test */
    // public function it_can_delete_m_barang()
    // {
    //     $barang = M_barang::create([
    //         'kode_barang' => 'BRG003',
    //         'nama_barang' => 'Printer Canon',
    //         'kategori' => 'Elektronik',
    //         'stok' => 3,
    //         'satuan' => 'Unit',
    //         'lokasi' => 'Gudang C',
    //         'kondisi' => 'Baru',
    //     ]);

    //     $barang->delete();

    //     $this->assertDatabaseMissing('m_barangs', [
    //         'kode_barang' => 'BRG003',
    //     ]);
    // }

    public function it_can_insert_kategori()
    {
        // protected $fillable = ['kode_barang', 'kode_transaksi', 'jumlah', 'satuan', 'tanggal_masuk', 'input_by'];
        $barang = M_kategori::create([
            'nama_kategori'=>"elektronik",
            'deskripsi'=>"ini alat elektronik"
        ]);

        $barang = M_kategori::create($barang);

        $this->assertDatabaseHas('m_barangs', $barang);
        // $this->assertEquals('BRG001', $barang->kode_barang);
        // $this->assertEquals('Laptop Lenovo', $barang->nama_barang);
    }
}
