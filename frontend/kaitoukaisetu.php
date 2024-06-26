<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../backend/class.php';


// $kaisetuID を最初に取得
$kaisetuID = isset($_GET['question_id']) ? $_GET['question_id'] : null;

// セッションから選択肢と正解の情報を取得
$correct_choices = isset($_SESSION['correct_choices']) ? $_SESSION['correct_choices'] : [];
$selected_choices = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];

// ユーザーの回答と正解の選択肢IDを取得
$user_choice_id = isset($selected_choices[$kaisetuID]) ? $selected_choices[$kaisetuID] : 'N/A';
$correct_choice_id = isset($correct_choices[$kaisetuID]) ? $correct_choices[$kaisetuID] : 'N/A';

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
    return 'N/A'; // テキストが取得できない場合は N/A を返す
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

} catch (PDOException $e) {
    echo 'データベース接続エラー: ' . $e->getMessage();
}

$form = new form();
$kaisetu = $form->getQues($kaisetuID);



?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>回答と解説画面</title>
    <link rel="stylesheet" href="../css/kaitoukaisetu.css">
</head>
<body>
    <div class="kaisetu1">
        <main>
            <h2>問題</h2>
            <h2>回答</h2>
            <section class="kaitouran">
                <div class="kaitou">
                    <strong>貴方の回答:</strong>
                    <span id="user-kaitou"><?php echo htmlspecialchars($user_choice_text, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <div class="kaitou">
                    <strong>正解:</strong>
                    <span id="correct-kaitou"><?php echo htmlspecialchars($correct_choice_text, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
            </section>
            <h2>解説</h2>
            <section class="kaiseturan">
                <p id="kaisetu">
                    <p><?php
                        // 画像のパスを作成
                        $image_path = "../image/解説/" . $kaisetu['explanation'] . ".jpg";
                        // HTMLで画像を表示
                        echo '<img src="' . $image_path . '" alt="問題画像" class="question_img">';
                    ?></p>
                </p>
            </section>
            <p><a href="result.php">リザルトに戻る</a></p>
        </main>
    </div>
</body>
</html>
