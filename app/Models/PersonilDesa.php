<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonilDesa extends Model
{
    use HasFactory;

    protected $table = 'personil_desa';
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'masa_jabatan_mulai' => 'date',
        'masa_jabatan_selesai' => 'date',
        'tanggal_sk' => 'date',
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new \App\Models\Scopes\DesaScope);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
