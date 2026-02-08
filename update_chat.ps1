$ErrorActionPreference = "Stop"
$path = "d:\Projectku\dashboard-kecamatan\resources\views\landing.blade.php"
# Read file as array of strings
$lines = Get-Content $path

$start = -1
$end = -1

# Find markers
for ($i=0; $i -lt $lines.Count; $i++) {
    if ($lines[$i] -match "<!-- 9.. Chatbot Floating Widget -->") { $start = $i }
    if ($lines[$i] -match "<!-- Formulir Pengajuan Layanan") { $end = $i; break }
}

if ($start -ne -1 -and $end -ne -1) {
    Write-Host "Found block from line $start to $end"
    
    # Slice arrays
    $arrBefore = @()
    if ($start -gt 0) {
        $arrBefore = $lines[0..($start-1)]
    }
    $arrAfter = $lines[$end..($lines.Count-1)]
    
    # Define New Content (ChatWindow + Original FAB)
    $newBlock = @(
        "    <!-- 9️⃣ Chatbot Interface (Hidden Window) -->",
        '    <div id="chatWindow" class="fixed bottom-28 right-8 z-[80] w-80 md:w-96 bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden transition-all duration-300 origin-bottom-right scale-0 opacity-0 translate-y-10 print:hidden">',
        '        <!-- Header -->',
        '        <div class="bg-gradient-to-r from-teal-600 to-teal-500 p-4 text-white flex justify-between items-center">',
        '            <div class="flex items-center gap-3">',
        '                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">',
        '                    <i class="fas fa-robot text-lg"></i>',
        '                </div>',
        '                <div>',
        '                    <h4 class="font-bold text-sm leading-tight">Asisten AI</h4>',
        '                    <p class="text-[10px] opacity-80">Jawab Suara & Teks</p>',
        '                </div>',
        '            </div>',
        '            <button onclick="toggleChat()" type="button" class="btn btn-sm btn-ghost btn-circle text-white hover:bg-white/20">',
        '                <i class="fas fa-times text-lg"></i>',
        '            </button>',
        '        </div>',
        '        ',
        '        <!-- Messages -->',
        '        <div id="chatMessages" class="h-80 overflow-y-auto p-4 bg-slate-50 space-y-3 scrollbar-thin scrollbar-thumb-slate-200 text-sm">',
        '            <div class="flex items-start gap-3">',
        '                <div class="w-8 h-8 rounded-xl bg-teal-600 flex items-center justify-center shrink-0 shadow-lg">',
        '                    <i class="fas fa-robot text-white text-[10px]"></i>',
        '                </div>',
        '                <div class="bg-white border border-slate-200 text-slate-700 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[85%]">',
        '                    Halo! 👋 Saya AI Kecamatan. Tanya saya apa saja tentang layanan, saya bisa menjawab dengan teks dan suara.',
        '                </div>',
        '            </div>',
        '        </div>',
        '',
        '        <!-- Input -->',
        '        <div class="p-3 bg-white border-t border-slate-100">',
        '            <form id="publicFaqForm" class="relative flex items-center gap-2">',
        '                <input type="text" id="botQuery" ',
        '                    class="input input-sm input-bordered w-full rounded-full pl-4 pr-10 bg-slate-50 focus:bg-white transition-all text-xs"',
        '                    placeholder="Tanya sesuatu..." autocomplete="off">',
        '                <button type="submit" ',
        '                    class="btn btn-sm btn-circle bg-teal-600 text-white border-none hover:bg-teal-700 shadow-md">',
        '                    <i class="fas fa-paper-plane text-xs"></i>',
        '                </button>',
        '            </form>',
        '        </div>',
        '    </div>',
        '',
        '    <!-- Floating Action Button (Restored Original Design) -->',
        '    <div class="fixed bottom-8 right-8 z-[70] group print:hidden">',
        '        <div class="absolute bottom-full right-0 mb-4 px-4 py-2 bg-teal-600 text-white text-xs font-bold rounded-2xl shadow-xl whitespace-nowrap opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all pointer-events-none">',
        '            Butuh Bantuan? Klik di sini',
        '        </div>',
        '        <button onclick="toggleChat()" id="chatToggleBtn" type="button"',
        '            class="btn btn-circle bg-teal-600 hover:bg-teal-700 border-none shadow-2xl shadow-teal-500/40 w-16 h-16 group/btn transition-all duration-300">',
        '            <i class="fas fa-comment-dots text-white text-2xl group-hover/btn:scale-110 transition-transform"></i>',
        '        </button>',
        '    </div>',
        '',
        '    <script>',
        '        function toggleChat() {',
        "            const w = document.getElementById('chatWindow');",
        "            const btnIcon = document.querySelector('#chatToggleBtn i');",
        "            const isOpen = !w.classList.contains('scale-0');",
        '            ',
        '            if (isOpen) {',
        "                w.classList.add('scale-0', 'opacity-0', 'translate-y-10');",
        '                if(btnIcon) {',
        "                    btnIcon.classList.remove('fa-times', 'rotate-90');",
        "                    btnIcon.classList.add('fa-comment-dots');",
        '                }',
        '            } else {',
        "                w.classList.remove('scale-0', 'opacity-0', 'translate-y-10');",
        '                if(btnIcon) {',
        "                    btnIcon.classList.remove('fa-comment-dots');",
        "                    btnIcon.classList.add('fa-times', 'rotate-90');",
        '                }',
        "                setTimeout(() => document.getElementById('botQuery').focus(), 300);",
        '            }',
        '        }',
        '    </script>'
    )
    
    # Combine
    $finalContent = $arrBefore + $newBlock + $arrAfter
    
    # Write back
    $finalContent | Set-Content $path -Encoding UTF8
    Write-Host "File updated successfully."
} else {
    Write-Host "Error: Could not find start/end markers in file."
    exit 1
}
