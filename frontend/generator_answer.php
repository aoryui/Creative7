<?php
require_once __DIR__ . '/header.php'; //ヘッダー指定
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テキストから画像へ</title>
    <link rel="stylesheet" href="../css/generator_answer.css">
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
            <canvas id="textCanvas" width="1477" height="591"></canvas>
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
        const fontSize = 45; // 画像と同等のサイズに調整
        const fontFamily = '"Yu Mincho", "游明朝", serif';
        ctx.font = `${fontSize}px ${fontFamily}`;
        ctx.fillStyle = "#000000";

        // 行間の設定
        const lineSpacing = fontSize * 1.2;

        // テキストの全体の高さを計算
        const totalTextHeight = lineSpacing * lines.length;

        // Y座標の開始位置をキャンバスの中央に設定
        let yOffset = (canvas.height - totalTextHeight) / 2; 

        // 各行をキャンバスの中央に描画
        lines.forEach(line => {
            // テキストの幅を取得し、X座標を中央に揃える
            const textWidth = ctx.measureText(line).width;
            const xOffset = (canvas.width - textWidth) / 2; // 中央に揃える
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