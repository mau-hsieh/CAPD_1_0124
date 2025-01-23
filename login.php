<?php
// 載入 config.php 並取得資料庫連線資訊
$config = include('config.php');

$servername = $config['servername'];
$username = $config['username'];
$password = $config['password'];
$dbname = $config['dbname'];

$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 處理登入
$login_error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // 查詢資料庫中的使用者
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // 取得使用者資料
        $user = $result->fetch_assoc();

        // 驗證密碼
        if (password_verify($input_password, $user['password'])) {
            // 密碼正確，登入成功
            // 設置 session 或其他登入相關操作
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // 回傳一段 JavaScript，儲存 username 到 localStorage
            echo "<script>
                localStorage.setItem('username', '" . $user['username'] . "');
                window.location.href = 'index.php';
            </script>";
            exit();
        } else {
            // 密碼錯誤
            $login_error = "密碼錯誤，請再試一次。";
        }
    } else {
        // 使用者不存在
        $login_error = "使用者名稱不存在。";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <title>使用者登入</title>
    <style>
        #mau_invisible {
            display: none;
        }

        #mau_dive {
            /*暫時將大小調低*/
            display: flex;
            flex: 1 1 auto;
            width: 50%;
            height: 50%;
            overflow: hidden;
        }

        .responsive-iframe {
            width: 100%;
            height: 100%;
            /* 根據需要調整這裡 */
            border: none;
            position: absolute;
        }
    </style>

</head>

<body>

    <div id="mau_invisible">
        <h1>登入頁面</h1>
        <?php
        // 動態生成 div 區塊的內容，可以從 PHP 變數中取得資料
        
        $texts = array(
            "這裡是變動的文字",
            "這裡是變動的文字",
            "這裡是變動的文字",
            "這裡是變動的文字",
            "這裡是變動的文字",
            "這裡是變動的文字",
            "這裡是變動的文字",
            "這裡是變動的文字",
            "這裡是變動的文字",
            "這裡是變動的文字",
            "這裡是變動的文字",
            "這裡是變動的文字",
            "這裡是變動的文字",
            "這裡是變動的文字",
            "這裡是變動的文字"
        );

        for ($i = 0; $i < count($texts); $i++) {
            echo '<div id="dynamicText0' . $i . '">' . $texts[$i] . '</div>';
        }

        ?>
        <!-- 顯示錯誤訊息 -->
        <?php if ($login_error): ?>
            <p style="color:red;"><?php echo $login_error; ?></p>
        <?php endif; ?>

        <!-- 登入表單 -->
        <form action="login.php" method="post">
            <label for="username">使用者名稱:</label>
            <input type="text" id="username" name="username" required>
            <br><br>
            <label for="password">密碼:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <button type="submit" id="submitBtn">登入</button>
        </form>

        <a href="register.php">還沒有帳號？點此註冊</a>

    </div>

    <iframe src="https://dive.nutn.edu.tw/Experiment/kaleTestExperiment5.jsp?eid=31826&record=false" name="dive"
        class="responsive-iframe">
    </iframe>
    <script src="https://dive.nutn.edu.tw/Experiment/js/dive.linker.js"></script>
    <script src="script00.js"></script>
</body>
<script>

</script>

</html>

<?php
// 關閉連接
$conn->close();
?>