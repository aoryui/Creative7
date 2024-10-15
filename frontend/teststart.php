<?php
session_start();
require_once __DIR__ . '/header.php';

// Initialize the lists
$_SESSION['displayed_questions'] = [];
$_SESSION['selected_choice'] = [];
$_SESSION['interval_time'] = [];
$_SESSION['already_saved'] = false;
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
                    <p>ランダムで想定された問題が10個出題されます。</p>
                    <p>時間までに解いてください。</p>
                    <p>時間が過ぎると次の問題に自動的に飛ばされます。</p>
                    <p>メモ用紙と筆記用具を用意してください。</p>
                </div>
                <div class="button-container">
                    <form method="post" action="test.php">
                        <input type="hidden" name="displayed_questions" value='<?php echo json_encode($_SESSION['displayed_questions']); ?>'>
                        <input type="hidden" name="selected_choice" value='<?php echo json_encode($_SESSION['selected_choice']); ?>'>
                        <input type="hidden" name="interval_time" value='<?php echo json_encode($_SESSION['interval_time']); ?>'>
                        <input type="hidden" name="already_saved" value='<?php echo json_encode($_SESSION['already_saved']); ?>'>
                        <input type="submit" value="模擬試験を開始する">
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
