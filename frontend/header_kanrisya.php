<?php
// ユーザーセッションの管理用スクリプトを読み込み
require_once __DIR__ . '/../backend/kanrisya_pre.php';

// ユーザーIDが特定の範囲（8桁の数値）に含まれるかを確認し、含まれている場合はログイン画面にリダイレクト
if ($userid >= 10000000 && $userid <= 99999999) {
    echo "<script>
            alert('ログインしてください'); // ログインを促すアラートを表示
            window.location.href = 'kanrisya_login.php'; // ログイン画面にリダイレクト
        </script>";
    exit();
}

// セッションからユーザーIDとユーザー名を取得
$userid = $_SESSION['userid'];
$username1 = $_SESSION['userName'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSSスタイルシートの読み込み -->
    <link rel="stylesheet" href="../css/header_kanrisya.css">
    <!-- ファビコンの設定 -->
    <link rel="icon" type="../image/x-icon" href="../image/icon.png" />
    <!-- ページのタイトル -->
    <title>SPIタイサくんのページ</title>
</head>
<body>
<header>
    <?php
    // 現在のPHPファイルが `test.php` の場合、特別なタイトルを表示
    if (basename($_SERVER['PHP_SELF']) == 'test.php') { ?>
        <h1 id="test-h1">SPIタイサくん</h1>
    <?php } else { ?>
        <!-- メニューボタン -->
        <button id="menuBtn">
            <img id="menubutton" src="../image/menubutton2.png" alt="ボタン画像">
        </button>
        <!-- ロゴ画像 -->
        <img id="free-h1" src="../image/icon/headerlogogreen.png">

        <!-- ナビゲーションメニュー -->
        <nav id="menuContent">
            <ul>
                <!-- 各メニュー項目 -->
                <li><a href="kanrisya_management.php">利用者管理</a></li>
                <li><a href="restrictions.php">アクセス制限</a></li>
                <li><a href="kanrisya.php">ユーザー情報一覧</a></li>
                <li><a href="question_list.php">問題一覧</a></li>
                <li><a href="generator_test.php">画像作成</a></li>
                <li><a href="question_insert.php">問題作成</a></li>
                <li><a href="user_opinion.php">ユーザーの意見欄</a></li>
                <?php
                // ユーザー名が "ゲスト" の場合、ログインリンクを表示
                if ($username === "ゲスト") {
                ?>
                    <li><a href="kanrisya_login.php">ログイン</a></li>
                <?php
                } else {
                    // それ以外の場合はログアウトリンクを表示
                ?>
                    <li><a href="../backend/logout.php">ログアウト</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>

        <!-- メニュー開閉スクリプト -->
        <script>
            // メニューボタンがクリックされたときのイベントリスナー
            document.getElementById("menuBtn").addEventListener("click", function() {
                var menu = document.getElementById("menuContent");
                // メニューの表示・非表示を切り替える
                if (menu.style.display === "block") {
                    menu.style.display = "none"; // 非表示に設定
                } else {
                    menu.style.display = "block"; // 表示に設定
                }
            });

            // ページ全体でクリックイベントを監視
            document.addEventListener('click', function(event) {
                // メニューボタン以外の場所がクリックされた場合
                if (!document.getElementById('menuBtn').contains(event.target)) {
                    document.getElementById('menuContent').style.display = 'none'; // メニューを非表示に設定
                }
            });
        </script>
    <?php } ?>
</header>
</body>
</html>

