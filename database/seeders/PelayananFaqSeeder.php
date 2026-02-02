<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PelayananFaq;

class PelayananFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // === KATEGORI: DARURAT (PRIORITAS TINGGI) ===
            [
                'category' => 'Darurat',
                'keywords' => 'maling, pencurian, perampokan, dirampok, kriminal, kejahatan, kekerasan, begal, jambret, curi, polisi, polsek',
                'question' => 'Ada pencurian atau tindak kriminal, apa yang harus saya lakukan?',
                'answer' => "⚠️ **TINDAKAN DARURAT KRIMINAL**\n\nJika Anda mengalami atau melihat tindak kejahatan:\n1. Segera hubungi Pihak Berwajib (Polisi) di nomor **110**\n2. Jangan melakukan tindakan berbahaya sendiri\n3. Cari tempat aman dan minta bantuan warga sekitar\n4. Datangi Polsek terdekat untuk membuat laporan resmi (STLP).\n\n*Utamakan Keselamatan Jiwa Anda.*",
                'is_active' => true
            ],
            [
                'category' => 'Darurat',
                'keywords' => 'pingsan, sesak napas, kejang, kecelakaan, luka berat, darah banyak, darurat kesehatan, sakit parah, serangan jantung, melahirkan, ambulan, rs, puskesmas',
                'question' => 'Butuh bantuan medis darurat/ambulans segera!',
                'answer' => "⚠️ **TINDAKAN DARURAT MEDIS**\n\n1. Segera hubungi layanan ambulans/darurat medis ke nomor **119**\n2. Berikan pertolongan pertama jika Anda memiliki keahlian\n3. Jangan memindahkan korban kecelakaan atau tidak sadar jika tidak terpaksa\n4. Segera bawa ke IGD Rumah Sakit atau Puskesmas terdekat.\n\n*Semoga bantuan segera datang.*",
                'is_active' => true
            ],
            [
                'category' => 'Darurat',
                'keywords' => 'kebakaran, api, damkar, kebakaran rumah, meledak',
                'question' => 'Terjadi kebakaran! Tolong panggilkan pemadam!',
                'answer' => "⚠️ **TINDAKAN DARURAT KEBAKARAN**\n\n1. Matikan aliran listrik jika memungkinkan\n2. Segera hubungi Pemadam Kebakaran (DAMKAR) di nomor **112** atau **113**\n3. Evakuasi seluruh penghuni ke area terbuka\n4. Jangan menggunakan lift jika berada di gedung bertingkat.\n\n*Segera menjauh dari area api.*",
                'is_active' => true
            ],
            [
                'category' => 'Darurat',
                'keywords' => 'banjir, longsor, gempa, angin kencang, bencana alam, evakuasi, puting beliung, tsunami, bpbd',
                'question' => 'Ada bencana alam (banjir/longsor), bagaimana informasinya?',
                'answer' => "⚠️ **TINDAKAN DARURAT BENCANA ALAM**\n\n1. Pantau arahan dari petugas BPBD atau aparat setempat\n2. Amankan dokumen berharga ke tempat yang tinggi/kering\n3. Jika air naik atau terjadi gempa susulan, segera menuju titik evakuasi resmi\n4. Siapkan tas siaga bencana (makanan, obat, lampu senter).\n\n*Tetap tenang dan waspada.*",
                'is_active' => true
            ],

            // === KATEGORI: ADMINDUK (ADMINISTRASI KEPENDUDUKAN) ===
            [
                'category' => 'Adminduk',
                'keywords' => 'ktp, buat ktp, syarat ktp, e-ktp, ktp hilang, ktp rusak',
                'question' => 'Mau buat KTP, apa saja syaratnya dan bagaimana caranya?',
                'answer' => "Halo! Untuk pengurusan KTP (KTP Elektronik), persyaratannya adalah:\n1. Usia minimal 17 tahun\n2. Fotokopi Kartu Keluarga (KK)\n\n**Jika KTP Hilang/Rusak:**\n- Surat Keterangan Hilang dari Polsek (jika hilang)\n- KTP yang rusak (jika rusak)\n- Fotokopi KK.\n\nSilakan datang ke Kantor Kecamatan pada jam layanan untuk melakukan perekaman foto dan biometrik.",
                'is_active' => true
            ],
            [
                'category' => 'Adminduk',
                'keywords' => 'kk, kartu keluarga, update kk, nambah anggota kk, anak baru lahir, pecah kk',
                'question' => 'Ingin mengupdate atau menambah anggota di Kartu Keluarga (KK)',
                'answer' => "Tentu! Untuk update data atau menambah anggota Kartu Keluarga (KK), silakan siapkan:\n1. KK Asli\n2. Surat Keterangan Lahir (jika tambah anak) atau Surat Pindah (jika ada yang datang)\n3. Fotokopi Buku Nikah/Akta Perkawinan\n4. Mengisi formulir dari Desa/Kelurahan.\n\nProses ini biasanya dilakukan di tingkat Kecamatan atau langsung ke Dispendukcapil.",
                'is_active' => true
            ],
            [
                'category' => 'Adminduk',
                'keywords' => 'akte kelahiran, lahir, buat akte, akta lahir',
                'question' => 'Anak saya baru lahir, bagaimana cara membuat Akta Kelahiran?',
                'answer' => "Selamat atas kelahiran buah hatinya! Untuk membuat Akta Kelahiran, syaratnya adalah:\n1. Surat Keterangan Kelahiran dari RS/Bidan/Puskesmas\n2. Fotokopi Buku Nikah orang tua (legalisir)\n3. Fotokopi KK dan KTP orang tua\n4. Nama anak yang sudah dipastikan ejaannya.\n\nPengurusan ini tidak dipungut biaya (gratis).",
                'is_active' => true
            ],
            [
                'category' => 'Adminduk',
                'keywords' => 'surat pindah, pindah keluar, pindah datang, domisili, pindah alamat',
                'question' => 'Ingin mengurus Surat Pindah Domisili ke luar daerah',
                'answer' => "Untuk mengurus Surat Pindah (SKPWNI), prosedurnya adalah:\n1. Membawa KK Asli & KTP Asli\n2. Membawa Alamat Lengkap tujuan pindah\n3. Melapor ke Desa/Kelurahan untuk mendapatkan Surat Pengantar Pengantar\n4. Menuju Kantor Kecamatan untuk proses cetak Surat Pindah.\n\nPastikan semua urusan administratif di tempat lama (pajak/iuran) sudah diselesaikan.",
                'is_active' => true
            ],
            [
                'category' => 'Adminduk',
                'keywords' => 'kia, kartu identitas anak, buat kia',
                'question' => 'Bagaimana cara membuat KIA (Kartu Identitas Anak)?',
                'answer' => "KIA sangat berguna untuk anak usia 0-17 tahun kurang satu hari. Syaratnya:\n1. Fotokopi Akta Kelahiran Anak\n2. KK asli orang tua\n3. Foto ukuran 2x3 (untuk anak usia di atas 5 tahun)\n4. KTP orang tua.\n\nSilakan ajukan di loket pelayanan Adminduk Kecamatan.",
                'is_active' => true
            ],

            // === KATEGORI: UMUM (PELAYANAN & INFORMASI) ===
            [
                'category' => 'Umum',
                'keywords' => 'jam kerja, jam pelayanan, senin, jumat, buka, tutup, operasional',
                'question' => 'Kapan jam pelayanan kantor Kecamatan buka dan tutup?',
                'answer' => "Kantor Kecamatan siap melayani Anda pada hari kerja rutin:\n- **Senin - Kamis**: 08.00 s/d 15.30 WIB\n- **Jumat**: 08.00 s/d 14.30 WIB\n\n*Sabtu, Minggu, dan Hari Libur Nasional kantor tutup.* Kami sarankan datang sebelum pukul 15.00 agar dokumen Anda dapat diproses di hari yang sama.",
                'is_active' => true
            ],
            [
                'category' => 'Umum',
                'keywords' => 'biaya, bayar, tarif, harga, pungli',
                'question' => 'Berapa biaya pengurusan surat-surat di Kecamatan?',
                'answer' => "Kami berkomitmen pada pelayanan bersih. Seluruh pengurusan administrasi kependudukan (KTP, KK, Akta, dll) di kantor Kecamatan adalah **GRATIS** atau tidak dipungut biaya apapun.\n\nJika ada oknum yang meminta imbalan, silakan laporkan melalui menu Pengaduan.",
                'is_active' => true
            ],
            [
                'category' => 'Umum',
                'keywords' => 'lapor, pengaduan, komplain, kritik, saran, pelayanan buruk',
                'question' => 'Saya ingin menyampaikan keluhan atau kritik terkait pelayanan.',
                'answer' => "Kami sangat menghargai masukan Anda. Anda dapat menyampaikan pengaduan atau kritik melalui:\n1. Menu 'Sampaikan Layanan / Pengaduan' di halaman utama aplikasi ini.\n2. Mengisi kotak saran di kantor Kecamatan.\n3. Menghubungi admin melalui WhatsApp Center yang tertera.\n\nSetiap laporan akan kami tindak lanjuti secara profesional.",
                'is_active' => true
            ],

            // === KATEGORI: PEMERINTAHAN (TATA KELOLA WILAYAH) ===
            [
                'category' => 'Pemerintahan',
                'keywords' => 'desa, kades, aparat desa, konflik desa, perangkat desa',
                'question' => 'Ada masalah dengan aparat Desa, ke mana saya harus melapor?',
                'answer' => "Masalah terkait kinerja atau administrasi Desa dapat dikonsultasikan melalui Seksi Pemerintahan di Kecamatan. Kami akan melakukan mediasi atau pembinaan terhadap Pemerintah Desa terkait sesuai kewenangan Camat sebagai pembina wilayah.",
                'is_active' => true
            ],
            [
                'category' => 'Pemerintahan',
                'keywords' => 'musdes, rkpdes, apbdes, anggaran desa',
                'question' => 'Ingin tahu tentang Musyawarah Desa dan Penggunaan Anggaran Desa.',
                'answer' => "Musyawarah Desa (Musdes) adalah forum tertinggi di tingkat desa untuk menentukan arah pembangunan. Warga berhak hadir dan memberikan usulan. Transparansi APBDes biasanya dipaparkan melalui baliho di depan kantor desa. Jika ada indikasi penyimpangan, warga dapat melapor ke BPD atau pihak Kecamatan.",
                'is_active' => true
            ],

            // === KATEGORI: PEMBANGUNAN (EKONOMI & SOSIAL) ===
            [
                'category' => 'Pembangunan',
                'keywords' => 'blt, bansos, bantuan sosial, pkh, sembako, kenapa tidak dapat bantuan',
                'question' => 'Mengapa saya tidak mendapatkan bantuan sosial (BLT/PKH)?',
                'answer' => "Kami memahami kebutuhan Anda. Penerima bantuan sosial ditentukan berdasarkan Data Terpadu Kesejahteraan Sosial (DTKS) dari Kementerian Sosial. Jika Anda merasa layak namun belum terdaftar, silakan melapor ke operator SIKS-NG di Desa/Kelurahan Anda untuk proses usulan baru atau verifikasi data lapangan.",
                'is_active' => true
            ],
            [
                'category' => 'Pembangunan',
                'keywords' => 'umkm, modal, izin usaha, ibp, nib',
                'question' => 'Ingin mengurus izin usaha kecil (UMKM) atau mencari bantuan modal.',
                'answer' => "Untuk pelaku usaha mikro, Anda dapat mengurus **NIB (Nomor Induk Berusaha)** secara mandiri melalui sistem OSS atau meminta bantuan pendampingan di Seksi Ekonomi & Pembangunan Kecamatan. Untuk bantuan modal, kami sering mengadakan sosialisasi program KUR dari perbankan atau pelatihan keterampilan UMKM.",
                'is_active' => true
            ],
        ];

        foreach ($faqs as $faq) {
            PelayananFaq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
