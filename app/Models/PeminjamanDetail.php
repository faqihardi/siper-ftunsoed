<? php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeminjamanDetail extends Model
{
    protected $table = 'peminjaman_details';  // ✅ Pastikan ini ada!
    
    protected $fillable = [
        'peminjaman_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman:: class, 'peminjaman_id');
    }
}