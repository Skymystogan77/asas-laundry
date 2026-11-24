<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_invoice',
        'nama_pelanggan',
        'no_hp',
        'layanan_id',
        'berat',
        'total_harga',
        'status_pengerjaan',
        'status_pembayaran',
        'catatan',
        'user_id',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
