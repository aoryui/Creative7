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
    genre_text TEXT NOT NULL,
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
INSERT INTO questions (question_id,genre_text,question_text) VALUES (1,'二語の関係','1_1_1');
INSERT INTO questions (question_id,genre_text,question_text) VALUES (2,'二語の関係','1_1_2');
INSERT INTO questions (question_id,genre_text,question_text) VALUES (3,'二語の関係','1_1_3');
INSERT INTO questions (question_id,genre_text,question_text) VALUES (4,'二語の関係','1_1_4');
INSERT INTO questions (question_id,genre_text,question_text) VALUES (5,'二語の関係','1_1_5');
INSERT INTO questions (question_id,genre_text,question_text) VALUES (6,'二語の関係','1_1_6');
INSERT INTO questions (question_id,genre_text,question_text) VALUES (7,'二語の関係','1_1_7');
INSERT INTO questions (question_id,genre_text,question_text) VALUES (8,'二語の関係','1_1_8');
INSERT INTO questions (question_id,genre_text,question_text) VALUES (9,'二語の関係','1_1_9');
INSERT INTO questions (question_id,genre_text,question_text) VALUES (10,'二語の関係','1_1_10');

-- 選択肢を挿入
INSERT INTO choices (question_id, choice_text) VALUES (1, 'A.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (1, 'B.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (1, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (1, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (1, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (1, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (2, 'A.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (2, 'B.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (2, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (2, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (2, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (2, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (3, 'A.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (3, 'B.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (3, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (3, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (3, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (3, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (4, 'A.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (4, 'B.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (4, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (4, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (4, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (4, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (5, 'A.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (5, 'B.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (5, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (5, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (5, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (5, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (6, 'A.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (6, 'B.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (6, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (6, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (6, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (6, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (7, 'A.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (7, 'B.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (7, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (7, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (7, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (7, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (8, 'A.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (8, 'B.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (8, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (8, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (8, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (8, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (9, 'A.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (9, 'B.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (9, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (9, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (9, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (9, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (10, 'A.アだけ');
INSERT INTO choices (question_id, choice_text) VALUES (10, 'B.イだけ');
INSERT INTO choices (question_id, choice_text) VALUES (10, 'C.ウだけ');
INSERT INTO choices (question_id, choice_text) VALUES (10, 'D.アとイ');
INSERT INTO choices (question_id, choice_text) VALUES (10, 'E.アとウ');
INSERT INTO choices (question_id, choice_text) VALUES (10, 'F.イとウ');

-- 正解と解説を挿入
-- 正解の番号が違うので後で修正
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (1, 5, '1_1_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (2, 10, '1_1_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (3, 17, '1_1_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (4, 23, '1_1_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (5, 25, '1_1_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (6, 34, '1_1_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (7, 37, '1_1_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (8, 47, '1_1_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (9, 54, '1_1_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (10, 58, '1_1_10');
