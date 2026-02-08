/**
 * voice.bundle.js
 * Consolidated Voice Guide System
 * Combine all modules into a single file to prevent race conditions and scope issues.
 */

(function () {
    "use strict";

    // --- 1. CONFIGURATION (voice.config.js) ---
    window.VoiceConfig = {
        appName: 'Sistem Informasi Kecamatan',
        regionName: window.APP_WILAYAH_NAMA || 'Kecamatan',
        INTENT: {
            WELCOME: 'WELCOME',
            STOP: 'STOP',
            NAVIGATE_BERITA: 'NAV_BERITA',
            NAVIGATE_LAYANAN: 'NAV_LAYANAN',
            NAVIGATE_HOME: 'NAV_HOME',
            NAVIGATE_WILAYAH: 'NAV_WILAYAH',
            NAVIGATE_PROFILE: 'NAV_PROFILE',
            READ_NEWS_ITEM: 'READ_NEWS_ITEM',
            READ_NEWS_DETAIL: 'READ_NEWS_DETAIL',
            LOGIN: 'LOGIN',
            INFO_HOURS: 'INFO_HOURS',
            FAQ_SEARCH: 'FAQ_SEARCH',
            UNKNOWN: 'UNKNOWN'
        },
        keywords: [
            { intent: 'STOP', words: ['matikan', 'stop', 'berhenti', 'nonaktifkan', 'diam'] },
            { intent: 'NAVIGATE_BERITA', words: ['berita', 'warta', 'kabar', 'informasi'] },
            { intent: 'NAVIGATE_LAYANAN', words: ['layanan', 'pelayanan', 'admin', 'surat', 'ktp', 'kk', 'akta', 'domisili'] },
            { intent: 'NAVIGATE_HOME', words: ['beranda', 'home', 'depan', 'utama', 'awal'] },
            { intent: 'NAVIGATE_WILAYAH', words: ['wilayah', 'pariwisata', 'wisata', 'umkm', 'potensi', 'loker', 'lowongan'] },
            { intent: 'NAVIGATE_INFO', words: ['info', 'informasi', 'pengumuman', 'hari ini'] },
            { intent: 'NAVIGATE_PENGADUAN', words: ['pengaduan', 'lapor', 'aspirasi', 'keluhan'] },
            { intent: 'NAVIGATE_PROFILE', words: ['profile', 'profil', 'tentang', 'sejarah', 'struktur'] },
            { intent: 'FAQ_SEARCH', words: ['bantuan', 'cari', 'tanya', 'bagaimana', 'syarat', 'persyaratan'] },
            { intent: 'LOGIN', words: ['masuk', 'login', 'operator', 'admin'] }
        ],
        messages: {
            welcome: (region) => `Selamat datang di ${region}. Berikut adalah menu yang tersedia pada halaman ini.`,
            menuItem: (item) => `Menu ${item}.`,
            instruction: "Silakan pilih menu yang Anda inginkan, atau katakan keperluan Anda.",
            stopConfirmation: "Baik, suara panduan dinonaktifkan.",
            navigateHome: "Kembali ke halaman utama.",
            navigateLogin: "Mengarahkan ke halaman Login Petugas.",
            infoHours: "Kami buka Senin sampai Kamis pukul 08.00 sampai 15.30, dan Jumat pukul 08.00 sampai 14.30 WIB.",
            activated: "Suara panduan diaktifkan. Silakan dengarkan petunjuk atau katakan perintah.",
            deactivated: "Suara panduan dinonaktifkan.",
            fallbackTitle: "Panduan Suara Aktif",
            fallbackText: "Audio tidak tersedia di perangkat ini. Silakan gunakan menu visual."
        }
    };

    // --- 2. LEXICON (voice.lexicon.js) ---
    window.VoiceLexicon = (function () {
        const RAW_LEXICON = {
            verbs: {
                'read': ['cek', 'periksa', 'lihat', 'baca', 'bacakan', 'bacain', 'membaca', 'dibaca', 'denger', 'dengar', 'dengerin', 'dengarkan', 'bukakan', 'buka', 'tampilkan', 'tunjukkan'],
                'stop': ['stop', 'setop', 'berhenti', 'diem', 'diam', 'cukup', 'sudah', 'jangan', 'matikan', 'nonaktifkan', 'batal', 'shh', 'tutup', 'keluar'],
                'back': ['kembali', 'balik', 'pulang', 'ke belakang', 'ke awal', 'ke beranda', 'ke halaman utama', 'back'],
                'next': ['lanjut', 'lanjutin', 'selanjutnya', 'berikutnya', 'terus', 'sambung', 'next'],
                'contact': ['hubungi', 'telepon', 'wa', 'whatsapp', 'email', 'alamat', 'kantor', 'lokasi', 'tanya', 'bertanya', 'minta tolong', 'syarat', 'prosedur', 'bagaimana'],
                'login': ['masuk', 'login', 'log in', 'sign in', 'daftar', 'akun', 'admin', 'operator', 'petugas']
            },
            nouns: {
                'news': ['berita', 'kabar', 'informasi', 'info', 'artikel', 'pengumuman', 'warta', 'bacaan'],
                'audio': ['suara', 'audio', 'panduan suara', 'voice', 'panduan'],
                'menu': ['menu', 'halaman', 'tampilan'],
                'service': [
                    'layanan', 'servis', 'jasa', 'pelayanan', 'bantuan', 'service',
                    'administrasi', 'urus', 'pembuatan', 'surat', 'dokumen', 'berkas',
                    'ktp', 'kk', 'akta', 'pengaduan', 'lapor', 'aduan', 'aspirasi'
                ],
                'region': [
                    'wilayah', 'daerah', 'desa', 'lokasi', 'tempat', 'peta', 'geografi',
                    'wisata', 'piknik', 'jalan-jalan', 'tamasya', 'rekreasi'
                ],
                'umkm': [
                    'umkm', 'jualan', 'dagangan', 'bisnis', 'usaha', 'pedagang', 'warung', 'toko'
                ],
                'loker': [
                    'loker', 'lowongan', 'kerja', 'kerjaan', 'karir', 'rekrutmen'
                ],
                'profile': ['profil', 'tentang', 'about', 'kami', 'kita', 'siapa', 'visimisi', 'sejarah', 'struktur', 'organisasi', 'pegawai', 'perangkat', 'pejabat', 'camat'],
                'hours': ['jam', 'pukul', 'waktu', 'jadwal', 'kapan', 'buka', 'operasi', 'operasional', 'kerja']
            },
            references: {
                'pos1': ['pertama', 'kesatu', 'nomer satu', 'nomor satu'],
                'pos2': ['kedua', 'nomer dua', 'nomor dua'],
                'pos3': ['ketiga', 'nomer tiga', 'nomor tiga'],
                'pos_last': ['terakhir', 'paling bawah'],
                'position': ['keempat', 'kelima', 'paling atas', 'sebelumnya', 'sesudahnya'],
                'contextual': ['ini', 'itu', 'yang itu', 'yang tadi', 'tadi', 'sebelumnya', 'barusan', 'tersebut']
            },
            fillers: ['tolong', 'dong', 'ya', 'deh', 'sih', 'lah', 'eh', 'anu', 'nih', 'aja', 'coba', 'boleh', 'mohon', 'saya', 'aku', 'kami', 'ingin', 'pengen', 'mau', 'bisa', 'harap', 'hendak', 'akan', 'sedang', 'lagi', 'kok', 'kan', 'yuk', 'mari', 'halo', 'hai', 'selamat', 'nggak', 'tidak', 'bukan', 'emang', 'apa', 'gimana', 'tuh', 'nah', 'wah', 'oh', 'hmm', 'ehm', 'yang', 'di', 'ke', 'dari', 'bikin', 'buat', 'membuat', 'ingin', 'tahu'],
            corrections: {
                'bacain': 'baca', 'denger': 'dengar', 'dengerin': 'dengar', 'setop': 'stop', 'balik': 'kembali', 'lanjutin': 'lanjut', 'beritanya': 'berita', 'camad': 'camat', 'hom': 'home', 'omkm': 'umkm', 'bup': 'buka', 'wes': 'wisata', 'check': 'cek', 'cheque': 'cek'
            }
        };
        return {
            synonyms: { ...RAW_LEXICON.verbs, ...RAW_LEXICON.nouns, ...RAW_LEXICON.references },
            stopwords: new Set(RAW_LEXICON.fillers),
            typoMap: RAW_LEXICON.corrections,
            _raw: RAW_LEXICON
        };
    })();

    // --- 3. NORMALIZER (voice.normalizer.js) ---
    window.VoiceNormalizer = (function () {
        const Lexicon = window.VoiceLexicon._raw;
        const Synonyms = window.VoiceLexicon.synonyms;

        function normalizeHumanSpeech(input) {
            if (!input || typeof input !== 'string') return { raw: '', normalized: '', tokens: [] };
            let text = input.toLowerCase();

            // 1. Symbol cleanup
            try { text = text.replace(/[^\p{L}\p{N}\s]/gu, ' '); } catch (e) { text = text.replace(/[^a-z0-9\s]/g, ' '); }

            // 2. Corrections & Fillers
            Object.entries(Lexicon.corrections).forEach(([wrong, correct]) => {
                const re = new RegExp(`\\b${wrong}\\b`, 'g');
                text = text.replace(re, correct);
            });
            Lexicon.fillers.forEach(filler => {
                const re = new RegExp(`\\b${filler}\\b`, 'g');
                text = text.replace(re, ' ');
            });

            // 3. Verb Stemming
            text = text.replace(/\bmembacakan\b/g, 'baca').replace(/\bbacakan\b/g, 'baca').replace(/\bbacain\b/g, 'baca').replace(/\bmembaca\b/g, 'baca').replace(/\bdengarkan\b/g, 'dengar').replace(/\bdengerin\b/g, 'dengar').replace(/\bmelihat\b/g, 'lihat');

            // 4. Synonym Mapping (Concept Resolution)
            // This ensures "berita", "kabar", etc. all become "news" for easier matching
            Object.entries(Synonyms).forEach(([concept, words]) => {
                words.forEach(word => {
                    const re = new RegExp(`\\b${word}\\b`, 'g');
                    text = text.replace(re, concept);
                });
            });

            text = text.replace(/\b(\w+)\s+\1\b/g, '$1').replace(/\s+/g, ' ').trim();
            const tokens = text.split(' ').filter(Boolean);
            return { raw: input, normalized: text, tokens };
        }
        return {
            clean: (text) => normalizeHumanSpeech(text).normalized,
            normalizeHumanSpeech: normalizeHumanSpeech
        };
    })();

    // --- 4. INTENT RULES (voice.intent.rules.js) ---
    window.VoiceIntentRules = (function () {
        const Config = window.VoiceConfig;
        const VERBS_NEWS = ['baca', 'bacakan', 'bacain', 'buka', 'berita', 'info', 'kabar', 'kegiatan', 'tentang', 'terkait', 'mengenai', 'read', 'news', 'isi', 'detail', 'selengkapnya', 'umkm', 'loker', 'lowongan', 'produk', 'jualan', 'dagangan'];
        const VERBS_SERVICE = ['syarat', 'cara', 'prosedur', 'biaya', 'urus', 'pengurusan', 'daftar', 'bikin', 'membuat', 'buat', 'ajukan', 'pengajuan'];
        const VERBS_COMPLAINT = ['lapor', 'adukan', 'keluhan', 'komplain'];
        const NOUNS_AMBIGUOUS = ['umkm', 'ktp', 'kk', 'akta', 'surat', 'nikah', 'cerai', 'pindah', 'domisili', 'ijin', 'izin', 'blt', 'dd', 'bantuan', 'region'];

        const RULES = [
            { intent: "NAV_HOME", triggers: ["back", "home", "beranda", "depan", "utama"], minScore: 1 },
            { intent: "NAV_NEWS", triggers: ["news", "read", "berita", "kabar", "detail", "isi", "umkm", "loker", "produk"], minScore: 1 },
            { intent: "NAV_SERVICES", triggers: ["service"], minScore: 1 },
            { intent: "NAV_PROFILE", triggers: ["profile", "profil", "tentang"], minScore: 1 },
            { intent: "NAV_INFO", triggers: ["info", "informasi", "pengumuman", "hari ini"], minScore: 1 },
            { intent: "NAV_COMPLAINT", triggers: ["pengaduan", "lapor", "aspirasi", "keluhan"], minScore: 1 },
            { intent: "NAV_LOGIN", triggers: ["login", "masuk", "admin", "operator"], minScore: 1 },
            { intent: "INFO_HOURS", triggers: ["hours", "jam", "buka", "tutup", "jadwal"], minScore: 1 },
            { intent: "FAQ_SEARCH", triggers: ["contact", "tanya", "apa", "syarat"], minScore: 1 }
        ];

        function evaluate(normalizedText) {
            console.log(`[IntentRules] Evaluating: "${normalizedText}"`);
            const tokens = normalizedText.split(' ');

            const hasNewsVerb = tokens.some(t => VERBS_NEWS.includes(t));
            if (hasNewsVerb) {
                const hasStrongServiceVerb = tokens.some(t => ['syarat', 'cara', 'prosedur', 'biaya', 'urus', 'mengurus'].includes(t));
                if (!hasStrongServiceVerb) return { intent: mapInternalIntentToConfig("NAV_NEWS"), score: 10, originalIntent: "NAV_NEWS" };
            }

            const hasServiceVerb = tokens.some(t => VERBS_SERVICE.includes(t));
            if (hasServiceVerb) return { intent: mapInternalIntentToConfig("FAQ_SEARCH"), score: 10, originalIntent: "FAQ_SEARCH" };

            const hasComplaintVerb = tokens.some(t => VERBS_COMPLAINT.includes(t));
            if (hasComplaintVerb) return { intent: mapInternalIntentToConfig("NAV_COMPLAINT"), score: 10, originalIntent: "NAV_COMPLAINT" };

            const hasAmbiguousNoun = tokens.some(t => NOUNS_AMBIGUOUS.includes(t));
            if (hasAmbiguousNoun) return { intent: mapInternalIntentToConfig("NAV_NEWS"), score: 5, originalIntent: "NAV_NEWS" };

            let bestMatch = null;
            let highestScore = 0;
            for (const rule of RULES) {
                let score = 0;
                tokens.forEach(token => { if (rule.triggers.includes(token)) score += 1; });
                if (score >= rule.minScore && score > highestScore) {
                    highestScore = score;
                    bestMatch = { intent: mapInternalIntentToConfig(rule.intent), score: score, originalIntent: rule.intent };
                }
            }
            return bestMatch;
        }

        function mapInternalIntentToConfig(ruleIntent) {
            const C = window.VoiceConfig.INTENT;
            const MAPPING = {
                "NAV_HOME": C.NAVIGATE_HOME,
                "NAV_NEWS": C.NAVIGATE_BERITA,
                "NAV_SERVICES": C.NAVIGATE_LAYANAN,
                "NAV_INFO": C.NAVIGATE_INFO,
                "NAV_COMPLAINT": C.NAVIGATE_PENGADUAN,
                "NAV_PROFILE": C.NAVIGATE_PROFILE,
                "NAV_REGION": C.NAVIGATE_WILAYAH,
                "NAV_LOGIN": C.LOGIN,
                "INFO_HOURS": C.INFO_HOURS,
                "FAQ_SEARCH": C.FAQ_SEARCH
            };
            return MAPPING[ruleIntent] || C.UNKNOWN;
        }

        return { findMatch: evaluate };
    })();

    // --- 5. STATE (voice.state.js) ---
    window.VoiceState = (function () {
        let state = { isActive: false, isContinuous: false, isSpeaking: false, isListening: false, hasPlayedWelcome: false };
        let recoveryTimer = null;

        function init() {
            const savedActive = localStorage.getItem('voiceGuideActive');
            if (savedActive === 'true') { state.isActive = true; state.isContinuous = true; }

            // Periodically check for "stuck" speaking state
            setInterval(() => {
                if (state.isSpeaking && !window.speechSynthesis.speaking) {
                    window.VoiceState.setSpeaking(false);
                    if (state.isActive) window.VoiceRecognition.start();
                }
            }, 3000);
        }
        return {
            init: init,
            isActive: () => state.isActive,
            isContinuous: () => state.isContinuous,
            setActive: (status) => {
                state.isActive = status; state.isContinuous = status;
                if (!status) state.hasPlayedWelcome = false;
                localStorage.setItem('voiceGuideActive', status ? 'true' : 'false');
                document.dispatchEvent(new CustomEvent('voice-state-change', { detail: { isActive: status } }));
            },
            setSpeaking: (status) => state.isSpeaking = status,
            isSpeaking: () => state.isSpeaking,
            setListening: (status) => state.isListening = status,
            isListening: () => state.isListening,
            setPlayedWelcome: (status) => state.hasPlayedWelcome = status,
            hasPlayedWelcome: () => state.hasPlayedWelcome,
            setPendingAction: (action, payload) => {
                try {
                    if (action) sessionStorage.setItem('voicePendingAction', JSON.stringify({ action, payload }));
                    else sessionStorage.removeItem('voicePendingAction');
                } catch (e) { console.warn('[VoiceState] sessionStorage failed', e); }
            },
            getPendingAction: () => {
                try {
                    const data = sessionStorage.getItem('voicePendingAction');
                    return data ? JSON.parse(data) : null;
                } catch (e) { console.warn('[VoiceState] getPendingAction failed', e); return null; }
            }
        };
    })();

    // --- 6. SPEECH (voice.speech.js) ---
    window.VoiceSpeech = (function () {
        let synth = window.speechSynthesis;
        let voices = [];
        function loadVoices() { if (synth) voices = synth.getVoices(); }
        if (synth) { if (synth.onvoiceschanged !== undefined) synth.onvoiceschanged = loadVoices; loadVoices(); }
        function naturalizeText(text) {
            if (!text) return '';
            // 1. Remove Markdown Bold/Italic
            let cleaned = text.replace(/\*\*/g, '').replace(/__(.*?)__/g, '$1').replace(/\*(.*?)\*/g, '$1').replace(/_(.*?)_/g, '$1');
            // 2. Remove Headers
            cleaned = cleaned.replace(/^#+ /gm, '');
            // 3. Keep text from links [text](url)
            cleaned = cleaned.replace(/\[(.*?)\]\(.*?\)/g, '$1');
            // 4. Remove list markers at start of lines
            cleaned = cleaned.replace(/^[*-] /gm, '').replace(/^[0-9]+\. /gm, '');
            // 5. Remove URLs and Emails
            cleaned = cleaned.replace(/https?:\/\/\S+/g, '').replace(/[\w\.-]+@[\w\.-]+\.\w+/g, '');
            // 6. Handle Newlines (Double -> Period, Single -> Comma for pause)
            cleaned = cleaned.replace(/\n\n/g, '. ').replace(/\n/g, ', ');
            // 7. Remove special chars like quotes that might be read literally in some engines
            cleaned = cleaned.replace(/["`]/g, '');
            // 8. Cleanup extra spaces
            return cleaned.replace(/\s+/g, ' ').trim();
        }

        function createUtterance(text, silentStart = false) {
            const naturalText = naturalizeText(text);
            const utterance = new SpeechSynthesisUtterance(naturalText);
            const voice = voices.find(v => v.lang === 'id-ID') || voices.find(v => v.lang.startsWith('id')) || voices[0];
            if (voice) { utterance.voice = voice; utterance.lang = voice.lang; } else utterance.lang = 'id-ID';
            utterance.rate = 1.0;

            utterance.onstart = () => {
                console.log('[VoiceSpeech] 🔊 Speaking:', text.substring(0, 30) + '...');
                window.VoiceState.setSpeaking(true);
            };

            // Common finalizer
            const finish = () => {
                console.log('[VoiceSpeech] 🔇 Finished:', text.substring(0, 20));
                // We DON'T setSpeaking(false) here if it's part of a sequence
                // That's handled by the caller or specialized sequence end logic
            };

            utterance.onend = finish;
            utterance.onerror = (e) => {
                console.error('[VoiceSpeech] ❌ Error:', e.error);
                finish();
            };

            return utterance;
        }
        return {
            speak: (text, onEndCallback) => {
                if (!window.VoiceState.isActive() && !text.includes('nonaktif')) return;
                if (!synth) { document.dispatchEvent(new CustomEvent('voice-error-tts')); return; }
                synth.cancel();
                const utterance = createUtterance(text);

                // Override onend/onerror for single utterances to handle state and recognition restart
                utterance.onend = () => {
                    window.VoiceState.setSpeaking(false);
                    if (onEndCallback) onEndCallback();
                    if (window.VoiceState.isActive()) window.VoiceRecognition.start();
                };
                utterance.onerror = () => {
                    window.VoiceState.setSpeaking(false);
                    if (window.VoiceState.isActive()) window.VoiceRecognition.start();
                };

                window.VoiceState.setSpeaking(true); // Pre-emptive state
                synth.speak(utterance);
            },
            stop: () => {
                if (synth) synth.cancel();
                window.VoiceState.setSpeaking(false);
                if (window.VoiceState.isActive()) window.VoiceRecognition.start();
            },
            speakSequence: (sentences, onComplete) => {
                if (!sentences || sentences.length === 0) { if (onComplete) onComplete(); return; }
                const playNext = (index) => {
                    if (index >= sentences.length) {
                        window.VoiceState.setSpeaking(false);
                        if (onComplete) onComplete();
                        if (window.VoiceState.isActive()) window.VoiceRecognition.start();
                        return;
                    }
                    if (!window.VoiceState.isActive()) { window.VoiceState.setSpeaking(false); return; }

                    const utterance = createUtterance(sentences[index]);
                    utterance.onend = () => playNext(index + 1);
                    utterance.onerror = () => playNext(index + 1);
                    synth.speak(utterance);
                };
                synth.cancel();
                window.VoiceState.setSpeaking(true); // Pre-emptive state
                playNext(0);
            }
        };
    })();

    // --- 7. RECOGNITION (voice.recognition.js) ---
    window.VoiceRecognition = (function () {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        let recognition = null;
        let restartTimer = null;
        function init() {
            if (!SpeechRecognition) return false;
            recognition = new SpeechRecognition();
            recognition.lang = 'id-ID';
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;
            recognition.onstart = () => { window.VoiceState.setListening(true); document.dispatchEvent(new CustomEvent('voice-listen-start')); };
            recognition.onend = () => {
                window.VoiceState.setListening(false);
                document.dispatchEvent(new CustomEvent('voice-listen-end'));

                // RECOVERY LOGIC: Only restart if we are NOT currently speaking and ACTUALLY active
                if (window.VoiceState.isActive() && !window.VoiceState.isSpeaking()) {
                    clearTimeout(restartTimer);
                    restartTimer = setTimeout(() => {
                        if (window.VoiceState.isActive() && !window.VoiceState.isSpeaking()) {
                            try { recognition.start(); } catch (e) { }
                        }
                    }, 250);
                }
            };
            recognition.onresult = (event) => {
                // FEEDBACK LOOP PROTECTION: Ignore if system is speaking
                if (window.VoiceState.isSpeaking()) {
                    console.log("[VoiceRecognition] 🤐 System is speaking, ignoring result.");
                    return;
                }

                const transcript = event.results[0][0].transcript;
                console.log("[VoiceRecognition] 👂 Heard:", transcript);
                document.dispatchEvent(new CustomEvent('voice-command', { detail: { text: transcript } }));
            };
            recognition.onerror = (event) => {
                if (event.error !== 'no-speech') {
                    console.log("Recognition Error:", event.error);
                }
                if (event.error === 'not-allowed' || event.error === 'service-not-allowed') window.VoiceState.setActive(false);
            };
            return true;
        }
        return {
            init: init,
            start: () => { if (recognition) try { recognition.start(); } catch (e) { } },
            stop: () => { if (recognition) try { recognition.stop(); } catch (e) { } }
        };
    })();

    // --- 8. PARSER (voice.parser.js) ---
    window.VoiceParser = (function () {
        function parse(text) {
            console.log('[VoiceParser] Parsing:', text);
            if (!text) return { intent: window.VoiceConfig.INTENT.UNKNOWN, original: "" };
            const normalized = window.VoiceNormalizer.clean(text);
            console.log('[VoiceParser] Normalized Concept:', normalized);

            const ruleMatch = window.VoiceIntentRules.findMatch(normalized);

            // 3. Item Specific Logic (Variable Extraction)
            const topic = extractTopic(normalized);
            const targetLink = findTargetLink(topic);

            // --- CONTEXTUAL CHECK ---
            const isDetailPage = document.querySelector('article') !== null || window.location.pathname.includes('/umkm/');
            const isContextualRequest = ['ini', 'itu', 'artikel', 'isi', 'detail', 'selengkapnya', 'produk'].includes(topic);

            // A. CONTEXTUAL
            if (isDetailPage && (isContextualRequest || !topic) && ruleMatch && ruleMatch.originalIntent === "NAV_NEWS") {
                return { intent: window.VoiceConfig.INTENT.READ_NEWS_DETAIL, original: text };
            }

            // B. DIRECT LINK FOUND
            if (targetLink) {
                return { intent: window.VoiceConfig.INTENT.READ_NEWS_ITEM, payload: targetLink, original: text };
            }

            // C. NOT FOUND BUT HAS TOPIC -> SEARCH
            if (ruleMatch && ruleMatch.originalIntent === "NAV_NEWS" && topic && topic.length > 3) {
                return { intent: 'SEARCH_NEWS', payload: { keyword: topic }, original: text };
            }

            return { intent: ruleMatch ? ruleMatch.intent : window.VoiceConfig.INTENT.UNKNOWN, original: text, matched: ruleMatch ? ruleMatch.originalIntent : 'UNKNOWN' };
        }

        function extractTopic(normalizedText) {
            // Remove known Intent Keywords to isolate the "Subject"
            return normalizedText
                .replace(/\bread\b/g, '')     // Key: read
                .replace(/\bnews\b/g, '')     // Key: news
                .replace(/\bprofile\b/g, '')  // Key: profile
                .replace(/\bcontact\b/g, '')  // Key: contact
                .replace(/\bmenu\b/g, '')     // Key: menu
                .replace(/\bservice\b/g, '')  // Key: service
                .replace(/\bposition\b/g, '') // Key: position
                .replace(/\bcontextual\b/g, '')
                .trim();
        }

        function findTargetLink(cleanText) {
            if (!cleanText || cleanText.length < 3) return null;

            // 1. News
            const newsLinks = document.querySelectorAll('#berita h3 a');
            for (let link of newsLinks) { if (link.innerText.toLowerCase().includes(cleanText)) return link; }

            // 2. UMKM
            const umkmTitles = document.querySelectorAll('#umkm h4');
            for (let title of umkmTitles) {
                if (title.innerText.toLowerCase().includes(cleanText)) {
                    const card = title.closest('.group');
                    const btn = card ? card.querySelector('a[href*="/umkm/"]') : null;
                    if (btn) return btn;
                }
            }

            // 3. Layanan
            const serviceTitles = document.querySelectorAll('#layanan h3');
            for (let title of serviceTitles) {
                if (title.innerText.toLowerCase().includes(cleanText)) {
                    const card = title.closest('.card');
                    const btn = card ? card.querySelector('button') : null;
                    if (btn) return btn;
                }
            }
            return null;
        }
        return { parse: parse };
    })();

    // --- 9. ACTIONS (voice.actions.js) ---
    window.VoiceActions = (function () {
        function execute(parseResult) {
            const Config = window.VoiceConfig;
            const Intent = Config.INTENT;
            const Speech = window.VoiceSpeech;
            console.log("Executing Intent:", parseResult.intent);
            switch (parseResult.intent) {
                case Intent.STOP: Speech.speak(Config.messages.stopConfirmation); window.VoiceState.setActive(false); break;
                case Intent.WELCOME: playWelcomeSequence(); break;
                case Intent.NAVIGATE_HOME:
                    Speech.speak(Config.messages.navigateHome);
                    // Check if we're on a different page
                    if (window.location.pathname !== '/') {
                        setTimeout(() => window.location.assign('/'), 100);
                    } else {
                        navigateTo('top');
                    }
                    break;
                case Intent.NAVIGATE_BERITA: navigateTo('berita'); readTargetSummary(); break;
                case Intent.NAVIGATE_LAYANAN: navigateTo('layanan'); readServices(); break;
                case Intent.NAVIGATE_WILAYAH: navigateTo('umkm'); Speech.speak("Menampilkan UMKM dan Lowongan Kerja."); break;
                case Intent.NAVIGATE_INFO: navigateTo('info-hari-ini'); Speech.speak("Menampilkan informasi hari ini."); break;
                case Intent.NAVIGATE_PENGADUAN: navigateTo('pengaduan'); Speech.speak("Menampilkan layanan pengaduan warga."); break;
                case Intent.LOGIN: Speech.speak(Config.messages.navigateLogin); setTimeout(() => window.location.assign('/login'), 0); break;
                case Intent.INFO_HOURS: Speech.speak(Config.messages.infoHours); break;
                case Intent.READ_NEWS_ITEM:
                    {
                        const target = parseResult.payload;
                        if (!target) break;
                        const url = target.getAttribute('href');
                        const title = target.innerText || target.textContent;
                        window.VoiceState.setPendingAction('READ_DETAIL', { title: title });
                        Speech.speak(`Membuka: ${title}`);
                        setTimeout(() => {
                            if (target.tagName.toLowerCase() === 'button') {
                                target.click();
                            } else {
                                window.location.assign(url);
                            }
                        }, 100);
                    }
                    break;
                case Intent.READ_NEWS_DETAIL: readGenericDetail(); break;
                case Intent.NAVIGATE_PROFILE: navigateTo('profil'); Speech.speak("Menampilkan profil kecamatan."); break;
                case 'SEARCH_NEWS':
                    {
                        const keyword = parseResult.payload.keyword;
                        Speech.speak(`Mencari berita tentang ${keyword}.`);
                        // Implement actual search logic here, e.g., redirect to search page or filter current view
                        // For now, just log
                        console.log(`[VoiceActions] Searching for news: ${keyword}`);
                        // Example: window.location.assign(`/search?q=${encodeURIComponent(keyword)}`);
                    }
                    break;
                case Intent.FAQ_SEARCH:
                    let query = parseResult.original || "";
                    if (query) {
                        // Clean query for Chatbot
                        query = query.toLowerCase()
                            .replace(/bikin|buat|pengen|mau|tahu|tolong|dong|cek|periksa|lihat/g, '')
                            .replace(/\s+/g, ' ').trim();

                        Speech.speak("Sedang mencari informasi untuk: " + query);

                        const modal = document.getElementById('publicServiceModal');
                        if (modal && typeof modal.showModal === 'function') modal.showModal();

                        const botInput = document.getElementById('botQuery'), botForm = document.getElementById('publicFaqForm');
                        if (botInput && botForm && query) {
                            botInput.value = query;
                            botForm.dispatchEvent(new Event('submit'));
                            // Watch for response
                            watchBotResponse();
                        }
                    }
                    break;
                default:
                    if (parseResult.original && parseResult.intent === Config.INTENT.UNKNOWN) {
                        Speech.speak("Maaf, saya tidak mengerti perintah tersebut. Silakan sebutkan menu yang ada di layar.");
                    }
                    break;
            }
        }
        function checkAutoRun() {
            const pending = window.VoiceState.getPendingAction();
            if (pending && pending.action === 'READ_DETAIL') {
                window.VoiceState.setPendingAction(null);
                setTimeout(() => readGenericDetail(pending.payload.title), 300);
            }
        }
        function readGenericDetail(knownTitle) {
            let titleEl = document.querySelector('h1') || document.querySelector('.post-title') || document.querySelector('article h2') || document.querySelector('.card-title');
            let titleText = knownTitle || (titleEl ? titleEl.textContent.trim() : "Informasi");
            let contentEl = document.querySelector('article') || document.querySelector('.article-content') || document.querySelector('.prose') || document.querySelector('.description');
            if (!contentEl) { window.VoiceSpeech.speak(`Saya sudah membuka detail ${titleText}.`); return; }
            let paragraphs = Array.from(contentEl.querySelectorAll('p, li')).map(p => p.textContent.trim()).filter(t => t.length > 20);
            if (paragraphs.length === 0) {
                const rawText = contentEl.textContent;
                const lines = rawText.split('\n').map(l => l.trim()).filter(l => l.length > 25);
                paragraphs = lines.length > 1 ? lines : [rawText];
            }
            let sentences = [`Menampilkan detail: ${titleText}.`].concat(paragraphs.slice(0, 8));
            sentences.push("Sekian informasi ini. Katakan 'kembali' untuk ke menu utama.");
            window.VoiceSpeech.speakSequence(sentences);
        }
        function navigateTo(id) {
            if (id === 'top') window.scrollTo({ top: 0, behavior: 'smooth' });
            else { const el = document.getElementById(id); if (el) { el.scrollIntoView({ behavior: 'smooth', block: 'start' }); el.classList.add('bg-blue-50'); setTimeout(() => el.classList.remove('bg-blue-50'), 2000); } }
        }
        function playWelcomeSequence() {
            const region = window.VoiceConfig.regionName;
            const menus = getReadableMenus();
            const sentences = [window.VoiceConfig.messages.welcome(region)];
            menus.forEach(m => sentences.push(window.VoiceConfig.messages.menuItem(m)));
            sentences.push(window.VoiceConfig.messages.instruction);
            window.VoiceSpeech.speakSequence(sentences, () => window.VoiceState.setPlayedWelcome(true));
        }
        function getReadableMenus() {
            // Target specific menu containers that contain the primary navigation
            const containers = document.querySelectorAll('.navbar-center, .menu, nav');
            const texts = new Set();

            containers.forEach(container => {
                const links = container.querySelectorAll('a');
                links.forEach(el => {
                    const text = el.textContent.trim();
                    // Filters: ignore "Masuk", ignore icons/short text
                    if (text && text.toLowerCase() !== 'masuk' && text.length > 2) {
                        // Check if parent is NOT hidden or if it's a primary menu link
                        texts.add(text);
                    }
                });
            });

            // If empty, try one last broad search
            if (texts.size === 0) {
                const footerLinks = document.querySelectorAll('footer a');
                footerLinks.forEach(el => {
                    const text = el.innerText.trim();
                    if (text && text.length > 3 && text.length < 20) texts.add(text);
                });
            }

            return Array.from(texts);
        }
        function readNewsSummary() {
            const newsItems = document.querySelectorAll('#berita h3 a');
            let text = "Berikut berita terbaru: ";
            if (newsItems.length === 0) text += "Belum ada berita.";
            newsItems.forEach((item, idx) => { if (idx < 3) text += `${item.textContent}. `; });
            window.VoiceSpeech.speak(text);
        }
        function readServices() {
            const items = document.querySelectorAll('#layanan h3');
            let text = "Layanan kami meliputi: ";
            items.forEach(i => text += `${i.textContent}, `);
            window.VoiceSpeech.speak(text);
        }
        function watchBotResponse() {
            const botChatContent = document.getElementById('chatbot-content') || document.querySelector('.chat-content');
            if (!botChatContent) return;

            let lastMessageCount = botChatContent.querySelectorAll('.chat-bubble-ai, .chat-message-bot').length;
            let checkCount = 0;
            const timer = setInterval(() => {
                checkCount++;
                const currentMessages = botChatContent.querySelectorAll('.chat-bubble-ai, .chat-message-bot');
                if (currentMessages.length > lastMessageCount) {
                    clearInterval(timer);
                    const lastMsg = currentMessages[currentMessages.length - 1];
                    const text = lastMsg.textContent.trim();
                    if (text && !text.includes('mencari')) {
                        window.VoiceSpeech.speak(text);
                    }
                }
                if (checkCount > 30) clearInterval(timer); // Timeout 15s
            }, 300);
        }
        return { execute: execute, checkAutoRun: checkAutoRun };
    })();

    // --- 10. INITIALIZATION CORE ---
    function initializeSystem() {
        console.log('[VoiceBundle] Initializing System...');

        // --- DYNAMIC FAQ SYNC ---
        if (window.APP_FAQ_KEYWORDS && Array.isArray(window.APP_FAQ_KEYWORDS)) {
            console.log('[VoiceBundle] Syncing dynamic FAQ keywords:', window.APP_FAQ_KEYWORDS.length);

            // 1. Add to Lexicon (for Normalizer resolution)
            if (window.VoiceLexicon && window.VoiceLexicon.synonyms && window.VoiceLexicon.synonyms.contact) {
                window.APP_FAQ_KEYWORDS.forEach(k => {
                    if (!window.VoiceLexicon.synonyms.contact.includes(k)) {
                        window.VoiceLexicon.synonyms.contact.push(k);
                    }
                });
            }

            // 2. Add to Config Keywords (for Intent Matching)
            const faqRule = window.VoiceConfig.keywords.find(k => k.intent === 'FAQ_SEARCH');
            if (faqRule) {
                window.APP_FAQ_KEYWORDS.forEach(k => {
                    if (!faqRule.words.includes(k)) {
                        faqRule.words.push(k);
                    }
                });
            }
        }

        window.VoiceState.init();
        window.VoiceRecognition.init();

        // Bind Toggle Button
        const bindBtn = () => {
            const btn = document.getElementById('btnVoiceGuideToggle') || document.getElementById('voice-guide-btn');
            if (btn) {
                window.activateVoiceGuide = window.activateVoiceGuide || function () {
                    const newState = !window.VoiceState.isActive();
                    window.VoiceState.setActive(newState);
                };
                if (!btn.onclick) btn.addEventListener('click', window.activateVoiceGuide);
            }
        };
        bindBtn();

        // Event Listeners
        document.addEventListener('voice-command', (e) => {
            const parseResult = window.VoiceParser.parse(e.detail.text);
            window.VoiceActions.execute(parseResult);
        });

        document.addEventListener('voice-state-change', (e) => {
            const active = e.detail.isActive;
            updateVisuals(active);
            if (active) {
                window.VoiceState.setPlayedWelcome(false);
                window.VoiceRecognition.start();

                // SAFETY DELAY: Ensure SpeechSynthesis is ready and UI has settled
                setTimeout(() => {
                    if (window.VoiceState.isActive()) {
                        window.VoiceActions.execute({ intent: window.VoiceConfig.INTENT.WELCOME });
                    }
                }, 100);
            } else {
                window.VoiceRecognition.stop();
                window.VoiceSpeech.stop();
            }
        });

        if (window.VoiceState.isActive()) {
            updateVisuals(true);
            window.VoiceRecognition.start();
        }
        window.VoiceActions.checkAutoRun();
    }

    function updateVisuals(isActive) {
        const btn = document.getElementById('btnVoiceGuideToggle') || document.getElementById('voice-guide-btn');
        const ping = document.getElementById('voice-ping'), dot = document.getElementById('voice-dot');
        if (!btn) return;
        if (isActive) {
            if (btn.id === 'btnVoiceGuideToggle') btn.classList.add('bg-emerald-500', 'ring-4', 'ring-emerald-200');
            else { btn.style.backgroundColor = '#10b981'; btn.classList.add('ring-4', 'ring-emerald-200'); }
            if (ping) ping.classList.remove('hidden');
            if (dot) { dot.classList.remove('hidden'); dot.classList.add('bg-emerald-400'); }
        } else {
            if (btn.id === 'btnVoiceGuideToggle') btn.classList.remove('bg-emerald-500', 'ring-4', 'ring-emerald-200');
            else { btn.style.backgroundColor = '#f97316'; btn.classList.remove('ring-4', 'ring-emerald-200'); }
            if (ping) ping.classList.add('hidden');
            if (dot) dot.classList.add('hidden');
        }
    }

    // BOOTSTRAP
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeSystem);
    } else {
        initializeSystem();
    }

    console.log('[VoiceGuide] Consolidated Bundle Loaded Successfully');
})();
