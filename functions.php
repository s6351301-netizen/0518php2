<?php
// functions.php - 通用函式庫

/**
 * 顯示美化的警告框
 * @param string $message 警告訊息
 * @param string $type 警告類型 (info, success, warning, error)
 */
function show_alert($message, $type = 'info') {
    $colors = array(
        'info' => '#3498db',
        'success' => '#2ecc71',
        'warning' => '#f39c12',
        'error' => '#e74c3c'
    );
    
    $color = isset($colors[$type]) ? $colors[$type] : $colors['info'];
    $icons = array(
        'info' => 'ℹ️',
        'success' => '✅',
        'warning' => '⚠️',
        'error' => '❌'
    );
    
    $icon = isset($icons[$type]) ? $icons[$type] : $icons['info'];
    
    echo '<div style="background: ' . $color . '20; border-left: 4px solid ' . $color . '; 
         padding: 12px 15px; margin: 10px 0; border-radius: 5px; color: #333;">';
    echo $icon . ' ' . htmlspecialchars($message);
    echo '</div>';
}

/**
 * 格式化檔案大小
 */
function format_file_size($bytes) {
    if ($bytes < 1024) {
        return $bytes . ' B';
    } elseif ($bytes < 1024 * 1024) {
        return round($bytes / 1024, 2) . ' KB';
    } else {
        return round($bytes / (1024 * 1024), 2) . ' MB';
    }
}

/**
 * 生成程式碼區塊
 */
function show_code_block($code, $title = 'Code') {
    echo '<div style="background: #f5f5f5; border: 1px solid #ddd; 
         border-radius: 5px; margin: 15px 0; overflow: hidden;">';
    echo '<div style="background: #333; color: #fff; padding: 10px; font-weight: bold;">' . $title . '</div>';
    echo '<pre style="margin: 0; padding: 15px; overflow-x: auto; font-size: 12px; line-height: 1.6;">';
    echo htmlspecialchars($code);
    echo '</pre></div>';
}

/**
 * 顯示變數資訊（類似 var_dump 但美化）
 */
function show_var($var, $title = 'Variable') {
    echo '<div style="background: #f9f9f9; border: 1px solid #ddd; 
         border-radius: 5px; margin: 10px 0; padding: 10px;">';
    echo '<strong style="color: #667eea;">' . htmlspecialchars($title) . ':</strong><br>';
    echo '<pre style="background: #f5f5f5; padding: 10px; overflow-x: auto; 
         margin: 5px 0; border-radius: 3px; font-size: 12px;">';
    print_r($var);
    echo '</pre></div>';
}

// 記錄檔案載入
error_log("functions.php 已被載入 - " . date("Y-m-d H:i:s"));

?>