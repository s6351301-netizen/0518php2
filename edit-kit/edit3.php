<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台管理 - 編輯最新消息 (使用Editor.js套件)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Editor.js 的外框樣式調整 */
        .editor-wrapper {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 20px;
            min-height: 400px;
            background-color: #fff;
        }
    </style>
</head>
<body class="bg-light py-5">

<div class="container bg-white p-4 rounded shadow-sm" style="max-width: 900px;">
    <h2 class="mb-4">編輯最新消息 (Editor.js)</h2>
    
    <form id="newsForm" action="save.php" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label fw-bold">消息標題</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="請輸入標題" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label fw-bold">消息內容</label>
            <div id="editorjs" class="editor-wrapper"></div>
        </div>

        <input type="hidden" name="content" id="content_json">
        
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">發布消息</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/image@latest"></script>

<script>
    // 初始化 Editor.js
    const editor = new EditorJS({
        holder: 'editorjs', // 綁定的 div ID
        placeholder: '點擊這裡開始撰寫最新消息...',
        
        // 配置載入的外掛工具
        tools: {
            header: {
                class: Header,
                inlineToolbar: ['link']
            },
            list: {
                class: List,
                inlineToolbar: true
            },
            image: {
                class: ImageTool,
                config: {
                    // 🔥 重要設定：後端接收圖片的 PHP 程式路徑
                    endpoints: {
                        byFile: 'upload.php', // 選擇檔案上傳的 API
                    }
                }
            }
        }
    });

    // 監聽表單送出事件
    document.getElementById('newsForm').addEventListener('submit', function(e) {
        // 阻止表單立刻送出，因為我們要先等待 Editor.js 導出資料
        e.preventDefault();

        // 呼叫 Editor.js 的 save() 方法取得 JSON 資料
        editor.save().then((outputData) => {
            // 將 JSON 物件轉成字串，塞進隱藏的 input 中
            document.getElementById('content_json').value = JSON.stringify(outputData);
            
            // 正式送出表單
            this.submit();
        }).catch((error) => {
            console.error('儲存編輯器內容失敗：', error);
            alert('內容儲存失敗，請檢查主控台。');
        });
    });
</script>

</body>
</html>