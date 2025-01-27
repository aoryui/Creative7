<?php
session_start(); // セッションを開始

// データベース接続情報
$host = 'mysql1.php.starfree.ne.jp';  // ホスト名
$user = 'creative7_jun';  // ユーザー名
$password = 'eL6VKCZh';  // パスワード
$dbname = 'creative7_creative7';  // データベース名

// ヘッダーの読み込み
require_once __DIR__ . '/header_kanrisya.php'; // 管理者用ヘッダーを読み込む

// MySQLiでデータベース接続
$mysqli = new mysqli($host, $user, $password, $dbname);

// 接続確認
if ($mysqli->connect_error) {
    die("接続に失敗しました: " . $mysqli->connect_error);  // 接続失敗時のエラーメッセージ
}

// アクセスログを取得するSQLクエリ
$sql = "SELECT * FROM access_logs ORDER BY access_time DESC";  // ログをアクセス日時順に並べる
$result = $mysqli->query($sql);  // SQLクエリを実行して結果を取得

// 許可されたIPアドレスを取得するSQLクエリ
$allowed_ips = [];  // 許可されたIPアドレスを格納する配列
$sql_allowed = "SELECT ip_address, name, subnet_mask FROM allowed_ips";  // IPアドレス、名前、サブネットマスクを取得する
$allowed_result = $mysqli->query($sql_allowed);  // SQLクエリを実行して結果を取得

// 許可されたIPアドレスを配列に格納
while ($row = $allowed_result->fetch_assoc()) {
    $allowed_ips[] = $row;  // 許可されたIPアドレス情報を配列に追加
}

// サブネットマスク対応: IPアドレスがCIDR範囲内か判定する関数
function ip_in_subnet($ip, $subnet) {
    list($subnet_ip, $netmask) = explode('/', $subnet);  // サブネットとネットマスクを分割
    $subnet_ip = ip2long($subnet_ip);  // サブネットIPを長整数に変換
    $ip = ip2long($ip);  // 引数のIPアドレスを長整数に変換
    $netmask = -1 << (32 - (int)$netmask);  // ネットマスクをビット演算で計算

    return ($ip & $netmask) == ($subnet_ip & $netmask);  // IPがサブネット範囲内かどうかを判定
}

// IPアドレスを手動で追加する処理
if (isset($_POST['add_ip'])) {
    $ip_to_add = $_POST['ip_address'];  // 追加するIPアドレス
    $subnet_mask_to_add = $_POST['subnet_mask'];  // 追加するサブネットマスク
    $name_to_add = $mysqli->real_escape_string($_POST['name']);  // 追加する名前（SQLインジェクション対策）

    // 既に許可されているIPアドレスが存在するかチェック
    $existing_ips = array_column($allowed_ips, 'ip_address');  // 許可されたIPアドレスの配列を取得
    if (!in_array($ip_to_add, $existing_ips)) {  // 追加しようとするIPが既に存在しない場合
        $mysqli->query("INSERT INTO allowed_ips (ip_address, subnet_mask, name) VALUES ('$ip_to_add', '$subnet_mask_to_add', '$name_to_add')");  // 新しいIPを許可リストに追加
    }
    header('Location: ' . $_SERVER['PHP_SELF']);  // 現在のページにリダイレクト
    exit;
}

// 許可を取り消す処理
if (isset($_POST['remove_ip'])) {
    $ip_to_remove = $_POST['ip_address'];  // 削除するIPアドレス
    $mysqli->query("DELETE FROM allowed_ips WHERE ip_address = '$ip_to_remove'");  // 許可リストから削除
    header('Location: ' . $_SERVER['PHP_SELF']);  // 現在のページにリダイレクト
    exit;
}

// アクセスログから許可されたIPアドレスを追加する処理
if (isset($_POST['allow_ip_from_logs'])) {
    $ip_to_allow = $_POST['ip_address'];  // 許可するIPアドレス
    // 許可リストに追加
    $existing_ips = array_column($allowed_ips, 'ip_address');  // 既存のIPアドレスを取得
    if (!in_array($ip_to_allow, $existing_ips)) {  // 追加するIPが許可リストにない場合
        $mysqli->query("INSERT INTO allowed_ips (ip_address) VALUES ('$ip_to_allow')");  // 許可リストにIPを追加
    }
    // アクセスログの状態を'許可'に更新
    $mysqli->query("UPDATE access_logs SET access_status = '許可' WHERE ip_address = '$ip_to_allow'");
    header('Location: ' . $_SERVER['PHP_SELF']);  // 現在のページにリダイレクト
    exit;
}

// 許可されたIPアドレスの名前を更新する処理
if (isset($_POST['update_name'])) {
    $ip_to_update = $_POST['ip_address'];  // 更新するIPアドレス
    $name_to_update = $mysqli->real_escape_string($_POST['name']);  // 更新する名前（SQLインジェクション対策）
    $mysqli->query("UPDATE allowed_ips SET name = '$name_to_update' WHERE ip_address = '$ip_to_update'");  // 名前を更新
    header('Location: ' . $_SERVER['PHP_SELF']);  // 現在のページにリダイレクト
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/restrictions.css">  <!-- スタイルシートを読み込む -->
    <title>アクセス制御画面</title>  <!-- ページタイトル -->
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
            <?php while ($row = $result->fetch_assoc()): ?>  <!-- アクセスログを表示 -->
                <tr>
                    <td><?php echo $row['ip_address']; ?></td>  <!-- IPアドレス -->
                    <td><?php echo $row['access_time']; ?></td>  <!-- アクセス日時 -->
                    <td><?php echo $row['access_status']; ?></td>  <!-- アクセス状態 -->
                    <?php if ($row['access_status'] == '拒否'): ?>  <!-- 拒否状態の場合 -->
                        <td>
                            <form method="POST">
                                <input type="hidden" name="ip_address" value="<?php echo $row['ip_address']; ?>">  <!-- IPアドレスを隠しフィールドに -->
                                <button type="submit" name="allow_ip_from_logs">追加</button>  <!-- 追加ボタン -->
                            </form>
                        </td>
                    <?php else: ?>
                        <td>追加済</td>  <!-- すでに許可されている場合 -->
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
            <?php foreach ($allowed_ips as $allowed_ip): ?>  <!-- 許可されたIPを表示 -->
                <tr>
                    <td><?php echo $allowed_ip['ip_address']; ?></td>  <!-- IPアドレス -->
                    <td>
                        <form method="POST">
                            <input type="hidden" name="ip_address" value="<?php echo $allowed_ip['ip_address']; ?>">  <!-- IPアドレスを隠しフィールドに -->
                            <input type="text" name="name" value="<?php echo htmlspecialchars($allowed_ip['name']); ?>" placeholder="名前を編集">  <!-- 名前編集フォーム -->
                            <button type="submit" name="update_name">更新</button>  <!-- 更新ボタン -->
                        </form>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="ip_address" value="<?php echo $allowed_ip['ip_address']; ?>">  <!-- IPアドレスを隠しフィールドに -->
                            <button type="submit" name="remove_ip">削除</button>  <!-- 削除ボタン -->
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>手動でIPアドレスを許可</h2>
    <form method="POST">
        <input type="text" name="ip_address" required placeholder="IPアドレスを入力">  <!-- IPアドレス入力フォーム -->
        <input type="text" name="subnet_mask" placeholder="サブネットマスク（例: 118.17.181.0/24）">  <!-- サブネットマスク入力フォーム -->
        <input type="text" name="name" placeholder="名前（任意）">  <!-- 名前入力フォーム -->
        <button type="submit" name="add_ip">追加</button>  <!-- 追加ボタン -->
    </form>
</body>
</html>
