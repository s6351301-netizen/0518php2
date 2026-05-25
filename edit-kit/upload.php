<?php
header('Content-Type: application/json; charset=utf-8');

// 1. 檢查檔案是否存在
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(['error' => '檔案上傳失敗']);
    exit;
}

$file = $_FILES['file']; // ⚠️ 注意：TinyMCE 預設的欄位名稱是 file

// 2. 檢查圖片格式
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
if (!in_array($file['type'], $allowedTypes)) {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(['error' => '不支援的圖片格式，僅限 JPG, PNG, GIF, WEBP']);
    exit;
}

// 3. 設定並建立儲存資料夾
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// 4. 生成唯一新檔名，避免重複
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$newFileName = uniqid('img_', true) . '.' . $extension;
$destination = $uploadDir . $newFileName;

// 5. 移動檔案並回傳 TinyMCE 要求的 JSON 格式
if (move_uploaded_file($file['tmp_name'], $destination)) {
    // 建立完整的圖片網址路徑
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $baseUrl = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/';
    $imageUrl = $baseUrl . $destination;

    // 🔥 TinyMCE 規定的成功 JSON 格式，鍵值必須是 location
    echo json_encode([
        'location' => $imageUrl
    ]);
} else {
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(['error' => '伺服器儲存檔案失敗']);
}