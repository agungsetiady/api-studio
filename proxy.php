<?php
header('Content-Type: application/json');

// Database Connection Settings (Mendukung Environment Variables)
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'api-studio';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    // Tetap berjalan jika DB tidak terhubung (fitur execute cURL tetap berfungsi)
    $pdo = null;
}

$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? 'execute';

// --- ACTION 1: GET HISTORY LIST ---
if ($action === 'get_history') {
    if (!$pdo) {
        echo json_encode(['status' => 'error', 'message' => 'Database tidak terhubung']);
        exit;
    }
    $stmt = $pdo->query("SELECT id, title, url, method, headers, body_payload FROM api_endpoints ORDER BY id DESC LIMIT 20");
    echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
    exit;
}

// --- ACTION 2: SAVE TO HISTORY ---
if ($action === 'save_history') {
    if (!$pdo) {
        echo json_encode(['status' => 'error', 'message' => 'Koneksi database gagal']);
        exit;
    }
    
    $title       = !empty($input['title']) ? $input['title'] : 'Untitled Request';
    $url         = $input['url'] ?? '';
    $method      = strtoupper($input['method'] ?? 'GET');
    $headers     = json_encode($input['headers'] ?? []);
    $body        = $input['body'] ?? '';
    $resp_status = $input['last_response_status'] ?? null;
    $resp_body   = is_array($input['last_response_body']) ? json_encode($input['last_response_body']) : ($input['last_response_body'] ?? '');

    $stmt = $pdo->prepare("INSERT INTO api_endpoints (title, url, method, headers, body_payload, last_response_status, last_response_body) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $url, $method, $headers, $body, $resp_status, $resp_body]);

    echo json_encode(['status' => 'success', 'message' => 'Arsip berhasil disimpan', 'id' => $pdo->lastInsertId()]);
    exit;
}

// --- ACTION 3: EXECUTE API REQUEST ---
$url     = trim($input['url'] ?? '');
$method  = strtoupper($input['method'] ?? 'GET');
$headers = $input['headers'] ?? [];
$body    = $input['body'] ?? '';

if (empty($url)) {
    echo json_encode(['status' => 'error', 'message' => 'URL tidak boleh kosong']);
    exit;
}

// 1. Validasi Format URL (Wajib HTTP/HTTPS)
if (!filter_var($url, FILTER_VALIDATE_URL) || !preg_match('/^https?:\/\//i', $url)) {
    echo json_encode(['status' => 'error', 'message' => 'URL harus berupa skema http:// atau https:// yang valid']);
    exit;
}

// 2. Proteksi SSRF (Blokir Akses ke Localhost & Private IP)
$host = parse_url($url, PHP_URL_HOST);
if ($host) {
    $ip = gethostbyname($host);
    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        echo json_encode(['status' => 'error', 'message' => 'Akses ke jaringan lokal/internal server dilarang']);
        exit;
    }
}

// 3. Konfigurasi cURL yang Terisolasi
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

// Keamanan Protokol Tambahan
curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Mencegah SSRF via HTTP 30x Redirect

$formattedHeaders = [];
foreach ($headers as $key => $val) {
    if (!empty($key)) {
        $formattedHeaders[] = "$key: $val";
    }
}
if (!empty($formattedHeaders)) {
    curl_setopt($ch, CURLOPT_HTTPHEADER, $formattedHeaders);
}

if (in_array($method, ['POST', 'PUT', 'PATCH']) && !empty($body)) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
}

$startTime = microtime(true);
$response  = curl_exec($ch);
$endTime   = microtime(true);

$statusCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$executionTime = round(($endTime - $startTime) * 1000, 2);

if (curl_errno($ch)) {
    echo json_encode([
        'status' => 'error',
        'message' => curl_error($ch)
    ]);
} else {
    $parsedResponse = json_decode($response);
    echo json_encode([
        'status' => 'success',
        'http_code' => $statusCode,
        'execution_time' => $executionTime . ' ms',
        'response' => $parsedResponse !== null ? $parsedResponse : $response
    ]);
}

curl_close($ch);