<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Include 和 Require 詳細教學</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px 20px;
            color: #333;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        .section h2 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 22px;
        }

        .section h3 {
            color: #764ba2;
            margin-top: 15px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background: white;
        }

        .comparison-table th,
        .comparison-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .comparison-table th {
            background: #667eea;
            color: white;
            font-weight: 600;
        }

        .comparison-table tr:nth-child(even) {
            background: #f5f5f5;
        }

        .code-block {
            background: #272822;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.5;
        }

        .example-box {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }

        .warning-box {
            background: #fff3e0;
            border-left: 4px solid #ff9800;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }

        .error-box {
            background: #ffebee;
            border-left: 4px solid #f44336;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }

        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 15px 0;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        .test-result {
            background: white;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border: 1px solid #ddd;
        }

        ul, ol {
            margin-left: 20px;
            line-height: 1.8;
        }

        li {
            margin: 8px 0;
        }

        .highlight {
            background: #ffeb3b;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // 使用 require_once 確保載入配置只執行一次
        require_once 'config.php';
        require_once 'functions.php';
        
        // 使用 include 載入頁頭
        include 'header.php';
        ?>

        <!-- 主要內容 -->
        <div class="grid">
            <div>
                <?php include_once 'sidebar.php'; ?>
            </div>
            <div>
                <!-- Section 1: 基本概念 -->
                <div class="section">
                    <h2>📖 基本概念</h2>
                    
                    <h3>什麼是 Include 和 Require？</h3>
                    <p>
                        在 PHP 中，我們經常需要在多個頁面中使用相同的代碼（如登入頁面、導航欄等）。
                        <span class="highlight">include</span> 和 <span class="highlight">require</span> 
                        都用來載入外部 PHP 檔案，但它們在遇到錯誤時的表現不同。
                    </p>

                    <div class="example-box">
                        <strong>✅ 實際應用場景：</strong>
                        <ul>
                            <li>包含網站的公共頁頭和頁腳</li>
                            <li>載入資料庫連接設定</li>
                            <li>包含函式庫檔案</li>
                            <li>載入導航菜單</li>
                            <li>引入驗證和授權代碼</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: 差異比較 -->
        <div class="section">
            <h2>⚔️ Include vs Require - 核心差異</h2>
            
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>特性</th>
                        <th>include</th>
                        <th>require</th>
                        <th>include_once</th>
                        <th>require_once</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>檔案不存在</strong></td>
                        <td>發出警告 (Warning)</td>
                        <td>致命錯誤 (Fatal Error)</td>
                        <td>發出警告 (Warning)</td>
                        <td>致命錯誤 (Fatal Error)</td>
                    </tr>
                    <tr>
                        <td><strong>執行繼續</strong></td>
                        <td>✅ 是</td>
                        <td>❌ 否</td>
                        <td>✅ 是</td>
                        <td>❌ 否</td>
                    </tr>
                    <tr>
                        <td><strong>重複包含</strong></td>
                        <td>每次都執行</td>
                        <td>每次都執行</td>
                        <td>只執行一次</td>
                        <td>只執行一次</td>
                    </tr>
                    <tr>
                        <td><strong>效能</strong></td>
                        <td>較快</td>
                        <td>較快</td>
                        <td>更快 (有檢查)</td>
                        <td>更快 (有檢查)</td>
                    </tr>
                    <tr>
                        <td><strong>使用場景</strong></td>
                        <td>可選檔案</td>
                        <td>必要檔案</td>
                        <td>可選且可能重複</td>
                        <td>必要且可能重複</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Section 3: 詳細說明 -->
        <div class="section">
            <h2>🔍 逐一詳解</h2>

            <h3>1️⃣ include - 包含並執行檔案</h3>
            <p>如果檔案不存在，發出警告但程式繼續執行。</p>
            
            <div class="code-block">include 'header.php';     // 檔案存在 - 正常
include 'missing.php';    // 檔案不存在 - 警告，但繼續執行
echo "程式繼續執行";      // 這行會被執行
            </div>

            <div class="warning-box">
                <strong>⚠️ 何時使用 include：</strong>
                <ul>
                    <li>載入可選的配置檔案</li>
                    <li>載入可能不存在的主題或套件</li>
                    <li>載入用戶自定義的設定</li>
                    <li>載入非必要的工具函式</li>
                </ul>
            </div>

            <h3>2️⃣ require - 要求載入檔案</h3>
            <p>如果檔案不存在，發生致命錯誤，程式停止執行。</p>

            <div class="code-block">require 'config.php';     // 檔案存在 - 正常
require 'missing.php';    // 檔案不存在 - 致命錯誤，停止！
echo "這行不會被執行";    // ❌ 程式已停止
            </div>

            <div class="error-box">
                <strong>❌ 何時使用 require：</strong>
                <ul>
                    <li>載入必要的配置檔案</li>
                    <li>載入資料庫連接</li>
                    <li>載入認證/授權代碼</li>
                    <li>載入核心函式庫</li>
                </ul>
            </div>

            <h3>3️⃣ include_once vs include</h3>
            <p>防止同一檔案被多次包含執行。</p>

            <div class="code-block">include 'functions.php';      // 第一次 - 執行
include 'functions.php';      // 第二次 - 再執行一次

include_once 'utils.php';     // 第一次 - 執行
include_once 'utils.php';     // 第二次 - 忽略，不執行
            </div>

            <div class="info-box">
                <strong>ℹ️ 使用場景：</strong>
                <ul>
                    <li>防止函式重複定義導致的致命錯誤</li>
                    <li>防止類別重複定義</li>
                    <li>防止常數重複定義</li>
                    <li>提高效能（避免重複解析）</li>
                </ul>
            </div>

            <h3>4️⃣ require_once - 最安全的選擇</h3>
            <p>結合 require 的強制性和 _once 的防重複特性。</p>

            <div class="code-block">require_once 'database.php';   // 第一次 - 執行
require_once 'database.php';   // 第二次 - 忽略

// 推薦用於：
require_once 'config/app.php';
require_once 'config/db.php';
require_once 'lib/functions.php';
            </div>
        </div>

        <!-- Section 4: 實時示範 -->
        <div class="section">
            <h2>🧪 實時示範</h2>

            <h3>載入配置檔案測試</h3>
            <div class="test-result">
                <strong>✅ Config.php 已成功載入</strong><br>
                <?php
                show_alert("Configuration loaded successfully!", "success");
                
                echo "站點 URL: <code>" . SITE_URL . "</code><br>";
                echo "應用版本: <code>" . $app_version . "</code><br>";
                echo "應用作者: <code>" . $app_author . "</code>";
                ?>
            </div>

            <h3>重複包含測試 (include vs include_once)</h3>
            <div class="test-result">
                <strong>📊 測試結果：</strong><br><br>
                
                <?php
                // 模擬重複包含的問題
                $test_file = tempnam(sys_get_temp_dir(), 'test_');
                file_put_contents($test_file, '<?php $counter = ($counter ?? 0) + 1; ?>');
                
                echo "<strong>情況 1: 使用 include（不防重複）</strong><br>";
                include $test_file;
                $first_count = $counter;
                include $test_file;
                $second_count = $counter;
                
                echo "第一次包含後計數器: " . $first_count . "<br>";
                echo "第二次包含後計數器: " . $second_count . "<br>";
                show_alert("計數器增加了 " . ($second_count - $first_count) . " 次，代表代碼被執行了兩次", "warning");
                
                unset($counter);
                unlink($test_file);
                ?>
            </div>

            <h3>函式庫載入測試</h3>
            <div class="test-result">
                <strong>✅ Functions.php 已載入，可用函式：</strong><br><br>
                
                <?php
                // 測試已載入的函式
                echo "1. show_alert() - ";
                if (function_exists('show_alert')) {
                    echo "<span style='color: green;'>✅ 可用</span>";
                }
                
                echo "<br>2. format_file_size() - ";
                if (function_exists('format_file_size')) {
                    echo "<span style='color: green;'>✅ 可用</span>";
                    echo "<br>   範例: 1024 bytes = " . format_file_size(1024);
                }
                
                echo "<br>3. show_code_block() - ";
                if (function_exists('show_code_block')) {
                    echo "<span style='color: green;'>✅ 可用</span>";
                }
                ?>
            </div>

            <h3>檔案路徑測試</h3>
            <div class="test-result">
                <?php
                echo "<strong>📁 檔案信息：</strong><br>";
                echo "目前檔案: " . __FILE__ . "<br>";
                echo "目前目錄: " . __DIR__ . "<br>";
                echo "相對路徑範例:<br>";
                echo "  - './config.php' → 同目錄<br>";
                echo "  - '../config.php' → 上層目錄<br>";
                echo "  - './lib/functions.php' → 子目錄<br>";
                ?>
            </div>
        </div>

        <!-- Section 5: 常見陷阱 -->
        <div class="section">
            <h2>⚡ 常見陷阱和最佳實踐</h2>

            <h3>❌ 陷阱 1: 迴圈包含（Circular Inclusion）</h3>
            <div class="code-block">// a.php
require 'b.php';

// b.php
require 'a.php';  // 會造成無限迴圈！
            </div>
            <div class="warning-box">
                <strong>✅ 解決方案：</strong>使用 require_once 或 include_once 防止重複包含
            </div>

            <h3>❌ 陷阱 2: 變數作用域問題</h3>
            <div class="code-block">// main.php
$name = "John";
include 'display.php';  // display.php 可以訪問 $name

// display.php
echo $name;  // 可以訪問 main.php 中的 $name 變數
            </div>

            <h3>❌ 陷阱 3: 函式重複定義</h3>
            <div class="code-block">// functions.php
function getData() { return "data"; }

// page1.php
include 'functions.php';
include 'functions.php';  // ❌ 致命錯誤: 函式已存在!

// ✅ 改用：
include_once 'functions.php';
include_once 'functions.php';  // ✅ 不會出錯
            </div>

            <h3>✅ 最佳實踐</h3>
            <div class="example-box">
                <strong>推薦做法：</strong>
                <div class="code-block">// 檔案開頭推薦的包含順序
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/lib/functions.php';
require_once __DIR__ . '/lib/security.php';

// 之後才包含可選檔案
include_once __DIR__ . '/vendor/helpers.php';
include_once __DIR__ . '/themes/current.php';
                </div>

                <strong>💡 建議：</strong>
                <ul>
                    <li>✅ 優先使用 <span class="highlight">require_once</span></li>
                    <li>✅ 使用絕對路徑：<code>__DIR__ . '/file.php'</code></li>
                    <li>✅ 把所有包含放在檔案開頭</li>
                    <li>✅ 按照依賴關係排序包含</li>
                    <li>✅ 為關鍵檔案使用 require，可選用 include</li>
                    <li>❌ 避免在迴圈中使用 include</li>
                    <li>❌ 避免在條件語句中使用 require（除非必要）</li>
                </ul>
            </div>
        </div>

        <!-- Section 6: 完整範例 -->
        <div class="section">
            <h2>📚 完整實作範例</h2>

            <h3>範例：構建一個簡單的內容管理系統</h3>
            <div class="code-block">// index.php
&lt;?php
// 步驟 1: 載入必要的配置和函式
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/lib/functions.php';

// 步驟 2: 檢查使用者是否已登入
require_once __DIR__ . '/auth/check.php';

// 步驟 3: 開始生成頁面
?&gt;
&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;?php include_once __DIR__ . '/templates/head.php'; ?&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;?php include_once __DIR__ . '/templates/header.php'; ?&gt;
    
    &lt;main&gt;
        &lt;?php include __DIR__ . '/pages/' . $page . '.php'; ?&gt;
    &lt;/main&gt;
    
    &lt;?php include_once __DIR__ . '/templates/footer.php'; ?&gt;
&lt;/body&gt;
&lt;/html&gt;
            </div>
        </div>

        <!-- Section 7: 總結 -->
        <div class="section">
            <h2>📝 快速參考表</h2>

            <div class="grid">
                <div>
                    <h3 style="color: #667eea;">使用 require / require_once</h3>
                    <ul>
                        <li>✅ 設定檔</li>
                        <li>✅ 資料庫連接</li>
                        <li>✅ 核心函式庫</li>
                        <li>✅ 安全驗證</li>
                        <li>✅ 強制性內容</li>
                    </ul>
                </div>
                <div>
                    <h3 style="color: #764ba2;">使用 include / include_once</h3>
                    <ul>
                        <li>✅ 主題/外觀</li>
                        <li>✅ 可選模組</li>
                        <li>✅ 佈局範本</li>
                        <li>✅ 使用者自定義檔案</li>
                        <li>✅ 第三方插件</li>
                    </ul>
                </div>
            </div>

            <div class="info-box">
                <strong>🎯 記住這個簡單規則：</strong><br>
                如果沒有這個檔案，我的程式會崩潰 → <span class="highlight">使用 require_once</span><br>
                如果沒有這個檔案，我的程式還能運作 → <span class="highlight">使用 include_once</span>
            </div>
        </div>

        <div class="info-box" style="text-align: center; margin-top: 30px;">
            <strong>✨ 現在你已經掌握了 PHP include 和 require 的所有知識！</strong><br>
            開始在你的專案中練習使用它們吧！
        </div>

        <?php
        // 使用 include 載入頁腳
        include 'footer.php';
        ?>
    </div>
</body>
</html>