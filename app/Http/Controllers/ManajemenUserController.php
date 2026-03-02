<?php

namespace App\Http\Controllers;

use App\Models\M_activity_log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManajemenUserController extends Controller
{
    public function index()
    {
        $user = User::paginate(5);
        return view('admin.manajemen_pengguna.tampil_data', compact('user'));
    }
    public function tambah_data_pengguna()
    {
        return view('admin.manajemen_pengguna.tambah_data');
    }

    public function store_user(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status' => "aktif"
        ]);

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'Menambahkan user baru dengan username: ' . $request->username,
        ]);

        return redirect()->route('manajemen_pengguna')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function nonaktifkan($id)
    {
        $user = User::findOrFail($id);

        // Misalnya: kamu hanya ingin menonaktifkan, bukan menghapus
        $user->status = 'nonaktif'; // pastikan kolom 'status' ada
        $user->save();

        $username = $user->username;

        // Jika ingin menghapus benar-benar:
        // $user->delete();

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'Nonaktifkan user dengan username: ' . $username,
        ]);

        return redirect()->back()->with('success_nonaktif', 'Akun pengguna berhasil dinonaktifkan.');
    }

    public function aktifkan($id)
    {
        $user = User::findOrFail($id);

        // Misalnya: kamu hanya ingin menonaktifkan, bukan menghapus
        $user->status = 'aktif'; // pastikan kolom 'status' ada
        $user->save();

        $username = $user->username;

        // Jika ingin menghapus benar-benar:
        // $user->delete();

        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'Aktifkan user dengan username: ' . $username,
        ]);

        return redirect()->back()->with('success_aktif', 'Akun pengguna berhasil diaktifkan.');
    }
}
