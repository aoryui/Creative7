<?php
require_once __DIR__ . '/pre.php';

$userid = $_SESSION['userid'];
$username = $_SESSION['userName'];
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="image/icon1.ico" />

</head>

<body>
    <header>
        <button id="menuBtn">
            <img id="menubutton" src="image/menubutton.png" alt="ボタン画像">
        </button>
        <nav id="menuContent">
            <ul>
                <?php
                if ($username === "ゲスト") {
                ?>
                    <li><a href="login.php">ログインページへ</a></li>
                <?php
                } else {
                ?>
                    <li><a href="mypage.php">マイページへ</a></li>
                <?php
                }
                ?>
                <li><a href="rule.php">利用規約へ</a></li>
            </ul>
        </nav>
        <h1>KD愛.CONNECT</h1>
        <script>
            document.getElementById("menuBtn").addEventListener("click", function() {
                var menu = document.getElementById("menuContent");
                if (menu.style.display === "block") {
                    menu.style.display = "none";
                } else {
                    menu.style.display = "block";
                }
            });
            document.addEventListener('click', function(event) { //全体にクリックイベントを設定
                if (!document.getElementById('menuBtn').contains(event.target)) { // メニューバー以外をクリックしたとき
                    document.getElementById('menuContent').style.display = 'none'; // メニューバーを閉じる
                }
            });
        </script>
    </header>