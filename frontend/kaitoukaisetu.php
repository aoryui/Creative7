<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../backend/class.php';
$kaisetuID = $_GET['question_id'];
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
    <div class="kaisetu1">  
        <body>
        <main>
            <h2>回答</h2>
            <section class="kaitouran">
                <div class="kaitou">
                    <strong>貴方の回答:</strong>
                    <span id="user-kaitou">回答欄</span>
                </div>
                <div class="kaitou">
                    <strong>正解:</strong>
                    <span id="correct-kaitou">正解欄</span>
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


