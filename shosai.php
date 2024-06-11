<?php
require_once __DIR__ . '/database/class.php';
require_once __DIR__ . '/pre.php';
$userid = $_SESSION['userid'];
$quesID = $_GET['ident'];
$form = new form();
$ques = $form->getQues($quesID);
$allAns = $form->getAllAns($quesID);
$pic = $form->getQuesPic($quesID);

$count = $form->countQuesLike($quesID);
$flag = $form->quesLikeFlag($quesID, $userid);

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

<div id="question-container">
    <h2><?= $ques['title'] ?></h2>
    <h4 style="text-align: right; display: block;">
        <a href="yourpage.php?ident=<?= $ques['userid'] ?>"><?= $ques['username'] ?></a>さん
        <?php
        if ($ques['userid'] == $userid) {
        ?>
            <br>
            <a href="editques.php?ident=<?= $quesID ?>">編集する</a>
        <?php
        }
        ?>
    </h4>
    <div class="text-container">
        <pre><?= $ques['message'] ?></pre>
        <br><br>
        <span class="tag"><?= $options[$ques['selection']] ?></span>
        <br><br>
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
            更新日時：<?= $ques['updatetime'] ?>
            <br>
            投稿日時：<?= $ques['configtime'] ?>
        </p>
    </div>

    <?php
    if ($flag['count'] == 0) {
    ?>
        <div style="display: flex; justify-content: flex-end;">
            <form class="rateques">
                <input type="hidden" name="quesid" value="<?= $ques['id'] ?>">
                <input type="hidden" name="userid" value="<?= $userid ?>">
                <input id="quesflag" type="hidden" name="type" value="0">
                <input id="quesbutton" type="image" src="image/good.png">
                <span id="quescount"><?= $count['count'] ?></span>
            </form>
        </div>
    <?php
    } else {
    ?>
        <div style="display: flex; justify-content: flex-end;">
            <form class="rateques">
                <input type="hidden" name="quesid" value="<?= $ques['id'] ?>">
                <input type="hidden" name="userid" value="<?= $userid ?>">
                <input id="quesflag" type="hidden" name="type" value="1">
                <input id="quesbutton" type="image" src="image/good2.png">
                <span id="quescount"><?= $count['count'] ?></span>
            </form>
        </div>
    <?php
    }
    ?>
</div>

<div class="good-container">
    <img id="goodVideo" src="image/trans-good.gif" class="centered-movie">
</div>

<!-- 回答フォーム -->
<div id="answer-container">
    <h2>回答</h2>
    <div id="answers-list">
        <!-- ここに回答が追加されます -->
        <?php
        foreach ($allAns as $row) {
        ?>
            <h4 style="text-align: right;">
                <a href="yourpage.php?ident=<?= $row['userid'] ?>">
                    <?= $row['username'] ?>
                </a> さん
                <br>
                <?= $row['datetime'] ?>
            </h4>
            <div class="answer">
                <p>
                    <a href="yourpage.php?ident=<?= $ques['userid'] ?>">
                        <?= $ques['username'] ?>
                    </a>
                    さんへの返信：
                </p>
                <p><?= $row['text'] ?></p>
            </div>
            <?php
            $count = $form->countLike($row['id']);
            $flag = $form->likeFlag($row['id'], $userid);

            if ($flag['count'] == 0) {
            ?>
                <div style="display: flex; justify-content: flex-end;">
                    <form class="rateform">
                        <input type="hidden" name="ansid" value="<?= $row['id'] ?>">
                        <input type="hidden" name="userid" value="<?= $userid ?>">
                        <input id="flag<?= $row['id'] ?>" type="hidden" name="type" value="0">
                        <input id="button<?= $row['id'] ?>" type="image" src="image/good.png">
                        <span id="count<?= $row['id'] ?>"><?= $count['count'] ?></span>
                    </form>
                </div>
            <?php
            } else {
            ?>
                <div style="display: flex; justify-content: flex-end;">
                    <form class="rateform">
                        <input type="hidden" name="ansid" value="<?= $row['id'] ?>">
                        <input type="hidden" name="userid" value="<?= $userid ?>">
                        <input id="flag<?= $row['id'] ?>" type="hidden" name="type" value="1">
                        <input id="button<?= $row['id'] ?>" type="image" src="image/good2.png">
                        <span id="count<?= $row['id'] ?>"><?= $count['count'] ?></span>
                    </form>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <div id="add-ans" onclick="showAnsForm()">
        <p>✙ここに回答を追加する</p>
    </div>
    <div id="answer-form" style="display: none;">
        <form action="answer.php" method="POST">
            回答内容：
            <br>
            <textarea id="answer_text" name="answer_text" placeholder="回答を入力してください"></textarea>
            <br>
            <input type="hidden" value="<?= $quesID ?>" name="ques_id">
            <input type="hidden" value="<?= $userid ?>" name="userid">
            <input id="submit-ans" type="submit" value="回答する">
            <button class="cancel-button" onclick="hideAnsForm()" type="button">キャンセル</button>
        </form>
    </div>
</div>
<footer class="mypage-footer">
    <div style="text-align: center;" class="footer-menu">
        <ul class="footer-menu-list">
            <a href="index.php">記事一覧を見る</a>
        </ul>
    </div>
    <p>&copy; I love 「愛」チーム情報共有サイト</p>
</footer>
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

    $(".rateform").on("submit", function(e) {

        var dataString = $(this).serialize();
        var ansid = $(this).find("[name=ansid]").val();

        $.ajax({
            type: "POST",
            url: "anslike.php",
            data: dataString,
            success: function(result) {
                var countString = $(".rateform").find("#count" + ansid);
                var goodImage = $(".rateform").find("#button" + ansid);
                var flagInput = $(".rateform").find("#flag" + ansid);

                var img = goodImage.attr("src");
                if (img == "image/good.png") {
                    goodImage.attr("src", "image/good2.png");
                    const videoElement = document.getElementById('goodVideo');
                    goodVideo.style.display = 'block';
                    setTimeout(function() {
                        goodVideo.style.display = 'none';
                    }, 1500);
                } else {
                    goodImage.attr("src", "image/good.png");
                }

                var flag = flagInput.val();
                if (flag == "0") {
                    flagInput.val("1");
                } else {
                    flagInput.val("0");
                }

                countString.text(result);
            }
        });
        e.preventDefault();
    });

    $(".rateques").on("submit", function(e) {

        var dataString = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "queslike.php",
            data: dataString,
            success: function(result) {
                var countString = $(".rateques").find("#quescount");
                var goodImage = $(".rateques").find("#quesbutton");
                var flagInput = $(".rateques").find("#quesflag");

                var img = goodImage.attr("src");
                if (img == "image/good.png") {
                    goodImage.attr("src", "image/good2.png");
                    const videoElement = document.getElementById('goodVideo');
                    goodVideo.style.display = 'block';
                    setTimeout(function() {
                        goodVideo.style.display = 'none';
                    }, 1500);
                } else {
                    goodImage.attr("src", "image/good.png");
                }

                var flag = flagInput.val();
                if (flag == "0") {
                    flagInput.val("1");
                } else {
                    flagInput.val("0");
                }

                countString.text(result);
            }
        });
        e.preventDefault();
    });
</script>

</html>