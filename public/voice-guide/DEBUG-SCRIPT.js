/**
 * VOICE GUIDE DEBUG SCRIPT
 * 
 * CARA PAKAI:
 * 1. Buka landing page di browser
 * 2. Buka DevTools Console (F12)
 * 3. Copy-paste script ini ke console
 * 4. Tekan Enter
 * 5. Lihat hasil diagnosa
 */

console.log('='.repeat(60));
console.log('VOICE GUIDE DEBUG DIAGNOSTIC');
console.log('='.repeat(60));

// 1. CHECK MODULES LOADED
console.log('\n[1] CHECKING MODULES:');
const modules = [
    'VoiceConfig',
    'VoiceState',
    'VoiceParser',
    'VoiceActions',
    'VoiceSpeech',
    'VoiceRecognition',
    'VoiceLexicon',
    'VoiceNormalizer',
    'VoiceIntentRules'
];

modules.forEach(mod => {
    const exists = window[mod] !== undefined;
    console.log(`  ${exists ? '✅' : '❌'} ${mod}: ${exists ? 'LOADED' : 'MISSING'}`);
});

// 2. CHECK NEWS ITEMS
console.log('\n[2] CHECKING NEWS ITEMS:');
const newsLinks = document.querySelectorAll('#berita h3 a');
console.log(`  Found ${newsLinks.length} news links`);

newsLinks.forEach((link, idx) => {
    const href = link.getAttribute('href');
    const title = link.innerText;
    console.log(`  [${idx}] Title: "${title}"`);
    console.log(`      URL: ${href}`);
    console.log(`      Valid: ${href && href !== '#' ? '✅' : '❌'}`);
});

// 3. TEST MANUAL NAVIGATION
if (newsLinks.length > 0) {
    console.log('\n[3] MANUAL NAVIGATION TEST:');
    const testLink = newsLinks[0];
    const testUrl = testLink.getAttribute('href');
    const testTitle = testLink.innerText;

    console.log(`  Test URL: ${testUrl}`);
    console.log(`  Test Title: ${testTitle}`);

    // Simulate what voice guide does
    console.log('\n  Simulating Voice Guide Logic:');
    console.log('  Step 1: setPendingAction...');

    try {
        window.VoiceState.setPendingAction('READ_DETAIL', { title: testTitle });
        console.log('  ✅ State saved to sessionStorage');

        const saved = window.VoiceState.getPendingAction();
        console.log('  Verified:', saved);
    } catch (e) {
        console.error('  ❌ setPendingAction failed:', e);
    }

    console.log('\n  Step 2: Speech.speak (simulated)...');
    console.log(`  ✅ Would say: "Membuka berita: ${testTitle}"`);

    console.log('\n  Step 3: Navigation test...');
    console.log(`  Type this command to test navigation:`);
    console.log(`  \x1b[33m  setTimeout(() => window.location.assign("${testUrl}"), 0)\x1b[0m`);

} else {
    console.warn('  ⚠️  NO NEWS ITEMS FOUND! Cannot test.');
}

// 4. CHECK VOICE STATE
console.log('\n[4] VOICE STATE:');
if (window.VoiceState) {
    console.log(`  isActive: ${window.VoiceState.isActive()}`);
    console.log(`  isSpeaking: ${window.VoiceState.isSpeaking()}`);
    console.log(`  isListening: ${window.VoiceState.isListening()}`);

    const pending = window.VoiceState.getPendingAction();
    console.log(`  pendingAction: ${pending ? JSON.stringify(pending) : 'null'}`);
}

// 5. PARSER TEST
console.log('\n[5] PARSER TEST (if news exists):');
if (newsLinks.length > 0 && window.VoiceParser) {
    const testPhrases = [
        'baca berita pertama',
        'baca berita tentang pembangunan',
        'bacakan berita'
    ];

    testPhrases.forEach(phrase => {
        try {
            const result = window.VoiceParser.parse(phrase);
            console.log(`  Input: "${phrase}"`);
            console.log(`  Intent: ${result.intent}`);
            console.log(`  Has Payload: ${!!result.payload}`);
            if (result.payload) {
                console.log(`  Payload URL: ${result.payload.getAttribute('href')}`);
            }
        } catch (e) {
            console.error(`  ❌ Parser error:`, e);
        }
    });
}

console.log('\n' + '='.repeat(60));
console.log('DIAGNOSTIC COMPLETE');
console.log('='.repeat(60));
console.log('\nNEXT STEPS:');
console.log('1. Activate Voice Guide (click mic button)');
console.log('2. Say: "Baca berita pertama"');
console.log('3. Check console for errors');
console.log('4. Check Network tab for navigation request');
