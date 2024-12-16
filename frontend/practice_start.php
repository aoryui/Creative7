<?php
session_start(); // セッションを開始する

require_once __DIR__ . '/header.php';
// データベース接続パラメータ
$servername = "localhost";
$username = "Creative7";
$password = "11111";
$dbname = "creative7";
// 接続を作成
$conn = new mysqli($servername, $username, $password, $dbname);
// 接続をチェック
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// セッションから選択された言語非言語とジャンルを受け取る
$field = isset($_SESSION['field']) ? $_SESSION['field'] : [];
$genre = isset($_SESSION['genre']) ? $_SESSION['genre'] : [];

// デバッグ用のコンソール出力
echo '<script>console.log('.json_encode($field).')</script>';
echo '<script>console.log('.json_encode($genre).')</script>';

if (count($field) !== count($genre)) {
    die("FieldとGenreのリストは同じ数の要素を持つ必要があります。");
}

// SQLクエリを動的に構築
$conditions = [];
$params = [];
$types = str_repeat('ii', count($field));

for ($i = 0; $i < count($field); $i++) {
    $conditions[] = "(field_id = ? AND genre_id = ?)";
    $params[] = $field[$i];
    $params[] = $genre[$i];
}

// question_idを取得
$sql = "SELECT question_id FROM questions WHERE " . implode(" OR ", $conditions) . " ORDER BY RAND()";

// パラメータを準備しバインド
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

// クエリを実行
$stmt->execute();
$result = $stmt->get_result();

// 結果を取得
$question_ids = [];
while ($row = $result->fetch_assoc()) {
    $question_ids[] = $row['question_id'];
}

// genre_textを取得
$sql = "SELECT DISTINCT field_id, genre_text FROM questions WHERE " . implode(" OR ", $conditions);

// パラメータを準備しバインド
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

// クエリを実行
$stmt->execute();
$result = $stmt->get_result();

// 結果を取得
$genre_texts = ['field_1' => [], 'field_2' => []];
while ($row = $result->fetch_assoc()) {
    if ($row['field_id'] == 1) {
        $genre_texts['field_1'][] = $row['genre_text'];
    } elseif ($row['field_id'] == 2) {
        $genre_texts['field_2'][] = $row['genre_text'];
    }
}

// ステートメントと接続を閉じる
$stmt->close();
$conn->close();

// セッションに解く問題とジャンル名を保存し、リザルト表示に不必要セッションを初期化
$_SESSION['displayed_questions'] = $question_ids; 
$_SESSION['genre_texts'] = $genre_texts;
// 問題数分「0」で初期化
$_SESSION['selected_choice'] = array_fill(0, count($question_ids), 0);
$_SESSION['current_question_index'] = 0;
$_SESSION['interval_time'] = [];

// 問題とジャンル名をコンソールに表示
echo '<script>console.log('.json_encode($question_ids).')</script>';
echo '<script>console.log('.json_encode($genre_texts).')</script>';
?>

<!DOCTYPE html>
    <html lang="ja">
    <head>
        <link rel="stylesheet" href="../css/practice_start.css">
        <link rel="stylesheet" href="../responsive/practice_start.css">
    </head>
    <body>
        <div class="border-frame">
        <div class="flex-inner" data-box-color="white">
            <h2>選択されたジャンルから問題がランダムに表示されます。</h2>
        <main>
        <!--言語系-->
        <fieldset class="left-contain">
        <legend>言語</legend>
        <div class="language-list-container">
        <ul class="language-list primary">
            <?php
            if (empty($_SESSION['genre_texts']['field_1'])) {
                echo "<li>なし</li>";
                } else {
                $count = 0; // カウンターを初期化
                echo '<div class="genre-row">'; // 最初の行を開始
                foreach ($_SESSION['genre_texts']['field_1'] as $genre_text) {
                echo "<li>{$genre_text}</li>";
                $count++;
                if ($count % 2 == 0) { // 4つごとに新しい行を開始
                echo '</div><div class="genre-row">';
                }
                }
                echo '</div>'; // 最後の行を閉じる
                }
            ?>
        </ul>
        </fieldset>

        <fieldset class="right-contain">
        <legend>非言語</legend>
        <div class="non-language-list-container">
    <?php
    if (empty($_SESSION['genre_texts']['field_2'])) {
        echo "<li>なし</li>";
    } else {
        foreach ($_SESSION['genre_texts']['field_2'] as $genre_text) {
            echo "<li>{$genre_text}</li>";
        }
    }
    ?>
        </div>
        </fieldset>
                    
                    <button class="button" type="submit" onclick="location.href='practice.php'">練習問題を開始する</button>
        </div>
    </div>
</div>          

    </main>
    </body>
</html>
