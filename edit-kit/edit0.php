<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台管理 - 編輯最新消息(使用CKEditor 5套件)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* 調整編輯器的高度，預設會太矮 */
        .ck-editor__editable_inline {
            min-height: 400px;
        }
    </style>
</head>
<body class="bg-light py-5">

<div class="container bg-white p-4 rounded shadow-sm" style="max-width: 900px;">
    <h2 class="mb-4">編輯最新消息</h2>
    
    <form action="save.php" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label fw-bold">消息標題</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="請輸入標題" required>
        </div>
        
        <div class="mb-3">
            <label for="editor" class="form-label fw-bold">消息內容</label>
            <textarea id="editor" name="content" placeholder="請輸入內容..."></textarea>
        </div>
        
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">發布消息</button>
        </div>
    </form>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/translations/zh-tw.js"></script>

<script>
    // 初始化 CKEditor 5
    ClassicEditor
        .create(document.querySelector('#editor'), {
            // 設定語系為繁體中文
            language: 'zh-tw',
            // 自訂工具列功能
            toolbar: [
                'heading', '|', 
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'imageUpload', 'insertTable', 'mediaEmbed', '|',
                'undo', 'redo'
            ],
            // 🔥 重要設定：圖片上傳適配器
            simpleUpload: {
                // 後端接收圖片的 PHP 程式路徑
                uploadUrl: 'upload.php',
            }
        })
        .then(editor => {
            console.log('CKEditor 5 初始化成功！', editor);
        })
        .catch(error => {
            console.error('CKEditor 5 初始化失敗：', error);
        });
</script>

</body>
</html>