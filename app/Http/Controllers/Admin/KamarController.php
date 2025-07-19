<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kamar;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        $query = Kamar::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nomor_kamar', 'like', "%$search%");
        }

        $kamar = $query->paginate(10)->withQueryString();

        return view('auth.admin.kamar.index', compact('kamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|string|unique:kamar,nomor_kamar',
            'fasilitas' => 'required|in:AC,Non-AC',
            'harga' => 'required|string',
            'status' => 'required|in:Kosong,Terisi',
        ]);

        $harga = preg_replace('/[^0-9]/', '', $request->harga);

        Kamar::create([
            'nomor_kamar' => $request->nomor_kamar,
            'fasilitas' => $request->fasilitas,
            'harga' => $harga,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);
        return view('auth.admin.kamar.edit', compact('kamar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_kamar' => 'required|string|unique:kamar,nomor_kamar,' . $id,
            'fasilitas' => 'required|in:AC,Non-AC',
            'harga' => 'required|string',
            'status' => 'required|in:Kosong,Terisi',
        ]);

        $harga = preg_replace('/[^0-9]/', '', $request->harga);

        $kamar = Kamar::findOrFail($id);
        $kamar->update([
            'nomor_kamar' => $request->nomor_kamar,
            'fasilitas' => $request->fasilitas,
            'harga' => $harga,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();

        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil dihapus!');
    }
}