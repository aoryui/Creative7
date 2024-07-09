<?php
require_once __DIR__ . '/../backend/pre.php';
$userid = $_SESSION['userid'];
$username = $_SESSION['userName'];
?>

<!DOCTYPE html>
<head>
<html lang="ja">
<meta charset="UTF-8">    
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/header.css">
<link rel="icon" type="../image/x-icon" href="../image/icon.png" />
<title>SPIタイサくんのページ</title>
<header>

        <button id="menuBtn">
            <img id="menubutton" src="../image/menubutton.png" alt="ボタン画像">
        </button>
<h1>SPIタイサくん</h1>
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
                <li><a href="index.php">質問一覧ページへ</a></li>
                <li><a href="seikabutuitirann.php">成果物一覧ページへ</a></li>
                <li><a href="otoiawase.php">お問い合わせページへ</a></li>
                <li><a href="rule.php">利用規約へ</a></li>
            </ul>
            </nav>
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
</head>
</html>



