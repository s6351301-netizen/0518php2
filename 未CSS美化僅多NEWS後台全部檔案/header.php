<?php
// header.php - 公共頁頭檔案
$site_name = "PHP Include/Require 示範";
$current_year = date("Y");
?>
<header style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
              color: white; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
    <h1 style="margin: 0; font-size: 24px;">🔧 <?= $site_name; ?></h1>
    <p style="margin: 5px 0 0 0; opacity: 0.9;">PHP 檔案包含機制詳細教學</p>
</header>