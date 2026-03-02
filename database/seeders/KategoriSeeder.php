<?php

namespace Database\Seeders;

use App\Models\M_kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        M_kategori::create([
            'nama_kategori' => "Elektronik Rumah Tangga",
            'deskripsi' => "Perangkat elektronik yang digunakan untuk kebutuhan rumah seperti TV, kulkas, AC, mesin cuci, dan dispenser."
        ]);
        
        M_kategori::create([
            'nama_kategori' => "Elektronik Konsumen",
            'deskripsi' => "Produk elektronik pribadi seperti handphone, tablet, earphone, dan speaker portable."
        ]);
        
        M_kategori::create([
            'nama_kategori' => "Komputer & Aksesoris",
            'deskripsi' => "Produk komputer dan perangkat pendukungnya, seperti laptop, printer, monitor, mouse, dan keyboard."
        ]);
        
        M_kategori::create([
            'nama_kategori' => "Kabel & Konektor",
            'deskripsi' => "Segala jenis kabel dan konektor termasuk kabel HDMI, kabel listrik, adaptor, dan terminal listrik."
        ]);
        
        M_kategori::create([
            'nama_kategori' => "Komponen Elektronik",
            'deskripsi' => "Komponen kecil seperti resistor, IC, LED, kapasitor, dan transistor yang biasa digunakan untuk perakitan atau perbaikan elektronik."
        ]);
        
        M_kategori::create([
            'nama_kategori' => "Peralatan & Tools",
            'deskripsi' => "Alat bantu teknisi seperti solder, multimeter, tang, obeng set, dan alat pengupas kabel."
        ]);
        
        M_kategori::create([
            'nama_kategori' => "Pencahayaan",
            'deskripsi' => "Produk penerangan seperti lampu LED, strip LED, fitting lampu, dan lampu emergency."
        ]);
        
        M_kategori::create([
            'nama_kategori' => "Baterai & Daya",
            'deskripsi' => "Produk daya seperti baterai isi ulang, charger, power bank, dan inverter listrik."
        ]);
        
        M_kategori::create([
            'nama_kategori' => "Keamanan & CCTV",
            'deskripsi' => "Sistem pengawasan dan keamanan seperti kamera CCTV, DVR/NVR, dan sensor alarm."
        ]);
        
        M_kategori::create([
            'nama_kategori' => "Aksesori Elektronik",
            'deskripsi' => "Aksesori tambahan seperti remote TV, pelindung layar, casing, bracket TV, dan kabel tambahan."
        ]);
        
    }
}
