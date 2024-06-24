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
    <div class="kaisetu1">  
        <body>
        <main>
            <h2>回答</h2>
            <section class="kaitouran">
                <div class="kaitou">
                    <p>不正解</p>
                    <strong>貴方の回答:</strong>
                    <span id="user-kaitou">回答欄</span>
                </div>
                <div class="kaitou">
                    <strong>正解:</strong>
                    <span id="correct-kaitou">正解欄</span>
                </div>
            </section>
            <h2>解説</h2>
            <section class="kaiseturan">
                <p id="kaisetu">解説欄</p>
            </section>
        </main> 
        </div>
    </body>
</html>


