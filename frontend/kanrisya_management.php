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
<div class="login-container">

    <div class="introduce-container1">        
    <img src="../image/icon/kanrisya.png" class="kanrisya1">       
    <div class="kanrisyakanri">ユーザー情報一覧</div>
    <button class="button1" onclick="window.location.href='kanrisya.php'"></button>

    <div class="introduce-container2">
    <img src="../image/icon/test-icon.png" class="kanrisya2">
    <div class="problem">画像作成</div>
    <button class="button2" onclick="window.location.href='generator_test.php'"></button>

    <div class="introduce-container3">
    <img src="../image/icon/sinki.png" class="kanrisya3">
    <div class="problem">問題作成</div>
    <button class="button2" onclick="window.location.href='question_list.php'"></button>
    </div>





</div>

    




</div>
</body>

</html>