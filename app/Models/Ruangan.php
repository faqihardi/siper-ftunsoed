<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruangan extends Model
{
    protected $primaryKey = 'ruang_id';
    protected $fillable = ['nama_ruang', 'kapasitas', 'tipe_ruang'];

    public function gedung(): BelongsTo {
        return $this->belongsTo(Gedung::class, 'gedung_id');
    }

    public function peminjamans() : HasMany 
    {
        return $this->hasMany(Peminjaman::class, 'ruang_id');
    }
}
