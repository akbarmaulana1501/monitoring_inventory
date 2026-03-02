<?php

namespace App\Http\Controllers;

use App\Models\M_activity_log;
use App\Models\M_barang;
use App\Models\M_barang_masuk;
use App\Models\M_barang_keluar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;

class PetugasController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Ambil ID user yang sedang login
        $activities = M_activity_log::with('user')
            ->where('user_id', $user->id)
            ->whereHas('user', function ($query) {
                $query->where('username', '!=', 'admin');
            })
            ->latest()
            ->take(10)
            ->get();

        return view('petugas.index', compact('activities'));
    }

    public function tampil_data_barang(Request $request)
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
        
        return view('petugas.data_barang.tampil_data', compact('barang'));
    }

    public function tampil_data_barang_masuk(Request $request)
    {
        $query = M_barang_masuk::query();

        // Filter pencarian berdasarkan kode_barang atau kode_transaksi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('kode_transaksi', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan tanggal hari ini (optional, hapus jika ingin semua tanggal)
        if (!$request->filled('search')) {
            $query->whereDate('tanggal_masuk', Carbon::today());
        }

        $barangMasuk = $query->orderBy('tanggal_masuk', 'desc')->paginate(5);
        return view('petugas.stok_masuk.tampil_data', compact('barangMasuk'));
    }

    public function tambah_data_barang_masuk()
    {
        $barangs = M_barang::all();
        $kodeTransaksi = $this->auto_number_trx();
        return view('petugas.stok_masuk.tambah_data', compact('barangs', 'kodeTransaksi'));
    }

    public function edit_data_barang_masuk($id)
    {
        $barangs = M_barang::all();
        $barangMasuk = M_barang_masuk::find($id);
        return view('petugas.stok_masuk.edit_data', compact('barangs', 'barangMasuk'));
    }

    public function tampil_data_barang_keluar(Request $request)
    {
        $query = M_barang_keluar::query();

        // Filter pencarian berdasarkan kode_barang atau kode_transaksi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('tujuan', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan tanggal hari ini (optional, hapus jika ingin semua tanggal)
        if (!$request->filled('search')) {
            $query->whereDate('tanggal', Carbon::today());
        }

        $barangKeluar = $query->orderBy('tanggal', 'desc')->paginate(5);
        return view('petugas.stok_keluar.tampil_data', compact('barangKeluar'));
    }

    public function tambah_data_barang_keluar()
    {
        $barangs = M_barang::all();
        return view('petugas.stok_keluar.tambah_data', compact('barangs'));
    }

    public function edit_data_barang_keluar($id)
    {
        $barangs = M_barang::all();
        $barangKeluar = M_barang_keluar::find($id);
        return view('petugas.stok_keluar.edit_data', compact('barangs', 'barangKeluar'));
    }

    public function store_barang_masuk_petugas(Request $request)
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

        return redirect()->route('stok_masuk_petugas')->with('success', 'Barang Masuk berhasil ditambahkan');
    }

    public function hapus_barang_masuk_petugas($id)
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

    public function update_barang_masuk_petugas(Request $request, $id)
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
        return redirect()->route('stok_masuk_petugas')->with('success_update', 'Data barang Masuk berhasil diperbarui.');
    }

    public function store_barang_keluar_petugas(Request $request)
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

        return redirect()->route('stok_keluar_petugas')->with('success', 'Barang berhasil ditambahkan');
    }

    public function hapus_barang_keluar_petugas($id)
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

    public function update_barang_keluar_petugas(Request $request, $id)
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
        return redirect()->route('stok_keluar_petugas')->with('success_update', 'Data barang Keluar berhasil diperbarui.');
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
