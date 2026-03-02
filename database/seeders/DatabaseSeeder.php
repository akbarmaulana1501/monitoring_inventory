<?php

namespace Database\Seeders;

use App\Models\M_barang;
use App\Models\M_barang_keluar;
use App\Models\M_barang_masuk;
use App\Models\M_kategori;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => "admin",
            'password' => Hash::make('123456'),
            'role' => "admin",
            'status'=> "aktif"
        ]);
        User::create([
            'username' => "naufal",
            'password' => Hash::make('123456'),
            'role' => "petugas",
            'status'=> "aktif"
        ]);
        User::create([
            'username' => "sahid",
            'password' => Hash::make('123456'),
            'role' => "pimpinan",
            'status'=> "aktif"
        ]);

        // M_kategori::create([
        //     'nama_kategori' => "Elektronik Rumah Tangga",
        //     'deskripsi'=> "Perangkat elektronik yang digunakan untuk kebutuhan rumah seperti TV, kulkas, AC, mesin cuci, dan dispenser."
        // ]);

        // for ($i = 1; $i <= 10; $i++) {
        //     M_barang::create([
        //         'kode_barang' => 'A0' . $i,
        //         'nama_barang' => 'Barang ' . $i,
        //         'kategori' => 'Elektronik Rumah Tangga',
        //         'stok' => rand(1, 100),
        //         'satuan' => 'unit',
        //         'lokasi' => 'Gudang ' . $i,
        //         'kondisi' => 'Baik',
        //     ]);
        // }

        // for ($i = 1; $i <= 10; $i++) {
        //     M_barang_masuk::create([
        //         'kode_barang' => 'A0' . $i, // contoh kode_barang
        //         'kode_transaksi' => 'TRX0' . $i,
        //         'jumlah' => rand(1, 20), // random jumlah
        //         'satuan' => 'unit',
        //         'input_by'=>'1',
        //         'tanggal_masuk' => now(), // tanggal saat ini
        //     ]);
        // }

        // for ($i = 1; $i <= 10; $i++) {
        //     M_barang_keluar::create([
        //         'kode_barang' => 'A0' . rand(10, 20),
        //         'tanggal' => now(),
        //         'jumlah' => rand(1, 50),
        //         'tujuan' => 'Tujuan ' . $i,
        //         'input_by'=>'1'
        //     ]);
        // }

        // User::factory(10)->create();
    }
}
