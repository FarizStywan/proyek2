<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewa;

class PenyewaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input pencarian
        $search = $request->input('search');

        // Query pencarian
        $query = Penyewa::query();

        if ($search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('nomor_kamar', 'like', "%{$search}%");
        }

        // Pagination
        $penyewa = $query->paginate(10)->withQueryString();

        return view('auth.admin.penyewa.index', compact('penyewa', 'search'));
    }

    public function edit($id)
    {
        $penyewa = Penyewa::findOrFail($id);
        return view('auth.admin.penyewa.edit', compact('penyewa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_kamar' => 'required',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $penyewa = Penyewa::findOrFail($id);
        $penyewa->update($request->only('nomor_kamar', 'status'));

        return redirect()->route('admin.penyewa.index')->with('success', 'Data penyewa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penyewa = Penyewa::findOrFail($id);
        $penyewa->delete();

        return redirect()->route('admin.penyewa.index')->with('success', 'Data penyewa berhasil dihapus.');
    }
}