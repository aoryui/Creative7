<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テキストから画像へ</title>
    <style>
        body {
            font-family: 'Meiryo', sans-serif;
            text-align: center;
            padding-top: 50px;
        }
        textarea {
            width: 80%;
            height: 150px;
            font-size: 14px;
        }
        canvas {
            border: 1px solid black;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h1>テキストから画像へ</h1>

    <textarea id="textInput" placeholder="ここにテキストを入力してください"></textarea><br><br>
    <button onclick="textToImage()">画像を作成</button><br><br>
    <a id="downloadLink" download="text_image.png">ここをクリックして画像をダウンロード</a>

    <canvas id="textCanvas" width="1182" height="709"></canvas><br>

    <script>
        function textToImage() {
            const canvas = document.getElementById('textCanvas');
            const ctx = canvas.getContext('2d');

            // 画像サイズ、背景色を設定
            ctx.fillStyle = "#FFFFFF";
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // テキストの取得
            const text = document.getElementById("textInput").value;
            const lines = text.split('\n');

            // フォントの設定
            const fontSize = 40;
            const fontFamily = '"Yu Mincho", "游明朝", serif';
            ctx.font = `${fontSize}px ${fontFamily}`;
            ctx.fillStyle = "#000000";

            // 行間の設定
            const lineSpacing = fontSize * 1.08;

            let yOffset = 100; // 上部のマージン
            const xOffset = 50; // 左側のマージン（固定値）

            // 各行をキャンバスに描画
            lines.forEach(line => {
                ctx.fillText(line, xOffset, yOffset); // 左寄せ
                yOffset += lineSpacing;
            });

            // 画像をダウンロードできるリンクを作成
            const downloadLink = document.getElementById('downloadLink');
            const currentTime = new Date().toISOString().slice(0, 19).replace(/:/g, '-'); // 日付と時間をファイル名に
            const fileName = `text_image_${currentTime}.png`;
            downloadLink.download = fileName; // ファイル名を設定
            downloadLink.href = canvas.toDataURL('image/png');
        }
    </script>

</body>
</html>
