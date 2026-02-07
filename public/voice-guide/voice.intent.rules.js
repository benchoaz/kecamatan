/**
 * voice.intent.rules.js
 * Logika penentuan maksud (Intent) berdasarkan skor dan aturan.
 * Menggantikan simple keyword matching dengan sistem bobot.
 */

window.VoiceIntentRules = (function () {
    const Config = window.VoiceConfig;
    // Pastikan Config sudah load. Jika belum, kita inject nanti via init.
    // Tapi karena struktur load berurutan, aman.

    // Definisi Rules
    // Setiap Intent punya 'triggers' (kata kunci)
    // weight: Bobot kata (semakin unik semakin tinggi)
    // required: Kata yang HARUS ada (opsional)

    // --- VERB-FIRST DOMAIN RESOLUTION CONFIG (STRICTER) ---

    // CRITICAL: Include English canonical forms (post-normalization)
    const VERBS_NEWS = ['baca', 'bacakan', 'buka', 'berita', 'info', 'kabar', 'kegiatan', 'tentang', 'terkait', 'mengenai', 'read', 'news'];
    const VERBS_SERVICE = ['syarat', 'cara', 'prosedur', 'biaya', 'urus', 'pengurusan', 'daftar', 'bikin', 'membuat', 'buat'];
    const VERBS_COMPLAINT = ['lapor', 'adukan', 'keluhan', 'komplain'];

    // Nouns that are ambiguous (can be news or service context)
    const NOUNS_AMBIGUOUS = ['umkm', 'ktp', 'kk', 'akta', 'surat', 'nikah', 'cerai', 'pindah', 'domisili', 'ijin', 'izin', 'blt', 'dd', 'bantuan', 'region'];

    const RULES = [
        {
            intent: "STOP_GUIDE",
            triggers: ["stop", "audio", "matikan", "berhenti", "diam"],
            minScore: 1
        },
        {
            intent: "NAV_HOME",
            triggers: ["back", "home", "beranda", "depan", "utama"],
            minScore: 1
        },
        {
            intent: "NAV_NEWS",
            triggers: ["news", "read"], // Fallback triggers
            minScore: 2
        },
        {
            intent: "NAV_SERVICES",
            triggers: ["service"],
            minScore: 1
        },
        {
            intent: "NAV_PROFILE",
            triggers: ["profile", "profil", "tentang"],
            minScore: 1
        },
        {
            intent: "NAV_REGION",
            triggers: ["region", "wilayah", "wisata", "potensi"],
            minScore: 1
        },
        {
            intent: "NAV_LOGIN",
            triggers: ["login", "masuk", "admin", "operator"],
            minScore: 1
        },
        {
            intent: "INFO_HOURS",
            triggers: ["hours", "jam", "buka", "tutup", "jadwal"],
            minScore: 1
        },
        {
            intent: "FAQ_SEARCH",
            triggers: ["contact", "tanya"],
            minScore: 1
        }
    ];

    function evaluate(normalizedText) {
        console.log(`[IntentRules] Evaluating: "${normalizedText}"`);
        const tokens = normalizedText.split(' ');

        // --- 1. PRIORITY: VERB CHECK ---

        // A. NEWS VERBS (Highest Priority)
        // If user says "baca berita...", "info...", "kabar..." -> FORCE NAV_NEWS
        const hasNewsVerb = tokens.some(t => VERBS_NEWS.includes(t));
        if (hasNewsVerb) {
            // Exception Check: "info syarat" -> Service wins
            // But "baca berita contact" -> News wins (contact alone is not enough)
            // Only yield to service verbs if there's a STRONG service indicator
            const hasStrongServiceVerb = tokens.some(t => ['syarat', 'cara', 'prosedur', 'biaya', 'urus', 'mengurus'].includes(t));
            if (!hasStrongServiceVerb) {
                console.log('[IntentRules] 📰 News Verb Detected -> Force NAV_NEWS');
                return {
                    intent: mapInternalIntentToConfig("NAV_NEWS"),
                    score: 10,
                    originalIntent: "NAV_NEWS"
                };
            }
        }

        // B. SERVICE VERBS (Second Priority)
        // If user says "syarat...", "cara...", "biaya..." -> FORCE FAQ_SEARCH (Service Chatbox)
        const hasServiceVerb = tokens.some(t => VERBS_SERVICE.includes(t));
        if (hasServiceVerb) {
            console.log('[IntentRules] 🛠️ Service Verb Detected -> Force FAQ_SEARCH');
            return {
                intent: mapInternalIntentToConfig("FAQ_SEARCH"),
                score: 10,
                originalIntent: "FAQ_SEARCH"
            };
        }

        // C. COMPLAINT VERBS (Third Priority)
        // If user says "lapor...", "aduan..." -> FORCE FAQ_SEARCH (or specific complaint intent later)
        const hasComplaintVerb = tokens.some(t => VERBS_COMPLAINT.includes(t));
        if (hasComplaintVerb) {
            console.log('[IntentRules] 📢 Complaint Verb Detected -> Force FAQ_SEARCH');
            return {
                intent: mapInternalIntentToConfig("FAQ_SEARCH"),
                score: 10,
                originalIntent: "FAQ_SEARCH"
            };
        }

        // --- 2. AMBIGUOUS NOUN CHECK ---
        // If NO strong verb found, check for ambiguous nouns (UMKM, KTP, etc.)
        // Default behavior for just "UMKM" or "KTP" without verb -> News/Info (Informatif)
        const hasAmbiguousNoun = tokens.some(t => NOUNS_AMBIGUOUS.includes(t));
        if (hasAmbiguousNoun) {
            console.log('[IntentRules] ❓ Ambiguous Noun Detected (No Service Verb) -> Default to NAV_NEWS');
            return {
                intent: mapInternalIntentToConfig("NAV_NEWS"),
                score: 5, // Lower score than explicit verb
                originalIntent: "NAV_NEWS"
            };
        }


        // --- 3. FALLBACK: ORIGINAL SCORING LOGIC ---
        let bestMatch = null;
        let highestScore = 0;

        // Iterasi semua rules standard
        for (const rule of RULES) {
            let score = 0;
            // Simple scoring: +1 per trigger word found
            tokens.forEach(token => {
                if (rule.triggers.includes(token)) {
                    score += 1;
                }
            });

            // Combination Bonus
            if (rule.combination) {
                const hasAll = rule.combination.every(c => tokens.includes(c));
                if (hasAll) score += 2;
            }

            // Threshold Check
            if (score >= rule.minScore && score > highestScore) {
                highestScore = score;
                bestMatch = {
                    intent: mapInternalIntentToConfig(rule.intent),
                    score: score,
                    originalIntent: rule.intent
                };
            }
        }

        return bestMatch;
    }

    // Helper mapping string lokal ke Config Global (karena Config pakai object constants)
    function mapInternalIntentToConfig(ruleIntent) {
        const C = window.VoiceConfig.INTENT;
        const MAPPING = {
            "STOP_GUIDE": C.STOP,
            "NAV_HOME": C.NAVIGATE_HOME,     // Fixed
            "NAV_NEWS": C.NAVIGATE_BERITA,   // Fixed
            "NAV_SERVICES": C.NAVIGATE_LAYANAN, // Fixed
            "NAV_PROFILE": C.NAVIGATE_PROFILE,  // Fixed
            "NAV_REGION": C.NAVIGATE_WILAYAH,   // Fixed
            "NAV_LOGIN": C.LOGIN,
            "INFO_HOURS": C.INFO_HOURS,
            "FAQ_SEARCH": C.FAQ_SEARCH
        };
        return MAPPING[ruleIntent] || C.UNKNOWN;
    }

    return {
        findMatch: evaluate
    };
})();
