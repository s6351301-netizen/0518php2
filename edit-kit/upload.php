<?php
header('Content-Type: application/json; charset=utf-8');

// 1. 檢查檔案是否存在 (對應前端 filesFieldName 設定的 upload_file)
if (!isset($_FILES['upload_file']) || $_FILES['upload_file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        'success' => false,
        'error' => '檔案上傳失敗或超過伺服器限制。'
    ]);
    exit;
}

$file = $_FILES['upload_file'];

// 2. 🔥 嚴格的資安防護：禁止上傳任何可能執行的後門腳本
$bannedExtensions = ['php', 'phtml', 'php3', 'php4', 'php5', 'php7', 'phps', 'jsp', 'asp', 'aspx', 'exe', 'sh', 'bat'];
$originalName = $file['name'];
$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

if (in_array($extension, $bannedExtensions) || empty($extension)) {
    echo json_encode([
        'success' => false,
        'error' => '資安警告：不允許上傳此類型的檔案。'
    ]);
    exit;
}

// 3. 設定儲存目錄
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// 4. 生成唯一新檔名，避免繁體中文亂碼或檔案覆蓋
$newFileName = uniqid('file_', true) . '.' . $extension;
$destination = $uploadDir . $newFileName;

// 5. 移動檔案
if (move_uploaded_file($file['tmp_name'], $destination)) {
    // 取得基礎 URL 路徑
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $baseUrl = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/';

    // 🔥 回傳對接 Jodit process() 方法的標準格式
    echo json_encode([
        'success' => true,
        'baseurl' => $baseUrl . $uploadDir, // 指向 uploads 資料夾根目錄的網址
        'files' => [
            [
                'name' => $newFileName,        // 儲存在伺服器上的安全新檔名
                'originalName' => $originalName // 使用者原本看到的檔案名稱
            ]
        ]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => '伺服器儲存檔案失敗。'
    ]);
}