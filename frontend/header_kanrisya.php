<?php
require_once __DIR__ . '/../backend/kanrisya_pre.php';

if ($userid >= 10000000 && $userid <= 99999999) {
    echo "<script>
            alert('ログインしてください');
            window.location.href = 'kanrisya_login.php';
        </script>";
    exit();
}
$userid = $_SESSION['userid'];
$username1 = $_SESSION['userName'];
?>

<!DOCTYPE html>
<head>
<html lang="ja">
<meta charset="UTF-8">    
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/header_kanrisya.css">
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
            <img id="menubutton" src="../image/menubutton2.png" alt="ボタン画像">
        </button>
        <img id="free-h1" src="../image/icon/headerlogogreen.png">
        <nav id="menuContent">
            <ul>
                
                <li><a href="kanrisya_management.php">利用者管理</a></li>
                <li><a href="restrictions.php">アクセス制限</a></li>
                <li><a href="kanrisya.php">ユーザー情報一覧</a></li>
                <li><a href="question_list.php">問題一覧</a></li>
                <li><a href="generator_test.php">画像作成</a></li>
                <li><a href="question_insert.php">問題作成</a></li>
                <li><a href="user_opinion.php">ユーザーの意見欄</a></li>
                <?php
                if ($username === "ゲスト") {
                ?>
                    <li><a href="kanrisya_login.php">ログイン</a></li>
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



