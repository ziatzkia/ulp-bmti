<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'divisi_id',
        'nama',
        'nim',
        'jurusan',
        'sekolah',
        'periode_awal',
        'periode_akhir',
        'kontak',
        'image',
        'status',
        'jenjang',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Divisi
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    
}
