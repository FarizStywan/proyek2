<?php

namespace App\Http\Controllers\Penyewa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanPenyewaController extends Controller
{
    // Konstruktor untuk memastikan pengguna sudah login
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    // Tampilkan daftar pengaduan milik penyewa yang sedang login
    public function index()
    {
        $pengaduan = Pengaduan::where('penyewa_id', Auth::id())
            ->latest()
            ->get();

        return view('auth.penyewa.pengaduan.index', compact('pengaduan'));
    }

    // Tampilkan form untuk membuat pengaduan
    public function create()
    {
        // Daftar kategori harus sesuai ENUM di database
        $kategoriList = ['Kebersihan', 'Keamanan', 'Kerusakan'];

        return view('auth.penyewa.pengaduan.create', compact('kategoriList'));
    }

    // Simpan pengaduan baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kategori' => 'required|in:Kebersihan,Keamanan,Kerusakan',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil data valid dari request
        $data = $request->only('kategori', 'deskripsi');
        $data['penyewa_id'] = Auth::id();
        $data['status'] = 'Pending';

        // Simpan foto jika ada
        if ($request->hasFile('foto')) {
            try {
                $data['foto'] = $request->file('foto')->store('pengaduan', 'public');
            } catch (\Exception $e) {
                \Log::error('Gagal upload foto: ' . $e->getMessage());
            }
        }
        

        // Simpan ke database
        Pengaduan::create($data);

        // Redirect ke daftar pengaduan
        return redirect()
            ->route('auth.penyewa.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dikirim.');
    }

    // Tampilkan detail pengaduan
    public function show($id)
    {
        $pengaduan = Pengaduan::where('id', $id)
            ->where('penyewa_id', Auth::id())
            ->firstOrFail();

        return view('auth.penyewa.pengaduan.show', compact('pengaduan'));
    }

    public function edit($id)
    {
        // Menemukan pengaduan berdasarkan ID
        $pengaduan = Pengaduan::findOrFail($id);

        // Mengembalikan tampilan form edit dengan data pengaduan
        return view('auth.penyewa.pengaduan.edit', compact('pengaduan'));
    }

    public function destroy($id)
{
    $pengaduan = Pengaduan::findOrFail($id);

    // Hapus foto jika ada
    if ($pengaduan->foto) {
        Storage::delete($pengaduan->foto);
    }

    // Hapus pengaduan
    $pengaduan->delete();

    return redirect()->route('auth.penyewa.pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
}

}
