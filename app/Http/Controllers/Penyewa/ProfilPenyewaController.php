<?php
namespace App\Http\Controllers\Penyewa;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilPenyewaController extends Controller
{
    // Menampilkan profil penyewa
    public function index()
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();

        // Mengembalikan tampilan profil dengan data pengguna
        return view('auth.penyewa.profil.index', compact('user'));
    }

    // Menampilkan form untuk mengedit profil
    public function edit()
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();

        // Mengembalikan tampilan form edit dengan data pengguna
        return view('auth.penyewa.profil.edit', compact('user'));
    }

    // Memperbarui data profil penyewa
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:pengguna,email,' . Auth::id(),
            'password' => 'nullable|confirmed|min:6',
        ]);

        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Update data pengguna
        $user->nama = $request->nama;
        $user->email = $request->email;

        // Jika ada password yang diubah, hash password dan simpan
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan
        $user->save();

        // Redirect ke halaman profil dengan pesan sukses
        return redirect()->route('auth.penyewa.profil.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
