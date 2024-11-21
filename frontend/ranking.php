<?php
session_start();
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../backend/class.php';

$form = new form();
$userid = $_SESSION['userid'];

// 1ページ目にアクセスした場合、またはランキングがまだセッションに保存されていない場合、データベースから取得
if (!isset($_GET['page']) || $_GET['page'] == 1) {
    $rankings = $form->getRanking();
    $_SESSION['rankings'] = $rankings; // セッションにランキングを保存
} else {
    // 2ページ目以降はセッションからランキングを取得
    $rankings = $_SESSION['rankings'];
}

// ランキングの手動更新処理
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rankings = $form->getRanking();
    $_SESSION['rankings'] = $rankings;
    // 現在のページにリダイレクト
    header("Location: " . $_SERVER['REQUEST_URI']); // 現在のページにリダイレクト
    exit();
}

//ページネーションの処理
$itemsPerPage = 10;
$totalRankings = count($rankings);
$totalPages = ceil($totalRankings / $itemsPerPage);

// 何ページ目かを取得(デフォは1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($totalPages, $page));

// 表示するランキングを決める処理
$startIndex = ($page - 1) * $itemsPerPage;
$paginatedRankings = array_slice($rankings, $startIndex, $itemsPerPage);

// ログイン中のユーザーのランキングを取り出す
$index = null;
foreach ($rankings as $key => $value) {
    if ($value['userid'] === $userid) {
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
    <link rel="stylesheet" href="../css/ranking.css">
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
        if ($index !== null) {
            $user = $rankings[$index];
            $user_rank = $user['rank'];
            $user_score = $user['score'];
            echo '<p id="precedence">あなたの順位は: <span style="color: red; font-size: 24px; font-weight: bold;">' . $user_rank . '位</span> です</p>';
            echo '<p id="total">総獲得経験値: <span style="color: black; font-size: 24px; font-weight: bold;"> ' . $user_score . '</span></p>';
        } else {
            echo "ランキングに登録するにはログインする必要があります";
        }
        echo '</div>'
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
                    echo '<img src="../image/crown1.png" alt="1位" class="crown-icon">';
                    //echo '<span>'.htmlspecialchars($ranking['rank'], ENT_QUOTES, 'UTF-8').'</span>';
                    echo '</td>';
                }elseif ($ranking['rank'] == 2){
                    echo 'second-place">'; 
                    echo '<td>';
                    echo '<img src="../image/crown2.png" alt="2位" class="crown-icon">';
                    //echo '<span>'.htmlspecialchars($ranking['rank'], ENT_QUOTES, 'UTF-8').'</span>';
                    echo '</td>';
                }elseif ($ranking['rank'] == 3){
                    echo 'third-place">'; 
                    echo '<td>';
                    echo '<img src="../image/crown3.png" alt="3位" class="crown-icon">';
                    //echo '<span>'.htmlspecialchars($ranking['rank'], ENT_QUOTES, 'UTF-8').'</span>';
                    echo '</td>';
                }else{
                    echo 'below-place">';
                    echo '<td>';
                    echo '<span>'.htmlspecialchars($ranking['rank'], ENT_QUOTES, 'UTF-8').'</span>';
                    echo '</td>';
                }
            ?>
                <td><?php echo htmlspecialchars($ranking['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($ranking['score'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- ページネーション -->
        <div class="pagination">
    <a href="?page=<?php echo $page - 1; ?>" class="prev <?php echo ($page <= 1) ? 'hidden' : ''; ?>">&laquo; 前</a>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'current-page' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>

    <a href="?page=<?php echo $page + 1; ?>" class="next <?php echo ($page >= $totalPages) ? 'hidden' : ''; ?>">次 &raquo;</a>
</div>
</body>
</html>
