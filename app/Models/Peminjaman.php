<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peminjaman extends Model
{
    protected $primaryKey = 'peminjaman_id';
    protected $fillable = [
        'user_id',
        'ruang_id',
        'durasi',
        'tujuan',
        'detail_kegiatan',
        'tanggal_peminjaman',
        'jam_mulai',
        'jam_selesai',
        'tanggal_selesai',
        'dokumen_pendukung',
        'status',
        'notes'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruang_id');
    }

    public function notifikasis(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'peminjaman_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PeminjamanDetail::class, 'peminjaman_id');
    }
}
