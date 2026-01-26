<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LembagaDesa extends Model
{
    use HasFactory;

    protected $table = 'lembaga_desa';
    protected $guarded = ['id'];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new \App\Models\Scopes\DesaScope);
    }
}
