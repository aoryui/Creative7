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

// アクセスログを取得
$sql = "SELECT * FROM access_logs ORDER BY access_time DESC";
$result = $mysqli->query($sql);

// 許可されたIPアドレスを取得
$allowed_ips = [];
$sql_allowed = "SELECT ip_address, name, subnet_mask FROM allowed_ips";
$allowed_result = $mysqli->query($sql_allowed);
while ($row = $allowed_result->fetch_assoc()) {
    $allowed_ips[] = $row;
}

// サブネットマスク対応: IPアドレスがCIDR範囲内か判定する関数
function ip_in_subnet($ip, $subnet) {
    list($subnet_ip, $netmask) = explode('/', $subnet);
    $subnet_ip = ip2long($subnet_ip);
    $ip = ip2long($ip);
    $netmask = -1 << (32 - (int)$netmask);

    return ($ip & $netmask) == ($subnet_ip & $netmask);
}

// IPアドレスを手動で追加する
if (isset($_POST['add_ip'])) {
    $ip_to_add = $_POST['ip_address'];
    $subnet_mask_to_add = $_POST['subnet_mask']; // サブネットマスク
    $name_to_add = $mysqli->real_escape_string($_POST['name']);
    
    // 既に許可されているIPアドレスでないか確認
    $existing_ips = array_column($allowed_ips, 'ip_address');
    if (!in_array($ip_to_add, $existing_ips)) {
        $mysqli->query("INSERT INTO allowed_ips (ip_address, subnet_mask, name) VALUES ('$ip_to_add', '$subnet_mask_to_add', '$name_to_add')");
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// 許可を取り消す
if (isset($_POST['remove_ip'])) {
    $ip_to_remove = $_POST['ip_address'];
    $mysqli->query("DELETE FROM allowed_ips WHERE ip_address = '$ip_to_remove'");
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// 許可されたIPアドレスにaccess_logsから追加する
if (isset($_POST['allow_ip_from_logs'])) {
    $ip_to_allow = $_POST['ip_address'];
    // allowed_ipsテーブルに追加
    $existing_ips = array_column($allowed_ips, 'ip_address');
    if (!in_array($ip_to_allow, $existing_ips)) {
        $mysqli->query("INSERT INTO allowed_ips (ip_address) VALUES ('$ip_to_allow')");
    }
    // access_logsに記録したIPアドレスのaccess_statusを'許可'に変更
    $mysqli->query("UPDATE access_logs SET access_status = '許可' WHERE ip_address = '$ip_to_allow'");
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// 許可されたIPアドレスの名前を更新する
if (isset($_POST['update_name'])) {
    $ip_to_update = $_POST['ip_address'];
    $name_to_update = $mysqli->real_escape_string($_POST['name']);
    $mysqli->query("UPDATE allowed_ips SET name = '$name_to_update' WHERE ip_address = '$ip_to_update'");
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
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
        <input type="text" name="subnet_mask" placeholder="サブネットマスク（例: 118.17.181.0/24）">
        <input type="text" name="name" placeholder="名前（任意）">
        <button type="submit" name="add_ip">追加</button>
    </form>
</body>
</html>
