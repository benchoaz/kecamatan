# Voice Guide News Navigation - Diagnostic Instructions

## LANGKAH 1: RUN DIAGNOSTIC SCRIPT

1. **Buka Landing Page** di browser
2. **Tekan F12** untuk buka DevTools Console
3. **Copy semua isi file** `public/voice-guide/TEST-NEWS-NAV.js`
4. **Paste ke Console** → tekan Enter
5. **Lihat output** diagnostic

## LANGKAH 2: RUN MANUAL TEST

Dari output diagnostic, akan ada section:
```
[4] MANUAL TEST - Run this in console:
--- COPY BELOW ---
```

**Copy semua code** di bawah "COPY BELOW" sampai "END COPY"
**Paste ke console** → Enter

## EXPECTED BEHAVIOR:

Seharusnya:
1. Console log: "✅ State saved"
2. Sistem berbicara: "Membuka berita: [judul]"
3. Browser navigasi ke halaman detail berita
4. (Di halaman detail) Voice Guide auto-read berita

## JIKA MASIH STUCK:

Screenshot console output dan kirim ke saya. Saya perlu lihat:
- Apakah news links ditemukan?
- Apakah parser berhasil?
- Apakah state tersimpan?
- Di mana eksekusi berhenti?

## QUICK TEST ALTERNATIF:

Di landing page console, run:
```javascript
// Test 1: Check modules
console.log('VoiceParser:', typeof window.VoiceParser);
console.log('VoiceActions:', typeof window.VoiceActions);
console.log('VoiceState:', typeof window.VoiceState);

// Test 2: Check news
console.log('News count:', document.querySelectorAll('#berita h3 a').length);

// Test 3: Parse command
const result = window.VoiceParser.parse('baca berita pertama');
console.log('Parse result:', result);

// Test 4: Execute action
window.VoiceActions.execute(result);
```
