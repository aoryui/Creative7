<?php

use LDAP\Result;

require_once __DIR__ . '/dbdata.php';

class form extends Dbdata
{
    public function insertForm($userid, $title, $message, $selection, $datetime)
    {
        $sql = "INSERT INTO question VALUES (null, ?, ?, ?, ?, ?, ?)";
        $this->exec($sql, [$userid, $title, $message, $selection, $datetime, $datetime]);
        $quesid = $this->pdo->lastInsertId();
        return $quesid;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM question ORDER BY updatetime DESC";
        $stmt = $this->query($sql, []);
        $result = $stmt->fetchAll();
        return $result;
    }


    public function getpass($userid, $newPass)
    {
        $sql = "UPDATE userinfo SET userinfo.password = ? WHERE userinfo.userid = ?";
        $this->exec($sql, [$newPass, $userid]);
    }

    public function getQues($ident)
    {
        $sql = "SELECT * FROM question INNER JOIN userinfo ON question.userid = userinfo.userid WHERE question.id = ?";
        $stmt = $this->query($sql, [$ident]);
        $result = $stmt->fetch();
        return $result;
    }

    public function getseikasyousai($ident)
    {
        $sql = "SELECT * FROM seikabutu INNER JOIN userinfo ON seikabutu.userid = userinfo.userid WHERE seikabutu.id = ?";
        $stmt = $this->query($sql, [$ident]);
        $result = $stmt->fetch();
        return $result;
    }

    public function insertAns($userid, $text, $quesID, $datetime)
    {
        $sql = "INSERT INTO answer VALUES (null, ?, ?, ?, ?)";
        $this->exec($sql, [$userid, $text, $quesID, $datetime]);
    }

    public function getAllAns($quesID)
    {
        $sql = "SELECT * FROM answer INNER JOIN userinfo ON answer.userid = userinfo.userid WHERE ques_id = ? ORDER BY datetime DESC";
        $stmt = $this->query($sql, [$quesID]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function signUP($username, $email, $subject, $password)
    {
        $sql = "SELECT userid FROM userinfo WHERE email = ?";
        $stmt = $this->query($sql, [$email]);
        $result = $stmt->fetch();
        if ($result) {
            return 'この' . $email . 'は既に登録されています。';
        }

        $sql = "INSERT INTO userinfo VALUES (NULL, ?, ?, ?, ?)";
        $this->exec($sql, [$username, $subject, $email, $password]);

        $sql = "SELECT userid FROM userinfo WHERE email = ?";
        $stmt = $this->query($sql, [$email]);
        $userid = $stmt->fetch();
        $sql = "INSERT INTO profile VALUES (?, NULL, NULL, NULL)";
        $result = $this->exec($sql, [$userid['userid']]);

        if ($result) {
            return '';
        } else {
            return '新規登録できませんでした。管理者にお問い合わせください。';
        }
    }

    public function authUser($email, $password)
    {
        $sql = "SELECT * FROM userinfo WHERE email = ?";
        $stmt = $this->query($sql, [$email]);
        $result = $stmt->fetch();
        if (password_verify($password, $result['password'])) {
            return $result;
        } else {
            return false;
        }
    }

    public function getProfile($userid)
    {
        $sql = "SELECT * FROM profile WHERE userid = ?";
        $stmt = $this->query($sql, [$userid]);
        $result = $stmt->fetch();
        return $result;
    }


    public function getInfo($userid)
    {
        $sql = "SELECT * FROM userinfo WHERE userid = ?";
        $stmt = $this->query($sql, [$userid]);
        $result = $stmt->fetch();
        return $result;
    }

    public function insertseikabutu($userid, $title, $message, $site, $shosai, $selection, $datetime)
    {
        $sql = "INSERT INTO seikabutu VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->exec($sql, [$userid, $title, $message, $site, $shosai, $selection, $datetime, $datetime]);
        $seikaid = $this->pdo->lastInsertId();
        return $seikaid;
    }

    public function getAllSeikabutu()
    {
        $sql = "SELECT * FROM seikabutu JOIN userinfo ON seikabutu.userid = userinfo.userid ORDER BY updatetime DESC";
        $stmt = $this->query($sql, []);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function updateUser($userId, $username, $subject)
    {
        $sql = "UPDATE userinfo SET username = ?, subject = ? WHERE userid = ?";
        $this->exec($sql, [$username, $subject, $userId]);
    }

    public function updateProfile($userId, $age, $interest, $intro)
    {
        $sql = "UPDATE profile SET age = ?, interest = ?, intro = ? WHERE userid = ?";
        $this->exec($sql, [$age, $interest, $intro, $userId]);
    }

    public function countLike($ansid)
    {
        $sql = "SELECT COUNT(id) AS count FROM anslike WHERE ansid = ?";
        $stmt = $this->query($sql, [$ansid]);
        $result = $stmt->fetch();
        return $result;
    }

    public function likeFlag($ansid, $userid)
    {
        $sql = "SELECT COUNT(id) AS count FROM anslike WHERE ansid = ? AND userid = ?";
        $stmt = $this->query($sql, [$ansid, $userid]);
        $result = $stmt->fetch();
        return $result;
    }

    public function addLike($ansid, $userid)
    {
        $sql = "INSERT INTO anslike VALUES (null, ?, ?)";
        $this->exec($sql, [$userid, $ansid]);
        $sql = "SELECT COUNT(id) AS count FROM anslike WHERE ansid = ?";
        $stmt = $this->query($sql, [$ansid]);
        $result = $stmt->fetch();
        return $result;
    }

    public function disLike($ansid, $userid)
    {
        $sql = "DELETE FROM anslike WHERE ansid = ? AND userid = ?";
        $this->exec($sql, [$ansid, $userid]);
        $sql = "SELECT COUNT(id) AS count FROM anslike WHERE ansid = ?";
        $stmt = $this->query($sql, [$ansid]);
        $result = $stmt->fetch();
        return $result;
    }

    public function getUserQues($userid)
    {
        $sql = "SELECT * FROM question WHERE userid = ?";
        $stmt = $this->query($sql, [$userid]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getUserAns($userid)
    {
        $sql = "SELECT answer.id, answer.text, answer.ques_id, question.title FROM answer JOIN question ON answer.ques_id = question.id WHERE answer.userid = ?";
        $stmt = $this->query($sql, [$userid]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getUserSeika($userid)
    {
        $sql = "SELECT * FROM seikabutu WHERE userid = ?";
        $stmt = $this->query($sql, [$userid]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function countQuesLike($quesid)
    {
        $sql = "SELECT COUNT(id) AS count FROM queslike WHERE quesid = ?";
        $stmt = $this->query($sql, [$quesid]);
        $result = $stmt->fetch();
        return $result;
    }

    public function quesLikeFlag($quesid, $userid)
    {
        $sql = "SELECT COUNT(id) AS count FROM queslike WHERE quesid = ? AND userid = ?";
        $stmt = $this->query($sql, [$quesid, $userid]);
        $result = $stmt->fetch();
        return $result;
    }

    public function addQuesLike($quesid, $userid)
    {
        $sql = "INSERT INTO queslike VALUES (null, ?, ?)";
        $this->exec($sql, [$userid, $quesid]);
        $sql = "SELECT COUNT(id) AS count FROM queslike WHERE quesid = ?";
        $stmt = $this->query($sql, [$quesid]);
        $result = $stmt->fetch();
        return $result;
    }

    public function disQuesLike($quesid, $userid)
    {
        $sql = "DELETE FROM queslike WHERE quesid = ? AND userid = ?";
        $this->exec($sql, [$quesid, $userid]);
        $sql = "SELECT COUNT(id) AS count FROM queslike WHERE quesid = ?";
        $stmt = $this->query($sql, [$quesid]);
        $result = $stmt->fetch();
        return $result;
    }

    public function countAns($quesid)
    {
        $sql = "SELECT COUNT(id) AS count FROM answer WHERE ques_id = ?";
        $stmt = $this->query($sql, [$quesid]);
        $result = $stmt->fetch();
        return $result;
    }

    public function getAllComment($seikaID)
    {
        $sql = "SELECT * FROM comment INNER JOIN userinfo ON comment.userid = userinfo.userid WHERE seikabutu_id = ? ORDER BY datetime DESC";
        $stmt = $this->query($sql, [$seikaID]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function insertComment($userid, $text, $seikaID, $datetime)
    {
        $sql = "INSERT INTO comment VALUES (null, ?, ?, ?, ?)";
        $this->exec($sql, [$userid, $text, $seikaID, $datetime]);
    }

    public function insertQuesPic($quesid, $filename)
    {
        $sql = "INSERT INTO quespic VALUES (null, ?, ?)";
        $this->exec($sql, [$quesid, $filename]);
    }

    public function insertSeikaPic($seikaid, $filename)
    {
        $sql = "INSERT INTO seikapic VALUES (null, ?, ?)";
        $this->exec($sql, [$seikaid, $filename]);
    }

    public function getQuesPic($quesid)
    {
        $sql = "SELECT * FROM quespic WHERE quesid = ?";
        $stmt = $this->query($sql, [$quesid]);
        $result = $stmt->fetch();
        return $result;
    }

    public function getSeikaPic($seikaid)
    {
        $sql = "SELECT * FROM seikapic WHERE seikaid = ?";
        $stmt = $this->query($sql, [$seikaid]);
        $result = $stmt->fetch();
        return $result;
    }

    public function updateQuestion($quesid, $title, $message, $selection, $datetime)
    {
        $sql = "UPDATE question SET title = ?, message = ?, selection = ? , updatetime = ? WHERE id = ?";
        $this->exec($sql, [$title, $message, $selection, $datetime, $quesid]);
    }

    public function updatePic($quesid, $path)
    {
        $sql = "SELECT * FROM quespic WHERE quesid = ?";
        $stmt = $this->query($sql, [$quesid]);
        $result = $stmt->fetch();

        if (!empty($result)) {
            $sql = "UPDATE quespic SET filename = ? WHERE quesid = ?";
            $this->exec($sql, [$path, $quesid]);
        } else {
            $sql = "INSERT INTO quespic VALUES (null, ?, ?)";
            $this->exec($sql, [$quesid, $path]);
        }
    }

    public function updateSeika($seikaid, $title, $message, $site, $shosai, $selection, $datetime)
    {
        $sql = "UPDATE seikabutu SET title = ?, message = ?, site = ?, shosai = ?, selection = ?, updatetime = ? WHERE id = ?";
        $this->exec($sql, [$title, $message, $site, $shosai, $selection, $datetime, $seikaid]);
    }

    public function updateSeikaPic($seikaid, $path)
    {
        $sql = "SELECT * FROM seikapic WHERE seikaid = ?";
        $stmt = $this->query($sql, [$seikaid]);
        $result = $stmt->fetch();

        if (!empty($result)) {
            $sql = "UPDATE seikapic SET filename = ? WHERE seikaid = ?";
            $this->exec($sql, [$path, $seikaid]);
        } else {
            $sql = "INSERT INTO seikapic VALUES (null, ?, ?)";
            $this->exec($sql, [$seikaid, $path]);
        }
    }
}
