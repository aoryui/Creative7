<?php
require_once __DIR__ . '/../backend/pre.php';
$userid = $_SESSION['userid'];
$username1 = $_SESSION['userName'];
$subject = $_SESSION['subject'];
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
        <?php
        if (basename($_SERVER['PHP_SELF']) == 'test.php') {?>
            <h1 id="test-h1">SPIタイサくん</h1>
        <?php
        }
        else{
        ?>
        <button id="menuBtn">
            <img id="menubutton" src="../image/menubutton.png" alt="ボタン画像">
        </button>
        <img id="free-h1" src="../image/icon/headerlogo.png">
        <nav id="menuContent">
            <ul>
                <?php
                if ($username === "ゲスト") {
                ?>
                    <li><a href="login.php">マイページへ</a></li>
                <?php
                } else {
                ?>
                    <li><a href="mypage.php">マイページへ</a></li>
                <?php
                }
                ?>
                <li><a href="genre_selection.php">ジャンル選択画面へ</a></li>
                <li><a href="teststart.php">模擬試験開始画面へ</a></li>
                <li><a href="review.php">復習ページへ</a></li>
                <li><a href="ranking.php">ランキング</a></li>
                <li><a href="home.php">ホームに戻る</a></li>
                <?php
                if ($username === "ゲスト") {
                ?>
                    <li><a href="login.php">ログイン</a></li>
                <?php
                } else {
                ?>
                    <li><a href="../backend/logout.php">ログアウト</a></li>
                <?php
                }
                ?>
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
        <?php
        }
        ?>
</header>
</head>
</html>



