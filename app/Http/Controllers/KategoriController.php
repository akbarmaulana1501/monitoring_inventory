<?php

namespace App\Http\Controllers;

use App\Models\M_activity_log;
use App\Models\M_kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = M_kategori::query();

        // Filter pencarian berdasarkan nama/kode barang
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kategori', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%"); // pastikan kolom ini ada di tabel
            });
        }

        $kategori = $query->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.kategori.tampil_data', compact('kategori'));
    }

    public function tambah_kategori()
    {
        return view('admin.kategori.tambah_data');
    }

    public function edit_kategori($id)
    {
        $kategori = M_kategori::find($id);
        return view('admin.kategori.edit_data', compact('kategori'));
    }

    public function store_kategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required'
        ]);

        M_kategori::create($request->all());

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'Menambahkan kategori baru dengan nama: ' . $request->nama_kategori,
        ]);

        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function hapus_kategori($id)
    {
        // Cari data berdasarkan ID
        $kategori = M_kategori::find($id);

        // Jika tidak ditemukan
        if (!$kategori) {
            return redirect()->back()->with('loginError', 'Data tidak ditemukan.');
        }

        $namaKategori = $kategori->nama_kategori;

        // Hapus data
        $kategori->delete();

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'Menghapus kategori dengan nama: ' . $namaKategori,
        ]);

        return redirect()->back()->with('success_hapus', 'Data kategori berhasil dihapus.');
    }

    public function update_kategori(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required'
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);

        // Cari data barang berdasarkan ID
        $kategori = M_kategori::findOrFail($id);

        // Update data
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->deskripsi = $request->deskripsi;
        // Tambahkan field lain sesuai kebutuhan

        $kategori->save(); // Simpan perubahan

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'update kategori dengan nama: ' . $kategori->nama_kategori,
        ]);

        // Redirect kembali ke halaman data barang
        return redirect()->route('kategori')->with('success_update', 'Data barang Keluar berhasil diperbarui.');
    }
}
