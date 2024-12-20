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

    // 制限時間を編集する関数
    public function updateInterval($question_id, $interval_num)
    {
        try {
            // 更新クエリ
            $sql = "UPDATE questions SET interval_num = ? WHERE question_id = ?";
            $this->exec($sql, [$interval_num, $question_id]);
            return true;
        } catch (PDOException $e) {
            // エラー発生時の処理
            return false;
        }
    }

    // 要約文を編集する関数
    public function updateSentence($question_id, $sentence)
    {
        try {
            // 更新クエリ
            $sql = "UPDATE questions SET sentence = ? WHERE question_id = ?";
            $this->exec($sql, [$sentence, $question_id]);
            return true;
        } catch (PDOException $e) {
            // エラー発生時の処理
            return false;
        }
    }

    // 選択肢を編集する関数
    public function updateChoicesAndAnswer($question_id, $new_choices, $correct_index) {
        try {
            $this->pdo->beginTransaction();
    
            // 現在の選択肢を取得
            $current_choices = $this->getChoices($question_id);
            $current_choice_ids = array_keys($current_choices);
    
            // 現在の正解選択肢IDを取得
            $sql = "SELECT correct_choice_id FROM answers WHERE question_id = ?";
            $stmt = $this->query($sql, [$question_id]);
            $correct_choice_id = $stmt->fetchColumn();
    
            // 正解選択肢が削除される場合に備えて正解を更新
            if ($correct_choice_id && !array_key_exists($correct_index, $new_choices)) {
                $correct_choice_id = null;
                $sql = "UPDATE answers SET correct_choice_id = NULL WHERE question_id = ?";
                $this->exec($sql, [$question_id]);
            }
    
            // 選択肢の更新または挿入
            foreach ($new_choices as $index => $choice_text) {
                if (isset($current_choice_ids[$index])) {
                    // 更新
                    $sql = "UPDATE choices SET choice_text = ? WHERE choice_id = ?";
                    $this->exec($sql, [$choice_text, $current_choice_ids[$index]]);
                } else {
                    // 新規追加
                    $sql = "INSERT INTO choices (question_id, choice_text) VALUES (?, ?)";
                    $this->exec($sql, [$question_id, $choice_text]);
                    $current_choice_ids[] = $this->pdo->lastInsertId();
                }
            }
    
            // 余分な選択肢を削除
            if (count($current_choices) > count($new_choices)) {
                $extra_choice_ids = array_slice($current_choice_ids, count($new_choices));
                $placeholders = implode(',', array_fill(0, count($extra_choice_ids), '?'));
    
                // 正解が削除される場合
                if (in_array($correct_choice_id, $extra_choice_ids)) {
                    $correct_choice_id = null;
                    $sql = "UPDATE answers SET correct_choice_id = NULL WHERE question_id = ?";
                    $this->exec($sql, [$question_id]);
                }
                
                // 余分な選択肢を削除
                $sql = "DELETE FROM choices WHERE choice_id IN ($placeholders)";
                $this->exec($sql, $extra_choice_ids);
            }
    
            // 正解の選択肢IDを更新
            if (isset($current_choice_ids[$correct_index])) {
                $correct_choice_id = $current_choice_ids[$correct_index];
                $sql = "UPDATE answers SET correct_choice_id = ? WHERE question_id = ?";
                $this->exec($sql, [$correct_choice_id, $question_id]);
            }
    
            $this->pdo->commit();
            // 保存に成功した場合
            return true;
    
        } catch (Exception $e) {
            $this->pdo->rollBack();
            // 失敗した場合エラーメッセージを返す
            return $e->getMessage();
        }
    }

    // 問題を削除する
    public function deleteQuestion($question_id){
        $sql = 'DELETE FROM questions WHERE question_id = ?';
        $stmt = $this->exec($sql, array_params: [$question_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // 解いた問題を保存
    public function save_solve($userid, $question_ids) { // save(保存)とsolve(解く)を掛けた関数名((´∀`*))ｹﾗｹﾗ
        // 複数行を一度に挿入、重複を無視
        $placeholders = implode(',', array_fill(0, count($question_ids), '(?, ?)'));
        $sql = "INSERT IGNORE INTO solved_questions (user_id, question_id) VALUES $placeholders";
        $stmt = $this->pdo->prepare($sql);
        // パラメータの配列を作成
        $params = [];
        foreach ($question_ids as $question_id) {
            $params[] = $userid;
            $params[] = $question_id;
        }
        $stmt->execute($params);
    
        return true;
    }    

    // 正解した問題を取得する関数
    public function get_question_solved_ratios($user_id) {
        // SQL クエリ
        $sql = "
            SELECT 
                q.field_id,
                q.genre_id,
                COUNT(q.question_id) AS total_questions,
                COUNT(sq.question_id) AS solved_questions,
                CONCAT(COUNT(sq.question_id), '/', COUNT(q.question_id)) AS solved_ratio
            FROM questions q
            LEFT JOIN solved_questions sq
                ON q.question_id = sq.question_id AND sq.user_id = :user_id
            GROUP BY q.field_id, q.genre_id
            ORDER BY q.field_id, q.genre_id;
        ";
    
        // クエリを準備して実行
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
    
        // 結果を取得
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
      

}    
