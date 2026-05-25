<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台管理 - 編輯最新消息 (Jodit 全功能檔案上傳Jodit Editor套件)</title>
    <!-- 引入 Bootstrap 5 讓畫面美觀 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- ⚠️ 引入 Jodit 官方最新版樣式 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jodit/4.6.13/es2015/jodit.min.css"/>
</head>
<body class="bg-light py-5">

<div class="container bg-white p-4 rounded shadow-sm" style="max-width: 900px;">
    <h2 class="mb-4">編輯最新消息 (Jodit Editor)</h2>
    <p class="text-muted">提示：此編輯器支援直接拖放或貼上圖片、PDF、ZIP、Word 等任何檔案。</p>
    
    <!-- 表單送出至 save.php -->
    <form action="save.php" method="POST">
        <!-- 消息標題 -->
        <div class="mb-3">
            <label for="title" class="form-label fw-bold">消息標題</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="請輸入標題" required>
        </div>
        
        <!-- 最新消息內容 (Jodit 自動綁定) -->
        <div class="mb-3">
            <label for="editor" class="form-label fw-bold">消息內容</label>
            <textarea id="editor" name="content" placeholder="請輸入內容..."></textarea>
        </div>
        
        <!-- 儲存按鈕 -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">發布消息</button>
        </div>
    </form>
</div>

<!-- ================= 引入 Jodit JS ================= -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jodit/4.6.13/es2015/jodit.min.js"></script>

<script>
    // 初始化 Jodit Editor
    const editor = Jodit.make('#editor', {
        height: 450,
        placeholder: '開始撰寫內容或直接拖入任意檔案附件...',
        language: 'zh_tw', // 支援繁體中文（部分版本需載入語系包，預設自動降級英文）
        
        // 啟用檔案與圖片的拖放上傳
        enableDragAndDropFileToEditor: true,
        
        // 🔥 重要：設定 Jodit 全功能上傳組態
        uploader: {
            url: 'upload.php', // 後端接收檔案的 PHP 程式路徑
            format: 'json',
            path: 'files',
            
            // 變更傳送給 PHP $_FILES 的欄位名稱，Jodit 預設會使用 files[0]
            // 為方便 PHP 處理，我們固定發送名稱為 'upload_file'
            filesFieldName: function (i) {
                return 'upload_file';
            },
            
            // 核心處理：將 PHP 回傳的自訂 JSON 格式對接給 Jodit
            process: function (resp) {
                return {
                    files: resp.files || [],
                    path: resp.path,
                    baseurl: resp.baseurl,
                    error: resp.error,
                    msg: resp.msg
                };
            },
            
            // 當上傳成功後的動作：判斷是圖片就插入 <img>，是其他檔案就插入下載超連結 <a>
            defaultHandlerSuccess: function (data) {
                const currentEditor = this; // 這裡的 this 指向 jodit 實例
                
                if (data.files && data.files.length) {
                    data.files.forEach(function (fileObj) {
                        const fileUrl = data.baseurl + fileObj.name;
                        const fileExt = fileObj.name.split('.').pop().toLowerCase();
                        
                        // 判斷是否為常見圖片格式
                        const imgExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        
                        if (imgExts.includes(fileExt)) {
                            // 如果是圖片，直接插入圖片標籤
                            currentEditor.s.insertImage(fileUrl);
                        } else {
                            // 如果是 PDF, ZIP 等其他檔案，插入精美超連結
                            let icon = '📄 ';
                            if (fileExt === 'pdf') icon = '📕 ';
                            if (fileExt === 'zip' || fileExt === 'rar') icon = '📦 ';
                            if (fileExt === 'doc' || fileExt === 'docx') icon = '📘 ';
                            
                            const linkHtml = `<p><a href="${fileUrl}" target="_blank" class="btn-download" style="color: #0d6efd; text-decoration: underline;">${icon}下載附件：${fileObj.originalName}</a></p>`;
                            currentEditor.s.insertHTML(linkHtml);
                        }
                    });
                }
            }
        }
    });
</script>

</body>
</html>