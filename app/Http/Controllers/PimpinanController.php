<?php

namespace App\Http\Controllers;

use App\Models\M_activity_log;
use App\Models\M_barang;
use App\Models\M_barang_keluar;
use App\Models\M_barang_masuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PimpinanController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Ambil ID user yang sedang login
        $activities = M_activity_log::with('user')
            ->where('user_id', $user->id)
            ->whereHas('user', function ($query) {
                $query->where('username', '!=', 'pimpinan');
            })
            ->latest()
            ->take(10)
            ->get();
        return view('pimpinan.index', compact('activities'));
    }

    public function tampil_data_barang_pimpinan(Request $request)
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
        return view('pimpinan.data_barang.tampil_data', compact('barang'));
    }

    public function tampil_data_barang_masuk_pimpinan(Request $request)
    {
        $query = M_barang_masuk::query();

        // Filter pencarian berdasarkan nama/kode barang
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('kode_transaksi', 'like', "%{$search}%"); // pastikan kolom ini ada di tabel
            });
        }

        $barangMasuk = $query->orderBy('tanggal_masuk', 'desc')->paginate(5);
        return view('pimpinan.stok_masuk.tampil_data', compact('barangMasuk'));
    }

    public function tampil_data_barang_keluar_pimpinan(Request $request)
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
        return view('pimpinan.stok_keluar.tampil_data', compact('barangKeluar'));
    }

    public function tampil_laporan()
    {
        return view('pimpinan.laporan.tampil_laporan');
    }

    public function export(Request $request)
    {
        $tipe = $request->pilih_laporan;
        $mulai = Carbon::parse($request->tanggal_mulai)->toDateString();
        $selesai = Carbon::parse($request->tanggal_selesai)->toDateString();


        if ($tipe == "barang") {
            // Menggunakan where() untuk tanggal mulai dan selesai
            $data = M_barang::whereDate('created_at', '>=', $mulai)
                ->whereDate('created_at', '<=', $selesai)
                ->select('kode_barang', 'nama_barang', 'kategori', 'stok', 'stok_sekarang', 'satuan', 'lokasi', 'kondisi')
                ->get();
        } else if ($tipe == "barang_keluar") {
            // Menggunakan where() untuk tanggal mulai dan selesai
            $data = M_barang_keluar::where('tanggal', '>=', $mulai)
                ->where('tanggal', '<=', $selesai)
                ->select('kode_barang', 'tanggal', 'jumlah', 'tujuan')
                ->get();
        } else if ($tipe == "barang_masuk") {
            // Menggunakan where() untuk tanggal mulai dan selesai
            $data = M_barang_masuk::where('tanggal_masuk', '>=', $mulai)
                ->where('tanggal_masuk', '<=', $selesai)
                ->select('kode_barang', 'jumlah', 'satuan', 'tanggal_masuk')
                ->get();
        }

        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan untuk periode yang dipilih!');
        }

        // Nama file
        $fileName = 'Laporan_' . ucfirst($tipe) . '_' . date('Ymd_His') . '.csv';

        // Header untuk download file CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // Callback untuk menulis CSV
        $callback = function () use ($data, $tipe) {
            $handle = fopen('php://output', 'w');


            if ($tipe == "barang") {
                fputcsv($handle, ['Laporan Data Barang']);
            } else if ($tipe == "barang_keluar") {
                fputcsv($handle, ['Laporan Data Barang Keluar']);
            } else if ($tipe == "barang_masuk") {
                fputcsv($handle, ['Laporan Data Barang Masuk']);
            }

            // Tulis header kolom dari array kunci pertama
            if (count($data) > 0) {
                fputcsv($handle, array_keys($data[0]->toArray()));
            }

            // Tulis data baris per baris
            foreach ($data as $row) {
                fputcsv($handle, $row->toArray());
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
