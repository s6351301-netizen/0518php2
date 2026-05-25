    <!-- Header -->
    <header>
        <div class="header-top">
            <div class="logo">JL</div>
            <div class="company-name">晶聯合科技股份有限公司</div>
        </div>
        <nav>
            <?php 
            $page=str_replace("/include/","",$_SERVER['PHP_SELF']);
            ?>
            <a href="index.php" <?= ($page=='index.php')?'class="active"':'';?>>首頁</a>         
            <a href="product.php"><?=($page=='product.php')?'class="active"':'';?>>產品介紹</a>
            <a href="aboutus.php" <?= ($page=='aboutus.php')?'class="active"':'';?>>聯絡我們</a>   
            <!--
        <a href="index.php" class="active">首頁</a>
        <a href="product.php">產品介紹</a>
        <a href="aboutus.php">聯絡我們</a>
            -->       
  <!--這段語法說明<?php $page=str_replace("/include/","",$_SERVER['PHP_SELF']);     ?>
1.	$_SERVER['PHP_SELF']：
o	這是一個 PHP 超全域變數，用來獲取當前正在執行的腳本檔案名稱（包含相對於網站根目錄的路徑）。
o	假設網址是： http://example.com
o	結果為： /include/about.php
2.	str_replace(search, replace, subject)：
o	這是一個字串替換函數。
o	search (尋找目標)："/include/"
o	replace (替換內容)："" (空字串，表示刪除)
o	subject (原始字串)：$_SERVER['PHP_SELF']
3.	整體邏輯：
o	它會把 /include/about.php 中的 "/include/" 替換成空值。
o	結果變為：about.php
4.	$page = ...：
o	將最終處理好的字串（例如 "about.php"）賦值給變數 $page。
      -->    

        </nav>
    </header>