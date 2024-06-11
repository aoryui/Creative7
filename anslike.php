<?php
require_once __DIR__ . '/database/class.php';
require_once __DIR__ . '/pre.php';

$form = new form();

if ($_POST['type'] == 0) {
    $result = $form->addLike($_POST['ansid'], $_POST['userid']);
    echo ($result['count']);
} else {
    $result = $form->disLike($_POST['ansid'], $_POST['userid']);
    echo ($result['count']);
}
