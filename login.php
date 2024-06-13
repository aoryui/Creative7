<?php
session_start();

// ログインフォームが送信された場合
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username === 'user' && $password === '12345') {
        $_SESSION['logged_in'] = true;
        // リクエストされたページがあれば、そのページにリダイレクト
        if(isset($_SESSION['requested_page'])) {
            header("Location: {$_SESSION['requested_page']}");
            exit;
        } else {
            header("Location: /home.html");
            exit;
        }
    } else {
        $error_message = "パスワードが違います";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>ログイン画面</title>
</head>
<body>

<?php if(isset($error_message)) { ?>
    <p><?php echo $error_message; ?></p>
<?php } ?>

<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br>
    <input type="submit" value="Login">
</form>

<form action="/logout.php" method="post">
    <input type="submit" value="ログアウト">
  </form>

</body>
</html>