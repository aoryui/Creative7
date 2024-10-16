<?php
session_start(); // セッションを開始
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../backend/class.php';
$rankingClass = new form();

// ログイン中のユーザーIDを取得
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

// 1ページあたりの表示件数
$itemsPerPage = 10;

// 現在のページを取得 (デフォルトは1ページ目)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// 表示を開始する順位を計算
$startRank = ($page - 1) * $itemsPerPage + 1;

// ランキングデータを取得
$rankingData = $rankingClass->ranking($startRank);

// 総ユーザー数に基づいて、ページ数を計算 (例: 100件の場合は10ページ)
$totalUsers = $rankingClass->getTotalUsers(); // ランキング全体の件数を取得するメソッド
$totalPages = ceil($totalUsers / $itemsPerPage);
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
        <h1>ランキング</h1>
        
        <!-- 自分のランキングを表示 -->
        <div class="my-ranking">
            <?php
            if (isset($userid)) {
                $userRank = $rankingClass->getUserRank($userid);
                
                // ユーザーの経験値を取得
                $userData = $rankingClass->getInfo($userid);
                $userTotalExp = $userData['exp'] + (($userData['level'] - 1) * 10); // 総獲得経験値を計算

                echo "<p>あなたの順位: " . $userRank . " 位</p>";
                echo "<p>総獲得経験値: " . htmlspecialchars($userTotalExp, ENT_QUOTES, 'UTF-8') . "</p>";
            } else {
                echo "<p>ログインしてください。</p>";
            }
            ?>
        </div>

        <table border="1" id="table">
            <tr>
                <th>順位</th>
                <th>ユーザ名</th>
                <th>総獲得経験値</th>
            </tr>
            <?php
            // 結果がある場合、ランキングを表示
            if (!empty($rankingData)) {
                $rank = $startRank; // 開始順位を設定
                $prevTotal = null; // 前のユーザーの総獲得経験値
                $sameRankCount = 0; // 同じ順位のユーザー数
                $prevRank = $startRank - 1; // 前のユーザーのランクを記録

                foreach ($rankingData as $row) {
                    // 総獲得経験値が前回と同じか確認
                    if ($row['total'] === $prevTotal) {
                        $sameRankCount++;
                    } else {
                        // 異なる場合、現在の順位に同じ順位のユーザー数を加算して更新
                        $rank = $prevRank + $sameRankCount + 1;
                        $sameRankCount = 0;
                    }

                    // ランクに応じてクラスを決定
                    $class = '';
                    if ($rank == 1) {
                        $class = 'first-place'; // 1位のクラス
                    } elseif ($rank == 2) {
                        $class = 'second-place'; // 2位のクラス
                    } elseif ($rank == 3) {
                        $class = 'third-place'; // 3位のクラス
                    }

                    echo "<tr class='$class'>";
                    echo "<td>" . $rank . "</td>";
                    echo "<td>" . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row['total'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "</tr>";

                    // 前回の経験値とランクを更新
                    $prevTotal = $row['total'];
                    $prevRank = $rank;
                }
            } else {
                // データがない場合のメッセージ
                echo "<tr><td colspan='3'>ランキングデータがありません。</td></tr>";
            }
            ?>
        </table>

        <!-- ページネーション -->
        <div class="pagination">
            <?php
            // ページネーションリンクを生成
            if ($totalPages > 1) {
                for ($i = 1; $i <= $totalPages; $i++) {
                    // 現在のページにはリンクを貼らない
                    if ($i == $page) {
                        echo "<span class='current-page'>$i</span>";
                    } else {
                        echo "<a href='?page=$i'>$i</a>";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
