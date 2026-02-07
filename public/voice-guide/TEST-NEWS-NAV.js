/**
 * VOICE GUIDE NEWS NAVIGATION TEST
 * 
 * CARA PAKAI DI LANDING PAGE:
 * 1. Buka landing page
 * 2. Buka Console (F12)
 * 3. Copy-paste script ini
 * 4. Tekan Enter
 * 
 * Script akan:
 * - Simulasi voice command "baca berita pertama"
 * - Test navigation logic
 * - Verify sessionStorage
 */

console.log('='.repeat(60));
console.log('VOICE GUIDE NEWS NAVIGATION TEST');
console.log('='.repeat(60));

// 1. Find news items
const newsLinks = document.querySelectorAll('#berita h3 a');
console.log(`\n[1] Found ${newsLinks.length} news items`);

if (newsLinks.length === 0) {
    console.error('❌ NO NEWS ITEMS FOUND! Cannot test.');
    console.log('Make sure you are on the landing page with news section.');
} else {
    const firstNews = newsLinks[0];
    const url = firstNews.getAttribute('href');
    const title = firstNews.innerText;

    console.log(`\n[2] Test Target:`);
    console.log(`   Title: ${title}`);
    console.log(`   URL: ${url}`);

    // 2. Simulate voice command parsing
    console.log(`\n[3] Simulating Voice Command: "baca berita pertama"`);

    if (window.VoiceParser) {
        const parseResult = window.VoiceParser.parse('baca berita pertama');
        console.log('   Parser Result:', parseResult);
        console.log('   Intent:', parseResult.intent);
        console.log('   Has Payload:', !!parseResult.payload);

        if (parseResult.payload) {
            console.log('   Payload URL:', parseResult.payload.getAttribute('href'));
            console.log('   Payload Title:', parseResult.payload.innerText);
        }
    } else {
        console.error('❌ VoiceParser not loaded!');
    }

    // 3. Manual navigation simulation
    console.log(`\n[4] MANUAL TEST - Run this in console:`);
    console.log(`\n--- COPY BELOW ---`);
    console.log(`
// Step 1: Save state
window.VoiceState.setPendingAction('READ_DETAIL', { title: "${title}" });
console.log('✅ State saved:', window.VoiceState.getPendingAction());

// Step 2: Speak
window.VoiceSpeech.speak("Membuka berita: ${title}");

// Step 3: Navigate
setTimeout(() => {
    console.log('🚀 Navigating to:', "${url}");
    window.location.assign("${url}");
}, 0);
    `);
    console.log(`--- END COPY ---\n`);

    // 4. Check current state
    console.log('[5] Current State:');
    console.log('   VoiceState active:', window.VoiceState?.isActive());
    console.log('   Pending action:', window.VoiceState?.getPendingAction());

    console.log('\n[6] sessionStorage check:');
    console.log('   voicePendingAction:', sessionStorage.getItem('voicePendingAction'));
}

console.log('\n' + '='.repeat(60));
console.log('TEST READY');
console.log('Copy the manual test code above and run it!');
console.log('='.repeat(60));
