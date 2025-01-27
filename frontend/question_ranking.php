<?php

// ヘッダーの読み込み
require_once __DIR__ . '/header.php';

// データベース接続設定
$host = 'localhost';  // データベースホスト名
$dbname = 'creative7'; // 使用するデータベース名
$username = 'Creative7'; // データベースのユーザー名
$password = '11111'; // データベースのパスワード

// （コメントアウトされている）別のデータベース接続設定
// $host = 'mysql1.php.starfree.ne.jp';
// $dbname = 'creative7_creative7';
// $username = 'creative7_jun';
// $password = 'eL6VKCZh';

try {
    // PDOを使用したデータベース接続
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // エラーモードの設定（例外をスロー）
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // 接続エラー時のエラーメッセージ表示
    die("データベース接続エラー: " . $e->getMessage());
}

// mysqli接続を使用するための設定
$conn = mysqli_connect($host, $username, $password, $dbname);

// リザルト画面の表示場所をセッションに保存
$_SESSION['result_display'] = 'ranking';

// 間違えやすい問題ランキングのためのSQLクエリ
$sql = "
    SELECT 
        qs.question_id,          -- 問題ID
        q.genre_text,            -- ジャンル
        q.sentence,              -- 問題文
        qs.total_answers,        -- 総回答数
        qs.incorrect_answers,    -- 間違えた回数
        ROUND((qs.incorrect_answers / qs.total_answers) * 100, 2) AS error_rate  -- 誤答率（%）
    FROM 
        question_statistics qs
    JOIN 
        questions q ON qs.question_id = q.question_id  -- question_statisticsテーブルとquestionsテーブルをJOIN
    WHERE 
        qs.total_answers >= 10 -- 回答数が10回以上の問題に限定
    ORDER BY 
        error_rate DESC, qs.total_answers DESC  -- 誤答率が高い順、次に回答数が多い順に並べ替え
    LIMIT 10; -- 上位10件を取得
";

try {
    // SQLクエリを実行
    $stmt = $db->query($sql);
    // 結果を連想配列として取得
    $rankingData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // クエリ実行エラー時のエラーメッセージ表示
    die("クエリ実行エラー: " . $e->getMessage());
}

// 問題IDの配列と選択肢IDの配列を初期化
foreach ($rankingData as $item) {
    $question_ids[] = $item['question_id'];  // 問題IDを格納
    $selected_choice[] = 0;                   // 初期選択肢ID（0）を格納
}

// 各問題IDに対して正解の選択肢IDを取得
foreach ($question_ids as $key => $question_id) {
    // 問題IDに対応する正解選択肢IDを取得するクエリ
    $query = "SELECT correct_choice_id FROM answers WHERE question_id = $question_id";
    $result = mysqli_query($conn, $query);
    
    // 結果を連想配列として取得
    $row = mysqli_fetch_assoc($result);
    $correct_choice_id = $row['correct_choice_id'];  // 正解の選択肢IDを格納
    $correct_choices[] = $correct_choice_id;          // 正解の選択肢IDを配列に追加
}

// セッションに問題ID、選択肢ID、正解IDを保存
$_SESSION['displayed_questions'] = $question_ids;
$_SESSION['selected_choice'] = $selected_choice;
$_SESSION['correct_choices'] = $correct_choices;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/question_ranking.css">  <!-- ランキング用CSS -->
    <link rel="stylesheet" href="../responsive/question_ranking.css">  <!-- レスポンシブ用CSS -->
    <title>間違えやすい問題ランキング</title>
</head>
<body>
<div class="border-frame">
    <div class="flex-inner" data-box-color="white">
        <h1>間違えやすい問題ランキング</h1>
        <?php if (count($rankingData) > 0): ?>
            <!-- ランキングデータがある場合 -->
            <table>
                <thead>
                    <tr>
                        <th>順位</th>                  <!-- 順位 -->
                        <th>ジャンル</th>              <!-- ジャンル -->
                        <th>問題文</th>                <!-- 問題文 -->
                        <th>総回答数</th>              <!-- 総回答数 -->
                        <th>間違えた回数</th>          <!-- 間違えた回数 -->
                        <th>誤答率 (%)</th>            <!-- 誤答率 -->
                        <th>問題</th>                 <!-- 問題へのリンク -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rankingData as $index => $row): ?>
                        <tr <?php echo $index === 0 ? 'style="background-color: #ffe5e5;"' : ''; ?>>
                            <td><?php echo $index + 1; ?></td>  <!-- 順位を表示 -->
                            <td><?php echo htmlspecialchars($row['genre_text'], ENT_QUOTES, 'UTF-8'); ?></td>  <!-- ジャンルを表示 -->
                            <td><?php echo htmlspecialchars($row['sentence'], ENT_QUOTES, 'UTF-8'); ?></td>    <!-- 問題文を表示 -->
                            <td><?php echo $row['total_answers']; ?></td>  <!-- 総回答数を表示 -->
                            <td><?php echo $row['incorrect_answers']; ?></td>  <!-- 間違えた回数を表示 -->
                            <td><?php echo $row['error_rate']; ?></td>  <!-- 誤答率を表示 -->
                            <td id="tri"><a href="review_questions.php?question_id=<?php echo htmlspecialchars($row['question_id'], ENT_QUOTES, 'UTF-8'); ?>">問題へ</a></td>  <!-- 問題へのリンク -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <!-- ランキングデータがない場合 -->
            <p>ランキングデータがありません。</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
