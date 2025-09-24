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
    public function index(Request $request): View // <-- Tambahkan Request $request
    {
        // --- MULAI PERUBAHAN ---

        // Statistik tidak berubah
        $stats = [
            'total' => Pengaduan::count(),
            'pending' => Pengaduan::where('status', 'pending')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
        ];

        // Memulai query builder
        $query = Pengaduan::with('user', 'kategori')->latest();

        // --- MULAI PERUBAHAN LOGIKA UNTUK PETUGAS ---
        $user = Auth::user();

        // Jika yang login adalah PETUGAS, filter laporannya
        if ($user->role === 'petugas') {
            // Ambil ID semua kategori yang ditugaskan padanya
            $kategoriIds = $user->kategoriDitugaskan()->pluck('kategori.id');

            // Terapkan filter whereIn
            $query->whereIn('kategori_id', $kategoriIds);
        }

        // Terapkan filter PENCARIAN jika ada
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Terapkan filter STATUS jika ada
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Eksekusi query dengan pagination
        // withQueryString() akan memastikan filter tetap ada saat berpindah halaman
        $pengaduan = $query->paginate(10)->withQueryString();

        return view('admin.dashboard', compact('stats', 'pengaduan'));

        // --- AKHIR PERUBAHAN ---
    }

    // ... (method show dan storeTanggapan tetap sama)
    public function show(Pengaduan $pengaduan): View
    {
        // Eager load semua relasi yang dibutuhkan
        $pengaduan->load(['user', 'tanggapan.petugas']);
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function storeTanggapan(Request $request, Pengaduan $pengaduan): RedirectResponse
    {
        $request->validate([
            'isi_tanggapan' => 'required|string',
            'status' => 'required|in:pending,diproses,selesai,ditolak',
        ]);

        Tanggapan::create([
            'pengaduan_id' => $pengaduan->id,
            'petugas_id' => Auth::id(),
            'isi_tanggapan' => $request->isi_tanggapan,
        ]);

        $pengaduan->update([
            'status' => $request->status,
        ]);

        try {
            Mail::to($pengaduan->user->email)->send(new TanggapanDiterima($pengaduan));
        } catch (\Exception $e) {
            // Opsional: catat error ke log jika pengiriman gagal
        }

        return back()->with('success', 'Tanggapan berhasil dikirim dan status telah diperbarui!');
    }
}
