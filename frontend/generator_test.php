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
    <link rel="stylesheet" href="../css/generator_test.css">
    <script src="https://cdn.jsdelivr.net/npm/markdown-it/dist/markdown-it.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body>

<h1 id="bun">作成したい問題文を入力してください</h1>

<div class="container">
    <div class="text-area">
        <textarea id="markdown-input" rows="10" cols="50" placeholder="テキストを入力してください(MarkDownを使用できます)"></textarea><br>
        <input type="file" id="image-upload" accept="image/*"><br>
        <button id="generate-button">画像をダウンロード</button>
    </div>

    <div class="canvas-area">
        <div id="preview"></div>
    </div>
</div>

<script>
    const md = window.markdownit({ breaks: true });
    const textarea = document.getElementById('markdown-input');
    const preview = document.getElementById('preview');
    const generateButton = document.getElementById('generate-button');
    const imageUpload = document.getElementById('image-upload');

    textarea.addEventListener('input', () => {
        updatePreview();
    });

    imageUpload.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100%'; // プレビュー内での画像の最大幅を指定
                img.style.height = 'auto'; // 高さを自動で調整
                preview.appendChild(img); // プレビューに画像を追加
            };
            reader.readAsDataURL(file);
        }
    });

    function updatePreview() {
        preview.innerHTML = md.render(textarea.value);
        adjustFontSize();
    }

    generateButton.addEventListener('click', () => {
        const originalZoom = preview.style.zoom;
        preview.style.zoom = "100%";  // 画像生成前にズーム解除

        html2canvas(preview, { scale: 2 }).then(canvas => {
            preview.style.zoom = originalZoom;

            // キャンバスを画像データURLに変換
            const imageData = canvas.toDataURL('image/jpg');

            // 画像を自動的にダウンロード
            const a = document.createElement('a');
            a.href = imageData;
            const currentTime = new Date().toISOString().slice(0, 19).replace(/:/g, '-');
            a.download = `text_image_${currentTime}.jpg`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            // PHPに画像データを送信
            fetch('your_php_script.php', { // PHPスクリプトのパスを指定
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ image: imageData })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Image saved as:', data.filename);
                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
        });
    });

    function adjustFontSize() {
        let fontSize = 50; // 初期フォントサイズ
        preview.style.fontSize = fontSize + 'px';

        // コンテンツが枠内に収まるまでフォントサイズを調整
        while (preview.scrollHeight > preview.clientHeight || preview.scrollWidth > preview.clientWidth) {
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
    <button onclick="location.href='generator_answer.php'">解説文作成ページヘ</button>
</div>
</body>
</html>
