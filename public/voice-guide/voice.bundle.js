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
            { intent: 'STOP', words: ['stop', 'matikan', 'berhenti', 'nonaktifkan', 'diam'] },
            { intent: 'NAVIGATE_BERITA', words: ['news', 'berita', 'warta', 'kabar', 'informasi'] },
            { intent: 'NAVIGATE_LAYANAN', words: ['service', 'layanan', 'pelayanan', 'admin', 'surat', 'ktp', 'kk', 'akta', 'domisili'] },
            { intent: 'NAVIGATE_HOME', words: ['home', 'beranda', 'depan', 'utama', 'awal'] },
            { intent: 'NAVIGATE_WILAYAH', words: ['region', 'wilayah', 'pariwisata', 'wisata', 'umkm', 'potensi'] },
            { intent: 'NAVIGATE_PROFILE', words: ['profile', 'profil', 'tentang', 'sejarah', 'struktur'] },
            { intent: 'FAQ_SEARCH', words: ['contact', 'tanya', 'hubungi', 'bantuan', 'tolong', 'cara', 'bagaimana', 'apa', 'syarat', 'prosedur', 'persyaratan', 'ktp', 'kk', 'akta', 'domisili', 'surat', 'pindah', 'nikah', 'lahir', 'mati', 'kematian'] },
            { intent: 'READ_NEWS_DETAIL', words: ['baca', 'detail', 'isi', 'lengkap', 'bacakan', 'lanjut', 'perjelas'] },
            { intent: 'LOGIN', words: ['login', 'masuk', 'operator'] },
            { intent: 'INFO_HOURS', words: ['hours', 'jam', 'buka', 'tutup', 'jadwal'] }
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
                'contact': ['hubungi', 'telepon', 'wa', 'whatsapp', 'email', 'alamat', 'kantor', 'lokasi', 'tanya', 'bertanya', 'minta tolong', 'syarat', 'prosedur', 'bagaimana', 'ktp', 'kk', 'akta', 'domisili'],
                'login': ['masuk', 'login', 'log in', 'sign in', 'daftar', 'akun', 'admin', 'operator', 'petugas']
            },
            nouns: {
                'news': ['berita', 'kabar', 'informasi', 'info', 'artikel', 'pengumuman', 'warta', 'bacaan'],
                'audio': ['suara', 'audio', 'panduan suara', 'voice', 'panduan'],
                'menu': ['menu', 'halaman', 'tampilan'],
                'service': ['layanan', 'servis', 'jasa', 'pelayanan', 'bantuan', 'service', 'administrasi', 'urus', 'pembuatan', 'surat', 'dokumen', 'berkas', 'ktp', 'kk', 'akta'],
                'region': ['wilayah', 'daerah', 'desa', 'lokasi', 'tempat', 'peta', 'geografi', 'wisata', 'piknik', 'jalan-jalan', 'tamasya', 'rekreasi', 'umkm', 'jualan', 'dagangan', 'bisnis'],
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
        // --- VERB-FIRST DOMAIN RESOLUTION CONFIG (STRICTER) ---
        // CRITICAL: Include English canonical forms (post-normalization)
        const VERBS_NEWS = ['baca', 'bacakan', 'buka', 'berita', 'info', 'kabar', 'kegiatan', 'tentang', 'terkait', 'mengenai', 'read', 'news'];
        const VERBS_SERVICE = ['syarat', 'cara', 'prosedur', 'biaya', 'urus', 'pengurusan', 'daftar', 'bikin', 'membuat', 'buat'];
        const VERBS_COMPLAINT = ['lapor', 'adukan', 'keluhan', 'komplain'];
        const NOUNS_AMBIGUOUS = ['umkm', 'ktp', 'kk', 'akta', 'surat', 'nikah', 'cerai', 'pindah', 'domisili', 'ijin', 'izin', 'blt', 'dd', 'bantuan', 'region'];

        function evaluate(normalizedText) {
            console.log(`[IntentRules] Evaluating: "${normalizedText}"`);
            const tokens = normalizedText.split(' ');

            // --- 1. PRIORITY: VERB CHECK ---

            // A. NEWS VERBS (Highest Priority)
            const hasNewsVerb = tokens.some(t => VERBS_NEWS.includes(t));
            if (hasNewsVerb) {
                // Exception Check: "info syarat" -> Service wins
                // But "baca berita contact" -> News wins (contact alone is not enough)
                const hasStrongServiceVerb = tokens.some(t => ['syarat', 'cara', 'prosedur', 'biaya', 'urus', 'mengurus'].includes(t));
                if (!hasStrongServiceVerb) {
                    console.log('[IntentRules] 📰 News Verb Detected -> Force NAV_NEWS');
                    return {
                        intent: window.VoiceConfig.INTENT.NAVIGATE_BERITA,
                        score: 10,
                        originalIntent: 'NAV_NEWS'
                    };
                }
            }

            // B. SERVICE VERBS (Second Priority)
            const hasServiceVerb = tokens.some(t => VERBS_SERVICE.includes(t));
            if (hasServiceVerb) {
                console.log('[IntentRules] 🛠️ Service Verb Detected -> Force FAQ_SEARCH');
                return {
                    intent: window.VoiceConfig.INTENT.FAQ_SEARCH,
                    score: 10,
                    originalIntent: 'FAQ_SEARCH'
                };
            }

            // C. COMPLAINT VERBS (Third Priority)
            const hasComplaintVerb = tokens.some(t => VERBS_COMPLAINT.includes(t));
            if (hasComplaintVerb) {
                console.log('[IntentRules] 📢 Complaint Verb Detected -> Force FAQ_SEARCH');
                return {
                    intent: window.VoiceConfig.INTENT.FAQ_SEARCH,
                    score: 10,
                    originalIntent: 'FAQ_SEARCH'
                };
            }

            // --- 2. AMBIGUOUS NOUN CHECK ---
            const hasAmbiguousNoun = tokens.some(t => NOUNS_AMBIGUOUS.includes(t));
            if (hasAmbiguousNoun) {
                console.log('[IntentRules] ❓ Ambiguous Noun Detected (No Service Verb) -> Default to NAV_NEWS');
                return {
                    intent: window.VoiceConfig.INTENT.NAVIGATE_BERITA,
                    score: 5,
                    originalIntent: 'NAV_NEWS'
                };
            }

            // --- 3. FALLBACK: STANDARD KEYWORD MATCHING ---
            let bestMatch = null;
            let highestScore = 0;
            const Keywords = window.VoiceConfig.keywords;

            for (const rule of Keywords) {
                let score = 0;
                tokens.forEach(token => {
                    if (rule.words.includes(token)) score += 1;
                });

                if (score > 0 && score >= highestScore) {
                    highestScore = score;
                    bestMatch = {
                        intent: window.VoiceConfig.INTENT[rule.intent],
                        originalIntent: rule.intent,
                        score: score
                    };
                }
            }

            console.log('[IntentRules] Best Match:', bestMatch);
            return bestMatch;
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
                    console.warn('[VoiceState] ⚠️ Detected stuck speaking state, forcing recovery...');
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
        function createUtterance(text, silentStart = false) {
            const utterance = new SpeechSynthesisUtterance(text);
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
                console.log("Recognition Error:", event.error);
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

            let interactiveLink = null;
            try {
                interactiveLink = findInteractiveLink(normalized, text);
                console.log('[VoiceParser] Interactive Link Result:', interactiveLink ? 'FOUND' : 'NULL');
            } catch (e) {
                console.error('[VoiceParser] Error in findInteractiveLink:', e);
            }

            // Priority 1: Specific Link Found (HIGHEST Priority for news detail)
            if (interactiveLink) {
                console.log('[VoiceParser] 🔗 Link Found:', interactiveLink.textContent);
                return { intent: window.VoiceConfig.INTENT.READ_NEWS_ITEM, payload: interactiveLink, original: text };
            }

            // Priority 2: Direct Non-Navigation Intents (FAQ,STOP, etc)
            if (ruleMatch && !['NAVIGATE_BERITA', 'NAVIGATE_LAYANAN'].includes(ruleMatch.originalIntent)) {
                return { intent: ruleMatch.intent, original: text, matched: ruleMatch.originalIntent };
            }

            // Priority 3: Section Navigation
            if (ruleMatch) return { intent: ruleMatch.intent, original: text, matched: ruleMatch.originalIntent };

            return { intent: window.VoiceConfig.INTENT.UNKNOWN, original: text, normalized: normalized };
        }
        function findInteractiveLink(normalizedText, originalText) {
            // Clean concepts from normalized text to find the core subject
            const cleanText = normalizedText
                .replace(/\b(read|news|service|region|profile|pos1|pos2|pos3|pos_last|position|contextual|buka|lihat|klik|terkait|mengenai|tentang|seputar)\b/g, '')
                .replace(/\s+/g, ' ')
                .trim();

            // Also extract meaningful words from original text (remove common verbs/connectors)
            const originalKeywords = originalText.toLowerCase()
                .replace(/\b(baca|bacakan|buka|berita|info|kabar|terkait|mengenai|tentang|seputar|yang|di|ke|dari|untuk)\b/g, '')
                .replace(/\s+/g, ' ')
                .trim();

            // Search priorities: 1. Berita, 2. Global links
            const selectors = ['#berita h3 a', '#wilayah a', '#layanan a', '.card a', 'nav a', 'main a'];
            let allLinks = [];
            selectors.forEach(s => { document.querySelectorAll(s).forEach(r => allLinks.push(r)); });

            if (allLinks.length === 0) return null;

            // Strict Positional Matching using concepts
            if (normalizedText.includes('pos1')) return allLinks[0];
            if (normalizedText.includes('pos2') && allLinks.length > 1) return allLinks[1];
            if (normalizedText.includes('pos3') && allLinks.length > 2) return allLinks[2];
            if (normalizedText.includes('pos_last')) return allLinks[allLinks.length - 1];

            // Check minimum length
            if (originalKeywords.length < 3 && !['kk', 'ktp', 'wa'].includes(originalKeywords)) return null;

            // ALWAYS use original keywords (not normalized) for searching
            const searchKeyword = originalKeywords;
            console.log('[VoiceParser] Searching for keyword:', searchKeyword);

            for (let link of allLinks) {
                const titleStr = (link.textContent || link.innerText).toLowerCase();

                // Match against original keywords
                if (searchKeyword && titleStr.includes(searchKeyword)) {
                    console.log('[VoiceParser] ✅ Matched:', titleStr);
                    return link;
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
                case Intent.NAVIGATE_BERITA: navigateTo('berita'); readNewsSummary(); break;
                case Intent.NAVIGATE_LAYANAN: navigateTo('layanan'); readServices(); break;
                case Intent.NAVIGATE_WILAYAH: navigateTo('wilayah'); Speech.speak("Menampilkan potensi wilayah dan pariwisata."); break;
                case Intent.LOGIN: Speech.speak(Config.messages.navigateLogin); setTimeout(() => window.location.assign('/login'), 0); break;
                case Intent.INFO_HOURS: Speech.speak(Config.messages.infoHours); break;
                case Intent.READ_NEWS_ITEM:
                    if (!parseResult.payload) { Speech.speak("Maaf, saya tidak menemukan berita."); break; }
                    const url = parseResult.payload.getAttribute('href');
                    const title = parseResult.payload.textContent;
                    window.VoiceState.setPendingAction('READ_DETAIL', { title: title });
                    Speech.speak(`Membuka berita: ${title}`);
                    setTimeout(() => window.location.assign(url), 100);
                    break;
                case Intent.READ_NEWS_DETAIL: readNewsDetailContent(); break;
                case Intent.NAVIGATE_PROFILE: navigateTo('profil'); Speech.speak("Menampilkan profil kecamatan."); break;
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
                setTimeout(() => readNewsDetailContent(pending.payload.title), 300);
            }
        }
        function readNewsDetailContent(knownTitle) {
            if (!window.VoiceState.isActive()) return;

            let titleEl = document.querySelector('h1') || document.querySelector('.post-title') || document.querySelector('article h1') || document.querySelector('main h1');
            let titleText = knownTitle || (titleEl ? titleEl.textContent.trim() : "Halaman");

            let contentEl = document.querySelector('article') || document.querySelector('.article-content') || document.querySelector('.content') || document.querySelector('.post-body') || document.querySelector('main');

            if (!contentEl) {
                window.VoiceSpeech.speak(`Sudah membuka ${titleText}. Silakan baca informasi yang tersedia.`);
                return;
            }
            let paragraphs = Array.from(contentEl.querySelectorAll('p')).map(p => p.textContent.trim()).filter(t => t.length > 20);
            if (paragraphs.length === 0) {
                const rawText = contentEl.textContent;
                const lines = rawText.split('\n').map(l => l.trim()).filter(l => l.length > 25);
                paragraphs = lines.length > 1 ? lines : (rawText.match(/[^.!?]+[.!?]+/g) || [rawText]).map(s => s.trim()).filter(s => s.length > 10).slice(0, 5);
            }
            let sentences = [`Menampilkan berita: ${titleText}.`];
            sentences = sentences.concat(paragraphs);
            sentences.push("Sekian berita ini. Katakan 'kembali' untuk ke menu utama.");
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
