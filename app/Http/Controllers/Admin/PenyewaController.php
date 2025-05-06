<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewa;

class PenyewaController extends Controller
{
    public function index()
    {
        $penyewa = Penyewa::all(); // Ambil semua data penyewa
        return view('auth.admin.penyewa.index', compact('penyewa'));
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
            'status' => 'required|in:Aktif,Non-Aktif',
        ]);

        $penyewa = Penyewa::findOrFail($id);
        $penyewa->update($request->only('nomor_kamar', 'status'));

        return redirect()->route('auth.admin.penyewa.index')->with('success', 'Data penyewa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penyewa = Penyewa::findOrFail($id);
        $penyewa->delete();

        return redirect()->route('auth.admin.penyewa.index')->with('success', 'Data penyewa berhasil dihapus.');
    }
}
