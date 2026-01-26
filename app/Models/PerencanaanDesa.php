<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerencanaanDesa extends Model
{
    use HasFactory;

    protected $table = 'perencanaan_desa';
    protected $guarded = ['id'];

    const STATUS_DRAFT = 'draft';
    const STATUS_LENGKAP = 'lengkap';
    const STATUS_VERIFIED = 'verified';
    const STATUS_REVISION = 'revision';

    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new \App\Models\Scopes\DesaScope);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function usulan()
    {
        return $this->hasMany(UsulanMusrenbang::class, 'perencanaan_id');
    }
}
