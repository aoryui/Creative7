<?php
require_once __DIR__ . '/header_kanrisya.php'; //ヘッダー指定
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['image'])) {
        // Get the base64 encoded image
        $imageData = $data['image'];

        // Remove the base64 header (data:image/jpg;base64,)
        $imageData = str_replace('data:image/jpg;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);

        // Decode the image
        $decodedImage = base64_decode($imageData);

        // Save the image
        $fileName = 'generated_image_' . time() . '.jpg';
        file_put_contents($fileName, $decodedImage);

        // Send response
        echo json_encode(['success' => true, 'filename' => $fileName]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'No image data received.']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テキストから画像へ</title>
    <link rel="stylesheet" href="../css/generator_answer.css">
    <script src="https://cdn.jsdelivr.net/npm/markdown-it/dist/markdown-it.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body>

<h1 id="bun">作成したい解説文を入力してください</h1>

    <div class="container">
        <!-- 左側: テキスト入力エリア -->
        <div class="text-area">
            <textarea id="markdown-input" rows="10" cols="50" placeholder="テキストを入力してください(MarkDownを使用できます)"></textarea><br>
            <button id="generate-button">画像生成</button>
        </div>

        <!-- 右側: キャンバスとダウンロードリンク -->
        <div class="canvas-area">
            <div id="preview"></div>
            <a id="downloadLink">画像をダウンロード</a>
        </div>
    </div>

    <script>
        // markdown-it のインスタンスを作成し、改行を許可するオプションを追加
        const md = window.markdownit({
            breaks: true  // 改行を <br> に変換するオプション
        });
        const textarea = document.getElementById('markdown-input');
        const preview = document.getElementById('preview');
        const generateButton = document.getElementById('generate-button');
        const downloadLink = document.getElementById('downloadLink');

        // プレビューの最大サイズを取得
        const maxPreviewHeight = preview.clientHeight;
        const maxPreviewWidth = preview.clientWidth;

        // MarkdownをHTMLに変換し、プレビューに表示
        textarea.addEventListener('input', () => {
            updatePreview();
        });

        function updatePreview() {
            preview.innerHTML = md.render(textarea.value);
            adjustFontSize();
        }

        // プレビューされたHTMLを画像として生成
        generateButton.addEventListener('click', () => {
            // 一時的にzoomを解除
            const originalZoom = preview.style.zoom;
            preview.style.zoom = "100%";  // 画像生成前にズーム解除

            html2canvas(preview, {
                width: 1182,  // 画像の幅を指定
                height: 709,  // 画像の高さを指定
                scale: 2      // 高解像度で生成するためのスケール
            }).then(canvas => {
                // zoomを元に戻す
                preview.style.zoom = originalZoom;

                // キャンバスを画像データURLに変換
                const imageData = canvas.toDataURL('image/jpg');

                // 画像のダウンロードリンクを作成
                const currentTime = new Date().toISOString().slice(0, 19).replace(/:/g, '-'); // 現在の日時をファイル名に
                const fileName = `text_image_${currentTime}.jpg`;
                downloadLink.download = fileName;
                downloadLink.href = imageData;

                // ダウンロードリンクを表示
                downloadLink.style.display = 'inline';
            });
        });

        function adjustFontSize() {
            let fontSize = 50; // 初期フォントサイズ
            preview.style.fontSize = fontSize + 'px';

            // コンテンツが枠内に収まるまでフォントサイズを調整
            while (preview.scrollHeight > maxPreviewHeight || preview.scrollWidth > maxPreviewWidth) {
                fontSize -= 1; // フォントサイズを1pxずつ減らす
                preview.style.fontSize = fontSize + 'px';

                // フォントサイズが小さすぎる場合は停止
                if (fontSize <= 10) {
                    break;
                }
            }
        }
    </script>

        <div class="button-container">
            <button onclick="location.href='generator_test.php'">問題文作成ページヘ</button>
        </div>
</body>
</html>
