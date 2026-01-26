<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nama_lengkap',
        'username',
        'password',
        'role_id',
        'desa_id',
        'status',
        'last_login',
    ];

    const STATUS_AKTIF = 'aktif';
    const STATUS_NONAKTIF = 'nonaktif';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    // Helper to check role
    public function hasRole($roleName)
    {
        return $this->role && $this->role->nama_role === $roleName;
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('Super Admin');
    }

    public function isOperatorKecamatan()
    {
        return $this->hasRole('Operator Kecamatan');
    }

    public function isOperatorDesa()
    {
        return $this->hasRole('Operator Desa');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'submitted_by');
    }
}
