<?php
require_once __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>回答と解説画面</title>
    <link rel="stylesheet" href="../css/kaitoukaisetu.css">
</head>
<body>
    <div class="kaisetu1">        
        <main>
            <section class="kaitouran">
                <h2>回答</h2>
                <div class="kaitou">
                    <strong>貴方の回答:</strong>
                    <span id="user-kaitou">うんちな未来</span>
                </div>
                <div class="kaitou">
                    <strong>正解:</strong>
                    <span id="correct-kaitou">うんこな未来</span>
                </div>
            </section>
            <section class="kaiseturan">
                <h2>解説</h2>
                <p id="kaisetu">以下解説</p>
            </section>
        </main>
    </div>
</body>
</html>

