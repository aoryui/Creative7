<?php

require_once __DIR__ . '/header.php';

if ($username === "ゲスト") {
    $_SESSION['login_error'] = '回答するにログインしてください。';
    header('Location: ' . 'login.php');
    exit();
}

require_once __DIR__ . '/database/class.php';
$form = new form();
$userid = $_POST['userid'];
$text = $_POST['answer_text'];
$quesID = $_POST['ques_id'];

$datetime = date('Y/m/d H:i');

$form->insertAns($userid, $text, $quesID, $datetime);

header("Location: shosai.php?ident=" . $quesID);
exit;
