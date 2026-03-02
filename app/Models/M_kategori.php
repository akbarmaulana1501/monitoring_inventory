<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_kategori extends Model
{
    use HasFactory;

    protected $table = 'm_kategoris'; // Nama tabel
    protected $fillable = ['nama_kategori','deskripsi'];
}
