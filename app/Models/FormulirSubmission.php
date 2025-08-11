<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulirSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'formulir_id',
        'user_id',
        'file_path',
        'status',
        'keterangan',
        'submitted_at'
    ];

    public function formulir()
    {
        return $this->belongsTo(Formulir::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 