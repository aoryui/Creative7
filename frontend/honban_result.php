<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../backend/class.php';
$form = new form();
require_once __DIR__ . '/../backend/pre.php';
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
    $username1 = $_SESSION['userName'];
}

// データベース接続設定
$host = 'localhost';
$dbname = 'creative7';
$username = 'Creative7';
$password = '11111';

// MySQLi を使った接続
$conn = new mysqli($host, $username, $password, $dbname);

// 接続エラーの確認
if ($conn->connect_error) {
    die("データベース接続エラー: " . $conn->connect_error);
}

// セッションから開いたページのファイル名を取得
$test_display = isset($_SESSION['test_display']) ? $_SESSION['test_display'] : [];

// リザルト画面のファイル場所をセッションに保存
$_SESSION['result_display'] = 'honban';

$displayed_questions = isset($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : [];
$selected_choice = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];
$interval_time = isset($_SESSION['interval_time']) ? $_SESSION['interval_time'] : [];
$already_saved = isset($_SESSION['already_saved']) ? $_SESSION['already_saved'] : [];

// 正誤判定用の配列を初期化
$correct_answers = [];  // 各問題の正誤を格納する配列
$genres = [];  // 各問題の分野を格納する配列
$correct_choices = [];  // 各問題の正解選択肢IDを格納する配列
$questionTexts = []; // 問題のテキストを格納する配列

$total_time = 0; // 合計回答時間
$total_time_lang = 0;
$total_time_nonlang = 0;
$total_questions = count($displayed_questions); // 問題数
$total_questions_lang = 0;
$total_questions_nonlang = 0;
$correct_count = 0; // 正解数
$correct_count_lang = 0;
$correct_count_nonlang = 0;

// 各問題の正誤を判定する
foreach ($displayed_questions as $key => $question_id) {
    // 問題IDに対応する正解の選択肢IDを取得するクエリ
    $query = "SELECT correct_choice_id FROM answers WHERE question_id = $question_id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('クエリ実行に失敗しました: ' . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    $correct_choice_id = $row['correct_choice_id'];
    $correct_choices[] = $correct_choice_id;

    // 選択された選択肢IDを取得
    $selected_choice_id = isset($selected_choice[$key]) ? $selected_choice[$key] : null;

    // 正誤判定
    if ($selected_choice_id == $correct_choice_id) {
        // 正解の場合のSQL
        $sql_correct = "INSERT INTO question_statistics (question_id, total_answers, incorrect_answers)
                        VALUES ($question_id, 1, 0) -- 初回回答
                        ON DUPLICATE KEY UPDATE
                        total_answers = total_answers + 1";

        // 正解の場合の処理
        $conn->query($sql_correct); // $conn はデータベース接続オブジェクト
        $correct_answers[$question_id] = true; // 正解の場合
        $correct_count++; // 正解数をカウント
    } else {
        // 不正解の場合のSQL
        $sql_incorrect = "INSERT INTO question_statistics (question_id, total_answers, incorrect_answers)
                        VALUES ($question_id, 1, 1) -- 初回回答
                        ON DUPLICATE KEY UPDATE
                        total_answers = total_answers + 1,
                        incorrect_answers = incorrect_answers + 1";

        // 不正解の場合の処理
        $conn->query($sql_incorrect); // $conn はデータベース接続オブジェクト
        $correct_answers[$question_id] = false; // 不正解の場合
    }

    // 分野名を取得するクエリ
    $genre_query = "SELECT genre_text FROM questions WHERE question_id = $question_id";
    $genre_result = mysqli_query($conn, $genre_query);

    if (!$genre_result) {
        die('クエリ実行に失敗しました: ' . mysqli_error($conn));
    }

    $genre_row = mysqli_fetch_assoc($genre_result);
    $genres[$question_id] = $genre_row['genre_text'];

    // 問題名を取得するクエリ
    $questionText_query = "SELECT sentence FROM questions WHERE question_id = $question_id";
    $questionText_result = mysqli_query($conn, $questionText_query);

    if (!$questionText_result) {
        die('クエリ実行に失敗しました: ' . mysqli_error($conn));
    }

    $questionText_row = mysqli_fetch_assoc($questionText_result);
    $questionTexts[$question_id] = $questionText_row['sentence'];

    // 回答時間を合計に追加
    if (isset($interval_time[$key]) && $interval_time[$key] !== '時間切れ') {
        $total_time += intval($interval_time[$key]);
    }

    // 言語非言語カウント
    $field_query = "SELECT field_id FROM questions WHERE question_id = $question_id";
    $field_result = mysqli_query($conn, $field_query);
    if (!$field_result) {
        die('クエリ実行に失敗しました: ' . mysqli_error($conn));
    }
    $field_row = mysqli_fetch_assoc($field_result);
    if($field_row['field_id'] === '1'){
        $total_questions_lang++; // 問題数をカウント
        if (isset($interval_time[$key]) && $interval_time[$key] !== '時間切れ') {
            $total_time_lang += intval($interval_time[$key]); // 回答時間をカウント
        }
        if ($selected_choice_id == $correct_choice_id) {
            $correct_count_lang++; // 正解数をカウント
        }
    }
    elseif($field_row['field_id'] === '2'){
        $total_questions_nonlang++; // 問題数をカウント
        if (isset($interval_time[$key]) && $interval_time[$key] !== '時間切れ') {
            $total_time_nonlang += intval($interval_time[$key]); // 回答時間をカウント
        }
        if ($selected_choice_id == $correct_choice_id) {
            $correct_count_nonlang++; // 正解数をカウント
        }
    }
}

// 制限時間があるか判定
$interval_time_empty = empty($interval_time);

$getUser = $form->getUser($userid); // ユーザーが存在するか確認
if($getUser === true){ // ログインしている時のみ間違えた問題を保存
    // 間違えた問題を取得
    $incorrect_questions = array_keys(array_filter($correct_answers, function($value) {return $value === false;}));
    sort($incorrect_questions); // 問題番号を昇順にソート
    echo '<script>console.log('.json_encode($incorrect_questions).')</script>';

    foreach ($incorrect_questions as $index => $question_id) {
        $quesid = $form->insert($userid, $incorrect_questions[$index]);
    }
}

// 正解と選択肢のセッション保存
$_SESSION['correct_choices'] = $correct_choices;
$_SESSION['selected_choice'] = $selected_choice;

// 平均回答時間を計算
if (!$interval_time_empty) { // 制限時間がない場合は計算しない
    $average_time = $total_time / $total_questions;
    $average_time = round($average_time);
    $average_time_lang = $total_time_lang / $total_questions_lang;
    $average_time_lang = round($average_time_lang);
    $average_time_nonlang = $total_time_nonlang / $total_questions_nonlang;
    $average_time_nonlang = round($average_time_nonlang);        
    $correct_rate_lang = ($correct_count_lang / $total_questions_lang) * 100;
    $correct_rate_nonlang = ($correct_count_nonlang / $total_questions_nonlang) * 100;
}
$correct_rate = ($correct_count / $total_questions) * 100; // 正答率を計算
// データベースに正答率、平均回答時間、学習問題数を保存
$result = $form->getStatus($userid);    // 学習記録を取得
$level = $result['level']; 
$exp = $result['exp']; // 経験値
$maxExp = 10;

$correctRate = $result['correct_rate'];      // 正答率
$averageTime = $result['average_time'];      // 平均回答時間
$totalQuestions = $result['total_questions']; // 学習問題数
$correctRate_lang = $result['correct_rate_lang'];
$averageTime_lang = $result['average_time_lang'];
$totalQuestions_lang = $result['total_questions_lang'];
$correctRate_nonlang = $result['correct_rate_nonlang'];
$averageTime_nonlang = $result['average_time_nonlang'];
$totalQuestions_nonlang = $result['total_questions_nonlang'];

if ($already_saved === false && $test_display === 'test' && $getUser === true){ // result初表示、ログイン状態、模擬試験、の時だけDBに保存
    // 全体の結果
    // 回答率の計算
    $correct_rate_num = $correct_rate / 100; // %を小数に変換
    $correctRate_num = $correctRate / 100;
    // 正答率を計算
    $new_correctRate = (($correctRate_num*$totalQuestions + $correct_rate_num*$total_questions) / ($totalQuestions+$total_questions))*100;
    $new_correctRate = round($new_correctRate); // 四捨五入
    // 回答時間の計算
    $new_averageTime = ($average_time*$total_questions + $averageTime*$totalQuestions) / ($total_questions+$totalQuestions);
    $new_averageTime = round($new_averageTime); // 四捨五入
    // 問題数の合計を計算
    $new_totalQuestions = $totalQuestions+$total_questions;

    // 言語の結果
    // 回答率の計算
    $correct_rate_num_lang = $correct_rate_lang / 100; // %を小数に変換
    $correctRate_num_lang = $correctRate_lang / 100;
    // 正答率を計算
    $new_correctRate_lang = (($correctRate_num_lang*$totalQuestions_lang + $correct_rate_num_lang*$total_questions_lang) / ($totalQuestions_lang+$total_questions_lang))*100;
    $new_correctRate_lang = round($new_correctRate_lang); // 四捨五入
    // 回答時間の計算
    $new_averageTime_lang = ($average_time_lang*$total_questions_lang + $averageTime_lang*$totalQuestions_lang) / ($total_questions_lang+$totalQuestions_lang);
    $new_averageTime_lang = round($new_averageTime_lang); // 四捨五入
    // 問題数の合計を計算
    $new_totalQuestions_lang = $totalQuestions_lang+$total_questions_lang;
    
    // 非言語の結果
    // 回答率の計算
    $correct_rate_num_nonlang = $correct_rate_nonlang / 100; // %を小数に変換
    $correctRate_num_nonlang = $correctRate_nonlang / 100;
    // 正答率を計算
    $new_correctRate_nonlang = (($correctRate_num_nonlang*$totalQuestions_nonlang + $correct_rate_num_nonlang*$total_questions_nonlang) / ($totalQuestions_nonlang+$total_questions_nonlang))*100;
    $new_correctRate_nonlang = round($new_correctRate_nonlang); // 四捨五入
    // 回答時間の計算
    $new_averageTime_nonlang = ($average_time_nonlang*$total_questions_nonlang + $averageTime_nonlang*$totalQuestions_nonlang) / ($total_questions_nonlang+$totalQuestions_nonlang);
    $new_averageTime_nonlang = round($new_averageTime_nonlang); // 四捨五入
    // 問題数の合計を計算
    $new_totalQuestions_nonlang = $totalQuestions_nonlang+$total_questions_nonlang;

    // ここにclass.phpのupdateStatusを実行するコード
    $form->updateStatus($userid, $correct_count, $new_correctRate, $new_averageTime, $new_totalQuestions, $new_correctRate_lang, $new_averageTime_lang, $new_totalQuestions_lang, $new_correctRate_nonlang, $new_averageTime_nonlang, $new_totalQuestions_nonlang);
    $_SESSION['already_saved'] = true; // DBに保存したことをセッションに保存
    $exp = $exp + $correct_count; // 経験値表示のズレを修正
}

// 経験値が最大経験値に到達またはそれを超えた場合の処理
if ($exp >= $maxExp) {
    // レベルアップ時に余剰経験値を計算し、$expをリセット
    $level = $level + floor($exp / $maxExp); // レベルアップ
    $exp = $exp % $maxExp; 
    // データベースのexpフィールドを更新
    $update_sql = "UPDATE userinfo SET exp = $exp, level = $level WHERE userid = $userid";
    $conn->query($update_sql);   
}

// 一問以上正解していた場合の条件
if ($correct_count > 0) {
    // badge_idが8のバッジを取得
    $badge_query = "SELECT badge_id FROM badge_collections WHERE badge_id = 8";
    $badge_result = $conn->query($badge_query);

    if ($badge_result && $badge_result->num_rows > 0) {
        // 取得したbadge_idをowned_badgeテーブルに挿入
        $row = $badge_result->fetch_assoc();
        $badge_id = $row['badge_id'];

        // すでにそのバッジを所有していないか確認
        $check_query = "SELECT * FROM owned_badge WHERE userid = $userid AND badge_id = $badge_id";
        $check_result = $conn->query($check_query);

        if ($check_result && $check_result->num_rows === 0) {
            // バッジを挿入
            $insert_badge_query = "INSERT INTO owned_badge (userid, badge_id) VALUES ($userid, $badge_id)";
            if ($conn->query($insert_badge_query) === TRUE) {
                echo "<script>console.log('Badge $badge_id granted to user $userid.');</script>";
            } else {
                echo "<script>console.error('Failed to insert badge: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>console.log('Badge $badge_id already owned by user $userid.');</script>";
        }
    } else {
        // 条件に該当しない場合は何もしない
        // No operation needed
    }
}

if ($correct_count > 3 && $averageTime < 1) { //3問連続正解かつ平均回答時間が1秒
    // badge_idが9のバッジを取得
    $badge_query = "SELECT badge_id FROM badge_collections WHERE badge_id = 9";
    $badge_result = $conn->query($badge_query);

    if ($badge_result && $badge_result->num_rows > 0) {
        // 取得したbadge_idをowned_badgeテーブルに挿入
        $row = $badge_result->fetch_assoc();
        $badge_id = $row['badge_id'];

        // すでにそのバッジを所有していないか確認
        $check_query = "SELECT * FROM owned_badge WHERE userid = $userid AND badge_id = $badge_id";
        $check_result = $conn->query($check_query);

        if ($check_result && $check_result->num_rows === 0) {
            // バッジを挿入
            $insert_badge_query = "INSERT INTO owned_badge (userid, badge_id) VALUES ($userid, $badge_id)";
            if ($conn->query($insert_badge_query) === TRUE) {
                echo "<script>console.log('Badge $badge_id granted to user $userid.');</script>";
            } else {
                echo "<script>console.error('Failed to insert badge: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>console.log('Badge $badge_id already owned by user $userid.');</script>";
        }
    } else {
        // 条件に該当しない場合は何もしない
        // No operation needed
    }
}

if ($correct_count > 7 && $averageTime < 20) { //平均回答時間が20秒かつ7問以上正解
    // badge_idが10のバッジを取得
    $badge_query = "SELECT badge_id FROM badge_collections WHERE badge_id = 10";
    $badge_result = $conn->query($badge_query);

    if ($badge_result && $badge_result->num_rows > 0) {
        // 取得したbadge_idをowned_badgeテーブルに挿入
        $row = $badge_result->fetch_assoc();
        $badge_id = $row['badge_id'];

        // すでにそのバッジを所有していないか確認
        $check_query = "SELECT * FROM owned_badge WHERE userid = $userid AND badge_id = $badge_id";
        $check_result = $conn->query($check_query);

        if ($check_result && $check_result->num_rows === 0) {
            // バッジを挿入
            $insert_badge_query = "INSERT INTO owned_badge (userid, badge_id) VALUES ($userid, $badge_id)";
            if ($conn->query($insert_badge_query) === TRUE) {
                echo "<script>console.log('Badge $badge_id granted to user $userid.');</script>";
            } else {
                echo "<script>console.error('Failed to insert badge: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>console.log('Badge $badge_id already owned by user $userid.');</script>";
        }
    } else {
        // 条件に該当しない場合は何もしない
        // No operation needed
    }
}

if ($correct_count == 10) {  //10問連続正解
    // badge_idが11のバッジを取得
    $badge_query = "SELECT badge_id FROM badge_collections WHERE badge_id = 11";
    $badge_result = $conn->query($badge_query);

    if ($badge_result && $badge_result->num_rows > 0) {
        // 取得したbadge_idをowned_badgeテーブルに挿入
        $row = $badge_result->fetch_assoc();
        $badge_id = $row['badge_id'];

        // すでにそのバッジを所有していないか確認
        $check_query = "SELECT * FROM owned_badge WHERE userid = $userid AND badge_id = $badge_id";
        $check_result = $conn->query($check_query);

        if ($check_result && $check_result->num_rows === 0) {
            // バッジを挿入
            $insert_badge_query = "INSERT INTO owned_badge (userid, badge_id) VALUES ($userid, $badge_id)";
            if ($conn->query($insert_badge_query) === TRUE) {
                echo "<script>console.log('Badge $badge_id granted to user $userid.');</script>";
            } else {
                echo "<script>console.error('Failed to insert badge: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>console.log('Badge $badge_id already owned by user $userid.');</script>";
        }
    } else {
        // 条件に該当しない場合は何もしない
        // No operation needed
    }
}

if ($correct_count > 100) { //100問以上正解
    // badge_idが12のバッジを取得
    $badge_query = "SELECT badge_id FROM badge_collections WHERE badge_id = 12";
    $badge_result = $conn->query($badge_query);

    if ($badge_result && $badge_result->num_rows > 0) {
        // 取得したbadge_idをowned_badgeテーブルに挿入
        $row = $badge_result->fetch_assoc();
        $badge_id = $row['badge_id'];

        // すでにそのバッジを所有していないか確認
        $check_query = "SELECT * FROM owned_badge WHERE userid = $userid AND badge_id = $badge_id";
        $check_result = $conn->query($check_query);

        if ($check_result && $check_result->num_rows === 0) {
            // バッジを挿入
            $insert_badge_query = "INSERT INTO owned_badge (userid, badge_id) VALUES ($userid, $badge_id)";
            if ($conn->query($insert_badge_query) === TRUE) {
                echo "<script>console.log('Badge $badge_id granted to user $userid.');</script>";
            } else {
                echo "<script>console.error('Failed to insert badge: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>console.log('Badge $badge_id already owned by user $userid.');</script>";
        }
    } else {
        // 条件に該当しない場合は何もしない
        // No operation needed
    }
}

// ログ表示
echo '<script>console.log('.json_encode($displayed_questions).')</script>';
echo '<script>console.log('.json_encode($selected_choice).')</script>';
echo '<script>console.log('.json_encode($correct_choices).')</script>';
// データベース接続をクローズ
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/result.css">
    <link rel="stylesheet" href="../responsive/honban_resulit.css">
    <!-- 制限時間がない場合はcssで非表示にするやつ -->
    <style>
        <?php if ($interval_time_empty): ?>
        .interval-time-header,
        .interval-time-cell,
        .average-time {
            display: none;
        }
        <?php endif; ?>
    </style>
</head>
<body>
    <div class="border-frame">
        <?php if (!$interval_time_empty): // 制限時間がない場合は実行しない -->
            if ($username1 !== "ゲスト") { // ゲストアカウントは経験値表示しない
        ?>
            <div><?php echo "レベル", $level?></div>
            <div class="level-bar-container">
                <div class="level-bar"></div>
            </div>
            <div><?php echo "exp", $exp ,"/", $maxExp?></div>
            <div><?php echo $correct_count,"exp獲得！" ?> </div>
        <?php
            }
        ?>
            <h2 class="average-time">平均回答時間: <?php echo $average_time; ?>秒</h2>
        <?php endif; ?>
        <h2 class="correct-rate">正答率: <?php echo round($correct_rate, 2); ?>%</h2>

        <table border="1" id="table">
            <tr>
                <th>問題No.</th>
                <th>正誤</th>
                <th>分野</th>
                <th>問題文</th>
                <?php if (!$interval_time_empty): ?><!-- 制限時間がない場合は非表示 -->
                    <th class="interval-time-header">回答時間</th>
                <?php endif; ?>
                <th>解説</th>
                <th>復習</th>
            </tr>
            <?php foreach ($displayed_questions as $key => $question): ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $correct_answers[$question] ? '○' : '×'; ?></td>
                    <td><?php echo htmlspecialchars($genres[$question], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td id="custom-question"><?php echo htmlspecialchars($questionTexts[$question], ENT_QUOTES, 'UTF-8'); ?></td>
                    <?php if (!$interval_time_empty): ?> <!-- 制限時間がない場合は非表示 -->
                        <td class="interval-time-cell"><?php echo (isset($interval_time[$key]) && $interval_time[$key] === '時間切れ') ? $interval_time[$key] : (isset($interval_time[$key]) ? $interval_time[$key] . '秒' : ''); ?></td>
                    <?php endif; ?>
                    <td id="tri"><a href="kaitoukaisetu.php?question_id=<?php echo $key; ?>">解説リンク</a></td>
                    <td id="tri"><a href="review_questions.php?question_id=<?php echo $displayed_questions[$key]; ?>">復習リンク</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script>
        // PHPから取得した経験値をJSに渡す
        const currentExp = <?= $exp ?>; // 経験値
        const maxExp = <?= $maxExp ?>; // 最大経験値

        // レベルバーを更新する関数
        function updateLevelBar(exp, maxExp) {
            const levelBar = document.querySelector('.level-bar');
            const percentage = (exp / maxExp) * 100;
            levelBar.style.width = percentage + '%'; // 経験値に応じてバーの幅を調整
        }

        // ページ読み込み時に経験値バーを更新
        window.onload = function() {
            updateLevelBar(currentExp, maxExp);
        }
    </script>
</body>
</html>
