<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaduanController extends Controller
{
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
