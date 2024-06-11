<?php
require_once __DIR__ . '/database/dbdata.php';
require_once __DIR__ . '/database/class.php';
require_once __DIR__ . '/pre.php';

$userid = $_SESSION['userid'];
$seikaID = $_GET['ident'];
$form = new form();
$seikabutuList = $form->getseikasyousai($seikaID);
$allComment = $form->getAllComment($seikaID);
$pic = $form->getSeikaPic($seikaID);

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



require_once __DIR__ . '/header.php';
?>

<script type="module" src="https://1.www.s81c.com/common/carbon/web-components/version/v2.8.0/code-snippet.min.js"></script>
<link rel="stylesheet" href="https://1.www.s81c.com/common/carbon/web-components/version/v2.8.0/themes.css" />
<div class="detail-container">
    <div class="detail-block">
        <h1>タイトル：<?= $seikabutuList['title'] ?></h1>
        <p>
            ユーザー名：<a href="yourpage.php?ident=<?= $seikabutuList['userid'] ?>"><?= $seikabutuList['username'] ?></a>さん
            <?php
            if ($seikabutuList['userid'] == $userid) {
            ?>
                <span style="float:right;"><a href="editseika.php?ident=<?= $seikaID ?>">編集する</a></span>
            <?php
            }
            ?>
        </p>
        <p>コード：</p>
        <cds-code-snippet type="multi" class="cds-theme-zone-g90"><?= htmlspecialchars($seikabutuList['message']) ?></cds-code-snippet>
        <p>外部サイト：<a href="<?= htmlspecialchars($seikabutuList['site']) ?>" target="_blank"><?= htmlspecialchars($seikabutuList['site']) ?></a></p>
        <pre class="label">詳細：<br><?= $seikabutuList['shosai'] ?></pre>
        <p>開発言語：<?= $options[$seikabutuList['selection']] ?></p>
        <div id="pic-container">
            <?php
            if (!empty($pic)) {
            ?>
                <img src="upload/<?= $pic['filename'] ?>" width="200px">
            <?php
            }
            ?>
        </div>
        <p>
            更新日時：<?= $seikabutuList['updatetime'] ?>
            <br>
            投稿日時：<?= $seikabutuList['configtime'] ?>
        </p>
    </div>
    <div style="text-align: left; margin-top: 20px;">

    </div>
</div>
<!-- コメント -->
<div id="answer-container">
    <h2>コメント</h2>
    <div id="answers-list">
        <!-- コメント -->
        <?php
        foreach ($allComment as $row) {
        ?>
            <h4 style="text-align: right; margin-bottom: 5px;">
                <a href="yourpage.php?ident=<?= $row['userid'] ?>">
                    <?= $row['username'] ?>
                </a>
                さん
                <br>
                <?= $row['datetime'] ?>
            </h4>
            <div class="answer">
                <p>
                    <a href="yourpage.php?ident=<?= $seikabutuList['userid'] ?>">
                        <?= $seikabutuList['username'] ?>
                    </a>
                    さんへの返信：
                </p>
                <p><?= $row['text'] ?></p>
            </div>
        <?php
        }
        ?>
    </div>
    <div id="add-ans" onclick="showAnsForm()">
        <p>✙ここにコメントを追加する</p>
    </div>
    <div id="answer-form" style="display: none;">
        <form action="comment.php" method="POST">
            コメント内容：
            <br>
            <textarea id="comment_text" name="comment_text" placeholder="コメントを入力してください"></textarea>
            <br>
            <input type="hidden" value="<?= $seikaID ?>" name="seika_id">
            <input type="hidden" value="<?= $userid ?>" name="userid">
            <input id="submit-ans" type="submit" value="コメントする">
            <button class="cancel-button" onclick="hideAnsForm()" type="button">キャンセル</button>
        </form>
    </div>
</div>
</body>

<script>
    function showAnsForm() {
        document.getElementById('add-ans').style.display = "none";
        document.getElementById('answer-form').style.display = "block";
    }

    function hideAnsForm() {
        document.getElementById('add-ans').style.display = "block";
        document.getElementById('answer-form').style.display = "none";

    }

    document.getElementById('pic-container').addEventListener('click', function(e) {
        var tgt = e.target;
        tgt.classList.toggle('zoomed');
    })
</script>

</html>