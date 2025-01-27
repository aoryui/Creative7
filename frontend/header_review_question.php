<?php
// ユーザー情報のセッション管理を行うスクリプトを読み込む
require_once __DIR__ . '/../backend/pre.php';

// セッションから現在のユーザー情報を取得
$userid = $_SESSION['userid']; // 現在ログイン中のユーザーID
$username1 = $_SESSION['userName']; // ユーザー名
$subject = $_SESSION['subject']; // 現在の科目情報
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSSファイルを読み込む -->
    <link rel="stylesheet" href="../css/header_review_question.css">
    <!-- レスポンシブデザイン用のCSS -->
    <link rel="stylesheet" href="../responsive/header_review_question.css">
    <!-- ファビコンの設定 -->
    <link rel="icon" type="../image/x-icon" href="../image/icon.png">
    <!-- ページタイトル -->
    <title>SPIタイサくんのページ</title>
</head>
<body>
<header>
    <?php
    // 現在のPHPファイル名が "test.php" の場合、特定のロゴを表示
    if (basename($_SERVER['PHP_SELF']) == 'test.php') { ?>
        <!-- 特定のロゴ画像を表示 -->
        <img id="free-h1" src="../image/icon/headerlogo.png">
    <?php
    } else {
        // その他の場合はメニュー付きのヘッダーを表示
    ?>
        <!-- メニューボタン -->
        <button id="menuBtn">
            <img id="menubutton" src="../image/menubutton.png" alt="ボタン画像">
        </button>
        <!-- ヘッダーロゴ画像 -->
        <img id="free-h1" src="../image/icon/headerlogo.png">

        <!-- ナビゲーションメニュー -->
        <nav id="menuContent">
            <ul>
                <!-- 各メニュー項目 -->
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
                    // ゲスト以外の場合、ログアウトリンクを表示
                ?>
                    <li><a href="../backend/logout.php">ログアウト</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>

        <!-- メニューボタンの動作を制御するJavaScript -->
        <script>
            // メニューボタンがクリックされたときのイベント
            document.getElementById("menuBtn").addEventListener("click", function() {
                var menu = document.getElementById("menuContent");
                // メニューの表示・非表示を切り替える
                if (menu.style.display === "block") {
                    menu.style.display = "none"; // メニューを非表示
                } else {
                    menu.style.display = "block"; // メニューを表示
                }
            });

            // ページ全体でクリックイベントを監視
            document.addEventListener('click', function(event) {
                // メニューボタン以外の部分がクリックされた場合
                if (!document.getElementById('menuBtn').contains(event.target)) {
                    document.getElementById('menuContent').style.display = 'none'; // メニューを非表示にする
                }
            });
        </script>
    <?php
    }
    ?>
</header>
</body>
</html>
