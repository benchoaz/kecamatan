<?php

namespace App\Http\Controllers;

use App\Models\PublicService;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PublicServiceController extends Controller
{
    public function submit(Request $request)
    {
        // 1. Honeypot check (simple anti-spam)
        if ($request->filled('website')) {
            return response()->json(['message' => 'Spam detected.'], 422);
        }

        // 2. Rate Limiting (2 reports / 24h per WA number)
        $count = PublicService::where('whatsapp', $request->whatsapp)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->count();
        if ($count >= 2) {
            return response()->json(['message' => 'Anda telah mencapai batas pengiriman laporan hari ini. Silakan coba lagi besok.'], 429);
        }

        // 3. Security Keyword filtering (Soft redirection to SP4N-LAPOR)
        $securityKeywords = ['korupsi', 'suap', 'pencurian', 'pidana', 'dana desa'];
        foreach ($securityKeywords as $keyword) {
            if (Str::contains(strtolower($request->uraian), $keyword)) {
                return response()->json([
                    'type' => 'security_referral',
                    'message' => 'Informasi: Untuk laporan terkait indikasi tata kelola keuangan atau penyimpangan berat, disarankan menggunakan kanal resmi SP4N-LAPOR! demi perlindungan data Anda.',
                    'link' => 'https://lapor.go.id'
                ], 200);
            }
        }

        // 4. SIAK keyword filtering (Passive redirection)
        $siakKeywords = ['ktp', 'kk', 'kartu keluarga', 'akta', 'capil', 'siak', 'domisili'];
        foreach ($siakKeywords as $keyword) {
            if (Str::contains(strtolower($request->uraian), $keyword)) {
                return response()->json([
                    'type' => 'siak_referral',
                    'message' => 'Informasi: Untuk layanan kependudukan (KTP, KK, Akta), silakan merujuk ke portal resmi SIAK atau layanan Dispendukcapil Kabupaten.',
                    'link' => 'https://siakterpusat.kemendagri.go.id'
                ], 200);
            }
        }

        // 5. FAQ Logic Integration
        if ($request->filled('uraian')) {
            $userQuestion = strtolower($request->uraian);
            $matchingFaq = \App\Models\PelayananFaq::where('is_active', true)->get()->first(function ($faq) use ($userQuestion) {
                $keywords = explode(',', strtolower($faq->keywords));
                foreach ($keywords as $kw) {
                    if (trim($kw) !== '' && str_contains($userQuestion, trim($kw))) {
                        return true;
                    }
                }
                return false;
            });

            if ($matchingFaq) {
                return response()->json([
                    'type' => 'faq_match',
                    'question' => $matchingFaq->question,
                    'message' => "Jawaban Otomatis:\n" . $matchingFaq->answer . "\n\nInformasi ini bersifat umum. Jika Anda masih ingin mengirim laporan resmi, silakan ubah sedikit deskripsi Anda atau sampaikan detail lainnya.",
                    'answer' => $matchingFaq->answer
                ], 200);
            }
        }

        // 5. Validation
        $validator = Validator::make($request->all(), [
            'jenis_layanan' => 'required|string',
            'desa_id' => 'nullable|exists:desa,id',
            'uraian' => 'required|string|max:500',
            'whatsapp' => 'required|string|regex:/^[0-9+]+$/',
            'foto.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 6. Create record (Status: Menunggu Klarifikasi)
        $service = PublicService::create([
            'uuid' => (string) Str::uuid(),
            'desa_id' => $request->desa_id,
            'jenis_layanan' => $request->jenis_layanan,
            'uraian' => $request->uraian,
            'whatsapp' => $request->whatsapp,
            'is_agreed' => $request->boolean('is_agreed'),
            'ip_address' => $request->ip(),
            'status' => 'Menunggu Klarifikasi'
        ]);

        // 7. Handle uploads
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $i => $file) {
                if ($i < 2) {
                    $path = $file->store('public_services', 'local');
                    $fieldName = 'file_path_' . ($i + 1);
                    $service->update([$fieldName => $path]);
                }
            }
        }

        return response()->json([
            'message' => 'Terima kasih. Laporan Anda telah kami terima dengan status "Menunggu Klarifikasi". Petugas kami akan melakukan tinjauan administratif secara selektif.'
        ]);
    }
}
