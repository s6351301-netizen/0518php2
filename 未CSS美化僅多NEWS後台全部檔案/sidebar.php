<?php
// sidebar.php - 側邊欄檔案（用於演示重複包含）
?>
<aside style="background: #f8f9fa; padding: 20px; border-radius: 10px; 
            margin-bottom: 20px; border-left: 4px solid #667eea;">
    <h3 style="margin-top: 0; color: #667eea;">📚 學習重點</h3>
    <ul style="line-height: 1.8; color: #555;">
        <li><strong>include</strong> - 檔案不存在時發出警告，繼續執行</li>
        <li><strong>require</strong> - 檔案不存在時發生致命錯誤，停止執行</li>
        <li><strong>include_once</strong> - 只包含一次，重複包含時忽略</li>
        <li><strong>require_once</strong> - 只包含一次，重複包含時忽略</li>
    </ul>
    
    <h3 style="color: #667eea; margin-top: 20px;">✨ 最佳實踐</h3>
    <ul style="line-height: 1.8; color: #555;">
        <li>✅ 使用 require/require_once 載入關鍵檔案</li>
        <li>✅ 使用 include/include_once 載入可選檔案</li>
        <li>✅ 盡量使用 *_once 版本避免重複定義</li>
        <li>✅ 把通用函式放在單獨檔案中</li>
    </ul>
    
    <p style="font-size: 12px; color: #999; margin-top: 15px;">
        ℹ️ 這個側邊欄被包含了 1 次
    </p>
</aside>