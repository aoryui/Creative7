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

// 新規登録者数をカウント
$newUsersCount = 0; // 初期化
$sqlNewUsers = "SELECT COUNT(*) as new_users FROM userinfo";
$newUsersResult = $conn->query($sqlNewUsers);

if ($newUsersResult && $row = $newUsersResult->fetch_assoc()) {
    $newUsersCount = $row['new_users'];
}

// データベースから情報を取得
$sql = "SELECT userid, username, subject, email, password, last_login FROM userinfo";

// 学科フィルタ
$selected_subject = isset($_GET['subject']) ? $_GET['subject'] : '';
if ($selected_subject !== '') {
    $sql .= " WHERE subject = '" . mysqli_real_escape_string($conn, $selected_subject) . "'";
}

// 総ユーザー数を取得
$total_result = $conn->query($sql);
$totaluser = $total_result->num_rows;

// ページネーションの処理
$itemsPerPage = 10;
$totalPages = ceil($totaluser / $itemsPerPage);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($totalPages, $page));
$offset = ($page - 1) * $itemsPerPage;

// LIMIT句を追加して、データを取得
$sql .= " LIMIT $itemsPerPage OFFSET $offset";
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
    
    <!-- 独自の新規登録者数ボックス -->
    <div class="new-users-box">
        <span class="icon">👤</span>
        <span>総新規登録者数: <span class="count"><?php echo $newUsersCount; ?></span> 人</span>
    </div>

    <!-- 検索フォームとテーブル表示部分はそのまま -->
    <form method="GET" action="">
        <label for="subject">学科で検索:</label>
        <select id="subject" name="subject">
            <option value="">全て</option>
            <option value="ITエキスパート学科" <?php echo $selected_subject === 'ITエキスパート学科' ? 'selected' : ''; ?>>ITエキスパート学科</option>
            <option value="ITスペシャリスト学科" <?php echo $selected_subject === 'ITスペシャリスト学科' ? 'selected' : ''; ?>>ITスペシャリスト学科</option>
            <option value="情報処理学科" <?php echo $selected_subject === '情報処理学科' ? 'selected' : ''; ?>>情報処理学科</option>
            <option value="AIシステム開発学科" <?php echo $selected_subject === 'AIシステム開発学科' ? 'selected' : ''; ?>>AIシステム開発学科</option>
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
                echo "<tr><td colspan='4'>データがありません</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- ページネーション -->
    <div class="pagination">
        <a href="?page=<?php echo $page - 1; ?>&subject=<?php echo urlencode($selected_subject); ?>" class="prev <?php echo ($page <= 1) ? 'hidden' : ''; ?>">&laquo; 前</a>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&subject=<?php echo urlencode($selected_subject); ?>" class="<?php echo ($i == $page) ? 'current-page' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <a href="?page=<?php echo $page + 1; ?>&subject=<?php echo urlencode($selected_subject); ?>" class="next <?php echo ($page >= $totalPages) ? 'hidden' : ''; ?>">次 &raquo;</a>
    </div>
</div>

</body>
</html>
