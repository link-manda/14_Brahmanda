<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman form dan preview laporan.
     */
    public function index(Request $request): View
    {
        $pengaduan = collect(); // Default ke koleksi kosong
        $tanggal_awal = $request->query('tanggal_awal');
        $tanggal_akhir = $request->query('tanggal_akhir');

        // Jika ada input tanggal, ambil data untuk preview
        if ($tanggal_awal && $tanggal_akhir) {
            $request->validate([
                'tanggal_awal' => 'required|date',
                'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            ]);

            $pengaduan = Pengaduan::with('user')
                ->whereDate('created_at', '>=', $tanggal_awal)
                ->whereDate('created_at', '<=', $tanggal_akhir)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('admin.laporan.index', compact('pengaduan', 'tanggal_awal', 'tanggal_akhir'));
    }

    /**
     * Menghasilkan laporan PDF berdasarkan rentang tanggal.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        // Ambil data pengaduan dalam rentang tanggal yang dipilih
        $pengaduan = Pengaduan::with('user')
            ->whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->orderBy('created_at', 'asc')
            ->get();

        // Load view PDF dengan data yang sudah diambil
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('pengaduan', 'tanggal_awal', 'tanggal_akhir'));

        // Atur nama file dan tampilkan di browser
        return $pdf->stream('laporan-pengaduan-' . $tanggal_awal . '-' . $tanggal_akhir . '.pdf');
    }
}

