<?php
require_once __DIR__ . '/database/class.php';
require_once __DIR__ . '/pre.php';

$form = new form();

if ($_POST['type'] == 0) {
    $result = $form->addQuesLike($_POST['quesid'], $_POST['userid']);
    echo ($result['count']);
} else {
    $result = $form->disQuesLike($_POST['quesid'], $_POST['userid']);
    echo ($result['count']);
}
