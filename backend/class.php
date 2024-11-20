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

        $sql = "INSERT INTO userinfo (username, subject, email, password) VALUES (?, ?, ?, ?)";
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

    public function signUP2($username, $email, $password)
    {
        $sql = "SELECT userid FROM kanrisyainfo WHERE email = ?";
        $stmt = $this->query($sql, [$email]);
        $result = $stmt->fetch();
        if ($result) {
            return 'この' . $email . 'は既に登録されています。';
        }

        $sql = "INSERT INTO kanrisyainfo (username, email, password) VALUES (?, ?, ?)";
        $this->exec($sql, [$username,$email, $password]);

        $sql = "SELECT userid FROM kanrisyainfo WHERE email = ?";
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

    public function authUser2($email, $password)
    {
        $sql = "SELECT * FROM kanrisyainfo WHERE email = ?";
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

    public function getUser($userId){ // ユーザーが存在するかを取得
        $sql = "SELECT COUNT(*) FROM userinfo WHERE userid = ?";
        $stmt = $this->query($sql, [$userId]);
        $count = $stmt->fetchColumn();
        // ユーザーが存在すれば true、存在しなければ false を返す
        return $count > 0;
    }

    public function getStatus($userid) // データベースの正答率、平均回答時間、学習問題数を取得
    {
        $sql = "SELECT exp, level, correct_rate, average_time, total_questions, correct_rate_lang, average_time_lang, total_questions_lang, correct_rate_nonlang, average_time_nonlang, total_questions_nonlang FROM userinfo WHERE userid = ?";
        $stmt = $this->query($sql, [$userid]);
        $result = $stmt->fetch();
        // 結果を返す（連想配列として）
        return $result;
    }

    public function updateStatus($userid, $exp, $new_correctRate, $new_averageTime, $new_totalQuestions, $new_correctRate_lang, $new_averageTime_lang, $new_totalQuestions_lang, $new_correctRate_nonlang, $new_averageTime_nonlang, $new_totalQuestions_nonlang) // データベースに正答率、平均回答時間、学習問題数を保存
    {
        $sql = "UPDATE userinfo SET exp = exp + ?, correct_rate = ?, average_time = ?, total_questions = ?, correct_rate_lang = ?, average_time_lang = ?, total_questions_lang  = ?, correct_rate_nonlang = ?, average_time_nonlang = ?, total_questions_nonlang = ? WHERE userid = ?";
        $this->exec($sql, [$exp, $new_correctRate, $new_averageTime, $new_totalQuestions, $new_correctRate_lang, $new_averageTime_lang, $new_totalQuestions_lang, $new_correctRate_nonlang, $new_averageTime_nonlang, $new_totalQuestions_nonlang, $userid]);
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

    public function getRanking()
    {
        // Retrieve all rankings in one go
        $sql = "SELECT userid, username, ((level - 1) * 10 + exp) AS score
                FROM userinfo
                ORDER BY score DESC, userid ASC";
        $stmt = $this->query($sql, []);
        
        $rankings = [];
        $rank = 1;
        $previousScore = null;
        $skipCount = 0;
    
        while ($row = $stmt->fetch()) {
            $userid = $row['userid'];
            $username = $row['username'];
            $score = $row['score'];
    
            // Handle same score users getting the same rank
            if ($previousScore !== null && $score == $previousScore) {
                $skipCount++;
            } else {
                $rank += $skipCount;
                $skipCount = 1;
            }
    
            $rankings[] = [
                'rank' => $rank,
                'userid' => $userid,
                'username' => $username,
                'score' => $score
            ];
    
            $previousScore = $score;
        }
    
        return $rankings; // Return all rankings at once
    }

    // question_idを使ってquestionsテーブルからデータをリストで取り出す
    public function getQuestion_fieldgenre($field, $genre){
        $sql = "SELECT * FROM questions WHERE field_id = ? AND genre_id = ?";
        $stmt = $this->exec($sql, array_params: [$field, $genre]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // question_idを使ってquestionsテーブルからデータをリストで取り出す
    public function getQuestion($question_id){
        $sql = "SELECT * FROM questions WHERE question_id = ?";
        $stmt = $this->exec($sql, array_params: [$question_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // choicesテーブルからデータをリストで取り出す
    public function getChoices($question_id){ 
        $sql = "SELECT choice_id, choice_text FROM choices WHERE question_id = ?";
        $stmt = $this->exec($sql, array_params: [$question_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // choice_idをキー、choice_textを値にした連想配列を生成
        $choices = [];
        foreach ($result as $row) {
            $choices[$row['choice_id']] = $row['choice_text'];
        }
    
        return $choices;
    }
    
    public function getAnswer($question_id){
        $sql = "SELECT * FROM answers WHERE question_id = ?";
        $stmt = $this->exec($sql, array_params: [$question_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // 問題を投稿する関数
    public function insertQuestion($field_id, $genre_id, $interval_num, $genre_text, $question_text, $sentence){
        $sql = "INSERT INTO questions (field_id, genre_id, interval_num, genre_text, question_text, sentence) VALUES (?, ?, ?, ?, ?, ?)";
        $this->exec($sql, array_params: [$field_id, $genre_id, $interval_num, $genre_text, $question_text, $sentence]);
        $lastId = $this->pdo->lastInsertId();
        return $lastId; // 問題の主キーを返す
    }

    // 問題の選択肢を投稿する関数
    public function insertChoices($question_id, $choice_text, $correct, $count){
        $sql = "INSERT INTO choices (question_id, choice_text) VALUES (?, ?)";
        $this->exec($sql, [$question_id, $choice_text]);
        if ($correct == $count) { //正解の時だけ戻り値を返す
            return $this->pdo->lastInsertId();
        }
        return null;
    }
    
    // 問題の正解を投稿する関数
    public function insertAnswers($question_id, $correct_choice_id, $explanation){
        $sql = "INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (?, ?, ?)";
        $this->exec($sql, [$question_id, $correct_choice_id, $explanation]);
        return true;
    }

    // ジャンルを編集する関数
    public function updateGenre($question_id, $field_id, $genre_id, $genre_text)
    {
        try {
            // 更新クエリ
            $sql = "UPDATE questions SET field_id = ?, genre_id = ?, genre_text = ? WHERE question_id = ?";
            $this->exec($sql, [$field_id, $genre_id, $genre_text, $question_id]);
            return true;
        } catch (PDOException $e) {
            // エラー発生時の処理
            return false;
        }
    }

}    
