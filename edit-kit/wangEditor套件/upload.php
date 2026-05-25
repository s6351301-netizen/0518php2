<?php
header('Content-Type: application/json; charset=utf-8');

// 1. 檢查檔案是否存在 (注意：我們在 edit.php 將 fieldName 改成了 news_image)
if (!isset($_FILES['news_image']) || $_FILES['news_image']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        'errno' => 1, // 🔥 wangEditor 規定：失敗時 errno 必須非 0
        'message' => '檔案上傳失敗或未選擇檔案'
    ]);
    exit;
}

$file = $_FILES['news_image'];

// 2. 檢查圖片格式
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
if (!in_array($file['type'], $allowedTypes)) {
    echo json_encode([
        'errno' => 2,
        'message' => '不支援的圖片格式，僅限 JPG, PNG, GIF, WEBP'
    ]);
    exit;
}

// 3. 設定並建立儲存資料夾
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// 4. 生成唯一新檔名
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$newFileName = uniqid('img_', true) . '.' . $extension;
$destination = $uploadDir . $newFileName;

// 5. 移動檔案並回傳 wangEditor 要求的特定格式
if (move_uploaded_file($file['tmp_name'], $destination)) {
    // 建立完整的圖片網址
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $baseUrl = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/';
    $imageUrl = $baseUrl . $destination;

    // 🔥 wangEditor V5 規定的成功 JSON 格式
    echo json_encode([
        'errno' => 0, // 成功必須為 0
        'data' => [
            'url' => $imageUrl, // 圖片網址 (必填)
            'alt' => $file['name'], // 圖片文字說明 (選填)
            'href' => '' // 圖片超連結 (選填)
        ]
    ]);
} else {
    echo json_encode([
        'errno' => 3,
        'message' => '伺服器儲存檔案失敗'
    ]);
}