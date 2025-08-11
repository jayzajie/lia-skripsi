<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasSementara extends Model
{
    use HasFactory;

    protected $table = 'berkas_sementara';

    protected $fillable = [
        'jenis_berkas',
        'file_path',
        'user_id',
        'status',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 