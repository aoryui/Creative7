<?php
require_once __DIR__ . '/header.php';
?>

<div class="container-otoi">
    <form action="submit.php" method="post">
        <div class="form-group">
            <label for="name">名前:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">メールアドレス:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="message">お問い合わせ内容:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="form-groupa">送信</button>
    </form>
</div>
</body>

</html>