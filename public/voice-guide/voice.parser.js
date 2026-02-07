/**
 * voice.parser.js
 * Natural Language Processing (Heuristic & Normalize)
 * Menggunakan Normalizer & IntentRules untuk pemahaman lebih baik.
 */

window.VoiceParser = (function () {
    const Normalizer = window.VoiceNormalizer;
    const IntentRules = window.VoiceIntentRules;
    const Config = window.VoiceConfig;

    function parse(text) {
        if (!text) return { intent: Config.INTENT.UNKNOWN, original: "" };

        // 1. Normalize
        const normalized = Normalizer.clean(text);
        console.log(`[VoiceParser] Original: "${text}" -> Normalized: "${normalized}"`);

        // 2. Intent Heuristics (Rules & Scoring)
        const ruleMatch = IntentRules.findMatch(normalized);

        // 3. News Specific Logic (Variable Extraction)
        // Cek apakah user ingin membaca berita spesifik: "baca berita tentang [banjir]"
        const newsTopic = extractNewsTopic(normalized);
        const newsLink = findNewsLink(newsTopic);

        // DECISION LOGIC

        // A. DIRECT FOUND: Judul berita ditemukan di halaman ini
        if (newsLink) {
            console.log(`[VoiceParser] 🎯 News Link FOUND: "${newsLink.innerText}"`);
            return {
                intent: Config.INTENT.READ_NEWS_ITEM,
                payload: newsLink,
                original: text
            };
        }

        // B. NOT FOUND BUT HAS TOPIC: Intent News + Topic -> SEARCH_NEWS
        if (ruleMatch && ruleMatch.originalIntent === "NAV_NEWS" && newsTopic && newsTopic.length > 3) {
            console.log(`[VoiceParser] 🔍 News Topic "${newsTopic}" NOT FOUND on this page. Escalating to SEARCH_NEWS.`);
            return {
                intent: Config.INTENT.SEARCH_NEWS,
                payload: { keyword: newsTopic }, // Pass keyword for next page
                original: text
            };
        }

        // C. GENERIC MATCH: "Baca berita" (Tanpa topik spesifik atau topik terlalu pendek)
        if (ruleMatch) {
            console.log(`[VoiceParser] Match Rule: ${ruleMatch.originalIntent} (Score: ${ruleMatch.score})`);
            return {
                intent: ruleMatch.intent,
                original: text,
                matched: ruleMatch.originalIntent
            };
        }

        // 4. Fallback: Search Specific News directly (Legacy fallback check)
        // Removed validation here because Step A covers it.

        // 5. Unknown -> FAQ Search fallback default (di Actions)
        return {
            intent: Config.INTENT.UNKNOWN,
            original: text,
            normalized: normalized
        };
    }

    // Helper: Extract variable topic from sentence
    function extractNewsTopic(normalizedText) {
        return normalizedText
            .replace(/baca/g, '')
            .replace(/bacakan/g, '') // Added bacakan
            .replace(/berita/g, '')
            .replace(/tentang/g, '')
            .replace(/info/g, '')
            .replace(/kabar/g, '')
            .replace(/kegiatan/g, '')
            .replace(/pertama/g, '')
            .replace(/kedua/g, '')
            .replace(/ketiga/g, '')
            .trim();
    }

    function findNewsLink(cleanText) {
        console.log('[VoiceParser] findNewsLink for:', cleanText);

        // If text is too short after cleaning, don't guess to avoid false triggers
        if (!cleanText || cleanText.length < 3) return null;

        const links = document.querySelectorAll('#berita h3 a');
        console.log('[VoiceParser] Found', links.length, 'news links in DOM');

        if (links.length === 0) return null;

        // 1. Strict Positional Matching cannot be done easily on cleanText content
        // We rely on specific keywords in normalized text for that, but here we only have cleanText.
        // Let's assume positional logic is less important for "baca berita judul X"

        // 2. Fuzzy/Title Matching
        for (let link of links) {
            const title = link.innerText.toLowerCase();
            if (title.includes(cleanText)) {
                console.log('[VoiceParser] ✅ MATCH:', link.innerText);
                return link;
            }
        }

        console.log('[VoiceParser] ⏸️ No clear news match found.');
        return null;
    }

    return {
        parse: parse
    };
})();

console.log('[VoiceGuide] Parser Module Loaded (Enhanced NLU)');
