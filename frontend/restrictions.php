<?php
session_start();

$host = 'mysql1.php.starfree.ne.jp';
$user = 'creative7_jun';
$password = 'eL6VKCZh';
$dbname = 'creative7_creative7';
require_once __DIR__ . '/header_kanrisya.php'; //ヘッダー指定

// MySQLiで接続
$mysqli = new mysqli($host, $user, $password, $dbname);

// 接続確認
if ($mysqli->connect_error) {
    die("接続に失敗しました: " . $mysqli->connect_error);
}

// 1ページに表示するログの件数
$logs_per_page = 10;

// 現在のページ番号を取得
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // 1未満を防ぐ

// 総ログ数を取得
$sql_count = "SELECT COUNT(*) AS total FROM access_logs";
$total_result = $mysqli->query($sql_count);
$total_logs = $total_result->fetch_assoc()['total'];

// 総ページ数を計算
$total_pages = ceil($total_logs / $logs_per_page);

// ページ番号の表示範囲を設定
$range = 10;

// データ取得の開始位置を計算
$offset = ($page - 1) * $logs_per_page;

// 表示するログを取得
$sql_logs = "SELECT * FROM access_logs ORDER BY access_time DESC LIMIT $logs_per_page OFFSET $offset";
$result = $mysqli->query($sql_logs);

// 許可されたIPアドレスを取得
$allowed_ips = [];
$sql_allowed = "SELECT ip_address, name FROM allowed_ips";
$allowed_result = $mysqli->query($sql_allowed);
while ($row = $allowed_result->fetch_assoc()) {
    $allowed_ips[] = $row;
}

// 以下の関数や処理は省略（省略箇所は既存コードと同様）
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/restrictions.css">
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

    <!-- ページングナビゲーション -->
    <div class="pagination">
        <?php
        // "<<" 最初のページへのリンク
        if ($page > 1): ?>
            <a href="?page=1"><<</a>
        <?php endif; ?>

        <!-- "<" 前のページへのリンク -->
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

        <!-- ">" 次のページへのリンク -->
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>">></a>
        <?php endif; ?>

        <!-- ">>" 最後のページへのリンク -->
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
                        <form method="POST">
                            <input type="hidden" name="ip_address" value="<?php echo $allowed_ip['ip_address']; ?>">
                            <input type="text" name="name" value="<?php echo htmlspecialchars($allowed_ip['name']); ?>" placeholder="名前を編集">
                            <button type="submit" name="update_name">更新</button>
                        </form>
                    </td>
                    <td>
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
    <form method="POST">
        <input type="text" name="ip_address" required placeholder="IPアドレスを入力">
        <input type="text" name="name" placeholder="名前（任意）">
        <input type="text" name="cidr" placeholder="CIDR（例: 118.17.181.0/24）">
        <button type="submit" name="add_ip">追加</button>
    </form>
</body>
</html>
