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

// ステートメントと接続を閉じる
$stmt->close();
$conn->close();

// セッションに問題を保存
$_SESSION['displayed_questions'] = $question_ids; 
$_SESSION['displayed_questions'] = [];
$_SESSION['selected_choice'] = [];
// 問題をコンソールに表示
echo '<script>console.log('.json_encode($question_ids).')</script>';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="../css/practicestart.css">
</head>
<body>
    <main>
        <div class="practicestartmain">
            <div class="container">
                <div class="content">
                    <p>ランダムで想定された問題が10個出題されます。</p>
                    <p>時間までに解いてください。</p>
                    <p>時間が過ぎると次の問題に自動的に飛ばされます。</p>
                    <p>メモ用紙と筆記用具を用意してください。</p>
                </div>
                <div class="button-container">
                    <input type="button" onclick="location.href='practice.php'" value="練習問題を開始する">
                </div>
            </div>
        </div>
    </main>
</body>
</html>
