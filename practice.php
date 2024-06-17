<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="image/icon.png" />
    <title>SPIタイサくん</title>
</head>

<body>
<?php
require_once __DIR__ . '/header.php';
?>
    <div class="content">
        <div class="question">
            <div class="question-text">次の文章を読んで問いに答えなさい</div>
            <p>下線部の語が最も近い意味で使われているものを1つ選びなさい。</p>
            <p><u>あかるい未来がまっている</u></p>
        </div>
        <div class="choices">
            <div class="choice">
                <input type="radio" name="future" id="option1">
                <label for="option1">明るい未来</label>
            </div>
            <div class="choice" style="background-color: #dcd0c0;">
                <input type="radio" name="future" id="option2">
                <label for="option2">輝るい未来</label>
            </div>
            <div class="choice">
                <input type="radio" name="future" id="option3">
                <label for="option3">輝く未来</label>
            </div>
            <div class="choice" style="background-color: #dcd0c0;">
                <input type="radio" name="future" id="option4">
                <label for="option4">拓類未来</label>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>時間超過した場合次の問題に行きます</p>
        <a href="#" class="next-button" id="next-button">次に進む</a>
    </div>
    <script>
        function goToNextQuestion() {
            // 次の問題に進む処理をここに書く
            window.location.href = "次の問題のURL"; // 実際の次の問題のURLに変更
        }

        document.getElementById('next-button').addEventListener('click', (e) => {
            e.preventDefault();
            goToNextQuestion();
        });
    </script>
</body>
</html>
