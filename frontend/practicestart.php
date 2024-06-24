<?php
require_once __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="../css/practicestart.css">
</head>
<body>
    <main>
        <div class="practicestartmain">
            <div class="container">
                <div class="content">
                    <p>ランダムで想定された問題が10個出題されます。</p>
                    <p></p>
                       時間までに解いてください。
                    <p></p>
                       時間が過ぎると次の問題に自動的に飛ばされます。</p>
                    <p></p>
                    メモ用紙と筆記用具を用意してください。
                </div>
                <div class="button-container">
                    <input type="button" onclick="location.href='./pracice.php'" value="練習問題を開始する">
                </div>
            </div>
        </div>
    </main>
</body>
</html>