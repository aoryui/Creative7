<?php
require_once __DIR__ . '/database/class.php';
$form = new form();
require_once __DIR__ . '/pre.php';
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}
$title = $_POST['title-input'];
$message = $_POST['message-input'];
$selection = $_POST['selection-input'];

$datetime = date('Y/m/d H:i');

$quesid = $form->insertForm($userid, $title, $message, $selection, $datetime);

if (!($_FILES["uploadfile"]["name"] == "")) {
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./upload/" . $filename;

    $form->insertQuesPic($quesid, $filename);

    move_uploaded_file($tempname, $folder);
}

// リダイレクト
header("Location: index.php");
exit;
