/**
 * Accessibility Widget Logic
 * Handles state management, feature toggling, and UI injection.
 */

(function () {
    const STORAGE_KEY = 'acc_settings';

    // Default Settings
    const defaultSettings = {
        contrast: 'normal',   // normal, high, dark, grayscale
        fontScale: 'normal',  // normal, large, xlarge
        underlineLinks: false,
        dyslexiaFont: false,
        tts: false
    };

    let settings = loadSettings();
    let speechUtterance = null;
    let autoReadHover = false;

    // =========================================
    // 1. State Management
    // =========================================
    function loadSettings() {
        try {
            const saved = localStorage.getItem(STORAGE_KEY);
            return saved ? { ...defaultSettings, ...JSON.parse(saved) } : { ...defaultSettings };
        } catch (e) {
            console.error('Accessibility: Failed to load settings', e);
            return { ...defaultSettings };
        }
    }

    function saveSettings() {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(settings));
        } catch (e) {
            console.error('Accessibility: Failed to save settings', e);
        }
    }

    function resetSettings() {
        settings = { ...defaultSettings };
        saveSettings();
        applySettings();
        renderActiveStates();
    }

    // =========================================
    // 2. Core Functions
    // =========================================
    function applySettings() {
        const root = document.documentElement;
        const body = document.body;

        // Reset all classes first
        body.classList.remove('acc-grayscale', 'acc-high-contrast', 'acc-dark-mode', 'acc-light-mode');
        root.classList.remove('acc-font-large', 'acc-font-xlarge');
        body.classList.remove('acc-link-underline', 'acc-dyslexia');

        // Apply Contrast
        if (settings.contrast === 'grayscale') body.classList.add('acc-grayscale');
        if (settings.contrast === 'high') body.classList.add('acc-high-contrast');
        if (settings.contrast === 'dark') body.classList.add('acc-dark-mode');

        // Apply Font Scale
        if (settings.fontScale === 'large') root.classList.add('acc-font-large');
        if (settings.fontScale === 'xlarge') root.classList.add('acc-font-xlarge');

        // Other Features
        if (settings.underlineLinks) body.classList.add('acc-link-underline');
        if (settings.dyslexiaFont) body.classList.add('acc-dyslexia');

        // TTS State
        if (settings.tts && !autoReadHover) {
            enableTTS();
        } else if (!settings.tts && autoReadHover) {
            disableTTS();
        }
    }

    function toggleContrast(mode) {
        settings.contrast = settings.contrast === mode ? 'normal' : mode;
        saveSettings();
        applySettings();
        renderActiveStates();
    }

    function resizeText(scale) {
        settings.fontScale = settings.fontScale === scale ? 'normal' : scale;
        saveSettings();
        applySettings();
        renderActiveStates();
    }

    function toggleLinks() {
        settings.underlineLinks = !settings.underlineLinks;
        saveSettings();
        applySettings();
        renderActiveStates();
    }

    function toggleDyslexiaFont() {
        settings.dyslexiaFont = !settings.dyslexiaFont;
        saveSettings();
        applySettings();
        renderActiveStates();
    }

    function toggleTTS() {
        settings.tts = !settings.tts;
        saveSettings();
        applySettings();
        renderActiveStates();
    }

    // =========================================
    // 3. TTS Logic
    // =========================================
    function enableTTS() {
        autoReadHover = true;
        document.body.addEventListener('mouseover', handleTTSHover);
        document.body.addEventListener('click', handleTTSClick);
    }

    function disableTTS() {
        autoReadHover = false;
        if (window.speechSynthesis) window.speechSynthesis.cancel();
        document.body.removeEventListener('mouseover', handleTTSHover);
        document.body.removeEventListener('click', handleTTSClick);
    }

    function handleTTSHover(e) {
        if (!settings.tts) return;
        const target = e.target.closest('p, h1, h2, h3, h4, h5, h6, a, button, li, label');
        if (target && target.innerText.trim().length > 0) {
            // Debounce or simple limit could be added here
            // For now, we wait for a slight pause
        }
    }

    function handleTTSClick(e) {
        if (!settings.tts) return;
        // Read on click is more reliable than hover preventing spam
        const target = e.target.closest('p, h1, h2, h3, h4, h5, h6, a, button, li, span, div');
        if (target && target.innerText) {
            speak(target.innerText);
        }
    }

    function speak(text) {
        if (!window.speechSynthesis) return;
        window.speechSynthesis.cancel();

        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'id-ID';
        utterance.rate = 1;
        window.speechSynthesis.speak(utterance);
    }

    // =========================================
    // 4. UI Generation & Injection
    // =========================================
    function createWidget() {
        const panelHtml = `
            <div id="accessibility-panel" role="dialog" aria-label="Menu Aksesibilitas">
                <h3>
                    <span class="flex items-center gap-2"><i class="fas fa-universal-access text-blue-600"></i> Aksesibilitas</span>
                    <button class="close-panel" aria-label="Tutup"><i class="fas fa-times"></i></button>
                </h3>

                <div class="acc-section">
                    <div class="acc-section-title">Mode Tampilan</div>
                    <div class="acc-grid">
                        <button class="acc-btn" data-action="contrast" data-value="grayscale">
                            <i class="fas fa-filter"></i> Abu-abu
                        </button>
                        <button class="acc-btn" data-action="contrast" data-value="high">
                            <i class="fas fa-adjust"></i> Kontras ++
                        </button>
                        <button class="acc-btn" data-action="contrast" data-value="dark">
                            <i class="fas fa-moon"></i> Mode Gelap
                        </button>
                         <button class="acc-btn" data-action="dyslexia">
                            <i class="fas fa-font"></i> Font Disleksia
                        </button>
                    </div>
                </div>

                <div class="acc-section">
                    <div class="acc-section-title">Ukuran Teks</div>
                    <div class="acc-grid">
                        <button class="acc-btn" data-action="resize" data-value="large">
                            <i class="fas fa-plus"></i> Besar
                        </button>
                        <button class="acc-btn" data-action="resize" data-value="xlarge">
                            <i class="fas fa-expand-arrows-alt"></i> Ekstra Besar
                        </button>
                    </div>
                </div>

                <div class="acc-section">
                    <div class="acc-section-title">Bantuan Lain</div>
                    <div class="acc-grid">
                        <button class="acc-btn" data-action="links">
                            <i class="fas fa-link"></i> Garis Link
                        </button>
                        <button class="acc-btn" data-action="tts">
                            <i class="fas fa-volume-up"></i> Suara (TTS)
                        </button>
                    </div>
                </div>

                <button class="acc-reset-btn" id="acc-reset">
                    <i class="fas fa-undo"></i> Atur Ulang
                </button>
            </div>
        `;

        const div = document.createElement('div');
        div.innerHTML = panelHtml;
        document.body.appendChild(div.firstElementChild);

        bindEvents();
        renderActiveStates();
    }

    function bindEvents() {
        const panel = document.getElementById('accessibility-panel');
        const toggleBtn = document.getElementById('accessibility-toggle'); // Should be in landing.blade.php
        const closeBtn = panel.querySelector('.close-panel');
        const resetBtn = document.getElementById('acc-reset');

        // Toggle Panel
        if (toggleBtn) {
            toggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                panel.classList.toggle('active');
                if (panel.classList.contains('active')) {
                    closeBtn.focus();
                }
            });
        }

        closeBtn.addEventListener('click', () => {
            panel.classList.remove('active');
            if (toggleBtn) toggleBtn.focus();
        });

        // Close on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && panel.classList.contains('active')) {
                panel.classList.remove('active');
                if (toggleBtn) toggleBtn.focus();
            }
        });

        // Feature Buttons
        panel.querySelectorAll('.acc-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const action = btn.dataset.action;
                const value = btn.dataset.value;

                switch (action) {
                    case 'contrast': toggleContrast(value); break;
                    case 'resize': resizeText(value); break;
                    case 'dyslexia': toggleDyslexiaFont(); break;
                    case 'links': toggleLinks(); break;
                    case 'tts': toggleTTS(); break;
                }
            });
        });

        resetBtn.addEventListener('click', resetSettings);
    }

    function renderActiveStates() {
        const panel = document.getElementById('accessibility-panel');
        if (!panel) return;

        // Reset all active classes
        panel.querySelectorAll('.acc-btn').forEach(btn => btn.classList.remove('active'));

        // Contrast
        if (settings.contrast !== 'normal') {
            const btn = panel.querySelector(`.acc-btn[data-action="contrast"][data-value="${settings.contrast}"]`);
            if (btn) btn.classList.add('active');
        }

        // Resize
        if (settings.fontScale !== 'normal') {
            const btn = panel.querySelector(`.acc-btn[data-action="resize"][data-value="${settings.fontScale}"]`);
            if (btn) btn.classList.add('active');
        }

        // Toggles
        if (settings.dyslexiaFont) panel.querySelector('.acc-btn[data-action="dyslexia"]').classList.add('active');
        if (settings.underlineLinks) panel.querySelector('.acc-btn[data-action="links"]').classList.add('active');
        if (settings.tts) panel.querySelector('.acc-btn[data-action="tts"]').classList.add('active');
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        // Create widget UI
        createWidget();
        // Apply saved settings
        applySettings();
    });

})();
