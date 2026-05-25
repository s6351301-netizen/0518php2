<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台管理 - 編輯最新消息 (wangEditor)</title>
    <!-- 引入 Bootstrap 5 讓畫面美觀 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- ⚠️ 引入 wangEditor V5 樣式 -->
    <link href="https://cdn.jsdelivr.net/npm/@wangeditor/editor@latest/dist/css/style.css" rel="stylesheet">
    
    <style>
        /* 調整編輯器外框與高度 */
        .editor-container {
            border: 1px solid #ccc;
            background-color: #fff;
        }
        #toolbar-container {
            border-bottom: 1px solid #ccc;
        }
        #editor-container {
            height: 400px;
        }
    </style>
</head>
<body class="bg-light py-5">

<div class="container bg-white p-4 rounded shadow-sm" style="max-width: 900px;">
    <h2 class="mb-4">編輯最新消息 (wangEditor)</h2>
    
    <!-- 表單送出至 save.php -->
    <form id="newsForm" action="save.php" method="POST">
        <!-- 消息標題 -->
        <div class="mb-3">
            <label for="title" class="form-label fw-bold">消息標題</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="請輸入標題" required>
        </div>
        
        <!-- 最新消息內容 (wangEditor 容器) -->
        <div class="mb-3">
            <label class="form-label fw-bold">消息內容</label>
            <div class="editor-container rounded">
                <!-- 工具列容器 -->
                <div id="toolbar-container"></div>
                <!-- 編輯器本文容器 -->
                <div id="editor-container"></div>
            </div>
        </div>

        <!-- ⚠️ 隱藏的 input：用來存放 wangEditor 產生的 HTML 字串 -->
        <input type="hidden" name="content" id="content_html">
        
        <!-- 儲存按鈕 -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">發布消息</button>
        </div>
    </form>
</div>

<!-- ================= 引入 wangEditor JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/@wangeditor/editor@latest/dist/index.min.js"></script>

<script>
    const { createEditor, createToolbar } = window.wangEditor;

    // 1. 編輯器配置
    const editorConfig = {
        placeholder: '請輸入內容...（支援 Word 複雜表格直接貼上）',
        // 配置選單功能（如圖片上傳）
        MENU_CONF: {
            // 配置圖片上傳
            uploadImage: {
                server: 'upload.php',    // 後端接收圖片的 PHP 程式路徑
                fieldName: 'news_image', // 🔥 自訂傳給 PHP 的 $_FILES 鍵名 (預設為 file)
                maxFileSize: 5 * 1024 * 1024, // 限制 5MB
                allowedFileTypes: ['image/*'],
                
                // 自訂超時時間
                timeout: 10 * 1000,
            }
        },
        onChange(editor) {
            // 當內容改變時，可以即時監聽（非必須，本範例改在 submit 時處理）
        }
    };

    // 2. 創建編輯器
    const editor = createEditor({
        selector: '#editor-container',
        config: editorConfig,
        mode: 'default', // 或 'simple' 簡潔模式
    });

    // 3. 創建工具列
    const toolbarConfig = {};
    const toolbar = createToolbar({
        editor,
        selector: '#toolbar-container',
        config: toolbarConfig,
        mode: 'default',
    });

    // 4. 監聽表單送出事件
    document.getElementById('newsForm').addEventListener('submit', function(e) {
        // 阻止表單立刻送出
        e.preventDefault();

        // 獲取 wangEditor 的 HTML 內容
        const htmlContent = editor.getHtml();

        // 檢查內容是否為空 (wangEditor 空內容時預設會是 '<p><br></p>')
        if (editor.isEmpty()) {
            alert('請輸入消息內容！');
            return;
        }

        // 將 HTML 字串塞進隱藏的 input 中
        document.getElementById('content_html').value = htmlContent;
        
        // 正式送出表單
        this.submit();
    });
</script>

</body>
</html>