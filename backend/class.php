<?php

use LDAP\Result;

require_once __DIR__ . '/dbdata.php';

class form extends Dbdata
{
    
    public function getpass($userid, $newPass)
    {
        $sql = "UPDATE userinfo SET userinfo.password = ? WHERE userinfo.userid = ?";
        $this->exec($sql, [$newPass, $userid]);
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

    public function getInfo($userid)
    {
        $sql = "SELECT * FROM userinfo WHERE userid = ?";
        $stmt = $this->query($sql, [$userid]);
        $result = $stmt->fetch();
        return $result;
    }

    public function updateUser($userId, $username, $subject)
    {
        $sql = "UPDATE userinfo SET username = ?, subject = ? WHERE userid = ?";
        $this->exec($sql, [$username, $subject, $userId]);
    }

    public function getQues($question_id)
    {
        $sql = "SELECT * FROM answers WHERE question_id = ?";
        $stmt = $this->query($sql, [$question_id]);
        $result = $stmt->fetch();
        return $result;
    }

    public function insert($userid, $question_id) // 間違えた問題を保存
    {
        // 重複確認クエリ
        $checkSql = "SELECT COUNT(*) FROM wrong WHERE userid = ? AND question_id = ?";
        $stmt = $this->pdo->prepare($checkSql);
        $stmt->execute([$userid, $question_id]);
        $count = $stmt->fetchColumn();
    
        // 重複していない場合にデータを挿入
        if ($count == 0) {
            $sql = "INSERT INTO wrong VALUES (NULL, ?, ?)";
            $this->exec($sql, [$userid, $question_id]);
            $seikaid = $this->pdo->lastInsertId();
            return $seikaid;
        } else {
            return false; // 既に存在する場合は false を返す
        }
    }   
    
    public function wrongdelete($userid, $question_id) {
        try {
            $checkSql = "DELETE FROM wrong WHERE userid = ? AND question_id = ?";
            $stmt = $this->pdo->prepare($checkSql);
            $stmt->execute([$userid, $question_id]);
            
            return true; // 成功した場合、trueを返します
        } catch (PDOException $e) {
            // エラーハンドリング（必要に応じて）
            die('削除に失敗しました: ' . $e->getMessage());
        }
        
        return false; // 失敗した場合、falseを返します
    }
}    
