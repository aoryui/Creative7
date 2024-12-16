<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../backend/class.php';
$form = new form();
require_once __DIR__ . '/../backend/pre.php';
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}

if ($userid >= 10000000 && $userid <= 99999999) {
    echo "<script>
            alert('ログインしてください');
            window.location.href = 'login.php';
        </script>";
    exit();
}

// データベースに接続するための情報
$host = 'localhost';
$username = 'Creative7';
$password = '11111';
$database = 'creative7';

// データベースに接続
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die('データベースに接続できませんでした: ' . mysqli_connect_error());
}

// リザルト画面のファイル場所をセッションに保存
$_SESSION['result_display'] = 'review';

$wrong_questions = [];
$wrong_query = "SELECT question_id FROM wrong WHERE userid = $userid";
$wrong_result = mysqli_query($conn, $wrong_query);
if (!$wrong_result) {
    die('クエリ実行に失敗しました: ' . mysqli_error($conn));
}
while ($row = mysqli_fetch_assoc($wrong_result)) {
    $wrong_questions[] = $row['question_id'];
}
// 間違えた問題を昇順にソート
sort($wrong_questions);

// ページネーション設定
$items_per_page = 10; // 1ページあたりの問題数
$total_questions = count($wrong_questions);
$total_pages = ceil($total_questions / $items_per_page);
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, min($current_page, $total_pages)); // ページ範囲を制限
$start_index = ($current_page - 1) * $items_per_page;

// 表示する問題を切り出す
$display_questions = array_slice($wrong_questions, $start_index, $items_per_page);

$_SESSION['displayed_questions'] = $display_questions;

echo '<script>console.log('.json_encode($wrong_questions).')</script>';

// データベース接続をクローズ
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/review.css">
    <link rel="stylesheet" href="../responsive/review.css">
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

                $query = "SELECT genre_text, sentence FROM questions WHERE question_id = $question_id";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    die('クエリ実行に失敗しました: ' . mysqli_error($conn));
                }

                $row = mysqli_fetch_assoc($result);
                $genre = $row['genre_text'];
                $sentence = $row['sentence'];

                mysqli_close($conn);
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($genre, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td id="custom-question"><?php echo htmlspecialchars($sentence, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td id="tri"><a href="kaitoukaisetu.php?question_id=<?php echo $question_id; ?>">解説リンク</a></td>
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
    function confirmDelete() {
        return confirm("本当に削除しますか？");
    }
</script>
</html>
