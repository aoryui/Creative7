<?php
// 管理者ヘッダーを読み込み
require_once __DIR__ . '/header_kanrisya.php';

// データベース接続情報
$host = 'localhost'; // ホスト名
$username = 'Creative7'; // データベースユーザー名
$password = '11111'; // データベースパスワード
$database = 'creative7'; // データベース名

// データベースに接続
$conn = mysqli_connect($host, $username, $password, $database);

// 接続エラーがあれば終了
if (!$conn) {
    die('データベースに接続できませんでした: ' . mysqli_connect_error());
}

// 新規登録者数のカウント
$newUsersCount = 0; // 初期化
$sqlNewUsers = "SELECT COUNT(*) as new_users FROM userinfo"; // 新規登録者数を取得するSQLクエリ
$newUsersResult = $conn->query($sqlNewUsers);

// 結果があれば、新規登録者数を変数に格納
if ($newUsersResult && $row = $newUsersResult->fetch_assoc()) {
    $newUsersCount = $row['new_users'];
}

// ユーザー情報を取得するSQLクエリ
$sql = "SELECT userid, username, subject, email, password, last_login FROM userinfo";

// 学科フィルタ処理（GETで選択された学科で絞り込み）
$selected_subject = isset($_GET['subject']) ? $_GET['subject'] : ''; // 送信された学科名を取得
if ($selected_subject !== '') {
    // SQLインジェクション対策のため、入力値をエスケープ
    $sql .= " WHERE subject = '" . mysqli_real_escape_string($conn, $selected_subject) . "'";
}

// ユーザー数を取得
$total_result = $conn->query($sql); // クエリ実行
$totaluser = $total_result->num_rows; // ユーザー数

// ページネーションの設定
$itemsPerPage = 10; // 1ページに表示するアイテム数
$totalPages = ceil($totaluser / $itemsPerPage); // 総ページ数
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // 現在のページ番号（デフォルトは1）
$page = max(1, min($totalPages, $page)); // ページ番号が範囲外の場合に修正
$offset = ($page - 1) * $itemsPerPage; // OFFSETの計算

// LIMIT句を追加して、取得するデータを制限
$sql .= " LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($sql); // 実行して結果を取得
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

    <!-- 新規登録者数を表示するボックス -->
    <div class="new-users-box">
        <span class="icon">👤</span>
        <span>総新規登録者数: <span class="count"><?php echo $newUsersCount; ?></span> 人</span>
    </div>

    <!-- 学科フィルタフォーム -->
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

    <!-- ユーザー情報を表示するテーブル -->
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
            // データが存在する場合は、ユーザー情報をテーブルに表示
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // データを安全に表示するためにhtmlspecialcharsでエスケープ
                    $userid = htmlspecialchars($row['userid']);
                    $username = htmlspecialchars($row['username']);
                    $subject = htmlspecialchars($row['subject']);
                    $email = htmlspecialchars($row['email']);
                    $last_login = htmlspecialchars($row['last_login']);

                    echo "<tr>";
                    echo "<td><a href='user.php?userid={$userid}'>{$username}</a></td>"; // ユーザー名リンク
                    echo "<td>{$subject}</td>";
                    echo "<td>{$email}</td>";
                    echo "<td>{$last_login}</td>";
                    echo "</tr>";
                }
            } else {
                // データがなければ「データがありません」と表示
                echo "<tr><td colspan='4'>データがありません</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- ページネーション -->
    <div class="pagination">
        <!-- 前のページへのリンク（最初のページなら非表示） -->
        <a href="?page=<?php echo $page - 1; ?>&subject=<?php echo urlencode($selected_subject); ?>" class="prev <?php echo ($page <= 1) ? 'hidden' : ''; ?>">&laquo; 前</a>

        <!-- 各ページへのリンク -->
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&subject=<?php echo urlencode($selected_subject); ?>" class="<?php echo ($i == $page) ? 'current-page' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <!-- 次のページへのリンク（最後のページなら非表示） -->
        <a href="?page=<?php echo $page + 1; ?>&subject=<?php echo urlencode($selected_subject); ?>" class="next <?php echo ($page >= $totalPages) ? 'hidden' : ''; ?>">次 &raquo;</a>
    </div>
</div>

</body>
</html>
