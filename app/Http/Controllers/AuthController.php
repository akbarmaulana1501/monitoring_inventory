<?php

namespace App\Http\Controllers;

use App\Models\M_activity_log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek apakah user dengan username tersebut ada
        $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
            return back()->with('loginError', 'Akun tidak ditemukan.');
        }

        // Cek apakah status user aktif
        if ($user->status === 'nonaktif') {
            return back()->with('loginErrorAkun', 'Akun Anda telah dinonaktifkan.');
        }

        // Cek password
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            M_activity_log::create([
                'user_id' => Auth::id(),
                'aktifitas' => 'User logged in.',
            ]);

            // Ambil role user
            $role = Auth::user()->role;

            // Redirect sesuai role
            if ($role === 'admin') {
                return redirect('/index_admin');
            } elseif ($role === 'petugas') {
                return redirect('/index_petugas');
            } elseif ($role === 'pimpinan') {
                return redirect('/index_pimpinan');
            }

            // Role tidak dikenali
            Auth::logout();
            return redirect('/login')->with('loginError', 'Role tidak dikenali.');
        }

        return back()->with('loginError', 'Login gagal! Username atau password salah.');
    }

    public function logout(Request $request)
    {
        M_activity_log::create([
            'user_id' => Auth::id(),
            'aktifitas' => 'User logged out.',
        ]);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function update_profil(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'min:6',
        ]);

        // Ambil data user berdasarkan ID
        $user = User::findOrFail($id); // Menggunakan model User untuk mengambil data user berdasarkan ID

        // Update data user
        $user->username = $request->username;

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Simpan perubahan
        $user->save(); // Menyimpan perubahan pada model User

        // Redirect atau memberikan response success
        return redirect()->back()->with('success_update', 'Profil berhasil diperbarui!');
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
