<?php
require_once __DIR__ . '/../backend/kanrisya_pre.php';
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
        <h1 id="free-h1">SPIタイサくん・管理者画面</h1>
        <nav id="menuContent">
            <ul>
                    <li><a href="home.php">ホーム画面</a></li>
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
</header>
</head>
</html>


