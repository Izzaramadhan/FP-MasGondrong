<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'sewa_kendaraan_kendaraan';
    protected $primaryKey = 'id_kendaraan';
    public $timestamps = false; // Jika tidak ada created_at dan updated_at

    protected $fillable = [
        'tipe',
        'jenis',
        'harga_perhari',
    ];

    protected $casts = [
        'harga_perhari' => 'decimal:2',
    ];

    // Relationships
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'id_kendaraan', 'id_kendaraan');
    }
}
