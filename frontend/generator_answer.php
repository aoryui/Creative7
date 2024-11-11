<?php
require_once __DIR__ . '/header_kanrisya.php';

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

<h1 id="bun">作成したい解説文を入力してください</h1>
<button class="button" id="add-heading">拡大</button>
<button class="button" id="add-bold">太字</button>
<button class="button" id="add-list">リスト</button>
<button class="button" id="add-line-break">改行</button> <!-- 改行ボタンを追加 -->

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
    const addHeadingButton = document.getElementById('add-heading');
    const addBoldButton = document.getElementById('add-bold');
    const addListButton = document.getElementById('add-list');
    const addLineBreakButton = document.getElementById('add-line-break'); // 改行ボタンを取得

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
                img.style.maxWidth = '100%';
                img.style.height = 'auto';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });

    addHeadingButton.addEventListener('click', () => {
        const currentText = textarea.value;
        textarea.value = `# ${currentText}`;
        updatePreview();
    });

    addBoldButton.addEventListener('click', () => {
        const selectedText = textarea.value.substring(textarea.selectionStart, textarea.selectionEnd) || "太字にしたいテキスト";
        const currentText = textarea.value;
        textarea.value = `${currentText} **${selectedText}**`;
        updatePreview();
    });

    addListButton.addEventListener('click', () => {
        const currentText = textarea.value;
        textarea.value = `${currentText}- `;
        updatePreview();
    });

    // 改行ボタンのクリックで `  \n` を追加
    addLineBreakButton.addEventListener('click', () => {
        const currentText = textarea.value;
        textarea.value = `${currentText}  \n`;
        updatePreview();
    });

    function updatePreview() {
        preview.innerHTML = md.render(textarea.value);
        adjustFontSize();
    }

    generateButton.addEventListener('click', () => {
        const originalZoom = preview.style.zoom;
        preview.style.zoom = "100%";

        html2canvas(preview, { scale: 2 }).then(canvas => {
            preview.style.zoom = originalZoom;

            const imageData = canvas.toDataURL('image/jpg');

            const a = document.createElement('a');
            a.href = imageData;
            const currentTime = new Date().toISOString().slice(0, 19).replace(/:/g, '-');
            a.download = `text_image_${currentTime}.jpg`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            fetch('your_php_script.php', {
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
        let fontSize = 50;
        preview.style.fontSize = fontSize + 'px';

        while (preview.scrollHeight > preview.clientHeight || preview.scrollWidth > preview.clientWidth) {
            fontSize -= 1;
            preview.style.fontSize = fontSize + 'px';

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
