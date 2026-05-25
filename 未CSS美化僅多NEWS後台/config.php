<?php
// config.php - 配置檔案，包含網站常數和設定

// 定義站點常數
define('SITE_URL', 'http://localhost');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_NAME', 'php_demo');

// 定義全域變數
$app_version = "1.0.0";
$app_author = "PHP 初學者";
$debug_mode = true;

// 定義配置陣列
$database_config = array(
    'host' => 'localhost',
    'user' => 'root',
    'pass' => 'password',
    'name' => 'php_demo'
);

// 定義顏色主題
$theme_colors = array(
    'primary' => '#667eea',
    'secondary' => '#764ba2',
    'success' => '#00bfff',
    'danger' => '#ff1493',
    'warning' => '#ffa500'
);

// 工具函式
function log_debug($message) {
    if (defined('DEBUG_MODE') || true) {
        echo "<!-- DEBUG: " . htmlspecialchars($message) . " -->\n";
    }
}

log_debug("Config.php 已被載入");
?>