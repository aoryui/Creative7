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
    <title>就活タイサくんのページ</title>
    <link rel="stylesheet" href="css/main.css">
    <header>
        <h1>就活タイサくん</h1>
    </header>
</head>

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

