<?php
require_once __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="./css/mogisiken.css">
</head>
<body>
    <main>
        <div class="honbanmain">
            <div class="container">
                <div class="content">
                    <p>ランダムで想定された問題が20個出題されます。
                    <p></p>
                       問題は1問30秒です。
                    <p></p>
                       時間までに解いてください。
                    <p></p>
                       時間が過ぎると次の問題に自動的に飛ばされます。</p>
                    <p></p>
                    メモ用紙と筆記用具を用意してください。
                </div>
                <div class="button-container">
                    <input type="button" onclick="location.href='./test.php'" value="模擬試験を開始する">
                </div>
            </div>
        </div>
    </main>
</body>
</html>








