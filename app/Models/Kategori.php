<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $fillable = ['nama_kategori', 'deskripsi'];
    /**
     * Satu kategori bisa memiliki banyak pengaduan.
     */
    public function pengaduan(): HasMany
    {
        return $this->hasMany(Pengaduan::class);
    }
}
