<?php

namespace App\Http\Controllers;

use App\Models\M_barang;
use App\Models\M_barang_keluar;
use App\Models\M_barang_masuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.tampil_laporan');
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
