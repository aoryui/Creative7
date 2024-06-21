set names utf8;
drop database if exists creative7;
create database creative7 character set utf8 collate utf8_general_ci;

grant all privileges on creative7.* to Creative7@localhost identified by '11111';

use creative7;

DROP TABLE IF EXISTS userinfo;
CREATE TABLE userinfo (
    userid    int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username  varchar(100) NOT NULL,
    subject   varchar(100) NOT NULL,
    email     varchar(100) NOT NULL,
    password  varchar(100) NOT NULL
);


-- 以下問題
-- 問題テーブルを作成
DROP TABLE IF EXISTS questions;
CREATE TABLE questions (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    question_text TEXT NOT NULL
);

-- 選択肢テーブルを作成
DROP TABLE IF EXISTS choices;
CREATE TABLE choices (
    choice_id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    choice_text TEXT NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE
);

-- 正解と解説テーブルを作成
DROP TABLE IF EXISTS answers;
CREATE TABLE answers (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    correct_choice_id INT NOT NULL,
    explanation TEXT NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE,
    FOREIGN KEY (correct_choice_id) REFERENCES choices(choice_id) ON DELETE CASCADE
);

-- 問題を挿入
INSERT INTO questions (question_id,question_text) VALUES (1,'1.1');
INSERT INTO questions (question_id,question_text) VALUES (2,'1.2');
INSERT INTO questions (question_id,question_text) VALUES (3,'1.3');
INSERT INTO questions (question_id,question_text) VALUES (4,'1.4');
INSERT INTO questions (question_id,question_text) VALUES (5,'1.5');



-- 選択肢を挿入
INSERT INTO choices (question_id, choice_text) VALUES (1, '1.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (1, '1.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (1, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (1, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (1, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (1, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (2, '2.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (2, '2.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (2, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (2, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (2, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (2, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (3, '3.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (3, '3.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (3, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (3, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (3, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (3, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (4, '4.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (4, '4.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (4, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (4, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (4, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (4, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (5, '5.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (5, '5.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (5, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (5, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (5, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (5, 'F.イとウ');

-- 正解と解説を挿入
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (1, 2, '正解は選択肢2です。これは最も適切な回答です。');

