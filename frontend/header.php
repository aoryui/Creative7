<?php
// セッション情報を管理するスクリプトを読み込む
require_once __DIR__ . '/../backend/pre.php';

// セッションからユーザー情報を取得
$userid = $_SESSION['userid']; // ユーザーID
$username1 = $_SESSION['userName']; // ユーザー名
$subject = $_SESSION['subject']; // 現在選択されている科目
?>

<!DOCTYPE html>
<html lang="ja"> <!-- HTML文書の言語を日本語に設定 -->
<head>
    <meta charset="UTF-8"> <!-- 文字エンコーディングをUTF-8に設定 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- レスポンシブデザイン対応 -->
    <!-- 共通のCSSファイルを読み込む -->
    <link rel="stylesheet" href="../css/header.css">
    <!-- レスポンシブ用CSSを読み込む -->
    <link rel="stylesheet" href="../responsive/header.css">
    <!-- ファビコンを設定 -->
    <link rel="icon" type="../image/x-icon" href="../image/icon.png">
    <!-- ページタイトル -->
    <title>SPIタイサくんのページ</title>
</head>
<body>
<header>
    <?php
    // 現在のPHPファイルが "test.php" の場合、ロゴ画像を表示
    if (basename($_SERVER['PHP_SELF']) == 'test.php') { ?>
        <img id="free-h1" src="../image/icon/headerlogo.png"> <!-- ロゴ画像 -->
    <?php
    } else {
        // それ以外のページではメニューボタン付きのヘッダーを表示
    ?>
        <button id="menuBtn"> <!-- メニューボタン -->
            <img id="menubutton" src="../image/menubutton.png" alt="ボタン画像"> <!-- メニューボタン画像 -->
        </button>
        <img id="free-h1" src="../image/icon/headerlogo.png"> <!-- ロゴ画像 -->

        <!-- ナビゲーションメニュー -->
        <nav id="menuContent">
            <ul>
                <!-- 各ページへのリンク -->
                <li><a href="mypage.php">マイページ</a></li>
                <li><a href="genre_selection.php">ジャンル選択画面</a></li>
                <li><a href="teststart.php">模擬試験開始画面</a></li>
                <li><a href="review.php">復習ページ</a></li>
                <li><a href="ranking.php">ランキング</a></li>
                <li><a href="question_ranking.php">問題ランキング</a></li>
                <?php
                // ユーザーが「ゲスト」の場合
                if ($username === "ゲスト") {
                ?>
                    <li><a href="login.php">ログイン</a></li> <!-- ログインページへのリンク -->
                <?php
                } else {
                    // ログイン済みユーザーの場合
                ?>
                    <li><a href="../backend/logout.php">ログアウト</a></li> <!-- ログアウト用リンク -->
                <?php
                }
                ?>
            </ul>
        </nav>

        <!-- JavaScriptでメニューの開閉を制御 -->
        <script>
            // メニューボタンをクリックしたときのイベント
            document.getElementById("menuBtn").addEventListener("click", function() {
                var menu = document.getElementById("menuContent"); // メニューのDOM要素を取得
                // メニューの表示状態を切り替え
                if (menu.style.display === "block") {
                    menu.style.display = "none"; // メニューを閉じる
                } else {
                    menu.style.display = "block"; // メニューを開く
                }
            });

            // ページ全体にクリックイベントを設定
            document.addEventListener('click', function(event) {
                // メニューボタン以外をクリックした場合
                if (!document.getElementById('menuBtn').contains(event.target)) {
                    document.getElementById('menuContent').style.display = 'none'; // メニューを閉じる
                }
            });
        </script>
    <?php
    }
    ?>
</header>
</body>
</html>
