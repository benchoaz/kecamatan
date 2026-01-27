<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelayananFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'category' => 'Pemerintahan',
                'keywords' => 'musdes, apbdes, musyawarah desa',
                'question' => 'Apa syarat penyelenggaraan Musyawarah Desa (Musdes) APBDes?',
                'answer' => 'Musdes APBDes wajib melibatkan Pemerintah Desa, BPD, dan tokoh masyarakat. Dokumen yang disiapkan meliputi: Rancangan RKPDes/APBDes, Undangan resmi (H-3), Daftar Hadir, dan Berita Acara kesepakatan.',
                'is_active' => true
            ],
            [
                'category' => 'Pembangunan',
                'keywords' => 'blt, bantuan, dana desa',
                'question' => 'Bagaimana kriteria penerima BLT Dana Desa?',
                'answer' => 'Penerima BLT Dana Desa ditetapkan melalui Musdes Khusus dengan kriteria: keluarga miskin ekstrem, kehilangan mata pencaharian, memiliki anggota keluarga sakit kronis/menahun, atau rumah tangga dengan lansia tunggal.',
                'is_active' => true
            ],
            [
                'category' => 'Umum',
                'keywords' => 'jam kerja, jam pelayanan, buka, tutup',
                'question' => 'Kapan jam operasional pelayanan Kecamatan?',
                'answer' => 'Pelayanan Kecamatan dibuka setiap hari kerja: Senin - Kamis (08:00 - 15:30 WIB) dan Jumat (08:00 - 14:30 WIB). Sabtu dan Minggu libur.',
                'is_active' => true
            ],
            [
                'category' => 'Umum',
                'keywords' => 'surat keterangan, pengantar, domisili',
                'question' => 'Bagaimana mengurus surat keterangan administrasi?',
                'answer' => 'Untuk permohonan surat keterangan (selain kependudukan), silakan membawa surat pengantar dari Desa, KTP asli, dan Fotokopi KK. Petugas Kecamatan akan memproses verifikasi dan tanda tangan Camat/Sekcam.',
                'is_active' => true
            ],
        ];

        foreach ($faqs as $faq) {
            \App\Models\PelayananFaq::create($faq);
        }
    }
}
