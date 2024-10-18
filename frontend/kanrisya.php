<?php
require_once __DIR__ . '/header_kanrisya.php';
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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffefd5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: calc(100px + 30px);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #333;
        }

        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        select, button {
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 1em;
        }

        button {
            background-color: #27acd9;
            color: white;
            border: none;
            margin-left: 10px;
            cursor: pointer;
        }

        button:hover {
            background-color: #27acd9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 15px;
            }

            form {
                flex-direction: column;
                align-items: center;
            }

            select, button {
                width: 100%;
                margin-bottom: 10px;
            }

            table {
                font-size: 0.9em;
            }
        }
    </style>
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
                <th>パスワード</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ソート条件に基づいてデータベースから情報を取得
            $sql = "SELECT username, subject, email, password FROM userinfo";
            
            if (isset($_GET['subject']) && $_GET['subject'] !== '') {
                $selected_subject = $_GET['subject'];
                $sql .= " WHERE subject = '" . mysqli_real_escape_string($conn, $selected_subject) . "'";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // データをテーブルに出力
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
</div>

</body>
</html>