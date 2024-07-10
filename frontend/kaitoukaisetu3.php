<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../backend/class.php';

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

// question_idを取得
if (isset($_GET['question_id'])) {
    $question_id = intval($_GET['question_id']);
} else {
    die('質問IDが指定されていません。');
}

// question_idに対応する問題文と解説を取得
$query = "SELECT q.question_text, a.explanation 
          FROM questions q
          JOIN answers a ON q.question_id = a.question_id 
          WHERE q.question_id = $question_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('クエリ実行に失敗しました: ' . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
$question_text = $row['question_text'];
$explanation = $row['explanation'];

// データベース接続をクローズ
mysqli_close($conn);

// $kaisetuID を最初に取得
$kaisetuID = isset($_GET['question_id']) ? $_GET['question_id'] : null;

// セッションから選択肢と正解の情報を取得
$displayed_questions = isset($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : [];
$selected_choices = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];
$correct_choices = isset($_SESSION['correct_choices']) ? $_SESSION['correct_choices'] : [];
echo '<script>console.log('.json_encode($displayed_questions).')</script>';
echo '<script>console.log('.json_encode($selected_choices).')</script>';
echo '<script>console.log('.json_encode($correct_choices).')</script>';

// ユーザーの回答と正解の選択肢IDを取得
$question_num = $displayed_questions[$kaisetuID];
$user_choice_id = isset($selected_choices[$kaisetuID]) ? $selected_choices[$kaisetuID] : 'N/A';
$correct_choice_id = isset($correct_choices[$kaisetuID]) ? $correct_choices[$kaisetuID] : 'N/A';
echo '<script>console.log('.json_encode($user_choice_id).')</script>';
echo '<script>console.log('.json_encode($correct_choice_id).')</script>';

// 正解の選択肢のテキストを取得する関数
function getChoiceText($choice_id, $pdo) {
    try {
        // クエリを準備して実行
        $stmt = $pdo->prepare('SELECT choice_text FROM choices WHERE choice_id = :choice_id');
        $stmt->bindParam(':choice_id', $choice_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['choice_text'];
        }
    } catch (PDOException $e) {
        echo 'データベースエラー: ' . $e->getMessage();
    }
    return '無回答'; // テキストが取得できない場合は 無回答 を返す
}

// データベース接続情報を設定
$dsn = 'mysql:host=localhost;dbname=creative7;charset=utf8';
$username = 'Creative7'; // データベースのユーザー名
$password = '11111'; // データベースのパスワード

try {
    // PDOインスタンスを作成
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 正解の選択肢のテキストを取得
    $correct_choice_text = getChoiceText($correct_choice_id, $pdo);

    // ユーザーの回答のテキストを取得
    $user_choice_text = getChoiceText($user_choice_id, $pdo);

    // 質問の情報を取得
    $stmt = $pdo->prepare('SELECT genre_text, question_text FROM questions WHERE question_id = :question_id');
    $stmt->bindParam(':question_id', $question_num, PDO::PARAM_INT);
    $stmt->execute();
    $question_info = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'データベース接続エラー: ' . $e->getMessage();
}

$form = new form();
$kaisetu = $form->getQues($question_num);

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/kaitoukaisetu.css">
</head>
<body>
    <div class="kaisetu1">
        <main>
            <h2>問題</h2>
            <section class="container">
                <div class="kaitou">
                    <b>ジャンル:</b>
                    <span><?php echo htmlspecialchars($question_info['genre_text'], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <div>
                    <b>問題文:</b>
                    <?php
                    $question_image_path = "../image/問題集/" . $question_text . ".jpg";
                    //HTMLで問題画像を表示
                    echo '<img src="' . htmlspecialchars($question_image_path, ENT_QUOTES, 'UTF-8') . '" alt="問題画像" class="question_img" width="100%" height="50%">';
                    ?>
                </div>
            </section>
            <h2>回答</h2>
            <section class="container">
                <div class="kaitou">
                    <b>正解:</b>
                    <span id="correct-kaitou"><?php echo htmlspecialchars($correct_choice_text, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
            </section>
            <h2>解説</h2>
            <section class="container">
                <p id="kaisetu">
                    <p><?php
                        $explanation_image_path = "../image/解説/" . $explanation . ".jpg";
                        //HTMLで解説画像を表示
                        echo '<img src="' . htmlspecialchars($explanation_image_path, ENT_QUOTES, 'UTF-8') . '" alt="解説画像" class="explanation_img" width="100%" height="50%">';
                    ?></p>
                </p>
            </section>
            <a href="review.php" class="btn">復習問題一覧に戻る</a>
        </main>
    </div>
</body>
</html></html>
