<?php
require_once __DIR__ . '/pre.php';
require_once __DIR__ . '/database/class.php';
require_once __DIR__ . '/database/dbdata.php';

// POSTされた現在のパスワードと新しいパスワードを取得
$form = new form();
$info = $form->getInfo($userid);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $inputpass = $_POST['old_password'];
    $newPass = $_POST['new_password'];
    $newpasswordhash = password_hash($newPass, PASSWORD_DEFAULT);
    if (password_verify($inputpass, $info['password'])) {
        // パスワードの更新
        $form->getpass($userid, $newpasswordhash);
        echo "パスワードが正常に更新されました。";
        header("Location: login.php?message=" . urlencode("パスワードが正常に更新されました"));
        exit();
    } else {
        echo "パスワードが違います";
        header("Location: passchange.php?message=" . urlencode("パスワードが違います"));
        exit();
    }
} else {
    echo "必要なデータが送信されていません。";
}


exit();
