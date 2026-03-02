<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_barang_masuk extends Model
{
    use HasFactory;

    protected $table = 'm_barang_masuks'; // Nama tabel
    protected $fillable = ['kode_barang', 'kode_transaksi', 'jumlah', 'satuan', 'tanggal_masuk', 'input_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barang()
    {
        return $this->belongsTo(M_barang::class, 'kode_barang', 'kode_barang');
    }
}
