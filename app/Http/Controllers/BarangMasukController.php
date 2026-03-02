<?php

namespace App\Http\Controllers;

use App\Models\M_activity_log;
use App\Models\M_barang_masuk;
use App\Models\M_barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = M_barang_masuk::query();

        // Filter pencarian berdasarkan nama/kode barang
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%"); // pastikan kolom ini ada di tabel
            });
        }

        $barangMasuk = $query->orderBy('tanggal_masuk', 'desc')->paginate(5);
        return view('admin.barang_masuk.tampil_data', compact('barangMasuk'));
    }

    public function tambah_data_barang_masuk()
    {
        $barangs = M_barang::all();
        $kodeTransaksi = $this->auto_number_trx();
        return view('admin.barang_masuk.tambah_data', compact('barangs', 'kodeTransaksi'));
    }

    public function edit_data_barang_masuk($id)
    {
        $barangMasuk = M_barang_masuk::find($id);
        $barangs = M_barang::all();
        return view('admin.barang_masuk.edit_data', compact('barangMasuk', 'barangs'));
    }

    public function store_barang_masuk(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required',
            'kode_transaksi' => 'required',
            'jumlah' => 'required',
            'satuan' => 'required',
            'tanggal_masuk' => 'required|date',
        ]);

        $data = $request->all();
        $data['input_by'] = Auth::user()->username;

        M_barang_masuk::create($data);

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'Menambahkan barang masuk dengan kode: ' . $request->kode_barang,
        ]);

        return redirect()->route('stok_masuk')->with('success', 'Barang berhasil ditambahkan');
    }

    public function hapus_barang_masuk($id)
    {
        // Cari data berdasarkan ID
        $barang = M_barang_masuk::find($id);

        // Jika tidak ditemukan
        if (!$barang) {
            return redirect()->back()->with('loginError', 'Data tidak ditemukan.');
        }

        $kodeBarang = $barang->kode_barang;

        // Hapus data
        $barang->delete();

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'Menghapus barang masuk dengan kode: ' . $kodeBarang,
        ]);

        return redirect()->back()->with('success_hapus', 'Data barang masuk berhasil dihapus.');
    }

    public function update_data_barang_masuk(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'kode_transaksi' => 'required',
            'jumlah' => 'required',
            'satuan' => 'required',
            'tanggal_masuk' => 'required|date',
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);

        // Cari data barang berdasarkan ID
        $barang = M_barang_masuk::findOrFail($id);

        // Update data
        $barang->kode_barang = $request->kode_barang;
        $barang->kode_transaksi = $request->kode_transaksi;
        $barang->jumlah = $request->jumlah;
        $barang->satuan = $request->satuan;
        $barang->tanggal_masuk = $request->tanggal_masuk;
        // Tambahkan field lain sesuai kebutuhan

        $barang->save(); // Simpan perubahan

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'update data barang masuk: ' . $request->kode_barang,
        ]);

        // Redirect kembali ke halaman data barang
        return redirect()->route('stok_masuk')->with('success_update', 'Data barang Masuk berhasil diperbarui.');
    }

    public function auto_number_trx()
    {
        // Ambil transaksi terakhir, urut berdasarkan angka setelah 'TRX'
        $latest = M_barang_masuk::orderByRaw('CAST(SUBSTRING(kode_transaksi, 4) AS UNSIGNED) DESC')->first();

        if (!$latest || !preg_match('/TRX(\d+)/', $latest->kode_transaksi, $matches)) {
            $number = 1;
        } else {
            $number = (int)$matches[1] + 1;
        }

        // Hasil: TRX10, TRX11, dll tanpa leading zero
        return 'TRX' . str_pad($number, 3, '0', STR_PAD_LEFT);  // Contoh: TRX001, TRX010
    }
}
