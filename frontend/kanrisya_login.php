<?php
session_start();

$host = "localhost";
$user = "Creative7";
$password = "11111";
$dbname = "creative7";

// MySQLiで接続
$mysqli = new mysqli($host, $user, $password, $dbname);

// 接続確認
if ($mysqli->connect_error) {
    die("接続に失敗しました: " . $mysqli->connect_error);
}

// 現在のIPアドレスを取得
$ip_address = $_SERVER['REMOTE_ADDR'];

// `allowed_ips`テーブルから、現在のIPアドレスが許可されているかをチェック
$sql_check = "SELECT * FROM allowed_ips WHERE ip_address = ?";
$stmt_check = $mysqli->prepare($sql_check);
$stmt_check->bind_param("s", $ip_address);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

// `allowed_ips`にない場合、アクセスを拒否し、`access_logs`に`拒否`として記録
if ($result_check->num_rows == 0) {
    // アクセスログを記録（拒否）
    $access_status = '拒否'; // 拒否された場合
    $access_time = date("Y-m-d H:i:s"); // 現在の日時

    // `access_logs`に挿入（拒否されたアクセス）
    $sql = "INSERT INTO access_logs (ip_address, access_time, access_status) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $ip_address, $access_time, $access_status);
    $stmt->execute();

    // アクセス拒否メッセージ
    die("アクセスが拒否されました。管理者に連絡してください。");
}

// アクセスログを記録（許可）
$access_status = '許可'; // 許可されたIPアドレスのため、'allowed'に設定
$access_time = date("Y-m-d H:i:s"); // 現在の日時

// ログを`access_logs`テーブルに挿入（アクセスログ記録）
$sql = "INSERT INTO access_logs (ip_address, access_time, access_status) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $ip_address, $access_time, $access_status);
$stmt->execute();

// データベース接続終了
$stmt->close();
?>
<?php
require_once __DIR__ . '/header_login_signup.php';
?>
<!DOCTYPE html>
<link rel="stylesheet" href="../css/kanrisya_login.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="login-body">
<div class="login-container">
<div class="login-ji">
<h1>管理者ログイン</h1>
</div>
<!-- ログインフォーム -->
<?php
if (isset($_SESSION['login_error'])) {
    $loginError = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>

<script>
    window.onload = function() {
        const loginError = "<?php echo $loginError; ?>";
        if (loginError) {
            alert(loginError);
        }
    };
</script>

<form action="../backend/kanrisya_login_db.php" method="post" class="form-group">
    <div class="form-group">
        <label for="username">メールアドレス</label>
        <input type="text" id="username" name="username" required />
    </div>
    <div class="form-group">
        <label for="password">パスワード</label>
        <input type="password" id="password" name="password" required />
    </div>
    <button type="submit" id="login">ログイン</button>
</form>
<div class="signup button">
<p><a href="kanrisya_signup.php"><br>管理者の新規登録はこちら</a></p>
</div>
</div>
</html>
