<?php
require_once __DIR__ . '/header_kanrisya.php';

// データベースに接続するための情報
$host = 'localhost';
$username = 'Creative7';
$password = '11111';
$database = 'creative7';

// データベースに接続
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die('データベースに接続できませんでした: ' . mysqli_connect_error());
}

// データベースから情報を取得
$sql = "SELECT userid, username, subject, email, password, last_login FROM userinfo"; // last_login を追加

if (isset($_GET['subject']) && $_GET['subject'] !== '') {
    $selected_subject = $_GET['subject'];
    $sql .= " WHERE subject = '" . mysqli_real_escape_string($conn, $selected_subject) . "'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<link rel="stylesheet" href="../css/kanrisya.css">
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者画面</title>
</head>
<body>

<div class="container">
    <h2>ユーザー情報一覧</h2>

    <form method="GET" action="">
        <label for="subject">学科で検索:</label>
        <select id="subject" name="subject">
            <option value="">全て</option>
            <option value="ITエキスパート学科">ITエキスパート学科</option>
            <option value="ITスペシャリスト学科">ITスペシャリスト</option>
            <option value="情報処理学科">情報処理学科</option>
            <option value="AIシステム開発学科">AIシステム開発学科</option>
        </select>
        <button type="submit">ソート</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ユーザー名</th>
                <th>科目</th>
                <th>メールアドレス</th>
                <th>最終ログイン</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // データをテーブルに出力
                while($row = $result->fetch_assoc()) {
                    $userid = htmlspecialchars($row['userid']);
                    $username = htmlspecialchars($row['username']);
                    $subject = htmlspecialchars($row['subject']);
                    $email = htmlspecialchars($row['email']);
                    $last_login = htmlspecialchars($row['last_login']);

                    echo "<tr>";
                    echo "<td><a href='user.php?userid={$userid}'>{$username}</a></td>";
                    echo "<td>{$subject}</td>";
                    echo "<td>{$email}</td>";
                    echo "<td>{$last_login}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>データがありません</td></tr>"; // カラム数を調整
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
