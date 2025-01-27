<?php
session_start(); // セッション開始

// データベース接続情報
$host = 'mysql1.php.starfree.ne.jp';
$user = 'creative7_jun';
$password = 'eL6VKCZh';
$dbname = 'creative7_creative7';

// ヘッダーのインクルード
require_once __DIR__ . '/header_kanrisya.php'; // 管理者用ヘッダーを読み込む

// MySQLiでデータベースに接続
$mysqli = new mysqli($host, $user, $password, $dbname);

// 接続確認
if ($mysqli->connect_error) {
    die("接続に失敗しました: " . $mysqli->connect_error); // 接続エラーの場合、エラーメッセージを表示
}

// アクセスログを取得するクエリ
$sql = "SELECT * FROM access_logs ORDER BY access_time DESC";
$result = $mysqli->query($sql); // クエリ実行

// 許可されたIPアドレスを取得するクエリ
$allowed_ips = [];
$sql_allowed = "SELECT ip_address, name FROM allowed_ips";
$allowed_result = $mysqli->query($sql_allowed);

// 許可されたIPアドレスを配列に格納
while ($row = $allowed_result->fetch_assoc()) {
    $allowed_ips[] = $row; // IPアドレスと名前を格納
}

// IPアドレスを手動で追加する処理
if (isset($_POST['add_ip'])) {
    $ip_to_add = $_POST['ip_address']; // フォームから入力されたIPアドレス
    $name_to_add = $mysqli->real_escape_string($_POST['name']); // 名前をエスケープ処理して取得

    // 既に許可されているIPアドレスでないか確認
    $existing_ips = array_column($allowed_ips, 'ip_address');
    if (!in_array($ip_to_add, $existing_ips)) {
        // 新しいIPアドレスをallowed_ipsテーブルに追加
        $mysqli->query("INSERT INTO allowed_ips (ip_address, name) VALUES ('$ip_to_add', '$name_to_add')");
    }
    header('Location: ' . $_SERVER['PHP_SELF']); // 自分自身のページにリダイレクト
    exit; // 処理終了
}

// IPアドレスの許可を取り消す処理
if (isset($_POST['remove_ip'])) {
    $ip_to_remove = $_POST['ip_address']; // 削除するIPアドレス
    $mysqli->query("DELETE FROM allowed_ips WHERE ip_address = '$ip_to_remove'"); // 許可リストから削除
    header('Location: ' . $_SERVER['PHP_SELF']); // 自分自身のページにリダイレクト
    exit; // 処理終了
}

// アクセスログから許可されたIPアドレスをallowed_ipsに追加する処理
if (isset($_POST['allow_ip_from_logs'])) {
    $ip_to_allow = $_POST['ip_address']; // ログから許可するIPアドレス
    // 既存の許可リストにIPが含まれていないか確認
    $existing_ips = array_column($allowed_ips, 'ip_address');
    if (!in_array($ip_to_allow, $existing_ips)) {
        $mysqli->query("INSERT INTO allowed_ips (ip_address) VALUES ('$ip_to_allow')"); // 新しいIPを追加
    }
    // access_logsテーブルのアクセス状態を'許可'に変更
    $mysqli->query("UPDATE access_logs SET access_status = '許可' WHERE ip_address = '$ip_to_allow'");
    header('Location: ' . $_SERVER['PHP_SELF']); // 自分自身のページにリダイレクト
    exit; // 処理終了
}

// 許可されたIPアドレスの名前を更新する処理
if (isset($_POST['update_name'])) {
    $ip_to_update = $_POST['ip_address']; // 更新するIPアドレス
    $name_to_update = $mysqli->real_escape_string($_POST['name']); // 更新する名前
    $mysqli->query("UPDATE allowed_ips SET name = '$name_to_update' WHERE ip_address = '$ip_to_update'"); // 名前を更新
    header('Location: ' . $_SERVER['PHP_SELF']); // 自分自身のページにリダイレクト
    exit; // 処理終了
}

// 1ページに表示するログの件数
$logs_per_page = 10;

// 現在のページ番号を取得、デフォルトは1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // 1未満のページ番号を防止

// 総ログ数を取得するクエリ
$sql_count = "SELECT COUNT(*) AS total FROM access_logs";
$total_result = $mysqli->query($sql_count);
$total_logs = $total_result->fetch_assoc()['total']; // 総ログ数

// 総ページ数を計算
$total_pages = ceil($total_logs / $logs_per_page);

// ページ番号の表示範囲を設定
$range = 10; // 表示するページリンクの数

// データ取得の開始位置を計算
$offset = ($page - 1) * $logs_per_page;

// 表示するログを取得するクエリ
$sql_logs = "SELECT * FROM access_logs ORDER BY access_time DESC LIMIT $logs_per_page OFFSET $offset";
$result = $mysqli->query($sql_logs); // クエリ実行
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/restrictions.css"> <!-- スタイルシートのリンク -->
    <title>アクセス制御画面</title>
</head>
<body>
    <h2>アクセスログ</h2>
    <table border="1">
        <thead>
            <tr>
                <th>IPアドレス</th>
                <th>アクセス日時</th>
                <th>アクセス状態</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['ip_address']; ?></td>
                    <td><?php echo $row['access_time']; ?></td>
                    <td><?php echo $row['access_status']; ?></td>
                    <?php if ($row['access_status'] == '拒否'): ?>
                        <td>
                            <!-- 拒否されたIPアドレスを許可するフォーム -->
                            <form method="POST">
                                <input type="hidden" name="ip_address" value="<?php echo $row['ip_address']; ?>">
                                <button type="submit" name="allow_ip_from_logs">追加</button>
                            </form>
                        </td>
                    <?php else: ?>
                        <td>追加済</td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php
        // 最初のページへのリンク
        if ($page > 1): ?>
            <a href="?page=1"><<</a>
        <?php endif; ?>

        <!-- 前のページへのリンク -->
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>"><</a>
        <?php endif; ?>

        <?php
        // ページリンクの範囲を計算
        $start = max(1, $page - floor($range / 2));
        $end = min($total_pages, $start + $range - 1);
        
        if ($end - $start + 1 < $range) {
            $start = max(1, $end - $range + 1);
        }

        // ページリンクを表示
        for ($i = $start; $i <= $end; $i++) {
            echo $i == $page 
                ? "<strong>$i</strong> " 
                : "<a href='?page=$i'>$i</a> ";
        }
        ?>

        <!-- 次のページへのリンク -->
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>">></a>
        <?php endif; ?>

        <!-- 最後のページへのリンク -->
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $total_pages; ?>">>></a>
        <?php endif; ?>
    </div>

    <h2>許可されたIPアドレス</h2>
    <table border="1">
        <thead>
            <tr>
                <th>IPアドレス</th>
                <th>名前</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allowed_ips as $allowed_ip): ?>
                <tr>
                    <td><?php echo $allowed_ip['ip_address']; ?></td>
                    <td>
                        <!-- 許可されたIPアドレスの名前を編集するフォーム -->
                        <form method="POST">
                            <input type="hidden" name="ip_address" value="<?php echo $allowed_ip['ip_address']; ?>">
                            <input type="text" name="name" value="<?php echo htmlspecialchars($allowed_ip['name']); ?>" placeholder="名前を編集">
                            <button type="submit" name="update_name">更新</button>
                        </form>
                    </td>
                    <td>
                        <!-- 許可されたIPアドレスを削除するフォーム -->
                        <form method="POST">
                            <input type="hidden" name="ip_address" value="<?php echo $allowed_ip['ip_address']; ?>">
                            <button type="submit" name="remove_ip">削除</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>手動でIPアドレスを許可</h2>
    <!-- IPアドレスを手動で追加するフォーム -->
    <form method="POST">
        <input type="text" name="ip_address" required placeholder="IPアドレスを入力">
        <input type="text" name="name" placeholder="名前（任意）">
        <button type="submit" name="add_ip">追加</button>
    </form>
</body>
</html>
