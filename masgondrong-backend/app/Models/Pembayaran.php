<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'sewa_kendaraan_pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps = false; // Jika tidak ada created_at dan updated_at

    protected $fillable = [
        'id_pemesanan',
        'tgl_bayar',
        'metode',
        'jml_bayar',
        'status_pembayaran',
    ];

    protected $casts = [
        'tgl_bayar' => 'date',
        'jml_bayar' => 'decimal:2',
    ];

    // Relationships
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }
}
