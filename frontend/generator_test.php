<?php
// 管理者用ヘッダーファイルを読み込み
require_once __DIR__ . '/header_kanrisya.php';

// POSTリクエストが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 送信されたJSONデータをデコード
    $data = json_decode(file_get_contents('php://input'), true);

    // 'image'キーが存在する場合の処理
    if (isset($data['image'])) {
        // Base64エンコードされた画像データを取得
        $imageData = $data['image'];

        // Base64ヘッダー部分 (data:image/jpg;base64,) を削除
        $imageData = str_replace('data:image/jpg;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);

        // 画像データをデコード
        $decodedImage = base64_decode($imageData);

        // 画像をファイルとして保存
        $fileName = 'generated_image_' . time() . '.jpg'; // 現在のタイムスタンプをファイル名に使用
        file_put_contents($fileName, $decodedImage);

        // 保存完了のレスポンスを返却
        echo json_encode(['success' => true, 'filename' => $fileName]);
        exit;
    } else {
        // 画像データが送信されなかった場合のエラーレスポンス
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
    <link rel="stylesheet" href="../css/generator_test.css"> <!-- 外部CSSファイルを読み込み -->
    <script src="https://cdn.jsdelivr.net/npm/markdown-it/dist/markdown-it.min.js"></script> <!-- MarkdownをHTMLに変換するライブラリ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script> <!-- HTMLを画像に変換するライブラリ -->
</head>
<body>

<h1 id="bun">作成したい問題文を入力してください</h1>
<!-- ボタン群 -->
<button class="button" id="add-heading">拡大</button> <!-- 見出しを追加するボタン -->
<button class="button" id="add-bold">太字</button> <!-- 太字を追加するボタン -->
<button class="button" id="add-list">リスト</button> <!-- リストを追加するボタン -->
<button class="button" id="add-line-break">改行</button> <!-- 改行を追加するボタン -->

<div class="container">
    <div class="text-area">
        <!-- Markdown入力用のテキストエリア -->
        <textarea id="markdown-input" rows="10" cols="50" placeholder="テキストを入力してください(MarkDownを使用できます)"></textarea><br>
        <!-- 画像アップロード用のファイル選択 -->
        <input type="file" id="image-upload" accept="image/*"><br>
        <button id="generate-button">画像をダウンロード</button> <!-- 画像生成ボタン -->
    </div>

    <div class="canvas-area">
        <div id="preview"></div> <!-- プレビューエリア -->
    </div>
</div>

<script>
    // Markdownライブラリのインスタンス化
    const md = window.markdownit({ breaks: true });

    // 各要素の取得
    const textarea = document.getElementById('markdown-input'); // Markdown入力エリア
    const preview = document.getElementById('preview'); // プレビューエリア
    const generateButton = document.getElementById('generate-button'); // 画像生成ボタン
    const imageUpload = document.getElementById('image-upload'); // 画像アップロードボタン
    const addHeadingButton = document.getElementById('add-heading'); // 見出しボタン
    const addBoldButton = document.getElementById('add-bold'); // 太字ボタン
    const addListButton = document.getElementById('add-list'); // リストボタン
    const addLineBreakButton = document.getElementById('add-line-break'); // 改行ボタン

    // テキストエリアの内容が変更されたらプレビューを更新
    textarea.addEventListener('input', () => {
        updatePreview();
    });

    // アップロードされた画像をプレビューに表示
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

    // 見出しボタンがクリックされた時の処理
    addHeadingButton.addEventListener('click', () => {
        const currentText = textarea.value;
        textarea.value = `# ${currentText}`; // 見出しのMarkdown記法を追加
        updatePreview();
    });

    // 太字ボタンがクリックされた時の処理
    addBoldButton.addEventListener('click', () => {
        const selectedText = textarea.value.substring(textarea.selectionStart, textarea.selectionEnd) || "太字にしたいテキスト";
        const currentText = textarea.value;
        textarea.value = `${currentText} **${selectedText}**`; // 太字のMarkdown記法を追加
        updatePreview();
    });

    // リストボタンがクリックされた時の処理
    addListButton.addEventListener('click', () => {
        const currentText = textarea.value;
        textarea.value = `${currentText}- `; // リストのMarkdown記法を追加
        updatePreview();
    });

    // 改行ボタンがクリックされた時の処理
    addLineBreakButton.addEventListener('click', () => {
        const currentText = textarea.value;
        textarea.value = `${currentText}  \n`; // Markdownの改行記法を追加
        updatePreview();
    });

    // プレビューを更新する関数
    function updatePreview() {
        preview.innerHTML = md.render(textarea.value); // MarkdownをHTMLに変換してプレビューに反映
        adjustFontSize(); // フォントサイズを調整
    }

    // 画像生成ボタンがクリックされた時の処理
    generateButton.addEventListener('click', () => {
        const originalZoom = preview.style.zoom; // 元のズーム設定を保存
        preview.style.zoom = "100%";

        html2canvas(preview, { scale: 2 }).then(canvas => {
            preview.style.zoom = originalZoom;

            const imageData = canvas.toDataURL('image/jpg'); // プレビューを画像に変換

            // 画像をダウンロード
            const a = document.createElement('a');
            a.href = imageData;
            const currentTime = new Date().toISOString().slice(0, 19).replace(/:/g, '-');
            a.download = `text_image_${currentTime}.jpg`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            // サーバーに画像を送信
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

    // プレビューエリアのフォントサイズを調整する関数
    function adjustFontSize() {
        let fontSize = 50; // 初期フォントサイズ
        preview.style.fontSize = fontSize + 'px';

        while (preview.scrollHeight > preview.clientHeight || preview.scrollWidth > preview.clientWidth) {
            fontSize -= 1;
            preview.style.fontSize = fontSize + 'px';

            if (fontSize <= 10) {
                break; // フォントサイズが最小値に達したら終了
            }
        }
    }
</script>

<div class="button-container">
    <button onclick="location.href='generator_answer.php'">解説文作成ページヘ</button>
</div>
</body>
</html>
