<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'isi_laporan',
        'foto_bukti',
        'status',
    ];

    /**
     * Satu pengaduan hanya dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Satu pengaduan bisa memiliki banyak tanggapan.
     */
    public function tanggapan(): HasMany
    {
        return $this->hasMany(Tanggapan::class);
    }

    /**
     * Satu pengaduan hanya memiliki satu Kategori.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}
