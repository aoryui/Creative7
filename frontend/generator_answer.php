<?php
require_once __DIR__ . '/header_kanrisya.php'; //ヘッダー指定
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

<h1 id="bun">作成したい解説文を入力してください</h1>

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
            const maxWidth = canvas.width - 2 * xOffset; // テキストの最大幅（左右のマージンを引いた幅）

            // テキストを描画する関数（自動改行対応）
            function wrapText(ctx, text, x, y, maxWidth, lineHeight) {
                const chars = text.split(''); // 文字を一つずつ取得
                let line = '';

                for (let i = 0; i < chars.length; i++) {
                    const testLine = line + chars[i];
                    const testWidth = ctx.measureText(testLine).width;

                    if (testWidth > maxWidth && line.length > 0) {
                        ctx.fillText(line, x, y); // 現在の行を描画
                        line = chars[i]; // 新しい行を開始
                        y += lineHeight; // Y位置を更新
                    } else {
                        line = testLine;
                    }
                }
                ctx.fillText(line, x, y); // 最後の行を描画
                return y + lineHeight; // 次の行のY位置を返す
            }

            // 各行を処理してキャンバスに描画
            lines.forEach(line => {
                yOffset = wrapText(ctx, line, xOffset, yOffset, maxWidth, lineSpacing);
            });

            // 画像をダウンロードできるリンクを作成
            const downloadLink = document.getElementById('downloadLink');
            const currentTime = new Date().toISOString().slice(0, 19).replace(/:/g, '-'); // 日付と時間をファイル名に
            const fileName = `text_image_${currentTime}.png`;
            downloadLink.download = fileName;
            downloadLink.href = canvas.toDataURL('image/png');
        }
    </script>

        <div class="button-container">
        <form method="post" action="generator_test.php">
        <input type="submit" value="問題文作成ページヘ">
</body>
</html>
