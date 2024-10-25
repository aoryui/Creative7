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

// 学科フィルタ
$selected_subject = isset($_GET['subject']) ? $_GET['subject'] : '';
if ($selected_subject !== '') {
    $sql .= " WHERE subject = '" . mysqli_real_escape_string($conn, $selected_subject) . "'";
}

// 総ユーザー数を取得
$total_result = $conn->query($sql);
$totaluser = $total_result->num_rows; // 総ユーザー数を取得

// ページネーションの処理
$itemsPerPage = 10; // 1ページあたりの表示件数
$totalPages = ceil($totaluser / $itemsPerPage); // 総ページ数

// 何ページ目かを取得(デフォは1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($totalPages, $page)); // ページ数を制限
$offset = ($page - 1) * $itemsPerPage; // データのオフセット

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
                echo "<tr><td colspan='4'>データがありません</td></tr>"; // カラム数を調整
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
