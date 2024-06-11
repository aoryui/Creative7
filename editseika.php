<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/database/class.php';

$seikaid = $_GET['ident'];
$form = new form();
$seika = $form->getseikasyousai($seikaid);
$pic = $form->getSeikaPic($seikaid);

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
    function showPicEdit() {
        document.getElementById("picblock").style.display = "none";
        document.getElementById("uploadfile").style.display = "block";
    }
</script>

<h1>成果物編集フォーム</h1>
<p>他の人に見てほしい自分が作成した成果物を投稿するページです。
</p>
<div class="form-container">
    <div class="form-wrapper">
        <form action="editseika_db.php" method="POST" enctype="multipart/form-data">
            <label for="title-input">タイトル</label>
            <input type="text" id="title-input" name="title-input" value="<?= $seika['title'] ?>" required>
            <label for="message-input">コード</label>
            <textarea id="message-input" name="message-input" placeholder="<?= $seika['message'] ?>"><?= $seika['message'] ?></textarea>
            <label for="site-input">外部サイト</label>
            <input type="text" id="site-input" name="site-input" value="<?= $seika['site'] ?>">
            <label for="shosai-input">詳細</label>
            <textarea id="shosai-input" name="shosai-input" placeholder="<?= $seika['shosai'] ?>"><?= $seika['shosai'] ?></textarea>
            <label for="selection-input">開発言語を選択</label>
            <select id="selection-input" name="selection-input">
                <?php
                foreach ($options as $option => $lang) {
                    if ($option == $seika['selection']) {
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
            <input type="hidden" name="seikaid" value="<?= $seikaid ?>">
            <input type="submit" id="submitButton" value="投稿" onclick="disableButton()">
        </form>
    </div>
</div>


</body>

</html>