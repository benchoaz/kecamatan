<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'kode_menu' => 'pemerintahan',
                'nama_menu' => 'Pemerintahan',
                'deskripsi' => 'Menu Bidang Pemerintahan dan Pelayanan',
                'icon' => 'ri-government-line',
                'urutan' => 1,
                'is_active' => true
            ],
            [
                'kode_menu' => 'ekbang',
                'nama_menu' => 'Ekonomi & Pembangunan',
                'deskripsi' => 'Menu Bidang Ekonomi dan Pembangunan',
                'icon' => 'ri-building-line',
                'urutan' => 2,
                'is_active' => true
            ],
            [
                'kode_menu' => 'kesra',
                'nama_menu' => 'Kesejahteraan Rakyat',
                'deskripsi' => 'Menu Bidang Kesejahteraan Rakyat',
                'icon' => 'ri-heart-pulse-line',
                'urutan' => 3,
                'is_active' => true
            ],
            [
                'kode_menu' => 'trantibum',
                'nama_menu' => 'Trantibum',
                'deskripsi' => 'Menu Bidang Ketentraman dan Ketertiban Umum',
                'icon' => 'ri-shield-star-line',
                'urutan' => 4,
                'is_active' => true
            ],
            [
                'kode_menu' => 'analisa',
                'nama_menu' => 'Analisa Data',
                'deskripsi' => 'Dashboard Analisa dan Evaluasi Kecamatan SAE',
                'icon' => 'ri-bar-chart-groupped-line',
                'urutan' => 5,
                'is_active' => true
            ],
        ];

        foreach ($menus as $m) {
            DB::table('menu')->updateOrInsert(
                ['kode_menu' => $m['kode_menu']],
                $m
            );
        }
    }
}
