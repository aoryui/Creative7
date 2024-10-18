<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../backend/class.php';
$form = new form();
require_once __DIR__ . '/../backend/pre.php';
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}

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
$sql = "SELECT username, subject, email, password FROM userinfo";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者画面</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>ユーザー情報一覧</h2>

<form method="GET" action="">
    <label for="subject">学科でソート:</label>
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
            <th>パスワード</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // データベースから情報を取得し、ソート条件を追加
        $sql = "SELECT username, subject, email, password FROM userinfo";
        
        // ユーザーがプルダウンで学科を選択した場合にソート
        if (isset($_GET['subject']) && $_GET['subject'] !== '') {
            $selected_subject = $_GET['subject'];
            $sql .= " WHERE subject = '" . mysqli_real_escape_string($conn, $selected_subject) . "'";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // データを出力
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>データがありません</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>