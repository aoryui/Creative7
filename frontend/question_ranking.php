<?php

require_once __DIR__ . '/header.php';

// データベース接続設定
$host = 'localhost';
$dbname = 'creative7';
$username = 'Creative7';
$password = '11111';

try {
    // PDOを使用したデータベース接続
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("データベース接続エラー: " . $e->getMessage());
}
$conn = mysqli_connect($host, $username, $password, $dbname);


// リザルト画面のファイル場所をセッションに保存
$_SESSION['result_display'] = 'ranking';

// 間違えやすい問題ランキングクエリ
$sql = "
    SELECT 
        qs.question_id,
        q.genre_text,
        q.sentence,
        qs.total_answers,
        qs.incorrect_answers,
        ROUND((qs.incorrect_answers / qs.total_answers) * 100, 2) AS error_rate
    FROM 
        question_statistics qs
    JOIN 
        questions q ON qs.question_id = q.question_id
    WHERE 
        qs.total_answers >= 10 -- 回答が10回以上の問題に限定
    ORDER BY 
        error_rate DESC, qs.total_answers DESC
    LIMIT 10; -- 上位10件を取得
";

try {
    $stmt = $db->query($sql);
    $rankingData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("クエリ実行エラー: " . $e->getMessage());
}

foreach ($rankingData as $item) {
    $question_ids[] = $item['question_id'];
    $selected_choice[] = 0;
}
foreach ($question_ids as $key => $question_id) {
    // 問題IDに対応する正解の選択肢IDを取得するクエリ
    $query = "SELECT correct_choice_id FROM answers WHERE question_id = $question_id";
    $result = mysqli_query($conn, $query);
    
    $row = mysqli_fetch_assoc($result);
    $correct_choice_id = $row['correct_choice_id'];
    $correct_choices[] = $correct_choice_id;
}

$_SESSION['displayed_questions'] = $question_ids;
$_SESSION['selected_choice'] = $selected_choice;
$_SESSION['correct_choices'] = $correct_choices;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/question_ranking.css">
    <link rel="stylesheet" href="../responsive/question_ranking.css">
    <title>間違えやすい問題ランキング</title>
</head>
<body>
    <h1>間違えやすい問題ランキング</h1>
    <?php if (count($rankingData) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>順位</th>
                    <th>ジャンル</th>
                    <th>問題文</th>
                    <th>総回答数</th>
                    <th>間違えた回数</th>
                    <th>誤答率 (%)</th>
                    <th>問題</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rankingData as $index => $row): ?>
                    <tr <?php echo $index === 0 ? 'style="background-color: #ffe5e5;"' : ''; ?>>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($row['genre_text'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['sentence'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo $row['total_answers']; ?></td>
                        <td><?php echo $row['incorrect_answers']; ?></td>
                        <td><?php echo $row['error_rate']; ?></td>
                        <td id="tri"><a href="review_questions.php?question_id=<?php echo htmlspecialchars($row['question_id'], ENT_QUOTES, 'UTF-8'); ?>">問題へ</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>ランキングデータがありません。</p>
    <?php endif; ?>
</body>
</html>
