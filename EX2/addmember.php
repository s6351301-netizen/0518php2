<?php
$success = isset($_GET['success']);
$error = isset($_GET['error']);
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員註冊</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(180deg, #d7edff 0%, #b7d8ff 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #3b3b3b;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .page-wrap {
            width: min(1200px, 100%);
            background: rgba(255, 255, 255, 0.95);
            border-radius: 25px;
            box-shadow: 0 18px 60px rgba(16, 76, 159, 0.12);
            overflow: hidden;
        }

        .top-area {
            display: grid;
            grid-template-columns: minmax(280px, 1fr) minmax(280px, 1fr);
            gap: 20px;
            padding: 36px;
        }

        .panel {
            border-radius: 20px;
            padding: 28px;
            min-height: 320px;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(255, 179, 0, 0.14);
        }

        .left-panel {
            background: rgba(204, 230, 255, 0.85);
        }

        .panel h2 {
            margin-top: 0;
            color: #ff9800;
            font-size: 1.9rem;
        }

        .panel p,
        .panel li {
            color: #ffb74d;
            line-height: 1.75;
        }

        .panel ul {
            margin: 18px 0 0;
            padding-left: 20px;
        }

        .panel ul li {
            margin-bottom: 12px;
        }

        .right-panel {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: rgba(255, 244, 214, 0.95);
        }

        .table-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 24px;
            box-shadow: inset 0 0 0 1px rgba(255, 179, 0, 0.16);
            flex: 1;
        }

        .table-card h3 {
            margin: 0 0 18px;
            color: #f57c00;
        }

        .table-card table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-card th,
        .table-card td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #f3e0c6;
        }

        .table-card th {
            color: #ff9800;
            font-size: 0.95rem;
        }

        .table-card td {
            color: #555;
            font-weight: 600;
        }

        .form-area {
            padding: 0 36px 36px;
        }

        .form-area h2 {
            margin: 0 0 18px;
            color: #ff9800;
            font-size: 2rem;
        }

        .form-area form {
            display: grid;
            gap: 18px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-row {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-row label {
            color: #ff9800;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .form-row input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid #b3d4ff;
            background: #f6fbff;
            font-size: 1rem;
            color: #333;
        }

        .form-row input:focus {
            outline: none;
            border-color: #ff9800;
            box-shadow: 0 0 0 4px rgba(255, 152, 0, 0.12);
            background: #fff9e6;
        }

        .form-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 10px;
        }

        .btn {
            flex: 1;
            min-width: 140px;
            padding: 14px 18px;
            border: none;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-submit {
            background: #ff9800;
            color: #fff;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(255, 152, 0, 0.24);
        }

        .btn-reset {
            background: #ffffff;
            color: #ff9800;
            border: 2px solid #ffb74d;
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(255, 183, 77, 0.18);
        }

        .alert {
            border-radius: 14px;
            padding: 16px 20px;
            font-weight: 700;
            margin-bottom: 18px;
            box-shadow: 0 8px 22px rgba(57, 73, 171, 0.08);
        }

        .alert.success {
            background: #e8f9e9;
            color: #2e7d32;
            border: 1px solid #b7dfb7;
        }

        .alert.error {
            background: #fff6e8;
            color: #bf360c;
            border: 1px solid #ffcc80;
        }

        @media (max-width: 920px) {
            .top-area {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="page-wrap">
        <div class="top-area">
            <div class="panel left-panel">
                <h2>註冊系統說明</h2>
                <p>這是一個簡易會員註冊系統，使用者可透過下方表單輸入帳號、密碼與個人資料，送出後即儲存至資料庫。</p>
                <ul>
                    <li>建立一個資料表來存放使用者的帳號、密碼及個人資料</li>
                    <li>建立一個網頁表單可以讓使用者輸入自己的帳號、密碼及個人資料</li>
                    <li>送出表單後可以將使用者的資料存入資料表</li>
                </ul>
            </div>

            <div class="panel right-panel">
                <div class="table-card">
                    <h3>資料表設計 - members</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>欄位</th>
                                <th>說明</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>id</td>
                                <td>自動編號</td>
                            </tr>
                            <tr>
                                <td>account</td>
                                <td>使用者帳號</td>
                            </tr>
                            <tr>
                                <td>password</td>
                                <td>使用者密碼</td>
                            </tr>
                            <tr>
                                <td>tel</td>
                                <td>電話</td>
                            </tr>
                            <tr>
                                <td>birthday</td>
                                <td>生日</td>
                            </tr>
                            <tr>
                                <td>email</td>
                                <td>電子郵件</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-area">
            <?php if ($success): ?>
                <div class="alert success">註冊成功，資料已儲存！</div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert error">請填寫所有欄位，並重新送出表單。</div>
            <?php endif; ?>

            <h2>會員註冊表單</h2>

            <form action="api_register.php" method="post">
                <div class="form-grid">
                    <div class="form-row">
                        <label for="account">帳號 *</label>
                        <input type="text" id="account" name="account" placeholder="請輸入帳號" required>
                    </div>
                    <div class="form-row">
                        <label for="password">密碼 *</label>
                        <input type="password" id="password" name="password" placeholder="請輸入密碼" required>
                    </div>
                    <div class="form-row">
                        <label for="email">電子郵件 *</label>
                        <input type="email" id="email" name="email" placeholder="請輸入信箱" required>
                    </div>
                    <div class="form-row">
                        <label for="tel">電話 *</label>
                        <input type="tel" id="tel" name="tel" placeholder="請輸入電話" required>
                    </div>
                    <div class="form-row">
                        <label for="birthday">生日 *</label>
                        <input type="date" id="birthday" name="birthday" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-submit">註冊</button>
                    <button type="reset" class="btn btn-reset">重置</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
