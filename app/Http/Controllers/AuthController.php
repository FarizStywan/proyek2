<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\Penyewa;
use App\Models\Admin;
use App\Models\Tagihan;
use App\Models\Kamar;

class AuthController extends Controller
{
    // ==== LOGIN ====
    public function showAdminLoginForm()
    {
        return view('auth.admin.login', ['role' => 'admin']);
    }

    public function showPenyewaLoginForm()
    {
        return view('auth.penyewa.login', ['role' => 'penyewa']);
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function penyewaLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('penyewa.dashboard'); // Redirect ke dashboard penyewa
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    // ==== REGISTER ====
    public function showPenyewaRegisterForm()
{
    $kamars = Kamar::where('status', 'Kosong')->get(); // ✅ hanya ambil kamar kosong
    return view('auth.penyewa.register', ['role' => 'penyewa', 'kamars' => $kamars]);
}


    public function penyewaRegister(Request $request)
    {
        // Validasi
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:penyewa,email',
            'no_hp' => 'required|string|max:15',
            'nomor_kamar' => 'required|string|exists:kamar,nomor_kamar', // validasi nomor_kamar yang harus ada di tabel kamar
            'password' => 'required|min:6|confirmed',
            'tanggal_mulai' => 'required|date',
            'foto_profil' => 'nullable|string',
            'status' => 'nullable|in:Aktif,Non-Aktif'
        ]);

   // Buat penyewa
   $penyewa = Penyewa::create([
    'nama' => $request->nama,
    'email' => $request->email,
    'no_hp' => $request->no_hp,
    'nomor_kamar' => $request->nomor_kamar,
    'password' => Hash::make($request->password),
    'tanggal_mulai' => $request->tanggal_mulai,
    'foto_profil' => $request->foto_profil ?? null,
    'status' => $request->status ?? 'Aktif'
]);

    // Ambil harga kamar berdasarkan nomor_kamar yang dipilih
    $kamar = \App\Models\Kamar::where('nomor_kamar', $request->nomor_kamar)->first();

    if (!$kamar) {
        return back()->withErrors(['nomor_kamar' => 'Kamar tidak ditemukan.'])->withInput();
    }

    // Buat tagihan berdasarkan harga kamar
    Tagihan::create([
        'penyewa_id' => $penyewa->id,
        'jumlah' => $kamar->harga, // Gunakan harga kamar
        'sisa_tagihan' => $kamar->harga,
        'status' => 'Belum Lunas',
        'jatuh_tempo' => Carbon::now()->addDays(30),
    ]);

    // Login otomatis untuk penyewa yang baru
    Auth::guard('web')->login($penyewa);

    // Redirect ke dashboard penyewa
    return redirect()->route('penyewa.dashboard');
}

    // ==== LOGOUT ====
public function logout()
{
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login'); // Pastikan route ini benar
    }

    if (Auth::guard('web')->check()) {
        Auth::guard('web')->logout();
        return redirect()->route('penyewa.login'); // Pastikan route ini benar
    }

    // Jika tidak ada yang login
    return redirect('/');
}
}
