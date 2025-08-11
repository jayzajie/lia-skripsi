<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiPembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_file',
        'path_file',
        'jenis_pembayaran',
        'nominal',
        'keterangan',
        'status',
        'catatan_admin',
        'tanggal_upload'
    ];

    protected $casts = [
        'tanggal_upload' => 'datetime',
        'nominal' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
