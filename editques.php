<?php
require_once __DIR__ . '/database/class.php';
require_once __DIR__ . '/header.php';

$userid = $_SESSION['userid'];
$quesID = $_GET['ident'];
$form = new form();
$ques = $form->getQues($quesID);
$pic = $form->getQuesPic($quesID);

$options = array(
    'option1' => 'C言語',
    'option2' => 'C#',
    'option3' => 'C++',
    'option4' => 'Java',
    'option5' => 'Python',
    'option6' => 'HTML',
    'option7' => 'JavaScript',
    'option8' => 'SQL',
    'option9' => 'CSS',
    'option10' => 'PHP',
    'option11' => 'その他',
);
?>

<script>
    function disableButton() {
        document.getElementById("submitButton").disabled = true;
        document.getElementById("submitButton").form.submit();
    }

    function showPicEdit() {
        document.getElementById("picblock").style.display = "none";
        document.getElementById("uploadfile").style.display = "block";
    }
</script>

<h1>IT質問用投稿フォーム</h1>
<!-- <p>ここはITに関する質問を投稿するためのフォームです。</p> -->
<p>状況や問題点が一目でわかるように詳細に情報や環境を入力すると回答される可能性が高くなります。
</p>
<div class="form-container">
    <div class="form-wrapper">
        <form action="edit_db.php" method="POST" enctype="multipart/form-data">
            <label for="title-input">タイトル</label>
            <input type="text" id="title-input" name="title-input" value="<?= $ques['title'] ?>" required>
            <label for="message-input">詳細情報</label>
            <textarea id="message-input" name="message-input" placeholder="<?= $ques['message'] ?>" required><?= $ques['message'] ?></textarea>
            <label for="selection-input">開発言語を選択</label>
            <select id="selection-input" name="selection-input">
                <?php
                foreach ($options as $option => $lang) {
                    if ($option == $ques['selection']) {
                        echo '<option value="' . $option . '" selected>' . $lang . '</option>';
                    } else {
                        echo '<option value="' . $option . '">' . $lang . '</option>';
                    }
                }
                ?>
            </select>
            <?php
            if (!empty($pic)) {
            ?>
                <div id="picblock">
                    <img src="upload/<?= $pic['filename'] ?>" width="200px" style="margin-top:10px; display:block;">
                    <button style="margin: 10px 0px;" onclick="showPicEdit()" type="button">画像を変更</button>
                </div>
                <input type="file" name="uploadfile" value="" id="uploadfile" style="display: none;">
            <?php
            } else {
            ?>
                <input type="file" name="uploadfile" value="">
            <?php
            }
            ?>
            <input type="hidden" value="<?= $quesID ?>" name="quesid">
            <input type="submit" id="submitButton" value="保存" onclick="disableButton()">
        </form>
    </div>
</div>
</body>

</html>