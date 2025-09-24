<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('manage-system');

        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $pengaduan = null;

        if ($tanggal_awal && $tanggal_akhir) {
            $request->validate([
                'tanggal_awal' => 'required|date',
                'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            ]);

            $pengaduan = Pengaduan::with(['user', 'kategori'])
                ->whereDate('created_at', '>=', $tanggal_awal)
                ->whereDate('created_at', '<=', $tanggal_akhir)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('admin.laporan.index', compact('pengaduan', 'tanggal_awal', 'tanggal_akhir'));
    }

    public function generate(Request $request)
    {
        $this->authorize('manage-system');

        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $pengaduan = Pengaduan::with('user')
            ->whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->orderBy('created_at', 'asc')
            ->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('pengaduan', 'tanggal_awal', 'tanggal_akhir'));

        return $pdf->stream('laporan-pengaduan-' . $tanggal_awal . '-' . $tanggal_akhir . '.pdf');
    }
}
