<?php
require_once __DIR__ . '/header_kanrisya.php'; //ヘッダー指定
require_once __DIR__ . '/../backend/class.php';
$form = new form();
require_once __DIR__ . '/../backend/pre.php';
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テキストから画像へ</title>
    <link rel="stylesheet" href="../css/kanrisya_management.css">
</head>
<body>
    <div class="border-frame">
    <div class="flex-inner" data-box-color="white">
            <h2>利用者管理一覧</h2>
    <a href="kanrisya.php"><img src="../image/icon/kanrisya.png" class="kanrisya" id="png" alt="ユーザー情報一覧"></a>
    <a href="question_list.php"><img src="../image/icon/problem.png" id="png" alt="問題一覧"></a>
    <a href="generator_test.php"><img src="../image/icon/test-icon.png" id="png" alt="画像作成"></a>
    <a href="question_insert.php"><img src="../image/icon/sinki.png" id="png" alt="問題作成"></a>
    <a href="user_opinion.php"><img src="../image/icon/users_6.png" id="png" alt="ユーザー意見欄"></a>
    <a href="ここにリンク先.php"><img src="../image/icon/access-lock.png" id="png" alt="アクセス制限"></a>
    <div>
    <p class="left1">ユーザー情報一覧</p>
    <p class="left2">問題一覧</p>
    <p class="left3">画像作成</p>
    <p class="left4">問題作成</p>
    <p class="left5">ユーザー意見欄</p>
    <p class="left6">アクセス制限</p>
    </div>
    </div>
</body>

</html>