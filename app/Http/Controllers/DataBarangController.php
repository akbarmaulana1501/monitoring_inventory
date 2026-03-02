<?php

namespace App\Http\Controllers;

use App\Models\M_activity_log;
use App\Models\M_barang;
use App\Models\M_barang_keluar;
use App\Models\M_barang_masuk;
use App\Models\M_kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataBarangController extends Controller
{

    public function index(Request $request)
    {

        $query = M_barang::query();

        // Filter pencarian berdasarkan nama/kode barang
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%"); // pastikan kolom ini ada di tabel
            });
        }

        $barang = $query->orderBy('created_at', 'desc')->paginate(5);

        foreach ($barang as $b) {
            $totalMasuk = M_barang_masuk::where('kode_barang', $b->kode_barang)->sum('jumlah');
            $totalKeluar = M_barang_keluar::where('kode_barang', $b->kode_barang)->sum('jumlah');

            $b->stok_sekarang = $b->stok_awal + $totalMasuk - $totalKeluar;
            $b->save();
        }
        return view('admin.data_barang.tampil_data', compact('barang'));
    }

    public function tambah_data_barang()
    {
        $kategori = M_kategori::all();
        return view('admin.data_barang.tambah_data', compact('kategori'));
    }

    public function edit_data_barang($id)
    {
        $barangs = M_barang::find($id);
        $kategori = M_kategori::all();
        return view('admin.data_barang.edit_data', compact('barangs', 'kategori'));
    }

    public function store_barang(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:m_barangs,kode_barang',
            'nama_barang' => 'required',
            'kategori' => 'required',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required',
            'lokasi' => 'required',
            'kondisi' => 'required'
        ]);

        M_barang::create($request->all());

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'Menambahkan barang baru dengan kode: ' . $request->kode_barang,
        ]);

        return redirect()->route('data_barang')->with('success', 'Barang berhasil ditambahkan');
    }

    public function hapus_barang($id)
    {
        // Cari data berdasarkan ID
        $barang = M_barang::find($id);

        // Jika tidak ditemukan
        if (!$barang) {
            return redirect()->back()->with('loginError', 'Data tidak ditemukan.');
        }

        $kodeBarang = $barang->kode_barang;

        // Hapus data
        $barang->delete();

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'Menghapus barang dengan kode: ' . $kodeBarang,
        ]);

        return redirect()->back()->with('success_hapus', 'Data barang masuk berhasil dihapus.');
    }

    public function update_data_barang(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'kategori' => 'required',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required',
            'lokasi' => 'required',
            'kondisi' => 'required'
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);

        // Cari data barang berdasarkan ID
        $barang = M_barang::findOrFail($id);

        // Update data
        $barang->kode_barang = $request->kode_barang;
        $barang->kondisi = $request->kondisi;
        $barang->nama_barang = $request->nama_barang;
        $barang->kategori = $request->kategori;
        $barang->stok = $request->stok;
        $barang->satuan = $request->satuan;
        $barang->lokasi = $request->lokasi;
        // Tambahkan field lain sesuai kebutuhan

        $barang->save(); // Simpan perubahan

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'update data barang : ' . $request->kode_barang,
        ]);

        // Redirect kembali ke halaman data barang
        return redirect()->route('data_barang')->with('success_update', 'Data barang berhasil diperbarui.');
    }

    public function generateKodeBarang(Request $request)
    {
        $kategori = $request->kategori;

        // Tentukan prefix berdasarkan kategori
        $prefix = $this->getPrefixByKategori($kategori);

        // Ambil kode terakhir berdasarkan prefix
        $latest = M_barang::where('kode_barang', 'like', $prefix . '%')
            ->orderBy('kode_barang', 'desc')
            ->first();

        if (!$latest || !preg_match('/' . $prefix . '(\d+)/', $latest->kode_barang, $matches)) {
            $number = 1;
        } else {
            $number = (int) $matches[1] + 1;
        }

        $kode = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);

        return response()->json(['kode' => $kode]);
    }

    private function getPrefixByKategori($kategori)
    {
        switch ($kategori) {
            case 'Elektronik Rumah Tangga':
                return 'EH-';
            case 'Elektronik Konsumen':
                return 'EC-';
            case 'Komputer & Aksesoris':
                return 'KA-';
            case 'Kabel & Konektor':
                return 'KK-';
            case 'Komponen Elektronik':
                return 'KE-';
            case 'Peralatan & Tools':
                return 'PT-';
            case 'Pencahayaan':
                return 'PC-';
            case 'Baterai & Daya':
                return 'BD-';
            case 'Keamanan & CCTV':
                return 'KC-';
            case 'Aksesori Elektronik':
                return 'AE-';
            default:
                return 'OT-';
        }
    }
}
