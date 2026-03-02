<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_barang_keluar extends Model
{
    use HasFactory;

    protected $table = 'm_barang_keluars'; // Nama tabel
    protected $fillable = ['kode_barang', 'tanggal', 'jumlah', 'tujuan', 'input_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barang()
    {
        return $this->belongsTo(M_barang::class, 'kode_barang', 'kode_barang');
    }
}
