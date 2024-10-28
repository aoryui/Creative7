<?php
require_once __DIR__ . '/class.php'; // DbDataクラスをインポート

$uploadOk = 1;
$imageFileType1 = "";
$imageFileType2 = "";
$field_id = 0; // 初期化
$databaseSaveSuccess = false; // データベース保存成功フラグ

// アップロードされたファイルの処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ジャンルを取得
    $field = $_POST['field'];  // 例: "1_1", "2_1" など
    $genretext = $_POST['genre_name'];  // 例: "二語の関係", "語句の意味" など

    // field_id をジャンルの選択に基づいて設定
    if (strpos($field, "1_") === 0) {
        $field_id = 1; // 言語が選択された場合
    } elseif (strpos($field, "2_") === 0) {
        $field_id = 2; // 非言語が選択された場合
    }
    // 最後の数字を取得
    $parts = explode('_', $field);
    $genre = end($parts);

    // field_idが正しくセットされていなければデータベースには保存しない
    if ($field_id !== 0) {
        // 他のデータの処理 (ファイルのアップロードなど)
        if (!empty($_FILES["image1"]["name"]) && !empty($_FILES["image2"]["name"])) {
            $imageFileType1 = strtolower(pathinfo($_FILES["image1"]["name"], PATHINFO_EXTENSION));
            $imageFileType2 = strtolower(pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION));

            $errorMessages = [];

            if ($imageFileType1 != "jpg") {
                $errorMessages[] = "1つ目のファイルはJPG形式のみ許可されています。";
                $uploadOk = 0;
            }
            if ($imageFileType2 != "jpg") {
                $errorMessages[] = "2つ目のファイルはJPG形式のみ許可されています。";
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                $target_dir1 = "../image/問題集/";
                $target_dir2 = "../image/解説/";

                $new_file_name1 = findNextAvailableFileName($target_dir1, $field, "jpg");
                $new_file_name2 = findNextAvailableFileName($target_dir2, $field, "jpg");

                $check1 = getimagesize($_FILES["image1"]["tmp_name"]);
                $check2 = getimagesize($_FILES["image2"]["tmp_name"]);

                if ($check1 === false) {
                    $errorMessages[] = "1つ目のファイルは画像ではありません。";
                    $uploadOk = 0;
                }
                if ($check2 === false) {
                    $errorMessages[] = "2つ目のファイルは画像ではありません。";
                    $uploadOk = 0;
                }

                if ($_FILES["image1"]["size"] > 5000000) {
                    $errorMessages[] = "1つ目のファイルサイズが大きすぎます。";
                    $uploadOk = 0;
                }
                if ($_FILES["image2"]["size"] > 5000000) {
                    $errorMessages[] = "2つ目のファイルサイズが大きすぎます。";
                    $uploadOk = 0;
                }

                if ($uploadOk == 1) {
                    if (move_uploaded_file($_FILES["image1"]["tmp_name"], $target_dir1 . $new_file_name1)) {
                        echo "1つ目のファイル " . $new_file_name1 . " がアップロードされました。";
                    } else {
                        echo "1つ目のファイルのアップロード中にエラーが発生しました。";
                    }

                    if (move_uploaded_file($_FILES["image2"]["tmp_name"], $target_dir2 . $new_file_name2)) {
                        echo "2つ目のファイル " . $new_file_name2 . " がアップロードされました。";
                    } else {
                        echo "2つ目のファイルのアップロード中にエラーが発生しました。";
                    }

                    // データベースに保存
                    if ($new_file_name1 !== $new_file_name2) {
                        // 異なるファイル名の場合は、データベースに保存しない
                        echo implode(" ", $errorMessages);
                        echo "問題と解答の画像ファイル名が一致しませんでした。";
                    }else{
                        $interval_num = (int) $_POST['time_limit']; // 制限時間30
                        $sentence = $_POST['sentence']; // 問題文あいうえお
                        $genre_text = $field; // ジャンル名（フォーマットそのまま使用）1_1
                        $question_text = $basename = pathinfo($new_file_name1, PATHINFO_FILENAME); // アップロードしたファイル名 1_1_13
                        $correct = $_POST['correct']; // 正解の選択肢
                        $explanation = $basename = pathinfo($new_file_name2, PATHINFO_FILENAME);

                        $form = new Form();
                        // 問題をデータベースに保存
                        $question_id = $form->insertQuestion($field_id, $genre, $interval_num, $genretext, $question_text, $sentence);

                        // 選択肢をデータベースに保存
                        $count = 0;
                        foreach ($_POST['choice'] as $choice_text) {
                            $insertChoices = $form->insertChoices($question_id, $choice_text, $correct, $count);
                            $count++;
                            if($insertChoices !== null){
                                $correct_choice_id = $insertChoices;
                            }
                        }

                        // 正解をデータベースに保存
                        $databaseSaveSuccess = $form->insertAnswers($question_id, $correct_choice_id, $explanation);

                        echo "問題がデータベースに保存されました。";
                    }
                }
            } else {
                echo implode(" ", $errorMessages);
                echo "アップロードしませんでした。";
            }
        } else {
            echo "2つのファイルを選択してください。";
        }
    } else {
        echo "正しいジャンルを選択してください。";
    }
    // 保存できた時のみリダイレクト
    if ($databaseSaveSuccess) {
        session_start();
        $_SESSION['question_id'] = $question_id;
        header("Location: ../frontend/question_preview.php"); // 後で問題プレビューに遷移
        exit();
    }
}

// ジャンルに基づいて次の使用可能なファイル名を取得する関数
function findNextAvailableFileName($directory, $field, $extension) {
    $files = glob($directory . $field . "_*." . $extension); 
    $maxNumber = 0;
    foreach ($files as $file) {
        preg_match('/_(\d+)\.' . $extension . '$/', $file, $matches);
        if (isset($matches[1])) {
            $number = (int)$matches[1];
            if ($number > $maxNumber) {
                $maxNumber = $number;
            }
        }
    }
    $nextNumber = $maxNumber + 1;
    return $field . "_" . $nextNumber . "." . $extension;
}
?>
