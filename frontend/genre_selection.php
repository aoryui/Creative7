<?php
require_once __DIR__ . '/header.php'; //ヘッダー指定
require_once __DIR__ . '/../backend/class.php';
require_once __DIR__ . '/../backend/pre.php';

$form = new form();
// ゲストの場合true、ログインしている場合false
$is_guest = ($username === 'ゲスト'); 

// ジャンルごとの解いた問題数と総問題数の比率を取得
$solved_ratios = $form->get_question_solved_ratios($userid);

// ジャンル名を配列に格納
$genre_names = [
    1 => [
        1 => "二語の関係",
        2 => "熟語の意味",
        3 => "語句の用法",
        4 => "文章の整序",
        5 => "空欄の補充"
    ],
    2 => [
        1 => "場合の数",
        2 => "推論",
        3 => "割合",
        4 => "確率",
        5 => "金額計算",
        6 => "分担計算",
        7 => "速度算",
        8 => "集合",
        9 => "表の読み取り",
        10 => "特殊計算"
    ]
];

// 解いた問題数と総問題数のデータをジャンル名に紐づける
$solved_data = [];
foreach ($solved_ratios as $ratio) {
    $field_id = $ratio['field_id'];
    $genre_id = $ratio['genre_id'];
    $solved_data[$field_id][$genre_id] = [
        'solved' => $ratio['solved_questions'],
        'total' => $ratio['total_questions']
    ];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPIタイサくん</title>
    <link rel="stylesheet" href="../css/genre_selection.css">
    <link rel="stylesheet" href="../responsive/genre_selection.css">
</head>

<body>
    <div class="border-frame">
        <div class="flex-inner" data-box-color="white">
            <h2>ジャンルを選択してください</h2>
            <form method="post" action="../backend/genre.php" onsubmit="return validateForm()">
                <!-- 言語系 -->
                <fieldset class="contain-left">
                    <legend>
                        <label>
                            言語
                        </label>
                    </legend>
                    
                    <div class="language-list-container">
                        <ul class="language-list primary">
                        <p><input type="checkbox" id="CheckLanguage">全選択</p>
                            <?php foreach ($genre_names[1] as $genre_id => $genre_name): ?>
                                <li class="genre-item">
                                    <label for="genre<?= $genre_id ?>" class="genre-label">
                                        <input type="checkbox" class="language-checkbox" id="genre<?= $genre_id ?>" name="language[]" value="<?= $genre_id ?>">
                                        <span class="genre-name"><?= $genre_name ?></span>
                                        <span class="genre-stats">
                                            <?php
                                            $data = $solved_data[1][$genre_id] ?? ['solved' => 0, 'total' => 0];
                                            if ($is_guest) { 
                                                // ゲスト場合
                                                echo "{$data['total']}問";
                                            } else {
                                                // ログインしている場合
                                                echo "{$data['solved']}/{$data['total']}問";
                                            }
                                            ?>
                                        </span>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </fieldset>

                <!-- 非言語系 -->
                <fieldset class="contain-right">
                    <legend>
                        <label>
                             非言語
                        </label>
                    </legend>
                    <div class="non-language-list-container">
                        <ul class="non-language-list primary">
                        <p class="tasukete"><input type="checkbox" id="CheckNonLanguage">全選択</p>
                        <?php foreach ($genre_names[2] as $genre_id => $genre_name): ?>
    <li class="genre-item <?php echo ($genre_id >= 6 && $genre_id <= 10) ? 'special-class' : ''; ?>">
        <label for="genre<?= $genre_id + 5 ?>" class="genre-label">
            <input type="checkbox" class="non-language-checkbox" id="genre<?= $genre_id + 5 ?>" name="non_language[]" value="<?= $genre_id ?>">
            <span class="genre-name"><?= $genre_name ?></span>
            <span class="genre-stats">
                <?php
                $data = $solved_data[2][$genre_id] ?? ['solved' => 0, 'total' => 0];
                if ($is_guest) {
                    // ゲストの場合
                    echo "{$data['total']}問";
                } else {
                    // ログインしている場合
                    echo "{$data['solved']}/{$data['total']}問";
                }
                ?>
            </span>
        </label>
    </li>
<?php endforeach; ?>
                        </ul>
                    </div>
                </fieldset>
                <button class="button" type="submit">選択</button>
            </form>
        </div>
    </div>
</body>
</html>

<!-- javascript -->
<script>
const checkLanguage = document.getElementById("CheckLanguage");
const languageCheckboxes = document.querySelectorAll(".language-checkbox");

const checkNonLanguage = document.getElementById("CheckNonLanguage");
const nonLanguageCheckboxes = document.querySelectorAll(".non-language-checkbox");

// 言語系全選択のチェックボックスがクリックされた時
checkLanguage.addEventListener("change", () => {
    languageCheckboxes.forEach((checkbox) => {
        checkbox.checked = checkLanguage.checked;
    });
});

// 言語系の個別チェックボックスがクリックされた時
for (let checkbox of languageCheckboxes) {
    checkbox.addEventListener('click', () => {
        if (!checkbox.checked) {
            checkAllLanguage.checked = false;
        } else if (document.querySelectorAll(".language-checkbox:checked").length === languageCheckboxes.length) {
            checkAllLanguage.checked = true;
        }
    });
}

// 非言語系全選択のチェックボックスがクリックされた時
checkNonLanguage.addEventListener("change", () => {
    nonLanguageCheckboxes.forEach((checkbox) => {
        checkbox.checked = checkNonLanguage.checked;
    });
});

// 非言語系の個別チェックボックスがクリックされた時
for (let checkbox of nonLanguageCheckboxes) {
    checkbox.addEventListener('click', () => {
        if (!checkbox.checked) {
            checkAllNonLanguage.checked = false;
        } else if (document.querySelectorAll(".non-language-checkbox:checked").length === nonLanguageCheckboxes.length) {
            checkAllNonLanguage.checked = true;
        }
    });
}

// フォーム送信時にチェックボックスが選択されているか確認
function validateForm() {
    const languageChecked = document.querySelectorAll('.language-checkbox:checked').length > 0;
    const nonLanguageChecked = document.querySelectorAll('.non-language-checkbox:checked').length > 0;

    if (!languageChecked && !nonLanguageChecked) {
        alert("ジャンルを選択してください");
        return false; // フォーム送信を中止
    }
    return true; // フォーム送信を許可
}
</script>
