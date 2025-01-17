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
<link rel="stylesheet" href="../responsive/header.css">
<link rel="icon" type="../image/x-icon" href="../image/icon.png" />
<title>SPIタイサくんのページ</title>
<header>
        <?php
        if (basename($_SERVER['PHP_SELF']) == 'test.php') {?>
            <img id="free-h1" src="../image/icon/headerlogo.png">
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
                <li><a href="mypage.php">マイページ</a></li>
                <li><a href="genre_selection.php">ジャンル選択画面</a></li>
                <li><a href="teststart.php">模擬試験開始画面</a></li>
                <li><a href="review.php">復習ページ</a></li>
                <li><a href="ranking.php">ランキング</a></li>
                <li><a href="question_ranking.php">問題ランキング</a></li>
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



