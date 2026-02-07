// TEST DEBUG SCRIPT
// Open browser console and run this to debug

console.log('=== TESTING VOICE GUIDE ===');

// Test 1: Normalizer
const testInput = "baca berita blt-dd";
const normalized = window.VoiceNormalizer.clean(testInput);
console.log('Input:', testInput);
console.log('Normalized:', normalized);
console.log('Tokens:', normalized.split(' '));

// Test 2: Intent Rules
const result = window.VoiceIntentRules.findMatch(normalized);
console.log('Intent Match:', result);

// Test 3: Parser
const parseResult = window.VoiceParser.parse(testInput);
console.log('Parse Result:', parseResult);
