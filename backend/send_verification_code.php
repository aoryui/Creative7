    <?php
require_once __DIR__ . '/../backend/pre.php';
require_once __DIR__ . '/../backend/class.php';

// セッション開始
session_start();

$dsn = 'mysql:dbname=creative7;host=localhost;charset=utf8';
$user = 'Creative7';
$password = '11111';
// $dsn = 'mysql:dbname=creative7_creative7;host=mysql1.php.starfree.ne.jp;charset=utf8';
// $user = 'creative7_jun';
// $password = 'eL6VKCZh';
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

        // セッションに保存
        $_SESSION['verification_code'] = $verification_code;
        $_SESSION['email'] = $email;

        // メールを送信 (メール送信ライブラリなどを使用)
        mail($email, '確認コード', "あなたの確認コードは: $verification_code", 'From: no-reply@yourdomain.com');

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
