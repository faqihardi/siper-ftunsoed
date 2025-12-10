<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    protected $primaryKey = 'notif_id';
    protected $fillable = [
        'peminjaman_id',
        'user_id',
        'pesan',
        'waktu_kirim',
        'status_baca'
    ];

    public function peminjaman():BelongsTo
    {
        return $this->belongsTo(Peminjaman::class,'peminjaman_id');
    }

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class,'user_id');  
    }
}
