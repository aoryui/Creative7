<?php
// セッション情報を管理するスクリプトを読み込む
require_once __DIR__ . '/../backend/pre.php';

// セッションからユーザー情報を取得
$userid = $_SESSION['userid']; // ユーザーID
$username1 = $_SESSION['userName']; // ユーザー名
$subject = $_SESSION['subject']; // 科目情報
?>

<!DOCTYPE html>
<html lang="ja"> <!-- 言語を日本語に設定 -->
<head>
    <meta charset="UTF-8"> <!-- 文字コードをUTF-8に設定 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- レスポンシブデザイン対応 -->
    <!-- 外部CSSファイルを読み込み -->
    <link rel="stylesheet" href="../css/header_test.css">
    <!-- レスポンシブ用のCSS -->
    <link rel="stylesheet" href="../responsive/header_test.css">
    <!-- ファビコンを設定 -->
    <link rel="icon" type="../image/x-icon" href="../image/icon.png">
    <!-- ページタイトル -->
    <title>SPIタイサくんのページ</title>
</head>
<body>
<header>
    <?php
    // 現在のPHPファイルが "test.php" の場合、特定のロゴ画像を表示
    if (basename($_SERVER['PHP_SELF']) == 'test.php') { ?>
        <!-- ロゴ画像を表示 -->
        <img id="free-h1" src="../image/icon/headerlogo.png">
    <?php
    } else {
        // それ以外の場合は、メニューボタン付きのヘッダーを表示
    ?>
        <!-- メニューボタン -->
        <button id="menuBtn">
            <img id="menubutton" src="../image/menubutton.png" alt="ボタン画像">
        </button>
        <!-- ヘッダーロゴ -->
        <img id="free-h1" src="../image/icon/headerlogo.png">

        <!-- ナビゲーションメニュー -->
        <nav id="menuContent">
            <ul>
                <!-- 各ページへのリンク -->
                <li><a href="mypage.php">マイページへ</a></li>
                <li><a href="genre_selection.php">ジャンル選択画面へ</a></li>
                <li><a href="teststart.php">模擬試験開始画面へ</a></li>
                <li><a href="review.php">復習ページへ</a></li>
                <li><a href="ranking.php">ランキング</a></li>
                <?php
                // ゲストユーザーの場合、ログインリンクを表示
                if ($username === "ゲスト") {
                ?>
                    <li><a href="login.php">ログイン</a></li>
                <?php
                } else {
                    // ログイン済みユーザーの場合、ログアウトリンクを表示
                ?>
                    <li><a href="../backend/logout.php">ログアウト</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>

        <!-- JavaScriptでメニューの動作を制御 -->
        <script>
            // メニューボタンのクリックイベント
            document.getElementById("menuBtn").addEventListener("click", function() {
                var menu = document.getElementById("menuContent");
                // メニューの表示・非表示を切り替え
                if (menu.style.display === "block") {
                    menu.style.display = "none"; // メニューを閉じる
                } else {
                    menu.style.display = "block"; // メニューを開く
                }
            });

            // ページ全体のクリックイベント
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
