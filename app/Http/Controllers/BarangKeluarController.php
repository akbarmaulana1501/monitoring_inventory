<?php

namespace App\Http\Controllers;

use App\Models\M_activity_log;
use App\Models\M_barang_keluar;
use App\Models\M_barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = M_barang_keluar::query();

        // Filter pencarian berdasarkan nama/kode barang
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('tujuan', 'like', "%{$search}%"); // pastikan kolom ini ada di tabel
            });
        }

        $barangKeluar = $query->orderBy('tanggal', 'desc')->paginate(5);
        return view('admin.barang_keluar.tampil_data', compact('barangKeluar'));
    }

    public function tambah_data_barang_keluar()
    {
        $barangs = M_barang::all();
        return view('admin.barang_keluar.tambah_data', compact('barangs'));
    }

    public function edit_data_barang_keluar($id)
    {
        $barangKeluar = M_barang_keluar::find($id);
        $barangs = M_barang::all();
        return view('admin.barang_keluar.edit_data', compact('barangKeluar', 'barangs'));
    }

    public function store_barang_keluar(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:0',
            'tujuan' => 'required',
        ]);

        $data = $request->all();
        $data['input_by'] = Auth::user()->username;

        M_barang_keluar::create($data);

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'Menambahkan barang keluar dengan kode: ' . $request->kode_barang,
        ]);

        return redirect()->route('stok_keluar')->with('success', 'Barang berhasil ditambahkan');
    }

    public function hapus_barang_keluar($id)
    {
        // Cari data berdasarkan ID
        $barang = M_barang_keluar::find($id);

        // Jika tidak ditemukan
        if (!$barang) {
            return redirect()->back()->with('loginError', 'Data tidak ditemukan.');
        }

        $kodeBarang = $barang->kode_barang;

        // Hapus data
        $barang->delete();

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'Menghapus barang keluar dengan kode: ' . $kodeBarang,
        ]);

        return redirect()->back()->with('success_hapus', 'Data barang masuk berhasil dihapus.');
    }

    public function update_data_barang_keluar(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:0',
            'tujuan' => 'required',
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);

        // Cari data barang berdasarkan ID
        $barang = M_barang_keluar::findOrFail($id);

        // Update data
        $barang->kode_barang = $request->kode_barang;
        $barang->jumlah = $request->jumlah;
        $barang->tujuan = $request->tujuan;
        $barang->tanggal = $request->tanggal;
        // Tambahkan field lain sesuai kebutuhan

        $barang->save(); // Simpan perubahan

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'update data barang keluar: ' . $request->kode_barang,
        ]);

        // Redirect kembali ke halaman data barang
        return redirect()->route('stok_keluar')->with('success_update', 'Data barang Keluar berhasil diperbarui.');
    }
}
