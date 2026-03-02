<?php

namespace App\Http\Controllers;

use App\Models\M_activity_log;
use App\Models\M_barang_keluar;
use App\Models\M_barang_masuk;
use App\Models\M_barang;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $user = User::count();
        $barangMasuk = M_barang_masuk::count();
        $barangKeluar = M_barang_keluar::count();
        $barangRusak = M_barang::where('kondisi', 'rusak')->count();
        $activities = M_activity_log::with('user')->latest()->take(5)->get();
        return view('admin.index', compact('user', 'barangMasuk', 'barangKeluar','barangRusak','activities'));
    }
}
