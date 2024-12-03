<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_code = $_POST['verification_code'];

    if ($input_code == $_SESSION['verification_code']) {
        // 成功した場合、パスワード変更ページに遷移
        header('Location: ../frontend/change_password.php');
        exit();
    } else {
        // 失敗した場合
        header('Location: ../frontend/verify_code.php?message=確認コードが正しくありません');
        exit();
    }
}
?>
