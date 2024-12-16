<?php
require_once __DIR__ . '/../backend/pre.php';
require_once __DIR__ . '/../backend/class.php';

// セッション開始
session_start();

$dsn = 'mysql:dbname=creative7;host=localhost;charset=utf8';
$user = 'Creative7';
$password = '11111';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // メールアドレスがデータベースに存在するか確認
    $stmt = $dbh->prepare("SELECT COUNT(*) FROM userinfo WHERE email = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $exists = $stmt->fetchColumn();

    if ($exists) {
        // ランダムな4桁のコードを生成
        $verification_code = rand(1000, 9999);

        // 現在時刻から10分後の時刻を計算
        $expire_time = time() + 600; // 現在時刻 + 600秒（10分）
        $expire_time_formatted = date('m/d H:i', $expire_time); // フォーマット例: 12/16 10:22

        // セッションに保存（コードと生成時刻を保存）
        $_SESSION['verification_code'] = $verification_code;
        $_SESSION['verification_code_time'] = time(); // 現在のタイムスタンプを保存
        $_SESSION['email'] = $email;

        // メール内容の作成
        $mail_subject = '確認コード';
        $mail_body = "[セキュリティコード] $verification_code\n";
        $mail_body .= "[有効期限] $expire_time_formatted\n";
        $mail_headers = 'From: no-reply@yourdomain.com';

        // メールを送信
        mail($email, $mail_subject, $mail_body, $mail_headers);

        // 確認コード入力ページにリダイレクト
        header('Location: ../frontend/verify_code.php');
        exit();
    } else {
        // メールアドレスが登録されていない場合
        header('Location: ../frontend/email_verify.php?message=そのメールアドレスは登録されていません');
        exit();
    }
}
?>
