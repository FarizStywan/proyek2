<?php
namespace App\Http\Controllers\Admin; // Harus sesuai dengan lokasi file

use App\Http\Controllers\Controller; // Pastikan ini ada!
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function __construct()
    {
        // Middleware agar hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $pengaduans = Pengaduan::latest()->get();
        return view('auth.admin.pengaduan.index', compact('pengaduans'));
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('auth.admin.pengaduan.show', compact('pengaduan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $request->validate([
            'status' => 'required|in:Pending,Diproses,Selesai',
            'tanggapan' => 'nullable|string',
        ]);

        $pengaduan->update([
            'status' => $request->status,
            'tanggapan' => $request->tanggapan,
        ]);

        return redirect()->route('auth.admin.pengaduan.index')->with('success', 'Status pengaduan diperbarui.');
    }
}
