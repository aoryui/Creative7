<?php
require_once __DIR__ . '/header.php'; //ヘッダー指定
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テキストから画像へ</title>
    <link rel="stylesheet" href="../css/generator_test.css">
</head>
<body>

<h1 id="bun">作成したい問題文を入力してください</h1>

    <div class="container">
        <!-- 左側: テキスト入力エリア -->
        <div class="text-area">
            <textarea id="textInput" placeholder="ここにテキストを入力してください"></textarea>
            <button onclick="textToImage()">画像を作成</button>
        </div>

        <!-- 右側: キャンバスとダウンロードリンク -->
        <div class="canvas-area">
            <canvas id="textCanvas" width="591" height="354"></canvas>
            <a id="downloadLink" download="text_image.png">ここをクリックして画像をダウンロード</a>
        </div>
    </div>

    <script>
        function textToImage() {
            const canvas = document.getElementById('textCanvas');
            const ctx = canvas.getContext('2d');

            // キャンバスの背景色を白に設定
            ctx.fillStyle = "#FFFFFF";
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // テキストの取得
            const text = document.getElementById("textInput").value;
            const lines = text.split('\n');

            // フォントの設定
            const fontSize = 20;
            const fontFamily = '"Yu Mincho", "游明朝", serif';
            ctx.font = `${fontSize}px ${fontFamily}`;
            ctx.fillStyle = "#000000";

            // 行間の設定
            const lineSpacing = fontSize * 1.2;

            let yOffset = 50; // 上部のマージン
            const xOffset = 20; // 左側のマージン

            // 各行をキャンバスに描画
            lines.forEach(line => {
                ctx.fillText(line, xOffset, yOffset);
                yOffset += lineSpacing;
            });

            // 画像をダウンロードできるリンクを作成
            const downloadLink = document.getElementById('downloadLink');
            const currentTime = new Date().toISOString().slice(0, 19).replace(/:/g, '-'); // 日付と時間をファイル名に
            const fileName = `text_image_${currentTime}.png`;
            downloadLink.download = fileName;
            downloadLink.href = canvas.toDataURL('image/png');
        }
    </script>

</body>
</html>




