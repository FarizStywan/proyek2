<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemasukanPengeluaran;

class PemasukanPengeluaranController extends Controller
{
    public function index()
{
    $pemasukan = PemasukanPengeluaran::where('jenis', 'Pemasukan')->sum('jumlah');
    $pengeluaran = PemasukanPengeluaran::where('jenis', 'Pengeluaran')->sum('jumlah');
    $keuntungan = $pemasukan - $pengeluaran;

    // Ambil data keuntungan per bulan, lalu ubah ke array
    $keuntunganPerBulan = PemasukanPengeluaran::selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as bulan, 
        SUM(CASE WHEN jenis = "Pemasukan" THEN jumlah ELSE 0 END) - 
        SUM(CASE WHEN jenis = "Pengeluaran" THEN jumlah ELSE 0 END) as keuntungan')
        ->groupBy('bulan')
        ->orderBy('bulan', 'asc')
        ->pluck('keuntungan', 'bulan')
        ->toArray(); // Ubah ke array

    return view('auth.admin.keuangan.index', compact('pemasukan', 'pengeluaran', 'keuntungan', 'keuntunganPerBulan'));
}


    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        PemasukanPengeluaran::create($request->all());

        return redirect()->route('admin.keuangan.index')->with('success', 'Data berhasil ditambahkan!');
    }
}
