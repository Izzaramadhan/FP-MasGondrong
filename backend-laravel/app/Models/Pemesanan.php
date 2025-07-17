<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_kendaraan',
        'tgl_mulai',
        'tgl_selesai',
        'total_harga',
        'status',
    ];
    public function pembayaran()
{
    return $this->hasOne(Pembayaran::class, 'id_pemesanan');
}


    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kendaraan(): BelongsTo {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan', 'id_kendaraan');
    }
}
