<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DIVE WORLD</title>
    <link rel="icon" href="asset/favicon.ico" type="image/x-icon" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="asset/style.css" />
    <link rel="stylesheet" type="text/css" href="asset/loading.css" />
</head>

<body>
    <div id="dive-app" class="container">
        <div class="loading" title="點擊後(全螢幕)並開始">
            <img class="ld ld-bounce" src="asset/loading.png" style="animation-duration:0.7s" />
            <img class="ld ld-bounce" src="asset/loading.png" style="animation-duration:1.5s" />
            <img class="ld ld-bounce" src="asset/loading.png" style="animation-duration:3.0s" />
        </div>
    </div>

    <!-- Dive Linker Script -->
    <script src="https://dive.nutn.edu.tw/Experiment/js/dive.linker.js"></script>

    <script>
        // 使用 PHP 傳遞的帳號設定 externalVariable
        <?php
        session_start();
        if (isset($_SESSION['username'])) {
            echo "let externalVariable = '" . $_SESSION['username'] . "';";
        } else {
            echo "let externalVariable = null;";
        }
        ?>

        // 檢查 externalVariable 並初始化 DiveWorld
        if (externalVariable) {
            console.log("External Variable Set: " + externalVariable);

            const map = [/* 這裡保留你的地圖參數 */];
            const preload_json = { /* 這裡保留你的預載參數 */ };

            // 初始化 DiveWorld 並設置外部變數
            const diveWorld = new DiveWorld(map, preload_json);
            diveWorld.updateInput("input", externalVariable);
        } else {
            console.error("External Variable 未設定！");
        }
    </script>

    <script src="asset/game.js"></script>
</body>

</html>
