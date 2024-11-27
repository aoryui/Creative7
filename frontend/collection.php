<?php
session_start(); // セッションを開始
require_once __DIR__ . '/header.php';
$servername = "localhost";
$username = "Creative7";
$password = "11111";
$dbname = "creative7";

// DB接続
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ユーザーID (例: セッションなどから取得)
$userid = $_SESSION['userid']; // セッションからユーザーIDを取得

// 所有バッジ取得
$badge_query = "
    SELECT bc.badge_file 
    FROM owned_badge ob
    JOIN badge_collections bc ON ob.badge_id = bc.badge_id
    WHERE ob.userid = $userid
";


$result = $conn->query($badge_query);

$owned_badges = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $owned_badges[] = $row['badge_file'] . ".png"; // .png を追加
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>バッジ一覧ページ</title>
    <link rel="stylesheet" href="../css/collection.css">
</head>
<body>
<div class="collection-container">
    <table>
        <tr>
            <td><img id="badgeimg1" class="<?= in_array("badge1.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge1.png"></td>
            <td><img id="badgeimg2" class="<?= in_array("badge2.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge2.png"></td>
            <td><img id="badgeimg3" class="<?= in_array("badge3.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge3.png"></td>
            <td><img id="badgeimg4" class="<?= in_array("badge4.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge4.png"></td>
            <td><img id="badgeimg5" class="<?= in_array("badge5.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge5.png"></td>
        </tr>
        <tr>
            <td><img id="badgeimg6" class="<?= in_array("badge6.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge6.png"></td>
            <td><img id="badgeimg7" class="<?= in_array("badge7.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge7.png"></td>
            <td><img id="badgeimg8" class="<?= in_array("badge8.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge8.png"></td>
            <td><img id="badgeimg9" class="<?= in_array("badge9.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge9.png"></td>
            <td><img id="badgeimg10" class="<?= in_array("badge10.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge10.png"></td>
        </tr>
        <tr>
            <td><img id="badgeimg11" class="<?= in_array("badge11.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge11.png"></td>
            <td><img id="badgeimg12" class="<?= in_array("badge12.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge12.png"></td>
            <td><img id="badgeimg13" class="<?= in_array("badge13.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge13.png"></td>
            <td><img id="badgeimg14" class="<?= in_array("badge14.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge14.png"></td>
            <td><img id="badgeimg15" class="<?= in_array("badge15.png", $owned_badges) ? "owned-badge" : "unowned-badge"; ?>" src="../image/icon/badge15.png"></td>
        </tr>
    </table>
</div>
<script>
<?php for ($i = 1; $i <= 15; $i++): ?>//1から15まで繰り返し
    const image<?= $i; ?> = document.getElementById('badgeimg<?= $i; ?>'); // 元画像

    image<?= $i; ?>.addEventListener('mouseover', () => {//カーソルが画像にあったとき
        image<?= $i; ?>.src = `../image/icon/badgemission<?= $i; ?>.png`; // 条件表示されてる画像
        image<?= $i; ?>.style.filter = "contrast(100%)";//コントラスト100%
    });

    <?php if (in_array("badge{$i}.png", $owned_badges)): ?>//バッジを所持しているかの比較
        image<?= $i; ?>.addEventListener('mouseout', () => {//バッジを持っていてカーソルが画像を離れたとき
            image<?= $i; ?>.src = `../image/icon/badge<?= $i; ?>.png`; // 元の画像に戻す
            image<?= $i; ?>.style.filter = "contrast(100%)";//コントラスト100%
        });
    <?php else: ?>
        image<?= $i; ?>.addEventListener('mouseout', () => {//バッジを持っていなくてカーソルが画像を離れたとき
            image<?= $i; ?>.src = `../image/icon/badge<?= $i; ?>.png`; // 元の画像に戻す
            image<?= $i; ?>.style.filter = "contrast(30%)";//コントラスト30%
        });
    <?php endif; ?>
<?php endfor; ?>
</script>

</body>
</html>
