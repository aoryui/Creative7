<!DOCTYPE html>
<html lang="ja">


<?php
require_once __DIR__ . '/pre.php';
require_once __DIR__ . '/database/class.php';
$form = new Form();
$profile = $form->getProfile($userid);
$info = $form->getInfo($userid);
$questions = $form->getUserQues($userid);
$answers = $form->getUserAns($userid);
$seikas = $form->getUserSeika($userid);

require_once __DIR__ . '/header.php';
?>

<h1><?= $username ?>さんのマイページ</h1>

<h2>プロフィール</h2>
<section id="profile">
    <div id="profileInfo">
        <form action="update.php" method="POST" class="mypage">
            <label>名前：</label><input id="name" name="name" value="<?= $username ?>" disabled>
            <br><br>
            <label>年齢：</label><input id="age" name="age" value="<?= is_null($profile['age']) ? '未入力' : $profile['age']; ?>" disabled>
            <br><br>
            <label>趣味：</label><input id="hobby" name="hobby" value="<?= is_null($profile['interest']) ? '未入力' : $profile['interest']; ?>" disabled>
            <br><br>
            <label>所属：</label><input id="company" name="company" value="<?= $info['subject'] ?>" disabled>
            <br><br>
            <label>メッセージ：</label>
            <br>
            <textarea id="description" name="description" placeholder="<?= is_null($profile['intro']) ? '未入力' : $profile['intro']; ?>" style="height:100px;" disabled><?= is_null($profile['intro']) ? '未入力' : $profile['intro']; ?></textarea>
            <br><br>
            <input name="userid" value="<?= $userid ?>" type="hidden">
            <div id="formButton" style="display: none;">
                <input type="submit" value="保存する" id="submitEdit" class="enterButton">
                <button id="cancelEdit" type="button" onclick="hideEdit()">キャンセル</button>
            </div>
        </form>
    </div>
    <button id="editButton" type="button" onclick="showEdit()" class="enterButton">編集する</button>
</section>

<h2>過去の質問履歴</h2>
<section id="questionlist">
    <?php
    if (empty($questions)) {
    ?>
        <p>質問履歴がございません。</p>
        <?php
    } else {
        foreach ($questions as $question) {
            $like = $form->countQuesLike($question['id']);
            $ans = $form->countAns($question['id']);
        ?>
            <p>
                <a href="shosai.php?ident=<?= $question['id'] ?>"><?= $question['title'] ?></a>
                <span style="float:right;">いいね数：<?= $like['count'] ?>　回答数：<?= $ans['count'] ?></span>
            </p>
    <?php
        }
    }
    ?>
</section>

<h2>過去の回答履歴</h2>
<section id="answerlist">
    <?php
    if (empty($answers)) {
    ?>
        <p>回答履歴がございません。</p>
        <?php
    } else {
        foreach ($answers as $answer) {
            $like = $form->countLike($answer['id']);
        ?>
            <p>
                <a href="shosai.php?ident=<?= $answer['ques_id'] ?>"><?= $answer['title'] ?></a>
                <span style="float:right;">いいね数：<?= $like['count'] ?></span>
            </p>
    <?php
        }
    }
    ?>
</section>

<h2>投稿された成果物</h2>
<section id="worklist">
    <?php
    if (empty($seikas)) {
    ?>
        <p class="workp">成果物の投稿履歴がございません。</p>
        <?php
    } else {
        foreach ($seikas as $seika) {
        ?>
            <p>
                <?php
                echo "<a href='seikabutushosai.php?ident={$seika['id']}'>{$seika['title']}</a>"
                ?>
            </p>
    <?php
        }
    }
    ?>
</section>

<footer class="mypage-footer">
    <div class="footer-menu">
        <ul class="footer-menu-list">
            <a href="logout.php">ログアウト</a>
            <a href="passchange.php">パスワード変更フォームへ</a>
        </ul>
    </div>
    <p>&copy; I love 「愛」チーム情報共有サイト</p>
</footer>
</body>

<script>
    function showEdit() {
        document.getElementById('editButton').style.display = "none";
        document.getElementById('formButton').style.display = "block";

        document.getElementById('name').disabled = false;
        document.getElementById('age').disabled = false;
        document.getElementById('hobby').disabled = false;
        document.getElementById('company').disabled = false;
        document.getElementById('description').disabled = false;
    }

    function hideEdit() {
        document.getElementById('editButton').style.display = "block";
        document.getElementById('formButton').style.display = "none";

        document.getElementById('name').disabled = true;
        document.getElementById('age').disabled = true;
        document.getElementById('hobby').disabled = true;
        document.getElementById('company').disabled = true;
        document.getElementById('description').disabled = true;
    }
</script>

</html>