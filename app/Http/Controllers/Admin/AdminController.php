<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use App\Mail\TanggapanDiterima;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan semua data pengaduan.
     */
    public function index(): View
    {
        // --- MULAI PERUBAHAN ---
        // Menghitung statistik pengaduan
        $stats = [
            'total' => Pengaduan::count(),
            'pending' => Pengaduan::where('status', 'pending')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
        ];

        // Ambil 5 pengaduan terbaru untuk ditampilkan di bawah statistik
        $pengaduanTerbaru = Pengaduan::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pengaduanTerbaru'));
        // --- AKHIR PERUBAHAN ---
    }

    /**
     * Menampilkan detail satu pengaduan untuk diproses.
     */
    public function show(Pengaduan $pengaduan): View
    {
        // Eager load semua relasi yang dibutuhkan
        $pengaduan->load(['user', 'tanggapan.petugas']);
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Menyimpan tanggapan dan mengubah status pengaduan.
     */
    public function storeTanggapan(Request $request, Pengaduan $pengaduan): RedirectResponse
    {
        $request->validate([
            'isi_tanggapan' => 'required|string',
            'status' => 'required|in:pending,diproses,selesai,ditolak',
        ]);

        // 1. Simpan tanggapan baru
        Tanggapan::create([
            'pengaduan_id' => $pengaduan->id,
            'petugas_id' => Auth::id(), // ID admin/petugas yang sedang login
            'isi_tanggapan' => $request->isi_tanggapan,
        ]);

        // 2. Update status pengaduan
        $pengaduan->update([
            'status' => $request->status,
        ]);

        try {
            Mail::to($pengaduan->user->email)->send(new TanggapanDiterima($pengaduan));
        } catch (\Exception $e) {
            // Opsional: catat error ke log jika pengiriman gagal
            // Log::error('Gagal mengirim email notifikasi: ' . $e->getMessage());
        }

        return back()->with('success', 'Tanggapan berhasil dikirim dan status telah diperbarui!');
    }
}

