<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndikatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Helper to get Aspek ID
        $getAspekId = function ($kode) {
            return DB::table('aspek')->where('kode_aspek', $kode)->value('id');
        };

        $indikators = [
            // Pemerintahan - Perencanaan (pem_perencanaan)
            [
                'aspek_id' => $getAspekId('pem_perencanaan'),
                'kode_indikator' => 'ind_rpjmdes',
                'nama_indikator' => 'Dokumen RPJMDes',
                'deskripsi' => 'Ketersediaan dokumen RPJMDes yang masih berlaku',
                'tipe_input' => 'file',
                'opsi_select' => null,
                'satuan' => 'Dokumen',
                'wajib_bukti' => true,
                'bobot' => 10.00,
                'urutan' => 1,
                'is_active' => true
            ],
            [
                'aspek_id' => $getAspekId('pem_perencanaan'),
                'kode_indikator' => 'ind_rkpdes',
                'nama_indikator' => 'Dokumen RKPDes Tahun Berjalan',
                'deskripsi' => 'Ketersediaan dokumen RKPDes untuk tahun anggaran berjalan',
                'tipe_input' => 'file',
                'opsi_select' => null,
                'satuan' => 'Dokumen',
                'wajib_bukti' => true,
                'bobot' => 10.00,
                'urutan' => 2,
                'is_active' => true
            ],
            [
                'aspek_id' => $getAspekId('pem_perencanaan'),
                'kode_indikator' => 'ind_musdes_rkp',
                'nama_indikator' => 'Pelaksanaan Musdes RKPDes',
                'deskripsi' => 'Bukti pelaksanaan Musdes penyusunan RKPDes (BA, Absensi, Foto)',
                'tipe_input' => 'file',
                'opsi_select' => null,
                'satuan' => 'Kegiatan',
                'wajib_bukti' => true,
                'bobot' => 5.00,
                'urutan' => 3,
                'is_active' => true
            ],
            [
                'aspek_id' => $getAspekId('pem_perencanaan'),
                'kode_indikator' => 'ind_keselarasan',
                'nama_indikator' => 'Keselarasan dengan RKPD',
                'deskripsi' => 'Tingkat keselarasan program desa dengan prioritas daerah',
                'tipe_input' => 'select',
                'opsi_select' => json_encode(['Sangat Selaras', 'Cukup Selaras', 'Kurang Selaras']),
                'satuan' => 'Status',
                'wajib_bukti' => false,
                'bobot' => 5.00,
                'urutan' => 4,
                'is_active' => true
            ],

            // Ekbang - Kepatuhan (ekb_kepatuhan)
            [
                'aspek_id' => $getAspekId('ekb_kepatuhan'),
                'kode_indikator' => 'ind_apbdes_waktu',
                'nama_indikator' => 'Penetapan APBDes Tepat Waktu',
                'deskripsi' => 'Tanggal penetapan Perdes APBDes (Maksimal 31 Desember)',
                'tipe_input' => 'date',
                'opsi_select' => null,
                'satuan' => 'Tanggal',
                'wajib_bukti' => true, // Bukti SK/Perdes
                'bobot' => 15.00,
                'urutan' => 1,
                'is_active' => true
            ],
            [
                'aspek_id' => $getAspekId('ekb_kepatuhan'),
                'kode_indikator' => 'ind_publikasi_apbdes',
                'nama_indikator' => 'Publikasi APBDes',
                'deskripsi' => 'Bukti publikasi APBDes (Banner/Baliho/Web)',
                'tipe_input' => 'file',
                'opsi_select' => null,
                'satuan' => 'Dokumen',
                'wajib_bukti' => true,
                'bobot' => 10.00,
                'urutan' => 2,
                'is_active' => true
            ],
        ];

        foreach ($indikators as $ind) {
            if ($ind['aspek_id']) {
                DB::table('indikator')->updateOrInsert(
                    ['kode_indikator' => $ind['kode_indikator']],
                    $ind
                );
            }
        }
    }
}
