<?php
require_once __DIR__ . '/database/dbdata.php';
require_once __DIR__ . '/header.php';

if ($username === "ゲスト") {
    $_SESSION['login_error'] = '質問を投稿するにログインしてください。';
    header('Location: ' . 'login.php');
    exit();
}
?>

<script>
    function disableButton() {
        document.getElementById("submitButton").disabled = true;
        document.getElementById("submitButton").form.submit();
    }
</script>

<h1>IT質問用投稿フォーム</h1>
<!-- <p>ここはITに関する質問を投稿するためのフォームです。</p> -->
<p>状況や問題点が一目でわかるように詳細に情報や環境を入力すると回答される可能性が高くなります。
</p>
<div class="form-container">
    <div class="form-wrapper">
        <form action="insert.php" method="POST" enctype="multipart/form-data">
            <label for="title-input">タイトル</label>
            <input type="text" id="title-input" name="title-input" placeholder="タイトルを入力してください" required>
            <label for="message-input">詳細情報</label>
            <textarea id="message-input" name="message-input" placeholder="ここに詳細情報を入力してください" required></textarea>
            <label for="selection-input">開発言語を選択</label>
            <select id="selection-input" name="selection-input">
                <option value="option1">C言語</option>
                <option value="option2">C#</option>
                <option value="option3">C++</option>
                <option value="option4">Java</option>
                <option value="option5">Python</option>
                <option value="option6">HTML</option>
                <option value="option7">JavaScript</option>
                <option value="option8">SQL</option>
                <option value="option9">CSS</option>
                <option value="option10">PHP</option>
                <option value="option11">その他</option>
            </select>
            <input type="file" name="uploadfile" value="">
            <input type="submit" id="submitButton" value="投稿" onclick="disableButton()" class="form-groupb">
        </form>
    </div>
</div>
</body>

</html>