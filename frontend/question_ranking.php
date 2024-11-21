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
        qs.total_answers > 0 -- 回答が1回以上ある問題に限定
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
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>間違えやすい問題ランキング</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #ffefd5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            padding-left: 40px;
            padding-right: 40px;
        }
        tbody{
            background-color: #f4f4f4;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding-left: 40px;
            padding-right: 40px;
        }
        th, td {
            padding: 8px;
            text-align: left;
           
        }
        th {
            background-color: #f4f4f4;
        }
        h1 {
            margin-bottom: 20px;
            text-align: center;
            padding-top: 100px;
        }
    </style>
</head>
<body>
    <h1>間違えやすい問題ランキング</h1>
    <?php if (count($rankingData) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>順位</th>
                    <th>ジャンル</th>
                    <th>問題</th>
                    <th>総回答数</th>
                    <th>間違えた回数</th>
                    <th>誤答率 (%)</th>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>ランキングデータがありません。</p>
    <?php endif; ?>
</body>
</html>
