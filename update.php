<?php
$userid = $_POST['userid'];
$username = $_POST['name'];
$age = $_POST['age'];
$hobby = $_POST['hobby'];
$subject = $_POST['company'];
$intro = $_POST['description'];

require_once __DIR__ . '/database/class.php';
$form = new Form();
$form->updateUser($userid, $username, $subject);
$form->updateProfile($userid, $age, $hobby, $intro);

header(('Location:' . 'mypage.php'));
