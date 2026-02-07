/**
 * voice.actions.js
 * Handler Maksud (Intents) & Eksekusi UI
 */

window.VoiceActions = (function () {

    function execute(parseResult) {
        const Config = window.VoiceConfig;
        const Intent = Config.INTENT;
        const Speech = window.VoiceSpeech;

        console.log("Executing Intent:", parseResult.intent);

        switch (parseResult.intent) {
            case Intent.STOP:
                Speech.speak(Config.messages.stopConfirmation);
                window.VoiceState.setActive(false);
                break;

            case Intent.WELCOME:
                console.log('[VoiceActions] WELCOME intent received, calling playWelcomeSequence...');
                playWelcomeSequence();
                break;

            case Intent.NAVIGATE_HOME:
                navigateTo('top');
                Speech.speak(Config.messages.navigateHome);
                break;

            case Intent.NAVIGATE_BERITA:
                navigateTo('berita');
                readNewsSummary();
                break;

            case Intent.NAVIGATE_LAYANAN:
                navigateTo('layanan');
                readServices();
                break;

            case Intent.NAVIGATE_WILAYAH:
                navigateTo('wilayah');
                Speech.speak("Menampilkan potensi wilayah dan pariwisata.");
                break;

            case Intent.SEARCH_NEWS:
                {
                    const keyword = parseResult.payload.keyword;
                    const isNewsPage = window.location.pathname.includes('/berita') && !window.location.pathname.includes('/berita/');

                    if (isNewsPage) {
                        Speech.speak(`Mohon maaf, saya tidak menemukan berita tentang ${keyword} di halaman ini.`);
                    } else {
                        Speech.speak(`Berita tentang ${keyword} tidak ada di halaman utama. Saya akan mencarinya di daftar berita.`);

                        // Set Pending Action
                        window.VoiceState.setPendingAction('SEARCH_NEWS', { keyword: keyword });

                        // Navigate
                        setTimeout(() => {
                            window.location.assign('/berita');
                        }, 1000);
                    }
                }
                break;

            case Intent.LOGIN:
                Speech.speak(Config.messages.navigateLogin);
                setTimeout(() => {
                    window.location.assign('/login');
                }, 0);
                break;

            case Intent.INFO_HOURS:
                Speech.speak(Config.messages.infoHours);
                break;

            case Intent.READ_NEWS_ITEM:
                console.log('[VoiceActions] READ_NEWS_ITEM triggered');
                console.log('[VoiceActions] ParseResult:', parseResult);

                if (!parseResult.payload) {
                    console.error('[VoiceActions] ❌ NO PAYLOAD found!');
                    Speech.speak("Maaf, saya tidak menemukan berita yang Anda maksud. Coba sebutkan judul berita yang lebih spesifik.");
                    break;
                }

                const newsLink = parseResult.payload;
                const url = newsLink.getAttribute('href');
                const titleForDetail = newsLink.innerText;

                console.log('[VoiceActions] News Link found:', newsLink);
                console.log('[VoiceActions] URL:', url);
                console.log('[VoiceActions] Title:', titleForDetail);

                if (!url || url === '#' || url === 'javascript:void(0)') {
                    console.error('[VoiceActions] ❌ INVALID URL:', url);
                    Speech.speak("Maaf, berita ini tidak memiliki tautan yang valid.");
                    break;
                }

                console.log('[VoiceActions] ✅ VALID URL, proceeding with navigation...');

                // 1. Simpan state SEBELUM navigasi
                window.VoiceState.setPendingAction('READ_DETAIL', { title: titleForDetail });
                console.log('[VoiceActions] ✅ State saved to sessionStorage');

                // Verify save
                const savedAction = window.VoiceState.getPendingAction();
                console.log('[VoiceActions] Verification - Saved data:', savedAction);

                // 2. Ucapkan TANPA menunggu callback
                Speech.speak(`Membuka berita: ${titleForDetail}`);

                // 3. NAVIGASI via setTimeout (event loop optimization)
                console.log('[VoiceActions] Setting navigation timeout...');
                setTimeout(() => {
                    console.log('[VoiceActions] 🚀 EXECUTING NAVIGATION to:', url);
                    window.location.assign(url);
                }, 100);
                break;

            case Intent.READ_NEWS_DETAIL:
                // Contextual Read (After landing)
                readNewsDetailContent();
                break;

            case Intent.NAVIGATE_PROFILE:
                navigateTo('profil'); // Ensure ID exists in landing
                Speech.speak("Menampilkan profil kecamatan dan struktur organisasi.");
                break;

            case Intent.FAQ_SEARCH:
                // General FAQ fallback using the original Clean Text
                // We dispatch it to the chatbot input
                const originalText = parseResult.original || "";
                if (originalText) {
                    Speech.speak("Sedang mencari informasi...", () => {
                        // Show Modal first
                        const modal = document.getElementById('publicServiceModal');
                        if (modal && typeof modal.showModal === 'function') {
                            modal.showModal();
                        }

                        // Send to Bot
                        const botInput = document.getElementById('botQuery');
                        const botForm = document.getElementById('publicFaqForm');
                        if (botInput && botForm) {
                            botInput.value = originalText;
                            botForm.dispatchEvent(new Event('submit'));
                        }
                    });
                }
                break;

            default:
                // Unknown command? Maybe just echo or ignore.
                // Speech.speak("Maaf, saya tidak mengerti.");
                break;
        }
    }

    // --- Auto-Run Check (Called on Init) ---
    function checkAutoRun() {
        const pending = window.VoiceState.getPendingAction();

        if (!pending) return;

        console.log("[VoiceActions] Found Pending Action:", pending.action);

        // CASE 1: READ DETAIL (From Landing match -> Navigate -> Read)
        if (pending.action === 'READ_DETAIL') {
            // Clear immediately
            window.VoiceState.setPendingAction(null);

            // Wait a bit for DOM
            setTimeout(() => {
                const title = pending.payload.title;
                readNewsDetailContent(title);
            }, 1000);
        }

        // CASE 2: SEARCH NEWS (From Landing fail -> Navigate Index -> Search Here)
        if (pending.action === 'SEARCH_NEWS') {
            // Clear immediately
            window.VoiceState.setPendingAction(null);

            setTimeout(() => {
                const keyword = pending.payload.keyword;
                console.log(`[VoiceActions] Executing Pending Search for: "${keyword}"`);

                // Search in /berita list (h3 a, .post-title a)
                const links = document.querySelectorAll('h3 a, .post-title a, .card-title a');
                let foundLink = null;

                for (let link of links) {
                    if (link.innerText.toLowerCase().includes(keyword.toLowerCase())) {
                        foundLink = link;
                        break;
                    }
                }

                if (foundLink) {
                    window.VoiceSpeech.speak(`Saya menemukan berita tentang ${keyword}. Membuka berita...`);

                    // Set Next Pending Action (Read Detail)
                    window.VoiceState.setPendingAction('READ_DETAIL', { title: foundLink.innerText });

                    setTimeout(() => {
                        window.location.assign(foundLink.href);
                    }, 1000);

                } else {
                    window.VoiceSpeech.speak(`Mohon maaf, saya juga tidak menemukan berita tentang ${keyword} di daftar berita. Apakah Anda ingin mendengar berita terbaru?`);
                }

            }, 1000);
        }
    }

    // --- Helpers ---

    function readNewsDetailContent(knownTitle) {
        // Heuristic to find content in standard Laravel/HTML layout
        // 1. Find Title
        let titleEl = document.querySelector('h1') || document.querySelector('.post-title') || document.querySelector('article h2');
        let titleText = knownTitle || (titleEl ? titleEl.innerText : "Berita");

        // 2. Find Content (Article Body)
        // Common selectors: article, .content, .post-body, .entry-content
        let contentEl = document.querySelector('article') || document.querySelector('.content') || document.querySelector('.post-body');

        if (!contentEl) {
            // Fallback: Try to find large text block?
            window.VoiceSpeech.speak(`Saya sudah membuka berita ${titleText}, namun saya kesulitan membaca isinya secara otomatis. Silakan baca manual.`);
            return;
        }

        // 3. Extract Paragraphs
        let paragraphs = Array.from(contentEl.querySelectorAll('p')).map(p => p.innerText.trim()).filter(t => t.length > 20);

        if (paragraphs.length === 0) {
            // Fallback: Check for text nodes or content with <br> (nl2br)
            // We can split the innerText by newlines if it has many
            const rawText = contentEl.innerText;
            const lines = rawText.split('\n').map(l => l.trim()).filter(l => l.length > 25);

            if (lines.length > 1) {
                console.log('[VoiceActions] Extracted paragraphs from newlines (nl2br fallback)');
                paragraphs = lines;
            } else {
                // Single block
                console.log('[VoiceActions] Using single text block fallback');
                // Split by common sentence endings if too long
                const sentences = rawText.match(/[^.!?]+[.!?]+/g) || [rawText];
                paragraphs = sentences.map(s => s.trim()).filter(s => s.length > 10).slice(0, 5); // Limit to first 5 sentences for brevity
            }
        }

        // 4. Speak Sequence
        let sentences = [`Menampilkan berita: ${titleText}.`];
        sentences = sentences.concat(paragraphs);
        sentences.push("Sekian berita ini. Katakan 'kembali' untuk ke menu utama.");

        window.VoiceSpeech.speakSequence(sentences);
    }

    function navigateTo(id) {
        if (id === 'top') {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            const el = document.getElementById(id);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Helper highlight
                el.classList.add('bg-blue-50', 'transition-colors', 'duration-1000');
                setTimeout(() => el.classList.remove('bg-blue-50'), 2000);
            }
        }
    }

    function playWelcomeSequence() {
        console.log('[VoiceActions] playWelcomeSequence() called');
        const Config = window.VoiceConfig;
        const Speech = window.VoiceSpeech;

        // 1. Get Region Name
        const region = Config.regionName;
        console.log('[VoiceActions] Region name:', region);

        // 2. Scan Menu
        const menus = getReadableMenus();
        console.log('[VoiceActions] Found menus:', menus);

        // 3. Build Sentences
        const sentences = [];
        sentences.push(Config.messages.welcome(region));

        menus.forEach(m => sentences.push(Config.messages.menuItem(m)));

        sentences.push(Config.messages.instruction);

        console.log('[VoiceActions] Sentences to speak:', sentences.length);
        console.log('[VoiceActions] First sentence:', sentences[0]);

        // 4. Speak
        Speech.speakSequence(sentences, () => {
            console.log('[VoiceActions] Welcome sequence completed');
            window.VoiceState.setPlayedWelcome(true);
        });
    }

    function getReadableMenus() {
        // Target specific menu containers that contain the primary navigation
        const containers = document.querySelectorAll('.navbar-center, .menu, nav');
        const texts = new Set();

        containers.forEach(container => {
            const links = container.querySelectorAll('a');
            links.forEach(el => {
                const text = el.innerText.trim();
                // Filters: ignore "Masuk", ignore icons/short text
                if (text && text.toLowerCase() !== 'masuk' && text.length > 2) {
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
        if (newsItems.length === 0) text += "Belum ada berita tersaji.";

        newsItems.forEach((item, idx) => {
            if (idx < 3) text += `${item.innerText}. `;
        });

        window.VoiceSpeech.speak(text);
    }

    function readServices() {
        const items = document.querySelectorAll('#layanan h3');
        let text = "Layanan kami meliputi: ";
        items.forEach(i => text += `${i.innerText}, `);
        window.VoiceSpeech.speak(text);
    }

    return {
        execute: execute,
        checkAutoRun: checkAutoRun
    };
})();

console.log('[VoiceGuide] Actions Module Loaded');
