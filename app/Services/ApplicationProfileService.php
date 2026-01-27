<?php

namespace App\Services;

use App\Models\AppProfile;
use Illuminate\Support\Facades\Cache;

class ApplicationProfileService
{
    protected $cacheKey = 'app_profile_global';

    public function getProfile()
    {
        return Cache::rememberForever($this->cacheKey, function () {
            return AppProfile::first() ?? new AppProfile([
                'app_name' => 'Kecamatan SAE',
                'region_name' => 'Kecamatan Besuk',
                'region_level' => 'kecamatan',
                'tagline' => 'Solusi Administrasi Terpadu',
            ]);
        });
    }

    public function getAppName()
    {
        return $this->getProfile()->app_name;
    }

    public function getRegionName()
    {
        return $this->getProfile()->region_name;
    }

    public function getRegionLevel()
    {
        return $this->getProfile()->region_level;
    }

    public function getTagline()
    {
        return $this->getProfile()->tagline;
    }

    public function getLogo()
    {
        $path = $this->getProfile()->logo_path;
        return $path ? asset('storage/' . $path) : null;
    }

    public function getUmkmImage()
    {
        $path = $this->getProfile()->image_umkm;
        return $path ? asset('storage/' . $path) : null;
    }

    public function getPariwisataImage()
    {
        $path = $this->getProfile()->image_pariwisata;
        return $path ? asset('storage/' . $path) : null;
    }

    public function getFestivalImage()
    {
        $path = $this->getProfile()->image_festival;
        return $path ? asset('storage/' . $path) : null;
    }

    public function clearCache()
    {
        Cache::forget($this->cacheKey);
    }
}
