<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori; // <-- Import model Kategori

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama untuk menghindari duplikasi saat seeding ulang
        Kategori::query()->delete();

        // Buat data kategori baru
        Kategori::create([
            'nama_kategori' => 'Infrastruktur Jalan',
            'deskripsi' => 'Laporan terkait jalan berlubang, trotoar rusak, jembatan, dan fasilitas jalan lainnya.'
        ]);

        Kategori::create([
            'nama_kategori' => 'Kebersihan dan Lingkungan',
            'deskripsi' => 'Laporan terkait sampah menumpuk, saluran air tersumbat, dan masalah lingkungan lainnya.'
        ]);

        Kategori::create([
            'nama_kategori' => 'Pelayanan Publik',
            'deskripsi' => 'Laporan terkait pelayanan di kantor desa/camat, catatan sipil, dan instansi pemerintah lainnya.'
        ]);

        Kategori::create([
            'nama_kategori' => 'Keamanan dan Ketertiban',
            'deskripsi' => 'Laporan terkait gangguan keamanan, ketertiban umum, dan masalah sosial.'
        ]);
    }
}
