<?php
session_start();
require_once __DIR__ . '/header.php';

// Initialize the lists
$_SESSION['displayed_questions'] = [];
$_SESSION['selected_choice'] = [];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="../css/teststart.css">
</head>
<body>
    <main>
        <div class="honbanmain">
            <div class="container">
                <div class="content">
                    <p>ランダムで想定された問題が20個出題されます。
                    <p></p>
                       時間までに解いてください。
                    <p></p>
                       時間が過ぎると次の問題に自動的に飛ばされます。</p>
                    <p></p>
                    メモ用紙と筆記用具を用意してください。
                </div>
                <div class="button-container">
                    <form method="post" action="test.php">
                        <label for="interval">問題の移り変わる時間を選択してください:</label>
                        <select name="interval" id="interval">
                            <option value="20">20秒</option>
                            <option value="30">30秒</option>
                            <option value="60">60秒</option>
                        </select>
                        <input type="hidden" name="displayed_questions" value='<?php echo json_encode($_SESSION['displayed_questions']); ?>'>
                        <input type="hidden" name="selected_choice" value='<?php echo json_encode($_SESSION['selected_choice']); ?>'>
                        <input type="submit" value="模擬試験を開始する">
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
