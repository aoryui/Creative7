<?php
// ヘッダーと必要なクラスファイルをインクルード
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../backend/class.php';
$form = new form();  // formクラスのインスタンスを作成
require_once __DIR__ . '/../backend/pre.php';

// セッションからユーザーIDを取得
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}

// ユーザーIDが無効な場合はログイン画面にリダイレクト
if ($userid >= 10000000 && $userid <= 99999999) {
    echo "<script>
            alert('ログインしてください');
            window.location.href = 'login.php';
        </script>";
    exit();
}

// データベースに接続するための設定
$host = 'localhost';  // ホスト名
$username = 'Creative7';  // ユーザー名
$password = '11111';  // パスワード
$database = 'creative7';  // データベース名

// データベース接続
$conn = mysqli_connect($host, $username, $password, $database);

// 接続失敗時のエラーハンドリング
if (!$conn) {
    die('データベースに接続できませんでした: ' . mysqli_connect_error());
}

// リザルト画面を表示するため、セッションに'「review」'を設定
$_SESSION['result_display'] = 'review';

// 間違えた問題のIDを格納する配列
$wrong_questions = [];

// ユーザーIDに基づいて、間違えた問題のIDを取得するクエリ
$wrong_query = "SELECT question_id FROM wrong WHERE userid = $userid";
$wrong_result = mysqli_query($conn, $wrong_query);

// クエリ実行失敗時のエラーハンドリング
if (!$wrong_result) {
    die('クエリ実行に失敗しました: ' . mysqli_error($conn));
}

// 間違えた問題のIDを配列に格納
while ($row = mysqli_fetch_assoc($wrong_result)) {
    $wrong_questions[] = $row['question_id'];
}

// 間違えた問題を昇順にソート
sort($wrong_questions);

// ページネーション設定
$items_per_page = 10;  // 1ページあたりに表示する問題数
$total_questions = count($wrong_questions);  // 総問題数
$total_pages = ceil($total_questions / $items_per_page);  // 総ページ数を計算
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // 現在のページ番号を取得
$current_page = max(1, min($current_page, $total_pages));  // 現在のページ番号を制限
$start_index = ($current_page - 1) * $items_per_page;  // 現在ページの開始位置

// 現在ページに表示する問題を切り出す
$display_questions = array_slice($wrong_questions, $start_index, $items_per_page);

// 正誤判定用の配列を初期化
$selected_choice = array();  // ユーザーが選択した選択肢
$correct_answers = [];  // 正解の選択肢ID
$genres = [];  // 各問題のジャンル
$correct_choices = [];  // 各問題の正解選択肢ID
$questionTexts = [];  // 各問題のテキスト

// 各問題の正誤を判定するためにデータを取得
foreach ($wrong_questions as $key => $question_id) {
    // 正解の選択肢IDを取得するクエリ
    $query = "SELECT correct_choice_id FROM answers WHERE question_id = $question_id";
    $result = mysqli_query($conn, $query);

    // クエリ実行失敗時のエラーハンドリング
    if (!$result) {
        die('クエリ実行に失敗しました: ' . mysqli_error($conn));
    }

    // 初期選択肢IDとして0を設定
    $selected_choice[] = 0;

    // 正解の選択肢IDを取得
    $row = mysqli_fetch_assoc($result);
    $correct_choice_id = $row['correct_choice_id'];
    $correct_choices[] = $correct_choice_id;

    // 問題のジャンル名を取得するクエリ
    $genre_query = "SELECT genre_text FROM questions WHERE question_id = $question_id";
    $genre_result = mysqli_query($conn, $genre_query);

    // クエリ実行失敗時のエラーハンドリング
    if (!$genre_result) {
        die('クエリ実行に失敗しました: ' . mysqli_error($conn));
    }

    // ジャンルを格納
    $genre_row = mysqli_fetch_assoc($genre_result);
    $genres[$question_id] = $genre_row['genre_text'];

    // 問題文を取得するクエリ
    $questionText_query = "SELECT sentence FROM questions WHERE question_id = $question_id";
    $questionText_result = mysqli_query($conn, $questionText_query);

    // クエリ実行失敗時のエラーハンドリング
    if (!$questionText_result) {
        die('クエリ実行に失敗しました: ' . mysqli_error($conn));
    }

    // 問題文を格納
    $questionText_row = mysqli_fetch_assoc($questionText_result);
    $questionTexts[$question_id] = $questionText_row['sentence'];
}

// セッションに問題の情報を格納
$_SESSION['displayed_questions'] = $wrong_questions;
$_SESSION['selected_choice'] = $selected_choice;
$_SESSION['correct_choices'] = $correct_choices;

// データベース接続をクローズ
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/review.css">  <!-- スタイルシートのリンク -->
    <link rel="stylesheet" href="../responsive/review.css">  <!-- レスポンシブ対応スタイルシート -->
</head>
<body>
    <div class="border-frame">
        <h2 class="answer">復習問題</h2>

        <table border="1" id="table">
            <tr>
                <th>分野</th>
                <th>問題文</th>
                <th>解説</th>
                <th>復習</th>
                <th>削除</th>
            </tr>
            <?php foreach ($display_questions as $key => $question_id): ?>
                <?php
                // データベースに再接続
                $conn = mysqli_connect($host, $username, $password, $database);
                if (!$conn) {
                    die('データベースに接続できませんでした: ' . mysqli_connect_error());
                }

                // 問題IDに基づいてジャンルと問題文を取得
                $query = "SELECT genre_text, sentence FROM questions WHERE question_id = $question_id";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    die('クエリ実行に失敗しました: ' . mysqli_error($conn));
                }

                // 取得したジャンルと問題文を変数に格納
                $row = mysqli_fetch_assoc($result);
                $genre = $row['genre_text'];
                $sentence = $row['sentence'];

                // データベース接続をクローズ
                mysqli_close($conn);
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($genre, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td id="custom-question"><?php echo htmlspecialchars($sentence, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td id="tri"><a href="kaitoukaisetu.php?question_id=<?php echo array_search($question_id, $wrong_questions); ?>">解説リンク</a></td>
                    <td id="tri"><a href="review_questions.php?question_id=<?php echo $question_id; ?>">問題</a></td>
                    <td>
                        <form method="post" action="../backend/delete_question.php" onsubmit="return confirmDelete();">
                            <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                            <button class="btn btn-danger" id="deleteButton" type="submit">削除</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- ページネーション表示 -->
        <div class="pagination">
            <?php if ($current_page > 1): ?>
                <a href="?page=<?php echo $current_page - 1; ?>">« 前</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo ($i === $current_page) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
                <a href="?page=<?php echo $current_page + 1; ?>">次 »</a>
            <?php endif; ?>
        </div>
    </div>
</body>
<script>
    // 削除確認ダイアログ
    function confirmDelete() {
        return confirm("本当に削除しますか？");
    }

    // 全削除確認ダイアログ
    function confirmDeleteAll() {
        return confirm("全ての問題を削除します。本当によろしいですか？");
    }
</script>
</html>
