<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Ambil hanya pengaduan milik user yang sedang login, urutkan dari terbaru
        $pengaduan = Auth::user()->pengaduan()->latest()->paginate(10);

        return view('dashboard', compact('pengaduan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pengaduan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        $pathFoto = null;
        if ($request->hasFile('foto_bukti')) {
            // Simpan gambar ke storage/app/public/bukti
            $pathFoto = $request->file('foto_bukti')->store('public/bukti');
        }

        // Buat pengaduan baru milik user yang sedang login
        $request->user()->pengaduan()->create([
            'judul' => $request->judul,
            'isi_laporan' => $request->isi_laporan,
            'foto_bukti' => $pathFoto,
        ]);

        return redirect()->route('dashboard')->with('success', 'Pengaduan Anda telah berhasil dikirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaduan $pengaduan): View
    {
        // Pastikan hanya pemilik pengaduan yang bisa melihat detailnya
        if ($pengaduan->user_id !== Auth::id()) {
            abort(403); // Unauthorized
        }

        // Eager load relasi untuk menghindari N+1 problem
        $pengaduan->load('tanggapan.petugas');

        return view('pengaduan.show', compact('pengaduan'));
    }
}
