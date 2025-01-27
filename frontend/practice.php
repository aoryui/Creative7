<?php
session_start(); // セッションを開始する

require_once __DIR__ . '/header.php'; // ヘッダーの読み込み

// データベース接続パラメータ
$servername = "localhost";  // サーバ名
$username = "Creative7";    // ユーザー名
$password = "11111";        // パスワード
$dbname = "creative7";      // データベース名

// 接続を作成
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続エラーチェック
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // 接続失敗時にエラーメッセージを表示
}

// セッションから選択された言語非言語とジャンルを受け取る
$field = isset($_SESSION['field']) ? $_SESSION['field'] : []; // 言語フィールド（ジャンル）の取得
$genre = isset($_SESSION['genre']) ? $_SESSION['genre'] : []; // ジャンルIDの取得

// デバッグ用のコンソール出力（選択された言語とジャンルを表示）
echo '<script>console.log('.json_encode($field).')</script>';
echo '<script>console.log('.json_encode($genre).')</script>';

// 言語とジャンルのリスト数が一致しない場合、処理を停止
if (count($field) !== count($genre)) {
    die("FieldとGenreのリストは同じ数の要素を持つ必要があります。");
}

// SQLクエリを動的に構築
$conditions = []; // 条件を格納する配列
$params = []; // パラメータを格納する配列
$types = str_repeat('ii', count($field)); // バインドするパラメータの型（'ii'は整数2つ）

// 言語とジャンルごとの条件を生成
for ($i = 0; $i < count($field); $i++) {
    $conditions[] = "(field_id = ? AND genre_id = ?)"; // field_idとgenre_idに基づいた条件を追加
    $params[] = $field[$i]; // fieldをパラメータとして追加
    $params[] = $genre[$i]; // genreをパラメータとして追加
}

// question_idをランダムに取得するSQL文
$sql = "SELECT question_id FROM questions WHERE " . implode(" OR ", $conditions) . " ORDER BY RAND()";

// SQL準備とパラメータバインド
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params); // 動的にパラメータをバインド

// クエリを実行
$stmt->execute();
$result = $stmt->get_result(); // 結果を取得

// 結果を配列に格納
$question_ids = [];
while ($row = $result->fetch_assoc()) {
    $question_ids[] = $row['question_id']; // question_idを配列に追加
}

// genre_textを取得するSQL文
$sql = "SELECT DISTINCT field_id, genre_text FROM questions WHERE " . implode(" OR ", $conditions);

// SQL準備とパラメータバインド
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

// クエリを実行
$stmt->execute();
$result = $stmt->get_result(); // 結果を取得

// 結果をgenre_textsに格納（field_1とfield_2のジャンルを区分け）
$genre_texts = ['field_1' => [], 'field_2' => []];
while ($row = $result->fetch_assoc()) {
    if ($row['field_id'] == 1) {
        $genre_texts['field_1'][] = $row['genre_text']; // field_idが1の場合はfield_1に追加
    } elseif ($row['field_id'] == 2) {
        $genre_texts['field_2'][] = $row['genre_text']; // field_idが2の場合はfield_2に追加
    }
}

// ステートメントと接続を閉じる
$stmt->close();
$conn->close();

// セッションに解く問題のIDとジャンル名を保存し、次のページで使用する
$_SESSION['displayed_questions'] = $question_ids; // 出題する問題IDをセッションに保存
$_SESSION['genre_texts'] = $genre_texts; // ジャンル名をセッションに保存
// 問題数分「0」で初期化
$_SESSION['selected_choice'] = array_fill(0, count($question_ids), 0); // 解答選択肢を初期化（0に設定）
$_SESSION['current_question_index'] = 0; // 現在の問題のインデックスを初期化
$_SESSION['interval_time'] = []; // 時間の間隔を初期化
$_SESSION['already_saved'] = false; // セーブフラグを初期化

// 問題IDとジャンル名をコンソールに表示（デバッグ用）
echo '<script>console.log('.json_encode($question_ids).')</script>';
echo '<script>console.log('.json_encode($genre_texts).')</script>';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="../css/practice_start.css"> <!-- 練習用スタイルシート -->
    <link rel="stylesheet" href="../responsive/practice_start.css"> <!-- レスポンシブ対応スタイルシート -->
</head>
<body>
    <div class="border-frame"> <!-- 枠組み -->
        <div class="flex-inner" data-box-color="white"> <!-- フレックスレイアウトの中身 -->
            <h2>選択されたジャンルから問題がランダムに表示されます。</h2> <!-- タイトル -->
            <main>
                <!-- 言語系 -->
                <fieldset class="left-contain"> <!-- 言語の問題 -->
                    <legend>言語</legend>
                    <div class="language-list-container"> <!-- 言語リスト -->
                        <ul class="language-list primary">
                            <?php
                            // 言語フィールドのジャンルが空でない場合にリストを表示
                            if (empty($_SESSION['genre_texts']['field_1'])) {
                                echo "<li>なし</li>"; // ジャンルがない場合
                            } else {
                                $count = 0; // カウンターを初期化
                                echo '<div class="genre-row">'; // 最初の行を開始
                                foreach ($_SESSION['genre_texts']['field_1'] as $genre_text) {
                                    echo "<li>{$genre_text}</li>"; // 各ジャンルをリストに表示
                                    $count++;
                                    // 2つずつに分けて行を変える
                                    if ($count % 2 == 0) {
                                        echo '</div><div class="genre-row">'; // 新しい行を開始
                                    }
                                }
                                echo '</div>'; // 最後の行を閉じる
                            }
                            ?>
                        </ul>
                    </fieldset>

                <!-- 非言語系 -->
                <fieldset class="right-contain"> <!-- 非言語の問題 -->
                    <legend>非言語</legend>
                    <div class="non-language-list-container"> <!-- 非言語リスト -->
                        <?php
                        // 非言語フィールドのジャンルが空でない場合にリストを表示
                        if (empty($_SESSION['genre_texts']['field_2'])) {
                            echo "<li>なし</li>"; // ジャンルがない場合
                        } else {
                            foreach ($_SESSION['genre_texts']['field_2'] as $genre_text) {
                                echo "<li>{$genre_text}</li>"; // 各ジャンルをリストに表示
                            }
                        }
                        ?>
                    </div>
                </fieldset>
                
                <!-- 練習問題開始ボタン -->
                <button class="button" type="submit" onclick="location.href='practice.php'">練習問題を開始する</button>
            </div>
        </div>
    </div>          

</main>
</body>
</html>
