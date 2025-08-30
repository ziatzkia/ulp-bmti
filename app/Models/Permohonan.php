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

    public function getJenjangTextAttribute()
    {
        $map = [
            1 => 'Pengajuan Permohonan',
            2 => 'Operator Surat',
            3 => 'Penanggung Jawab Humas',
            4 => 'Staff Hubungan Masyarakat',
            5 => 'Selesai',
        ];

        return $map[$this->jenjang] ?? 'Unknown';
    }



    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
