<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_code = $_POST['verification_code'];

    // セッションから確認コードと生成時刻を取得
    $saved_code = isset($_SESSION['verification_code']) ? $_SESSION['verification_code'] : null;

    // セッションから保存された時間を取得
    if (isset($_SESSION['verification_code_time'])) {
        $verification_code_time = $_SESSION['verification_code_time'];
        $current_time = time();  // 現在の時刻

        // 現在時刻と保存された時刻の差分を計算
        $time_diff = $current_time - $verification_code_time;

        // コードが一致するか確認
        if ($input_code == $saved_code) {
            // 10分以内（600秒）の場合は有効、それ以上の場合は無効
            if ($time_diff <= 600) {
                // 成功した場合、パスワード変更ページに遷移
                unset($_SESSION['verification_code']);
                unset($_SESSION['verification_code_time']);
                header('Location: ../frontend/change_password.php');
                exit();
            } else {
                // 有効期限切れ
                unset($_SESSION['verification_code']);
                unset($_SESSION['verification_code_time']);
                header('Location: ../frontend/email_verify.php?message=確認コードの有効期限が切れています。再送信してください。');
                exit();
            }
        } else {
            // コードが一致しない場合
            header('Location: ../frontend/verify_code.php?message=確認コードが正しくありません');
            exit();
        }
        
    } else {
        header('Location: ../frontend/email_verify.php?message=確認コードが保存されていません再度メールアドレスを入力してください');
            exit();
    }
}
?>
