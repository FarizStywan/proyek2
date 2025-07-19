<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemasukanPengeluaran;
use Carbon\Carbon;

class PemasukanPengeluaranController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan dari request, default ke bulan ini
        $bulanFilter = $request->input('bulan', now()->format('Y-m'));

        list($tahun, $bulan) = explode('-', $bulanFilter);
        $jumlahHari = now()->setYear((int)$tahun)->setMonth((int)$bulan)->daysInMonth;

        $awalBulan = "$tahun-$bulan-01";
        $akhirBulan = "$tahun-$bulan-$jumlahHari";

        // Hitung pemasukan/pengeluaran sesuai bulan
        $pemasukan = PemasukanPengeluaran::where('jenis', 'Pemasukan')
            ->whereBetween('tanggal', [$awalBulan, $akhirBulan])
            ->sum('jumlah');

        $pengeluaran = PemasukanPengeluaran::where('jenis', 'Pengeluaran')
            ->whereBetween('tanggal', [$awalBulan, $akhirBulan])
            ->sum('jumlah');

        $keuntungan = (float)$pemasukan - (float)$pengeluaran;

        // Data grafik semua bulan
        $keuntunganPerBulanRaw = PemasukanPengeluaran::selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as bulan,
            SUM(CASE WHEN jenis = "Pemasukan" THEN jumlah ELSE 0 END) -
            SUM(CASE WHEN jenis = "Pengeluaran" THEN jumlah ELSE 0 END) as keuntungan')
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        // Format label bulan + tahun
        $labels = [];
        $data = [];

        foreach ($keuntunganPerBulanRaw as $item) {
            try {
                // Pastikan format bulan benar & bersihkan whitespace
                $bulan = trim($item->bulan);

                // Validasi format YYYY-MM
                if (!preg_match('/^\d{4}-\d{2}$/', $bulan)) {
                    continue; // Lewati jika format tidak valid
                }

                // Parsing ke tanggal lengkap dengan "-01"
                $date = \Carbon\Carbon::createFromFormat('Y-m-d', $bulan . '-01')->locale('id');

                // Tambahkan label "Januari 2023"
                $labels[] = $date->translatedFormat('F Y');
                $data[] = (float)$item->keuntungan;
            } catch (\Exception $e) {
                continue; // Lewati error
            }
        }

        return view('auth.admin.keuangan.index', compact(
            'pemasukan', 'pengeluaran', 'keuntungan', 'labels', 'data', 'bulanFilter'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis'     => 'required|in:Pemasukan,Pengeluaran',
            'deskripsi' => 'required|string|max:255',
            'jumlah'    => 'required|numeric|min:0.01',
            'tanggal'   => 'required|date',
        ]);

        // Membersihkan input rupiah jika ada
        if ($request->has('jumlah_display')) {
            $jumlah = preg_replace('/[^0-9]/', '', $request->jumlah_display);
            $request->merge(['jumlah' => (float)$jumlah / 100]); // karena decimal(10,2)
        }

        PemasukanPengeluaran::create([
            'jenis'     => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'jumlah'    => $request->jumlah,
            'tanggal'   => $request->tanggal,
        ]);

        return redirect()->route('admin.keuangan.index')->with('success', 'Data berhasil ditambahkan!');
    }
}