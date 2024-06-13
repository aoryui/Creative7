

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPIタイサくん</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            flex-direction: column;
            align-items: center;
        }
        
        .menu {
            display: flex;
            flex-direction: column;
            margin-right: 20px;
        }
        .menu div {
            width: 30px;
            height: 5px;
            background-color: #fff;
            margin: 3px 0;
        }
        .content {
            display: flex;
            justify-content: flex-end;
            width: 100%;
            padding: 20px;
        }
        .question {
            flex-grow: 1;
            margin-right: 20px;
        }
        .question-text {
            background-color: #e0e0e0;
            padding: 10px;
            border-radius: 5px;
        }
        .choices {
            display: flex;
            flex-direction: column;
            margin-bottom: 40px;
            margin-top: 100px; /* 上側のマージンを追加 */
            margin-right: 300px;
            width: 200px; /* 適切な幅を設定 */
        }
        .choice {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            background-color: #d3d3d3;
            padding: 5px;
            border-radius: 5px;
        }
        .choice input {
            margin-right: 10px;
        }
        .choice label {
            margin: 0;
            flex-grow: 1;
        }
        .timer {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            width: 100%;
        }
        .timer-label {
            margin-right: 10px;
        }
        .timer-bar {
            display: flex;
            width: 80%;
            height: 20px;
            overflow: hidden;
        }
        .timer-bar div {
            flex: 1;
            background-color: #e0e0e0;
            margin: 0 1px;
            opacity: 1;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer p {
            margin-bottom: 10px;
        }
        .next-button {
            padding: 10px 20px;
            background-color: #00aaff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
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
    <div class="timer">
        <div class="timer-label">回答時間</div>
        <div class="timer-bar" id="timer-bar">
            <!-- タイマーバーの色の部分をJavaScriptで生成 -->
        </div>
    </div>
    <div class="footer">
        <p>時間超過した場合次の問題に行きます</p>
        <a href="#" class="next-button">次に進む</a>
    </div>
    <script>
        const timerBar = document.getElementById('timer-bar');
        const totalSegments = 30;
        const segmentTime = 1000; // 1秒
        const lightColors = [
            '#dcedc8', '#dcedc8', '#dcedc8', '#dcedc8', '#dcedc8',
            '#f0f4c3', '#f0f4c3', '#f0f4c3', '#f0f4c3', '#f0f4c3',
            '#fff9c4', '#fff9c4', '#fff9c4', '#fff9c4', '#fff9c4',
            '#ffecb3', '#ffecb3', '#ffecb3', '#ffecb3', '#ffecb3',
            '#ffe0b2', '#ffe0b2', '#ffe0b2', '#ffe0b2', '#ffe0b2',
            '#ffccbc', '#ffccbc', '#ffccbc', '#ffccbc', '#ffcdd2'
        ];
        const darkColors = [
            '#8bc34a', '#8bc34a', '#8bc34a', '#8bc34a', '#8bc34a',
            '#cddc39', '#cddc39', '#cddc39', '#cddc39', '#cddc39',
            '#ffeb3b', '#ffeb3b', '#ffeb3b', '#ffeb3b', '#ffeb3b',
            '#ffc107', '#ffc107', '#ffc107', '#ffc107', '#ffc107',
            '#ff9800', '#ff9800', '#ff9800', '#ff9800', '#ff9800',
            '#ff5722', '#ff5722', '#ff5722', '#ff5722', '#f44336'
        ];

        function createSegments() {
            for (let i = 0; i < totalSegments; i++) {
                const segment = document.createElement('div');
                segment.style.backgroundColor = lightColors[i];
                timerBar.appendChild(segment);
            }
        }

        function startTimer() {
            let currentSegment = 0;
            const segments = timerBar.children;
            const interval = setInterval(() => {
                if (currentSegment >= totalSegments) {
                    clearInterval(interval);
                    // タイムアップ後の処理をここに書く
                } else {
                    segments[currentSegment].style.backgroundColor = darkColors[currentSegment];
                    currentSegment++;
                }
            }, segmentTime);
        }

        createSegments();
        startTimer();
    </script>
</body>
</html>
