<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Studio - API Testing Suite by Aguphia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        glass: 'rgba(255, 255, 255, 0.75)',
                        glassDark: 'rgba(15, 23, 42, 0.75)',
                    }
                }
            }
        }
    </script>
    <style>
        .glass-panel {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 text-slate-800 dark:from-slate-950 dark:via-indigo-950 dark:to-slate-900 dark:text-slate-100 min-h-screen transition-colors duration-300">

    <div class="container mx-auto p-4 md:p-6 max-w-7xl">
        <!-- Header & Top Navigation -->
        <header class="flex justify-between items-center mb-6 glass-panel bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700/50 p-4 rounded-2xl shadow-xl dark:shadow-2xl transition-colors">
            <div class="flex items-center gap-3">
                <div class="w-3 h-3 rounded-full bg-cyan-500 animate-pulse"></div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-cyan-600 via-teal-500 to-indigo-600 dark:from-cyan-400 dark:via-teal-300 dark:to-indigo-400 bg-clip-text text-transparent">
                    API Studio
                </h1>
            </div>
            <button id="toggleTheme" class="px-3.5 py-1.5 rounded-xl bg-slate-200 hover:bg-slate-300 border border-slate-300 dark:bg-slate-800/80 dark:border-slate-700 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-semibold transition">
                🌙 Dark / ☀️ Light
            </button>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Main Tester Panel (Left - 3 Cols) -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Request Form Panel -->
                <div class="glass-panel bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700/50 p-6 rounded-2xl shadow-lg dark:shadow-xl space-y-5 transition-colors">
                    
                    <!-- Title & Save Action -->
                    <div class="flex gap-3">
                        <input type="text" id="reqTitle" placeholder="Nama Request / API Title (misal: Get User List)" class="flex-1 bg-white dark:bg-slate-950/50 border border-slate-300 dark:border-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 rounded-xl px-4 py-2 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-cyan-500">
                        <button id="saveBtn" class="bg-slate-200 hover:bg-slate-300 text-slate-700 border border-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-200 dark:border-slate-700 font-semibold px-4 py-2 rounded-xl text-xs transition flex items-center gap-1.5">
                            💾 Save
                        </button>
                    </div>

                    <!-- URL & Method Bar -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <select id="method" class="bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700 rounded-xl px-4 py-2.5 font-bold text-cyan-600 dark:text-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 text-sm">
                            <option value="GET">GET</option>
                            <option value="POST">POST</option>
                            <option value="PUT">PUT</option>
                            <option value="PATCH">PATCH</option>
                            <option value="DELETE">DELETE</option>
                        </select>
                        <input type="text" id="url" placeholder="https://api.example.com/v1/resource" class="flex-1 bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-500 text-sm font-mono">
                        <button id="sendBtn" class="bg-gradient-to-r from-cyan-600 to-indigo-600 hover:from-cyan-500 hover:to-indigo-500 dark:from-cyan-500 dark:to-indigo-600 text-white font-bold px-7 py-2.5 rounded-xl shadow-lg transition duration-200 text-sm">
                            Send Request
                        </button>
                    </div>

                    <!-- Dynamic Headers Section -->
                    <div class="border-t border-slate-200 dark:border-slate-800/80 pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">HTTP Headers</span>
                            <button id="addHeaderBtn" class="text-xs text-cyan-600 dark:text-cyan-400 hover:underline font-semibold flex items-center gap-1">
                                + Tambah Header
                            </button>
                        </div>
                        <div id="headersContainer" class="space-y-2">
                            <!-- Default Header Row -->
                            <div class="header-row flex gap-2">
                                <input type="text" placeholder="Key (e.g. Authorization)" value="Content-Type" class="header-key w-1/2 bg-white dark:bg-slate-950/50 border border-slate-300 dark:border-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 rounded-lg px-3 py-1.5 text-xs font-mono focus:outline-none focus:ring-1 focus:ring-cyan-500">
                                <input type="text" placeholder="Value (e.g. Bearer token)" value="application/json" class="header-value w-1/2 bg-white dark:bg-slate-950/50 border border-slate-300 dark:border-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 rounded-lg px-3 py-1.5 text-xs font-mono focus:outline-none focus:ring-1 focus:ring-cyan-500">
                                <button type="button" class="remove-header text-rose-500 hover:text-rose-600 dark:text-rose-400 dark:hover:text-rose-300 px-2 text-xs font-bold">✕</button>
                            </div>
                        </div>
                    </div>

                    <!-- Body Payload -->
                    <div class="border-t border-slate-200 dark:border-slate-800/80 pt-4">
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2">JSON Body Payload</label>
                        <textarea id="bodyPayload" rows="4" class="w-full bg-slate-900 dark:bg-slate-950/80 border border-slate-700 dark:border-slate-800 text-emerald-400 rounded-xl p-3 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder='{\n  "name": "Aguphia",\n  "role": "Developer"\n}'></textarea>
                    </div>
                </div>

                <!-- Response Panel -->
                <div class="glass-panel bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700/50 p-6 rounded-2xl shadow-lg dark:shadow-xl space-y-3 transition-colors">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-slate-700 dark:text-slate-300 text-sm">Response Output</h3>
                        <div class="flex gap-3 text-xs font-mono">
                            <span id="resStatus" class="px-2.5 py-1 rounded-md bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400">Status: -</span>
                            <span id="resTime" class="px-2.5 py-1 rounded-md bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400">Time: -</span>
                        </div>
                    </div>
                    <pre id="responseBox" class="bg-slate-900 dark:bg-slate-950/90 border border-slate-800 rounded-xl p-4 text-xs font-mono text-cyan-300 overflow-x-auto max-h-[300px] min-h-[150px]">Waiting for request...</pre>
                </div>

                <!-- Code Snippet Generator Panel -->
                <div class="glass-panel bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700/50 p-6 rounded-2xl shadow-lg dark:shadow-xl space-y-3 transition-colors">
                    <div class="flex justify-between items-center border-b border-slate-200 dark:border-slate-800 pb-3">
                        <h3 class="font-bold text-slate-700 dark:text-slate-300 text-sm">Code Snippet Generator</h3>
                        <!-- Tab Selector -->
                        <div class="flex gap-1.5 bg-slate-200 dark:bg-slate-950/60 p-1 rounded-lg border border-slate-300 dark:border-slate-800 text-xs">
                            <button class="snippet-tab px-3 py-1 rounded-md font-mono bg-cyan-500/20 text-cyan-700 dark:text-cyan-300 font-bold" data-lang="curl">cURL</button>
                            <button class="snippet-tab px-3 py-1 rounded-md font-mono text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200" data-lang="js">JS Fetch</button>
                            <button class="snippet-tab px-3 py-1 rounded-md font-mono text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200" data-lang="python">Python</button>
                            <button class="snippet-tab px-3 py-1 rounded-md font-mono text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200" data-lang="php">PHP</button>
                        </div>
                    </div>
                    <pre id="snippetBox" class="bg-slate-900 dark:bg-slate-950/90 border border-slate-800 rounded-xl p-4 text-xs font-mono text-amber-300/90 overflow-x-auto">// Snippet otomatis diperbarui saat parameter diisi</pre>
                </div>
            </div>

            <!-- History Sidebar (Right - 1 Col) -->
            <div class="glass-panel bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700/50 p-6 rounded-2xl shadow-lg dark:shadow-xl h-fit transition-colors">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-slate-700 dark:text-slate-300 text-sm">Arsip Request</h3>
                    <button id="refreshHistory" class="text-xs text-cyan-600 dark:text-cyan-400 hover:underline">Refresh</button>
                </div>
                <div id="historyList" class="space-y-2.5 text-xs max-h-[600px] overflow-y-auto pr-1">
                    <p class="text-slate-500 italic">Memuat arsip...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let activeSnippetLang = 'curl';
            let lastResponseData = null;

            // Load History Pertama Kali
            fetchHistory();

            // --- 1. DYNAMIC HEADERS LOGIC ---
            $('#addHeaderBtn').click(function() {
                const row = `
                    <div class="header-row flex gap-2">
                        <input type="text" placeholder="Key" class="header-key w-1/2 bg-white dark:bg-slate-950/50 border border-slate-300 dark:border-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 rounded-lg px-3 py-1.5 text-xs font-mono focus:outline-none focus:ring-1 focus:ring-cyan-500">
                        <input type="text" placeholder="Value" class="header-value w-1/2 bg-white dark:bg-slate-950/50 border border-slate-300 dark:border-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 rounded-lg px-3 py-1.5 text-xs font-mono focus:outline-none focus:ring-1 focus:ring-cyan-500">
                        <button type="button" class="remove-header text-rose-500 hover:text-rose-600 dark:text-rose-400 dark:hover:text-rose-300 px-2 text-xs font-bold">✕</button>
                    </div>`;
                $('#headersContainer').append(row);
                updateSnippet();
            });

            $(document).on('click', '.remove-header', function() {
                $(this).closest('.header-row').remove();
                updateSnippet();
            });

            function getHeadersObj() {
                const headers = {};
                $('.header-row').each(function() {
                    const k = $(this).find('.header-key').val().trim();
                    const v = $(this).find('.header-value').val().trim();
                    if(k) headers[k] = v;
                });
                return headers;
            }

            // --- 2. CODE SNIPPET GENERATOR LOGIC ---
            function updateSnippet() {
                const url = $('#url').val() || 'https://api.example.com/endpoint';
                const method = $('#method').val();
                const body = $('#bodyPayload').val();
                const headers = getHeadersObj();

                let snippet = '';

                if (activeSnippetLang === 'curl') {
                    snippet = `curl -X ${method} "${url}" \\\n`;
                    for(let k in headers) {
                        snippet += `  -H "${k}: ${headers[k]}" \\\n`;
                    }
                    if(['POST', 'PUT', 'PATCH'].includes(method) && body) {
                        snippet += `  -d '${body.replace(/'/g, "'\\''")}'`;
                    }
                } else if (activeSnippetLang === 'js') {
                    snippet = `fetch("${url}", {\n  method: "${method}",\n  headers: ${JSON.stringify(headers, null, 4)},\n`;
                    if(['POST', 'PUT', 'PATCH'].includes(method) && body) {
                        snippet += `  body: JSON.stringify(${body})\n`;
                    }
                    snippet += `})\n.then(response => response.json())\n.then(data => console.log(data));`;
                } else if (activeSnippetLang === 'python') {
                    snippet = `import requests\n\nurl = "${url}"\nheaders = ${JSON.stringify(headers, null, 4)}\n`;
                    if(['POST', 'PUT', 'PATCH'].includes(method) && body) {
                        snippet += `payload = ${body}\nresponse = requests.${method.toLowerCase()}(url, headers=headers, json=payload)\n`;
                    } else {
                        snippet += `response = requests.${method.toLowerCase()}(url, headers=headers)\n`;
                    }
                    snippet += `print(response.json())`;
                } else if (activeSnippetLang === 'php') {
                    snippet = `<?php\n$ch = curl_init();\ncurl_setopt($ch, CURLOPT_URL, "${url}");\ncurl_setopt($ch, CURLOPT_CUSTOMREQUEST, "${method}");\ncurl_setopt($ch, CURLOPT_RETURNTRANSFER, true);\n`;
                    const hArr = [];
                    for(let k in headers) hArr.push(`${k}: ${headers[k]}`);
                    if(hArr.length > 0) {
                        snippet += `curl_setopt($ch, CURLOPT_HTTPHEADER, ${JSON.stringify(hArr)});\n`;
                    }
                    if(['POST', 'PUT', 'PATCH'].includes(method) && body) {
                        snippet += `curl_setopt($ch, CURLOPT_POSTFIELDS, '${body}');\n`;
                    }
                    snippet += `$res = curl_exec($ch);\ncurl_close($ch);\necho $res;`;
                }

                $('#snippetBox').text(snippet);
            }

            // Re-generate snippet saat input berubah
            $(document).on('input change', '#url, #method, #bodyPayload, .header-key, .header-value', updateSnippet);

            $('.snippet-tab').click(function() {
                $('.snippet-tab').removeClass('bg-cyan-500/20 text-cyan-700 dark:text-cyan-300 font-bold').addClass('text-slate-600 dark:text-slate-400');
                $(this).addClass('bg-cyan-500/20 text-cyan-700 dark:text-cyan-300 font-bold').removeClass('text-slate-600 dark:text-slate-400');
                activeSnippetLang = $(this).data('lang');
                updateSnippet();
            });

            // --- 3. EXECUTE REQUEST ---
            $('#sendBtn').click(function() {
                const url = $('#url').val();
                if(!url) { alert('URL target wajib diisi!'); return; }

                $('#responseBox').text('Sending request...');
                
                $.ajax({
                    url: 'proxy.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        action: 'execute',
                        url: url,
                        method: $('#method').val(),
                        headers: getHeadersObj(),
                        body: $('#bodyPayload').val()
                    }),
                    success: function(res) {
                        lastResponseData = res;
                        $('#resStatus').text('Status: ' + (res.http_code || 'Error'))
                                       .removeClass('bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400')
                                       .addClass(res.http_code >= 200 && res.http_code < 300 ? 'bg-emerald-500/20 text-emerald-600 dark:text-emerald-400' : 'bg-rose-500/20 text-rose-600 dark:text-rose-400');
                        $('#resTime').text('Time: ' + (res.execution_time || '-'));
                        $('#responseBox').text(JSON.stringify(res.response, null, 2));
                    },
                    error: function() {
                        $('#responseBox').text('Terjadi kesalahan pada sistem proxy server.');
                    }
                });
            });

            // --- 4. MYSQL HISTORY MANAGEMENT ---
            $('#saveBtn').click(function() {
                const title = $('#reqTitle').val() || $('#url').val();
                if(!$('#url').val()) { alert('URL tidak boleh kosong!'); return; }

                $.ajax({
                    url: 'proxy.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        action: 'save_history',
                        title: title,
                        url: $('#url').val(),
                        method: $('#method').val(),
                        headers: getHeadersObj(),
                        body: $('#bodyPayload').val(),
                        last_response_status: lastResponseData ? lastResponseData.http_code : null,
                        last_response_body: lastResponseData ? lastResponseData.response : null
                    }),
                    success: function(res) {
                        if(res.status === 'success') {
                            alert('Request berhasil diarsipkan!');
                            fetchHistory();
                        } else {
                            alert('Gagal menyimpan: ' + res.message);
                        }
                    }
                });
            });

            $('#refreshHistory').click(fetchHistory);

            function fetchHistory() {
                $.ajax({
                    url: 'proxy.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ action: 'get_history' }),
                    success: function(res) {
                        if(res.status === 'success') {
                            let html = '';
                            if(res.data.length === 0) {
                                html = '<p class="text-slate-500 italic">Belum ada arsip tersimpan.</p>';
                            } else {
                                res.data.forEach(item => {
                                    const badgeColor = item.method === 'GET' ? 'text-emerald-600 dark:text-emerald-400 bg-emerald-500/10' :
                                                       item.method === 'POST' ? 'text-cyan-600 dark:text-cyan-400 bg-cyan-500/10' : 'text-amber-600 dark:text-amber-400 bg-amber-500/10';
                                    
                                    html += `
                                        <div class="history-item p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/40 hover:bg-slate-100 dark:hover:bg-slate-800/60 cursor-pointer transition" data-json='${JSON.stringify(item).replace(/'/g, "&apos;")}'>
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-semibold text-slate-800 dark:text-slate-200 truncate max-w-[140px]">${item.title}</span>
                                                <span class="px-1.5 py-0.5 rounded font-mono text-[10px] font-bold ${badgeColor}">${item.method}</span>
                                            </div>
                                            <div class="text-[11px] text-slate-500 dark:text-slate-400 font-mono truncate">${item.url}</div>
                                        </div>`;
                                });
                            }
                            $('#historyList').html(html);
                        }
                    }
                });
            }

            // Klik item arsip untuk memuat ulang ke form
            $(document).on('click', '.history-item', function() {
                const data = $(this).data('json');
                $('#reqTitle').val(data.title);
                $('#url').val(data.url);
                $('#method').val(data.method);
                $('#bodyPayload').val(data.body_payload || '');

                // Rebuild Dynamic Headers Rows
                $('#headersContainer').empty();
                const headers = typeof data.headers === 'string' ? JSON.parse(data.headers) : data.headers;
                if(headers && Object.keys(headers).length > 0) {
                    for(let k in headers) {
                        $('#headersContainer').append(`
                            <div class="header-row flex gap-2">
                                <input type="text" value="${k}" class="header-key w-1/2 bg-white dark:bg-slate-950/50 border border-slate-300 dark:border-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 rounded-lg px-3 py-1.5 text-xs font-mono focus:outline-none focus:ring-1 focus:ring-cyan-500">
                                <input type="text" value="${headers[k]}" class="header-value w-1/2 bg-white dark:bg-slate-950/50 border border-slate-300 dark:border-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 rounded-lg px-3 py-1.5 text-xs font-mono focus:outline-none focus:ring-1 focus:ring-cyan-500">
                                <button type="button" class="remove-header text-rose-500 hover:text-rose-600 dark:text-rose-400 dark:hover:text-rose-300 px-2 text-xs font-bold">✕</button>
                            </div>
                        `);
                    }
                }
                updateSnippet();
            });

            // Theme Toggle Logic
            $('#toggleTheme').click(function() {
                $('html').toggleClass('dark');
            });

            // Initial Snippet Build
            updateSnippet();
        });
    </script>
</body>
</html>