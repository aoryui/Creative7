<?php
session_start(); // セッションの開始
require_once __DIR__ . '/header.php'; // ヘッダーファイルを読み込み
require_once __DIR__ . '/../backend/class.php'; // クラスファイルを読み込み

$form = new form(); // formクラスのインスタンス作成
$userid = $_SESSION['userid']; // セッションからログイン中のユーザーIDを取得

// 1ページ目にアクセスした場合、またはランキングがまだセッションに保存されていない場合、データベースからランキングを取得
if (!isset($_GET['page']) || $_GET['page'] == 1) {
    $rankings = $form->getRanking(); // ランキングを取得
    $_SESSION['rankings'] = $rankings; // ランキングをセッションに保存
} else {
    // 2ページ目以降はセッションからランキングを取得
    $rankings = $_SESSION['rankings'];
}

// ランキングの手動更新処理
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rankings = $form->getRanking(); // ランキングを再取得
    $_SESSION['rankings'] = $rankings; // セッションに更新されたランキングを保存
    // 現在のページにリダイレクト
    header("Location: " . $_SERVER['REQUEST_URI']); // 現在のページにリダイレクト
    exit();
}

// ページネーションの処理
$itemsPerPage = 10; // 1ページあたりに表示する項目数
$totalRankings = count($rankings); // ランキングデータの総数
$totalPages = ceil($totalRankings / $itemsPerPage); // 総ページ数を計算

// 現在のページ番号を取得（デフォルトは1ページ目）
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($totalPages, $page)); // ページ番号の範囲を調整

// 表示するランキングを決める処理
$startIndex = ($page - 1) * $itemsPerPage; // 表示開始インデックス
$paginatedRankings = array_slice($rankings, $startIndex, $itemsPerPage); // ページごとのランキングを取得

// ログイン中のユーザーのランキングを取り出す
$index = null; // ユーザーのインデックスを初期化
foreach ($rankings as $key => $value) {
    if ($value['userid'] === $userid) { // ログイン中のユーザーIDと一致するランキングを探す
        $index = $key;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPIタイサくん</title>
    <link rel="stylesheet" href="../css/ranking.css"> <!-- ランキングページ用のCSS -->
    <link rel="stylesheet" href="../responsive/ranking.css"> <!-- レスポンシブデザイン用のCSS -->
</head>

<body>
    <div class="border-frame">
        <!-- ユーザーのランキングを表示 -->
        <?php 
        echo '<div class="ranking-header">';
        echo '    <p id="ranking">';
        echo '        <img src="../image/icon/rank_icon.png" class="ranking_icon"> ランキング';
        echo '    </p>';
        echo '    <a href="question_ranking.php" class="stylish-link">間違えやすい問題ランキングはこちら</a>';
        echo '</div>';
        echo '<div id="user_data">';
        if ($index !== null) { // ログインユーザーがランキングに存在する場合
            $user = $rankings[$index]; // ユーザーのランキングデータを取得
            $user_rank = $user['rank']; // ユーザーの順位
            $user_score = $user['score']; // ユーザーの総獲得経験値
            echo '<p id="precedence">あなたの順位は: <span style="color: red; font-size: 24px; font-weight: bold;">' . $user_rank . '位</span> です</p>';
            echo '<p id="total">総獲得経験値: <span style="color: black; font-size: 24px; font-weight: bold;"> ' . $user_score . '</span></p>';
        } else {
            echo "ランキングに登録するにはログインする必要があります"; // ログインしていない場合
        }
        echo '</div>';
        ?>

        <!-- ランキングを手動で更新 -->
        <form method="post">
            <div id="ranking_update">
                <div id="update_text">ランキングの更新</div>
                <button type="submit" name="update" class="update-button">
                    <img src="../image/icon/reload.png" alt="更新">
                </button>
            </div>
        </form>

        <!-- ランキングテーブル -->
        <table border="1" id="table">
            <tr>
                <th>順位</th>
                <th>ユーザ名</th>
                <th>総獲得経験値</th>
            </tr>
            <?php foreach ($paginatedRankings as $ranking): ?>
            <tr class="<?php 
                // 1~3位は行に色を付ける
                if ($ranking['rank'] == 1){
                    echo 'first-place">'; 
                    echo '<td>';
                    echo '<img src="../image/crown1.png" alt="1位" class="crown-icon">'; // 1位の王冠アイコン
                    echo '</td>';
                }elseif ($ranking['rank'] == 2){
                    echo 'second-place">'; 
                    echo '<td>';
                    echo '<img src="../image/crown2.png" alt="2位" class="crown-icon">'; // 2位の王冠アイコン
                    echo '</td>';
                }elseif ($ranking['rank'] == 3){
                    echo 'third-place">'; 
                    echo '<td>';
                    echo '<img src="../image/crown3.png" alt="3位" class="crown-icon">'; // 3位の王冠アイコン
                    echo '</td>';
                }else{
                    echo 'below-place">'; // 1~3位以外は通常の色
                    echo '<td>';
                    echo '<span>'.htmlspecialchars($ranking['rank'], ENT_QUOTES, 'UTF-8').'</span>';
                    echo '</td>';
                }
            ?>
                <td><?php echo htmlspecialchars($ranking['username'], ENT_QUOTES, 'UTF-8'); ?></td> <!-- ユーザー名 -->
                <td><?php echo htmlspecialchars($ranking['score'], ENT_QUOTES, 'UTF-8'); ?></td> <!-- ユーザーの総獲得経験値 -->
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- ページネーション -->
        <div class="pagination">
            <a href="?page=<?php echo $page - 1; ?>" class="prev <?php echo ($page <= 1) ? 'hidden' : ''; ?>">&laquo; 前</a> <!-- 前のページリンク -->

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'current-page' : ''; ?>"><?php echo $i; ?></a> <!-- ページ番号リンク -->
            <?php endfor; ?>

            <a href="?page=<?php echo $page + 1; ?>" class="next <?php echo ($page >= $totalPages) ? 'hidden' : ''; ?>">次 &raquo;</a> <!-- 次のページリンク -->
        </div>
    </div>
</body>
</html>
