<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台管理 - 編輯最新消息 (使用TinyMCE套件)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

<div class="container bg-white p-4 rounded shadow-sm" style="max-width: 900px;">
    <h2 class="mb-4">編輯最新消息 (TinyMCE)</h2>
    
    <form action="save.php" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label fw-bold">消息標題</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="請輸入標題" required>
        </div>
        
        <div class="mb-3">
            <label for="mytextarea" class="form-label fw-bold">消息內容</label>
            <textarea id="mytextarea" name="content" placeholder="請輸入內容..."></textarea>
        </div>
        
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">發布消息</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#mytextarea', // 綁定 textarea 的 CSS 選擇器
        height: 500,            // 設定編輯器高度
        language: 'zh_TW',      // 設定語系（若 CDN 未包含中文，預設會呈現英文）
        
        // 載入的外掛功能：包含開源必備的連結、圖片、表格、程式碼查看等
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
        
        // 自訂工具列排版
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image table | code fullscreen',
        
        /* 🔥 重要設定：圖片非同步上傳 */
        images_upload_url: 'upload.php', // 後端接收圖片的 PHP 程式路徑
        
        // 預設圖片上傳成功後，TinyMCE 會用相對路徑，改成以下設定可以確保抓到絕對路徑
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true
    });
</script>

</body>
</html>