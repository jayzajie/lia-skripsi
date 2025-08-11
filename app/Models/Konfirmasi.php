<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konfirmasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'status',
        'user_id',
        'tanggal_konfirmasi',
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 