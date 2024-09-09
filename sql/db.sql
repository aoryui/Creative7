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
    password  varchar(100) NOT NULL,
    correct_rate INT NOT NULL DEFAULT 0, -- 正答率 (初期値0)
    average_time INT NOT NULL DEFAULT 0, -- 平均回答時間
    total_questions INT NOT NULL DEFAULT 0, -- 問題数
    -- 言語
    correct_rate_lang INT NOT NULL DEFAULT 0, -- 正答率 (初期値0)
    average_time_lang INT NOT NULL DEFAULT 0, -- 平均回答時間
    total_questions_lang INT NOT NULL DEFAULT 0, -- 問題数
    -- 非言語
    correct_rate_nonlang INT NOT NULL DEFAULT 0, -- 正答率 (初期値0)
    average_time_nonlang INT NOT NULL DEFAULT 0, -- 平均回答時間
    total_questions_nonlang INT NOT NULL DEFAULT 0 -- 問題数
);


-- 以下問題
-- 問題テーブルを作成
DROP TABLE IF EXISTS questions;
CREATE TABLE questions (
    question_id INT AUTO_INCREMENT PRIMARY KEY, -- 問題ID
    field_id INT NOT NULL, -- 言語非言語ID
    genre_id INT NOT NULL, -- ジャンルID
    interval_num INT NOT NULL, -- 制限時間
    genre_text TEXT NOT NULL, -- ジャンルの名前
    question_text TEXT NOT NULL, -- 問題の画像
    sentence TEXT NOT NULL -- 問題の文章
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

DROP TABLE IF EXISTS wrong;
CREATE TABLE wrong (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userid int(255) NOT NULL ,
    question_id int(255) NOT NULL 
);

-- 問題を挿入
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (1,1,1,30,'二語の関係','1_1_1','努力：成功');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (2,1,1,30,'二語の関係','1_1_2','勤勉：怠惰');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (3,1,1,30,'二語の関係','1_1_3','医者：患者');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (4,1,1,30,'二語の関係','1_1_4','花：種');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (5,1,1,30,'二語の関係','1_1_5','映画：劇場');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (6,1,1,30,'二語の関係','1_1_6','知識：学問');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (7,1,1,30,'二語の関係','1_1_7','車：道路');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (8,1,1,30,'二語の関係','1_1_8','天気予報：天気');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (9,1,1,30,'二語の関係','1_1_9','昼：夜');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (10,1,1,30,'二語の関係','1_1_10','数学：算数');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (11,1,2,30,'語句の意味','1_2_1','「非常に優れていること」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (12,1,2,30,'語句の意味','1_2_2','「話が横道にそれること」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (13,1,2,30,'語句の意味','1_2_3','「一時的に流行すること」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (14,1,2,30,'語句の意味','1_2_4','「人をたぶらかすこと」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (15,1,2,30,'語句の意味','1_2_5','「意見が対立すること」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (16,1,2,30,'語句の意味','1_2_6','「無駄になること」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (17,1,2,30,'語句の意味','1_2_7','「言動が一致していること」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (18,1,2,30,'語句の意味','1_2_8','「努力が報われていること」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (19,1,2,30,'語句の意味','1_2_9','「何もしていない状態」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (20,1,2,30,'語句の意味','1_2_10','「細かいことにこだわらないこと」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (21,1,2,30,'語句の意味','1_2_11','「心の中でひそかに喜ぶこと」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (22,1,2,30,'語句の意味','1_2_12','「意見や行動が一致すること」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (23,1,3,30,'語句の用法','1_3_1','「うれしい」知らせが届いた');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (24,1,3,30,'語句の用法','1_3_2','「つよい」風が吹く');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (25,1,3,30,'語句の用法','1_3_3','「みじかい」手紙を書く');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (26,1,3,30,'語句の用法','1_3_4','「あつい」コーヒーを飲む');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (27,1,3,30,'語句の用法','1_3_5','「すずしい」風が吹く');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (28,1,3,30,'語句の用法','1_3_6','「ひろい」視野を持つ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (29,1,3,30,'語句の用法','1_3_7','「ふかい」眠りにつく');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (30,1,3,30,'語句の用法','1_3_8','「つめたい」態度をとる');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (31,1,3,30,'語句の用法','1_3_9','「はやい」対応する');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (32,1,3,30,'語句の用法','1_3_10','「おおきな」声で話す');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (33,1,4,30,'文章整序','1_4_1','食生活の改善');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (34,1,4,30,'文章整序','1_4_2','彼の意見');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (35,1,4,30,'文章整序','1_4_3','技術革新');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (36,1,4,30,'文章整序','1_4_4','環境保護のため');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (37,1,4,30,'文章整序','1_4_5','教育改革は');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (38,1,4,30,'文章整序','1_4_6','グローバル化');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (39,1,4,30,'文章整序','1_4_7','日本の伝統文化');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (40,1,4,30,'文章整序','1_4_8','情報セキュリティ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (41,1,4,30,'文章整序','1_4_9','自然災害に備えるために');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (42,1,4,30,'文章整序','1_4_10','人間関係のトラブルを解決する');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (43,1,5,30,'空欄補充','1_5_1','部長は新しい企画に[ ]を入れた');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (44,1,5,30,'空欄補充','1_5_2','この計画を実行するため');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (45,1,5,30,'空欄補充','1_5_3','彼は仕事に対して[ ]の精神を持っている');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (46,1,5,30,'空欄補充','1_5_4','会議中に彼は何度も[ ]を見せた');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (47,1,5,30,'空欄補充','1_5_5','彼は新しい環境に[ ]した');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (48,1,5,30,'空欄補充','1_5_6','この書類に[ ]をする必要がある');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (49,1,5,30,'空欄補充','1_5_7','彼はその問題に対して迅速に[ ]した');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (50,1,5,30,'空欄補充','1_5_8','新しい政策は市民の[ ]を引いた');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (51,1,5,30,'空欄補充','1_5_9','彼はチームの一員として[ ]している');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (52,1,5,30,'空欄補充','1_5_10','彼の発言は会議の[ ]を左右した');

-- 非言語問題
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (53,2,1,30,'場合の数','2_1_1','6人のグループから3人を選ぶ方法');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (54,2,1,30,'場合の数','2_1_2','4人の中から1位と2位を選ぶ方法');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (55,2,1,30,'場合の数','2_1_3','5つの異なる本を2列に並べる方法');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (56,2,1,30,'場合の数','2_1_4','赤、青、緑、黄の4色のボールを一列');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (57,2,1,30,'場合の数','2_1_5','6人の中から2人を選び');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (58,2,1,30,'場合の数','2_1_6','A、B、C、D の4人を一列に並べる方法');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (59,2,1,30,'場合の数','2_1_7','5種類の異なるジュースから3つを選ぶ方法');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (60,2,1,30,'場合の数','2_1_8','5人の中から3人を選び');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (61,2,1,30,'場合の数','2_1_9','ある町の住民の70%がインターネット');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (62,2,1,30,'場合の数','2_1_10','ある試験で、全体の得点が200点');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (63,2,2,30,'推論','2_2_1','全ての猫は動物である');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (64,2,2,30,'推論','2_2_2','全ての花は植物である');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (65,2,2,30,'推論','2_2_3','全ての車は乗り物である');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (66,2,2,30,'推論','2_2_4','全ての本は紙で作られている');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (67,2,2,30,'推論','2_2_5','全ての学生は試験を受ける');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (68,2,2,30,'推論','2_2_6','全ての鳥は卵を産む');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (69,2,2,30,'推論','2_2_7','全ての果物は食べられる');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (70,2,2,30,'推論','2_2_8','全ての犬は哺乳類である');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (71,2,2,30,'推論','2_2_9','全ての映画はフィクションである');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (72,2,2,30,'推論','2_2_10','全ての椅子は家具である');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (73,2,3,30,'割合','2_3_1','あるクラスに 30人の生徒');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (74,2,3,30,'割合','2_3_2','100個のリンゴのうち20個');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (75,2,3,30,'割合','2_3_3','ある会社には50人の従業員');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (76,2,3,30,'割合','2_3_4','ある製品の価格は800円です');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (77,2,3,30,'割合','2_3_5','200人の学生のうち、150人が数学');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (78,2,3,30,'割合','2_3_6','あるプロジェクトに60時間が割り当て');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (79,2,3,30,'割合','2_3_7','ある町には5000人の住民');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (80,2,3,30,'割合','2_3_8','ある商品の価格が15%上昇');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (81,2,3,30,'割合','2_3_9','ある町の住民の 70%がインターネット');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (82,2,3,30,'割合','2_3_10','ある試験で、全体の得点が200点');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (83,2,4,30,'確率','2_4_1','1枚の公正なコインを1回投げた');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (84,2,4,30,'確率','2_4_2','4人の中から1位と2位を選ぶ方法');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (85,2,4,30,'確率','2_4_3','5つの異なる本を2列に並べる方法');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (86,2,4,30,'確率','2_4_4','赤、青、緑、黄の4色のボールを一列');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (87,2,4,30,'確率','2_4_5','6人の中から2人を選び、さらにその2人');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (88,2,4,30,'確率','2_4_6','あるプロジェクトに60時間');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (89,2,4,30,'確率','2_4_7','ある町には5000人の住民がいます');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (90,2,4,30,'確率','2_4_8','ある商品の価格が15%上昇');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (91,2,4,30,'確率','2_4_9','ある町の住民の70%がインターネット');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (92,2,4,30,'確率','2_4_10','ある試験で、全体の得点が200点中');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (93,2,5,30,'金額計算','2_5_1','1つ150円のリンゴを5個');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (94,2,5,30,'金額計算','2_5_2','1つ200円のケーキを3個');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (95,2,5,30,'金額計算','2_5_3','1つ250円のサンドイッチを2個');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (96,2,5,30,'金額計算','2_5_4','1つ180円のパンを4個');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (97,2,5,30,'金額計算','2_5_5','1つ350円のピザを1枚');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (98,2,5,30,'金額計算','2_5_6','1つ120円のアイスクリーム');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (99,2,5,30,'金額計算','2_5_7','1つ90円のチョコレート');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (100,2,5,30,'金額計算','2_5_8','1つ500円のステーキ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (101,2,5,30,'金額計算','2_5_9','1つ400円のパスタを2皿');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (102,2,5,30,'金額計算','2_5_10','1つ350円のハンバーガーを3個');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (103,2,6,30,'分担計算','2_6_1','ある学校の生徒150人に対して');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (104,2,6,30,'分担計算','2_6_2','12人で300 枚の書類を処理する場合');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (105,2,6,30,'分担計算','2_6_3','8人で240 個のボールを仕分ける場合');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (106,2,6,30,'分担計算','2_6_4','15人で450冊の本を分類する場合');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (107,2,6,30,'分担計算','2_6_5','9人で540ページの書類を読む場合');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (108,2,6,30,'分担計算','2_6_6','20人で1000個の部品を組み立てる');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (109,2,6,30,'分担計算','2_6_7','6人で180個のファイルを整理する');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (110,2,6,30,'分担計算','2_6_8','7人で350個のピースをパズルにはめる');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (111,2,6,30,'分担計算','2_6_9','4人で360個のパーツを検査');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (112,2,6,30,'分担計算','2_6_10','5人で400本のペンをチェックする場合');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (113,2,7,30,'速度算','2_7_1','A駅からB駅までの距離は120km');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (114,2,7,30,'速度算','2_7_2','Xさんは毎朝自転車で通勤している');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (115,2,7,30,'速度算','2_7_3','A地点からB地点までの距離は60km');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (116,2,7,30,'速度算','2_7_4','A駅からB駅までの距離は75km');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (117,2,7,30,'速度算','2_7_5','XさんとYさんは同じ場所を同時に出発');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (118,2,7,30,'速度算','2_7_6','A駅からB駅までの距離');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (119,2,7,30,'速度算','2_7_7','A地点からB地点までの距離');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (120,2,7,30,'速度算','2_7_8','Xさんは毎朝自宅から学校まで自転車');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (121,2,7,30,'速度算','2_7_9','A地点からB地点までの距離は90km');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (122,2,7,30,'速度算','2_7_10','XさんとYさんは互いに離れた場所');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (123,2,8,30,'集合','2_8_1','ある学校の生徒150人に対して');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (124,2,8,30,'集合','2_8_2','美術部のメンバー45人のうち');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (125,2,8,30,'集合','2_8_3','ある会社の社員300人にアンケートを実施');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (126,2,8,30,'集合','2_8_4','100人の学生のうち、数学が好きな学生');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (127,2,8,30,'集合','2_8_5','あるイベントに参加した200人');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (128,2,8,30,'集合','2_8_6','ある地域の住民500人に調査');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (129,2,8,30,'集合','2_8_7','あるクラスの生徒50人のうち');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (130,2,8,30,'集合','2_8_8','ある企業の社員200人に調査');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (131,2,8,30,'集合','2_8_9','ある地域の住民1000人にアンケート');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (132,2,8,30,'集合','2_8_10','ある大学の学生300人に調査');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (133,2,9,30,'表の読み取り','2_9_1','化合物A、B、CはH、N、Oの3種類の原子');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (134,2,9,30,'表の読み取り','2_9_2','店A、店B、店Cの3つの店舗で販売');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (135,2,9,30,'表の読み取り','2_9_3','ある企業の部門A、B、Cの社員数');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (136,2,9,30,'表の読み取り','2_9_4','製品P、Q、Rの生産量');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (137,2,9,30,'表の読み取り','2_9_5','企業X、Y、Zの3社が共同で新製品を開発');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (138,2,9,30,'表の読み取り','2_9_6','化合物P、Q、RはNa、Cl、Kの3種類');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (139,2,9,30,'表の読み取り','2_9_7','ある会社の部門X、Y、Zの予算配分の割合');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (140,2,9,30,'表の読み取り','2_9_8','ある企業の部門A、B、Cの売上高の割合');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (141,2,9,30,'表の読み取り','2_9_9','化合物X、Y、ZはH、O、Nの3種類の原子');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (142,2,9,30,'表の読み取り','2_9_10','ある学校のクラスA、B、Cの生徒数の割合');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (143,2,10,30,'特殊計算','2_10_1','500円と300円の2種類の定食');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (144,2,10,30,'特殊計算','2_10_2','700円と400円の2種類のスニーカー');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (145,2,10,30,'特殊計算','2_10_3','600円と250円の2種類の鉛筆');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (146,2,10,30,'特殊計算','2_10_4','800円と500円の2種類のバッグ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (147,2,10,30,'特殊計算','2_10_5','1000円と600円の2種類のノート');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (148,2,10,30,'特殊計算','2_10_6','3000円と2000円の2種類の靴');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (149,2,10,30,'特殊計算','2_10_7','1500円と1000円の2種類のバッグ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (150,2,10,30,'特殊計算','2_10_8','1200円と800円の2種類のシャツ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (151,2,10,30,'特殊計算','2_10_9','1800円と1100円の2種類の帽子');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (152,2,10,30,'特殊計算','2_10_10','2200円と1500円の2種類のズボン');




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
INSERT INTO choices (question_id, choice_text) VALUES (10, 'E.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (11, 'A.花を持たせる');
INSERT INTO choices (question_id, choice_text) VALUES (11, 'B.頭角を現す');
INSERT INTO choices (question_id, choice_text) VALUES (11, 'C.手を焼く');
INSERT INTO choices (question_id, choice_text) VALUES (11, 'D.道を開く');
INSERT INTO choices (question_id, choice_text) VALUES (11, 'E.目をかける');

INSERT INTO choices (question_id, choice_text) VALUES (12, 'A.逸脱する');
INSERT INTO choices (question_id, choice_text) VALUES (12, 'B.話が弾む');
INSERT INTO choices (question_id, choice_text) VALUES (12, 'C.脱線する');
INSERT INTO choices (question_id, choice_text) VALUES (12, 'D.切り出す');
INSERT INTO choices (question_id, choice_text) VALUES (12, 'E.一矢報いる');

INSERT INTO choices (question_id, choice_text) VALUES (13, 'A.一世を風靡する');
INSERT INTO choices (question_id, choice_text) VALUES (13, 'B.言い古される');
INSERT INTO choices (question_id, choice_text) VALUES (13, 'C.焼き直す');
INSERT INTO choices (question_id, choice_text) VALUES (13, 'D.流行に乗る');
INSERT INTO choices (question_id, choice_text) VALUES (13, 'E.泡沫の如し');

INSERT INTO choices (question_id, choice_text) VALUES (14, 'A.火に油を注ぐ');
INSERT INTO choices (question_id, choice_text) VALUES (14, 'B.油断大敵');
INSERT INTO choices (question_id, choice_text) VALUES (14, 'C.目の上のたんこぶ');
INSERT INTO choices (question_id, choice_text) VALUES (14, 'D.口車に乗せる');
INSERT INTO choices (question_id, choice_text) VALUES (14, 'E.水の泡');

INSERT INTO choices (question_id, choice_text) VALUES (15, 'A.意気投合');
INSERT INTO choices (question_id, choice_text) VALUES (15, 'B.二律背反');
INSERT INTO choices (question_id, choice_text) VALUES (15, 'C.一枚上手');
INSERT INTO choices (question_id, choice_text) VALUES (15, 'D.一致団結');
INSERT INTO choices (question_id, choice_text) VALUES (15, 'E.反目する');

INSERT INTO choices (question_id, choice_text) VALUES (16, 'A.有終の美を飾る');
INSERT INTO choices (question_id, choice_text) VALUES (16, 'B.水泡に帰す');
INSERT INTO choices (question_id, choice_text) VALUES (16, 'C.実を結ぶ');
INSERT INTO choices (question_id, choice_text) VALUES (16, 'D.飛ぶ鳥を落とす勢い');
INSERT INTO choices (question_id, choice_text) VALUES (16, 'E.地道に');

INSERT INTO choices (question_id, choice_text) VALUES (17, 'A.二枚舌');
INSERT INTO choices (question_id, choice_text) VALUES (17, 'B.裏表がない');
INSERT INTO choices (question_id, choice_text) VALUES (17, 'C.裏腹');
INSERT INTO choices (question_id, choice_text) VALUES (17, 'D.たぬき寝入り');
INSERT INTO choices (question_id, choice_text) VALUES (17, 'E.二重人格');

INSERT INTO choices (question_id, choice_text) VALUES (18, 'A.一朝一夕');
INSERT INTO choices (question_id, choice_text) VALUES (18, 'B.手塩にかける');
INSERT INTO choices (question_id, choice_text) VALUES (18, 'C.報われる');
INSERT INTO choices (question_id, choice_text) VALUES (18, 'D.袖振り合うも多生の縁');
INSERT INTO choices (question_id, choice_text) VALUES (18, 'E.七転び八起き');

INSERT INTO choices (question_id, choice_text) VALUES (19, 'A.袖手傍観');
INSERT INTO choices (question_id, choice_text) VALUES (19, 'B.腕を磨く');
INSERT INTO choices (question_id, choice_text) VALUES (19, 'C.手をこまねく');
INSERT INTO choices (question_id, choice_text) VALUES (19, 'D.腕に覚えがある');
INSERT INTO choices (question_id, choice_text) VALUES (19, 'E.手を広げる');

INSERT INTO choices (question_id, choice_text) VALUES (20, 'A.細かいことを気にする');
INSERT INTO choices (question_id, choice_text) VALUES (20, 'B.対局を見据える');
INSERT INTO choices (question_id, choice_text) VALUES (20, 'C.枝葉末節にとらわれる');
INSERT INTO choices (question_id, choice_text) VALUES (20, 'D.塵も積もれば山となる');
INSERT INTO choices (question_id, choice_text) VALUES (20, 'E.大ざっぱである');

INSERT INTO choices (question_id, choice_text) VALUES (21, 'A.ほくそ笑む');
INSERT INTO choices (question_id, choice_text) VALUES (21, 'B.微笑む');
INSERT INTO choices (question_id, choice_text) VALUES (21, 'C.笑い転げる');
INSERT INTO choices (question_id, choice_text) VALUES (21, 'D.心底喜ぶ');
INSERT INTO choices (question_id, choice_text) VALUES (21, 'E.爆笑する');

INSERT INTO choices (question_id, choice_text) VALUES (22, 'A.意見対立');
INSERT INTO choices (question_id, choice_text) VALUES (22, 'B.統一見解');
INSERT INTO choices (question_id, choice_text) VALUES (22, 'C.一致協力');
INSERT INTO choices (question_id, choice_text) VALUES (22, 'D.和睦');
INSERT INTO choices (question_id, choice_text) VALUES (22, 'E.争い事');

INSERT INTO choices (question_id, choice_text) VALUES (23, 'A.うれしい気持ちになる');
INSERT INTO choices (question_id, choice_text) VALUES (23, 'B.うれしい顔をする');
INSERT INTO choices (question_id, choice_text) VALUES (23, 'C.うれしい食事をする');
INSERT INTO choices (question_id, choice_text) VALUES (23, 'D.うれしい歌を聴く');
INSERT INTO choices (question_id, choice_text) VALUES (23, 'E.うれしい出来事が起こる');

INSERT INTO choices (question_id, choice_text) VALUES (24, 'A.つよい心を持つ');
INSERT INTO choices (question_id, choice_text) VALUES (24, 'B.つよい印象を受ける');
INSERT INTO choices (question_id, choice_text) VALUES (24, 'C.つよい酒を飲む');
INSERT INTO choices (question_id, choice_text) VALUES (24, 'D.つよいチーム');
INSERT INTO choices (question_id, choice_text) VALUES (24, 'E.つよい寒さ');

INSERT INTO choices (question_id, choice_text) VALUES (25, 'A.みじかい髪の毛');
INSERT INTO choices (question_id, choice_text) VALUES (25, 'B.みじかい話');
INSERT INTO choices (question_id, choice_text) VALUES (25, 'C.みじかい命');
INSERT INTO choices (question_id, choice_text) VALUES (25, 'D.みじかいスカート');
INSERT INTO choices (question_id, choice_text) VALUES (25, 'E.みじかい昼休み');

INSERT INTO choices (question_id, choice_text) VALUES (26, 'A.あつい友情');
INSERT INTO choices (question_id, choice_text) VALUES (26, 'B.あつい毛布');
INSERT INTO choices (question_id, choice_text) VALUES (26, 'C.あつい手袋');
INSERT INTO choices (question_id, choice_text) VALUES (26, 'D.あつい声援');
INSERT INTO choices (question_id, choice_text) VALUES (26, 'E.あつい鉄板');

INSERT INTO choices (question_id, choice_text) VALUES (27, 'A.すずしい色');
INSERT INTO choices (question_id, choice_text) VALUES (27, 'B.すずしい気持ち');
INSERT INTO choices (question_id, choice_text) VALUES (27, 'C.すずしい態度');
INSERT INTO choices (question_id, choice_text) VALUES (27, 'D.すずしい水');
INSERT INTO choices (question_id, choice_text) VALUES (27, 'E.すずしい表情');

INSERT INTO choices (question_id, choice_text) VALUES (28, 'A.ひろい場所');
INSERT INTO choices (question_id, choice_text) VALUES (28, 'B.ひろい肩幅');
INSERT INTO choices (question_id, choice_text) VALUES (28, 'C.ひろい心');
INSERT INTO choices (question_id, choice_text) VALUES (28, 'D.ひろい海');
INSERT INTO choices (question_id, choice_text) VALUES (28, 'E.ひろい道');

INSERT INTO choices (question_id, choice_text) VALUES (29, 'A.ふかい色');
INSERT INTO choices (question_id, choice_text) VALUES (29, 'B.ふかい知識');
INSERT INTO choices (question_id, choice_text) VALUES (29, 'C.ふかい海');
INSERT INTO choices (question_id, choice_text) VALUES (29, 'D.ふかい考え');
INSERT INTO choices (question_id, choice_text) VALUES (29, 'E.ふかい悲しみ');

INSERT INTO choices (question_id, choice_text) VALUES (30, 'A.つめたい飲み物');
INSERT INTO choices (question_id, choice_text) VALUES (30, 'B.つめたい空気');
INSERT INTO choices (question_id, choice_text) VALUES (30, 'C.つめたい風');
INSERT INTO choices (question_id, choice_text) VALUES (30, 'D.つめたい人');
INSERT INTO choices (question_id, choice_text) VALUES (30, 'E.つめたい手');

INSERT INTO choices (question_id, choice_text) VALUES (31, 'A.はやい話');
INSERT INTO choices (question_id, choice_text) VALUES (31, 'B.はやい車');
INSERT INTO choices (question_id, choice_text) VALUES (31, 'C.はやい足');
INSERT INTO choices (question_id, choice_text) VALUES (31, 'D.はやい春');
INSERT INTO choices (question_id, choice_text) VALUES (31, 'E.はやい時間');

INSERT INTO choices (question_id, choice_text) VALUES (32, 'A.おおきなビル');
INSERT INTO choices (question_id, choice_text) VALUES (32, 'B.おおきな心');
INSERT INTO choices (question_id, choice_text) VALUES (32, 'C.おおきな問題');
INSERT INTO choices (question_id, choice_text) VALUES (32, 'D.おおきな進捗');
INSERT INTO choices (question_id, choice_text) VALUES (32, 'E.おおきな野望');

INSERT INTO choices (question_id, choice_text) VALUES (33, 'A.バランスの取れた栄養を');
INSERT INTO choices (question_id, choice_text) VALUES (33, 'B.さまざまな食品から');
INSERT INTO choices (question_id, choice_text) VALUES (33, 'C.摂取することが');
INSERT INTO choices (question_id, choice_text) VALUES (33, 'D.私たちの');
INSERT INTO choices (question_id, choice_text) VALUES (33, 'E.役立つことは');

INSERT INTO choices (question_id, choice_text) VALUES (34, 'A.会議の席上で');
INSERT INTO choices (question_id, choice_text) VALUES (34, 'B.多くの人々に');
INSERT INTO choices (question_id, choice_text) VALUES (34, 'C.その新しいプロジェクトに対する');
INSERT INTO choices (question_id, choice_text) VALUES (34, 'D.認められ');
INSERT INTO choices (question_id, choice_text) VALUES (34, 'E.特に');

INSERT INTO choices (question_id, choice_text) VALUES (35, 'A.情報通信技術や');
INSERT INTO choices (question_id, choice_text) VALUES (35, 'B.交通手段の進化など');
INSERT INTO choices (question_id, choice_text) VALUES (35, 'C.様々な分野で');
INSERT INTO choices (question_id, choice_text) VALUES (35, 'D.特に');
INSERT INTO choices (question_id, choice_text) VALUES (35, 'E.現代の');

INSERT INTO choices (question_id, choice_text) VALUES (36, 'A.国際社会が');
INSERT INTO choices (question_id, choice_text) VALUES (36, 'B.連携して');
INSERT INTO choices (question_id, choice_text) VALUES (36, 'C.様々な');
INSERT INTO choices (question_id, choice_text) VALUES (36, 'D.問題に');
INSERT INTO choices (question_id, choice_text) VALUES (36, 'E.協力し合い');

INSERT INTO choices (question_id, choice_text) VALUES (37, 'A.生徒の');
INSERT INTO choices (question_id, choice_text) VALUES (37, 'B.近年');
INSERT INTO choices (question_id, choice_text) VALUES (37, 'C.学習意欲の向上や');
INSERT INTO choices (question_id, choice_text) VALUES (37, 'D.学力向上に');
INSERT INTO choices (question_id, choice_text) VALUES (37, 'E.努力が');

INSERT INTO choices (question_id, choice_text) VALUES (38, 'A.国際的な');
INSERT INTO choices (question_id, choice_text) VALUES (38, 'B.様々な分野での');
INSERT INTO choices (question_id, choice_text) VALUES (38, 'C.協力や連携が');
INSERT INTO choices (question_id, choice_text) VALUES (38, 'D.進む中で');
INSERT INTO choices (question_id, choice_text) VALUES (38, 'E.特に');

INSERT INTO choices (question_id, choice_text) VALUES (39, 'A.現在でも');
INSERT INTO choices (question_id, choice_text) VALUES (39, 'B.多くの人々によって');
INSERT INTO choices (question_id, choice_text) VALUES (39, 'C.様々な形で');
INSERT INTO choices (question_id, choice_text) VALUES (39, 'D.大切に');
INSERT INTO choices (question_id, choice_text) VALUES (39, 'E.受け継がれて');

INSERT INTO choices (question_id, choice_text) VALUES (40, 'A.インターネットの');
INSERT INTO choices (question_id, choice_text) VALUES (40, 'B.利用が増加する中で');
INSERT INTO choices (question_id, choice_text) VALUES (40, 'C.企業や個人の');
INSERT INTO choices (question_id, choice_text) VALUES (40, 'D.脅威に対する');
INSERT INTO choices (question_id, choice_text) VALUES (40, 'E.適切な');

INSERT INTO choices (question_id, choice_text) VALUES (41, 'A.防災教育の');
INSERT INTO choices (question_id, choice_text) VALUES (41, 'B.地域住民への');
INSERT INTO choices (question_id, choice_text) VALUES (41, 'C.実施が');
INSERT INTO choices (question_id, choice_text) VALUES (41, 'D.大切であり');
INSERT INTO choices (question_id, choice_text) VALUES (41, 'E.早急な');

INSERT INTO choices (question_id, choice_text) VALUES (42, 'A.対話と');
INSERT INTO choices (question_id, choice_text) VALUES (42, 'B.互いの');
INSERT INTO choices (question_id, choice_text) VALUES (42, 'C.理解が');
INSERT INTO choices (question_id, choice_text) VALUES (42, 'D.尊重と');
INSERT INTO choices (question_id, choice_text) VALUES (42, 'E.深めることが');

INSERT INTO choices (question_id, choice_text) VALUES (43, 'A.横槍');
INSERT INTO choices (question_id, choice_text) VALUES (43, 'B.横車');
INSERT INTO choices (question_id, choice_text) VALUES (43, 'C.横紙');
INSERT INTO choices (question_id, choice_text) VALUES (43, 'D.横行');
INSERT INTO choices (question_id, choice_text) VALUES (43, 'E.横断');

INSERT INTO choices (question_id, choice_text) VALUES (44, 'A.鉄面皮');
INSERT INTO choices (question_id, choice_text) VALUES (44, 'B.鉄腕');
INSERT INTO choices (question_id, choice_text) VALUES (44, 'C.鉄則');
INSERT INTO choices (question_id, choice_text) VALUES (44, 'D.鉄壁');
INSERT INTO choices (question_id, choice_text) VALUES (44, 'E.鉄路');

INSERT INTO choices (question_id, choice_text) VALUES (45, 'A.絶望');
INSERT INTO choices (question_id, choice_text) VALUES (45, 'B.確信');
INSERT INTO choices (question_id, choice_text) VALUES (45, 'C.根気');
INSERT INTO choices (question_id, choice_text) VALUES (45, 'D.適当');
INSERT INTO choices (question_id, choice_text) VALUES (45, 'E.優柔');

INSERT INTO choices (question_id, choice_text) VALUES (46, 'A.絶望');
INSERT INTO choices (question_id, choice_text) VALUES (46, 'B.不満');
INSERT INTO choices (question_id, choice_text) VALUES (46, 'C.敬意');
INSERT INTO choices (question_id, choice_text) VALUES (46, 'D.適当');
INSERT INTO choices (question_id, choice_text) VALUES (46, 'E.確信');

INSERT INTO choices (question_id, choice_text) VALUES (47, 'A.適応');
INSERT INTO choices (question_id, choice_text) VALUES (47, 'B.適合');
INSERT INTO choices (question_id, choice_text) VALUES (47, 'C.適応症');
INSERT INTO choices (question_id, choice_text) VALUES (47, 'D.摘用');
INSERT INTO choices (question_id, choice_text) VALUES (47, 'E.適当');

INSERT INTO choices (question_id, choice_text) VALUES (48, 'A.修正');
INSERT INTO choices (question_id, choice_text) VALUES (48, 'B.修理');
INSERT INTO choices (question_id, choice_text) VALUES (48, 'C.修復');
INSERT INTO choices (question_id, choice_text) VALUES (48, 'D.修正術');
INSERT INTO choices (question_id, choice_text) VALUES (48, 'E.修行');

INSERT INTO choices (question_id, choice_text) VALUES (49, 'A.対処');
INSERT INTO choices (question_id, choice_text) VALUES (49, 'B.対応');
INSERT INTO choices (question_id, choice_text) VALUES (49, 'C.対決');
INSERT INTO choices (question_id, choice_text) VALUES (49, 'D.対峙');
INSERT INTO choices (question_id, choice_text) VALUES (49, 'E.対策');

INSERT INTO choices (question_id, choice_text) VALUES (50, 'A.注目');
INSERT INTO choices (question_id, choice_text) VALUES (50, 'B.注意');
INSERT INTO choices (question_id, choice_text) VALUES (50, 'C.注文');
INSERT INTO choices (question_id, choice_text) VALUES (50, 'D.注視');
INSERT INTO choices (question_id, choice_text) VALUES (50, 'E.注釈');

INSERT INTO choices (question_id, choice_text) VALUES (51, 'A.貢献');
INSERT INTO choices (question_id, choice_text) VALUES (51, 'B.相談');
INSERT INTO choices (question_id, choice_text) VALUES (51, 'C.交渉');
INSERT INTO choices (question_id, choice_text) VALUES (51, 'D.交渉中');
INSERT INTO choices (question_id, choice_text) VALUES (51, 'E.貢献者');

INSERT INTO choices (question_id, choice_text) VALUES (52, 'A.行方');
INSERT INTO choices (question_id, choice_text) VALUES (52, 'B.方向');
INSERT INTO choices (question_id, choice_text) VALUES (52, 'C.道筋');
INSERT INTO choices (question_id, choice_text) VALUES (52, 'D.行程');
INSERT INTO choices (question_id, choice_text) VALUES (52, 'E.推移');

INSERT INTO choices (question_id, choice_text) VALUES (53, 'A. 15 通り');
INSERT INTO choices (question_id, choice_text) VALUES (53, 'B. 20 通り');
INSERT INTO choices (question_id, choice_text) VALUES (53, 'C. 30 通り');
INSERT INTO choices (question_id, choice_text) VALUES (53, 'D. 40 通り');

INSERT INTO choices (question_id, choice_text) VALUES (54, 'A. 6 通り');
INSERT INTO choices (question_id, choice_text) VALUES (54, 'B. 8 通り');
INSERT INTO choices (question_id, choice_text) VALUES (54, 'C. 10 通り');
INSERT INTO choices (question_id, choice_text) VALUES (54, 'D. 12 通り');

INSERT INTO choices (question_id, choice_text) VALUES (55, 'A. 10 通り');
INSERT INTO choices (question_id, choice_text) VALUES (55, 'B. 20 通り');
INSERT INTO choices (question_id, choice_text) VALUES (55, 'C. 30 通り');
INSERT INTO choices (question_id, choice_text) VALUES (55, 'D. 40 通り');

INSERT INTO choices (question_id, choice_text) VALUES (56, 'A. 12 通り');
INSERT INTO choices (question_id, choice_text) VALUES (56, 'B. 24 通り');
INSERT INTO choices (question_id, choice_text) VALUES (56, 'C. 36 通り');
INSERT INTO choices (question_id, choice_text) VALUES (56, 'D. 48 通り');

INSERT INTO choices (question_id, choice_text) VALUES (57, 'A. 15 通り');
INSERT INTO choices (question_id, choice_text) VALUES (57, 'B. 30 通り');
INSERT INTO choices (question_id, choice_text) VALUES (57, 'C. 60 通り');
INSERT INTO choices (question_id, choice_text) VALUES (57, 'D. 120 通り');

INSERT INTO choices (question_id, choice_text) VALUES (58, 'A. 6 通り');
INSERT INTO choices (question_id, choice_text) VALUES (58, 'B. 12 通り');
INSERT INTO choices (question_id, choice_text) VALUES (58, 'C. 18 通り');
INSERT INTO choices (question_id, choice_text) VALUES (58, 'D. 24 通り');

INSERT INTO choices (question_id, choice_text) VALUES (59, 'A. 10 通り');
INSERT INTO choices (question_id, choice_text) VALUES (59, 'B. 15 通り');
INSERT INTO choices (question_id, choice_text) VALUES (59, 'C. 20 通り');
INSERT INTO choices (question_id, choice_text) VALUES (59, 'D. 25 通り');

INSERT INTO choices (question_id, choice_text) VALUES (60, 'A. 30 通り');
INSERT INTO choices (question_id, choice_text) VALUES (60, 'B. 60 通り');
INSERT INTO choices (question_id, choice_text) VALUES (60, 'C. 120 通り');
INSERT INTO choices (question_id, choice_text) VALUES (60, 'D. 240 通り');

INSERT INTO choices (question_id, choice_text) VALUES (61, 'A. 800 人');
INSERT INTO choices (question_id, choice_text) VALUES (61, 'B. 900 人');
INSERT INTO choices (question_id, choice_text) VALUES (61, 'C. 1000 人');
INSERT INTO choices (question_id, choice_text) VALUES (61, 'D. 1100 人');

INSERT INTO choices (question_id, choice_text) VALUES (62, 'A. 85%');
INSERT INTO choices (question_id, choice_text) VALUES (62, 'B. 90%');
INSERT INTO choices (question_id, choice_text) VALUES (62, 'C. 92%');
INSERT INTO choices (question_id, choice_text) VALUES (62, 'D. 95%');

INSERT INTO choices (question_id, choice_text) VALUES (63, 'A. 全ての動物は猫である。');
INSERT INTO choices (question_id, choice_text) VALUES (63, 'B. 全ての黒猫は動物である。');
INSERT INTO choices (question_id, choice_text) VALUES (63, 'C. 一部の動物は猫でない。');
INSERT INTO choices (question_id, choice_text) VALUES (63, 'D. 一部の黒猫は動物でない。');

INSERT INTO choices (question_id, choice_text) VALUES (64, 'A. 花は植物ではない。');
INSERT INTO choices (question_id, choice_text) VALUES (64, 'B. 全ての植物は花を咲かせる。');
INSERT INTO choices (question_id, choice_text) VALUES (64, 'C. 一部の植物は花を咲かせない。');
INSERT INTO choices (question_id, choice_text) VALUES (64, 'D. 一部の花は植物ではない。');

INSERT INTO choices (question_id, choice_text) VALUES (65, 'A. 全ての乗り物は車である。');
INSERT INTO choices (question_id, choice_text) VALUES (65, 'B. 全ての電気自動車は乗り物である。');
INSERT INTO choices (question_id, choice_text) VALUES (65, 'C. 一部の電気自動車は車でない。');
INSERT INTO choices (question_id, choice_text) VALUES (65, 'D. 一部の乗り物は車でない。');

INSERT INTO choices (question_id, choice_text) VALUES (66, 'A. 全ての紙は本である。');
INSERT INTO choices (question_id, choice_text) VALUES (66, 'B. 全ての小説は紙で作られている。');
INSERT INTO choices (question_id, choice_text) VALUES (66, 'C. 一部の紙は本でない。');
INSERT INTO choices (question_id, choice_text) VALUES (66, 'D. 一部の本は紙でない。');

INSERT INTO choices (question_id, choice_text) VALUES (67, 'A. 全ての試験を受ける人は学生である。');
INSERT INTO choices (question_id, choice_text) VALUES (67, 'B. 全ての部活動をしている学生は試験を受ける。');
INSERT INTO choices (question_id, choice_text) VALUES (67, 'C. 一部の部活動をしている学生は試験を受けない。');
INSERT INTO choices (question_id, choice_text) VALUES (67, 'D. 一部の試験を受ける人は学生でない。');

INSERT INTO choices (question_id, choice_text) VALUES (68, 'A. 全ての卵を産む動物は鳥である。');
INSERT INTO choices (question_id, choice_text) VALUES (68, 'B. 全ての飛べない鳥は卵を産まない。');
INSERT INTO choices (question_id, choice_text) VALUES (68, 'C. 一部の飛べない鳥は卵を産む。');
INSERT INTO choices (question_id, choice_text) VALUES (68, 'D. 一部の卵を産む動物は鳥でない。');

INSERT INTO choices (question_id, choice_text) VALUES (69, 'A. 全ての酸っぱいものは果物である。');
INSERT INTO choices (question_id, choice_text) VALUES (69, 'B. 全ての食べられるものは果物である。');
INSERT INTO choices (question_id, choice_text) VALUES (69, 'C. 一部の酸っぱいものは果物である。');
INSERT INTO choices (question_id, choice_text) VALUES (69, 'D. 一部の果物は食べられない。');

INSERT INTO choices (question_id, choice_text) VALUES (70, 'A. 全ての盲導犬は哺乳類である。');
INSERT INTO choices (question_id, choice_text) VALUES (70, 'B. 全ての哺乳類は犬である。');
INSERT INTO choices (question_id, choice_text) VALUES (70, 'C. 一部の哺乳類は犬でない。');
INSERT INTO choices (question_id, choice_text) VALUES (70, 'D. 一部の盲導犬は哺乳類でない。');

INSERT INTO choices (question_id, choice_text) VALUES (71, 'A. 全てのドキュメンタリーはフィクションである。');
INSERT INTO choices (question_id, choice_text) VALUES (71, 'B. 全てのフィクションは映画である。');
INSERT INTO choices (question_id, choice_text) VALUES (71, 'C. 一部のドキュメンタリーはフィクションでない。');
INSERT INTO choices (question_id, choice_text) VALUES (71, 'D. 一部の映画はフィクションでない。');

INSERT INTO choices (question_id, choice_text) VALUES (72, 'A. 全ての家具は椅子である。');
INSERT INTO choices (question_id, choice_text) VALUES (72, 'B. 全ての木製のものは椅子である。');
INSERT INTO choices (question_id, choice_text) VALUES (72, 'C. 一部の木製の椅子は家具でない。');
INSERT INTO choices (question_id, choice_text) VALUES (72, 'D. 一部の家具は椅子でない。');

INSERT INTO choices (question_id, choice_text) VALUES (73, 'A. 50%');
INSERT INTO choices (question_id, choice_text) VALUES (73, 'B. 60%');
INSERT INTO choices (question_id, choice_text) VALUES (73, 'C. 70%');
INSERT INTO choices (question_id, choice_text) VALUES (73, 'D. 80%');

INSERT INTO choices (question_id, choice_text) VALUES (74, 'A. 10%');
INSERT INTO choices (question_id, choice_text) VALUES (74, 'B. 15%');
INSERT INTO choices (question_id, choice_text) VALUES (74, 'C. 20%');
INSERT INTO choices (question_id, choice_text) VALUES (74, 'D. 25%');

INSERT INTO choices (question_id, choice_text) VALUES (75, 'A. 10 人');
INSERT INTO choices (question_id, choice_text) VALUES (75, 'B. 15 人');
INSERT INTO choices (question_id, choice_text) VALUES (75, 'C. 20 人');
INSERT INTO choices (question_id, choice_text) VALUES (75, 'D. 25 人');

INSERT INTO choices (question_id, choice_text) VALUES (76, 'A. 600 円');
INSERT INTO choices (question_id, choice_text) VALUES (76, 'B. 620 円');
INSERT INTO choices (question_id, choice_text) VALUES (76, 'C. 640 円');
INSERT INTO choices (question_id, choice_text) VALUES (76, 'D. 660 円');

INSERT INTO choices (question_id, choice_text) VALUES (77, 'A. 70%');
INSERT INTO choices (question_id, choice_text) VALUES (77, 'B. 75%');
INSERT INTO choices (question_id, choice_text) VALUES (77, 'C. 80%');
INSERT INTO choices (question_id, choice_text) VALUES (77, 'D. 85%');

INSERT INTO choices (question_id, choice_text) VALUES (78, 'A. 60%');
INSERT INTO choices (question_id, choice_text) VALUES (78, 'B. 65%');
INSERT INTO choices (question_id, choice_text) VALUES (78, 'C. 70%');
INSERT INTO choices (question_id, choice_text) VALUES (78, 'D. 75%');

INSERT INTO choices (question_id, choice_text) VALUES (79, 'A. 2500 人');
INSERT INTO choices (question_id, choice_text) VALUES (79, 'B. 3000 人');
INSERT INTO choices (question_id, choice_text) VALUES (79, 'C. 3500 人');
INSERT INTO choices (question_id, choice_text) VALUES (79, 'D. 4000 人');

INSERT INTO choices (question_id, choice_text) VALUES (80, 'A. 800 円');
INSERT INTO choices (question_id, choice_text) VALUES (80, 'B. 820 円');
INSERT INTO choices (question_id, choice_text) VALUES (80, 'C. 840 円');
INSERT INTO choices (question_id, choice_text) VALUES (80, 'D. 850 円');

INSERT INTO choices (question_id, choice_text) VALUES (81, 'A. 800 人');
INSERT INTO choices (question_id, choice_text) VALUES (81, 'B. 900 人');
INSERT INTO choices (question_id, choice_text) VALUES (81, 'C. 1000 人');
INSERT INTO choices (question_id, choice_text) VALUES (81, 'D. 1100 人');

INSERT INTO choices (question_id, choice_text) VALUES (82, 'A. 85%');
INSERT INTO choices (question_id, choice_text) VALUES (82, 'B. 90%');
INSERT INTO choices (question_id, choice_text) VALUES (82, 'C. 92%');
INSERT INTO choices (question_id, choice_text) VALUES (82, 'D. 95%');

INSERT INTO choices (question_id, choice_text) VALUES (83, 'A. 0.1');
INSERT INTO choices (question_id, choice_text) VALUES (83, 'B. 0.25');
INSERT INTO choices (question_id, choice_text) VALUES (83, 'C. 0.5');
INSERT INTO choices (question_id, choice_text) VALUES (83, 'D. 1');

INSERT INTO choices (question_id, choice_text) VALUES (84, 'A. 6 通り');
INSERT INTO choices (question_id, choice_text) VALUES (84, 'B. 8 通り');
INSERT INTO choices (question_id, choice_text) VALUES (84, 'C. 10 通り');
INSERT INTO choices (question_id, choice_text) VALUES (84, 'D. 12 通り');

INSERT INTO choices (question_id, choice_text) VALUES (85, 'A. 10 通り');
INSERT INTO choices (question_id, choice_text) VALUES (85, 'B. 20 通り');
INSERT INTO choices (question_id, choice_text) VALUES (85, 'C. 30 通り');
INSERT INTO choices (question_id, choice_text) VALUES (85, 'D. 40 通り');

INSERT INTO choices (question_id, choice_text) VALUES (86, 'A. 12 通り');
INSERT INTO choices (question_id, choice_text) VALUES (86, 'B. 24 通り');
INSERT INTO choices (question_id, choice_text) VALUES (86, 'C. 36 通り');
INSERT INTO choices (question_id, choice_text) VALUES (86, 'D. 48 通り');

INSERT INTO choices (question_id, choice_text) VALUES (87, 'A. 15 通り');
INSERT INTO choices (question_id, choice_text) VALUES (87, 'B. 30 通り');
INSERT INTO choices (question_id, choice_text) VALUES (87, 'C. 60 通り');
INSERT INTO choices (question_id, choice_text) VALUES (87, 'D. 120 通り');

INSERT INTO choices (question_id, choice_text) VALUES (88, 'A. 60%');
INSERT INTO choices (question_id, choice_text) VALUES (88, 'B. 65%');
INSERT INTO choices (question_id, choice_text) VALUES (88, 'C. 70%');
INSERT INTO choices (question_id, choice_text) VALUES (88, 'D. 75%');

INSERT INTO choices (question_id, choice_text) VALUES (89, 'A. 2500 人');
INSERT INTO choices (question_id, choice_text) VALUES (89, 'B. 3000 人');
INSERT INTO choices (question_id, choice_text) VALUES (89, 'C. 3500 人');
INSERT INTO choices (question_id, choice_text) VALUES (89, 'D. 4000 人');

INSERT INTO choices (question_id, choice_text) VALUES (90, 'A. 800 円');
INSERT INTO choices (question_id, choice_text) VALUES (90, 'B. 820 円');
INSERT INTO choices (question_id, choice_text) VALUES (90, 'C. 840 円');
INSERT INTO choices (question_id, choice_text) VALUES (90, 'D. 850 円');

INSERT INTO choices (question_id, choice_text) VALUES (91, 'A. 800 人');
INSERT INTO choices (question_id, choice_text) VALUES (91, 'B. 900 人');
INSERT INTO choices (question_id, choice_text) VALUES (91, 'C. 1000 人');
INSERT INTO choices (question_id, choice_text) VALUES (91, 'D. 1100 人');

INSERT INTO choices (question_id, choice_text) VALUES (92, 'A. 85%');
INSERT INTO choices (question_id, choice_text) VALUES (92, 'B. 90%');
INSERT INTO choices (question_id, choice_text) VALUES (92, 'C. 92%');
INSERT INTO choices (question_id, choice_text) VALUES (92, 'D. 95%');

INSERT INTO choices (question_id, choice_text) VALUES (93, 'A. 1050 円');
INSERT INTO choices (question_id, choice_text) VALUES (93, 'B. 1140 円');
INSERT INTO choices (question_id, choice_text) VALUES (93, 'C. 1230 円');
INSERT INTO choices (question_id, choice_text) VALUES (93, 'D. 1320 円');

INSERT INTO choices (question_id, choice_text) VALUES (94, 'A. 950 円');
INSERT INTO choices (question_id, choice_text) VALUES (94, 'B. 1000 円');
INSERT INTO choices (question_id, choice_text) VALUES (94, 'C. 1050 円');
INSERT INTO choices (question_id, choice_text) VALUES (94, 'D. 1100 円');

INSERT INTO choices (question_id, choice_text) VALUES (95, 'A. 1040 円');
INSERT INTO choices (question_id, choice_text) VALUES (95, 'B. 1050 円');
INSERT INTO choices (question_id, choice_text) VALUES (95, 'C. 1060 円');
INSERT INTO choices (question_id, choice_text) VALUES (95, 'D. 1070 円');

INSERT INTO choices (question_id, choice_text) VALUES (96, 'A. 1040 円');
INSERT INTO choices (question_id, choice_text) VALUES (96, 'B. 1060 円');
INSERT INTO choices (question_id, choice_text) VALUES (96, 'C. 1080 円');
INSERT INTO choices (question_id, choice_text) VALUES (96, 'D. 1100 円');

INSERT INTO choices (question_id, choice_text) VALUES (97, 'A. 700 円');
INSERT INTO choices (question_id, choice_text) VALUES (97, 'B. 750 円');
INSERT INTO choices (question_id, choice_text) VALUES (97, 'C. 800 円');
INSERT INTO choices (question_id, choice_text) VALUES (97, 'D. 850 円');

INSERT INTO choices (question_id, choice_text) VALUES (98, 'A. 1200 円');
INSERT INTO choices (question_id, choice_text) VALUES (98, 'B. 1350 円');
INSERT INTO choices (question_id, choice_text) VALUES (98, 'C. 1500 円');
INSERT INTO choices (question_id, choice_text) VALUES (98, 'D. 1650 円');

INSERT INTO choices (question_id, choice_text) VALUES (99, 'A. 1500 円');
INSERT INTO choices (question_id, choice_text) VALUES (99, 'B. 1550 円');
INSERT INTO choices (question_id, choice_text) VALUES (99, 'C. 1600 円');
INSERT INTO choices (question_id, choice_text) VALUES (99, 'D. 1650 円');

INSERT INTO choices (question_id, choice_text) VALUES (100, 'A. 1800 円');
INSERT INTO choices (question_id, choice_text) VALUES (100, 'B. 1900 円');
INSERT INTO choices (question_id, choice_text) VALUES (100, 'C. 2000 円');
INSERT INTO choices (question_id, choice_text) VALUES (100, 'D. 2100 円');

INSERT INTO choices (question_id, choice_text) VALUES (101, 'A. 1300 円');
INSERT INTO choices (question_id, choice_text) VALUES (101, 'B. 1400 円');
INSERT INTO choices (question_id, choice_text) VALUES (101, 'C. 1500 円');
INSERT INTO choices (question_id, choice_text) VALUES (101, 'D. 1600 円');

INSERT INTO choices (question_id, choice_text) VALUES (102, 'A. 1450 円');
INSERT INTO choices (question_id, choice_text) VALUES (102, 'B. 1550 円');
INSERT INTO choices (question_id, choice_text) VALUES (102, 'C. 1650 円');
INSERT INTO choices (question_id, choice_text) VALUES (102, 'D. 1850 円');

INSERT INTO choices (question_id, choice_text) VALUES (103, 'A. 100');
INSERT INTO choices (question_id, choice_text) VALUES (103, 'B. 110');
INSERT INTO choices (question_id, choice_text) VALUES (103, 'C. 120');
INSERT INTO choices (question_id, choice_text) VALUES (103, 'D. 130');

INSERT INTO choices (question_id, choice_text) VALUES (104, 'A. 20枚');
INSERT INTO choices (question_id, choice_text) VALUES (104, 'B. 25枚');
INSERT INTO choices (question_id, choice_text) VALUES (104, 'C. 30枚');
INSERT INTO choices (question_id, choice_text) VALUES (104, 'D. 35枚');

INSERT INTO choices (question_id, choice_text) VALUES (105, 'A. 20個');
INSERT INTO choices (question_id, choice_text) VALUES (105, 'B. 25個');
INSERT INTO choices (question_id, choice_text) VALUES (105, 'C. 30個');
INSERT INTO choices (question_id, choice_text) VALUES (105, 'D. 35個');

INSERT INTO choices (question_id, choice_text) VALUES (106, 'A. 25冊');
INSERT INTO choices (question_id, choice_text) VALUES (106, 'B. 30冊');
INSERT INTO choices (question_id, choice_text) VALUES (106, 'C. 35冊');
INSERT INTO choices (question_id, choice_text) VALUES (106, 'D. 40冊');

INSERT INTO choices (question_id, choice_text) VALUES (107, 'A. 50ページ');
INSERT INTO choices (question_id, choice_text) VALUES (107, 'B. 55ページ');
INSERT INTO choices (question_id, choice_text) VALUES (107, 'C. 60ページ');
INSERT INTO choices (question_id, choice_text) VALUES (107, 'D. 65ページ');

INSERT INTO choices (question_id, choice_text) VALUES (108, 'A. 40個');
INSERT INTO choices (question_id, choice_text) VALUES (108, 'B. 45個');
INSERT INTO choices (question_id, choice_text) VALUES (108, 'C. 50個');
INSERT INTO choices (question_id, choice_text) VALUES (108, 'D. 55個');

INSERT INTO choices (question_id, choice_text) VALUES (109, 'A. 25個');
INSERT INTO choices (question_id, choice_text) VALUES (109, 'B. 30個');
INSERT INTO choices (question_id, choice_text) VALUES (109, 'C. 35個');
INSERT INTO choices (question_id, choice_text) VALUES (109, 'D. 40個');

INSERT INTO choices (question_id, choice_text) VALUES (110, 'A. 45個');
INSERT INTO choices (question_id, choice_text) VALUES (110, 'B. 50個');
INSERT INTO choices (question_id, choice_text) VALUES (110, 'C. 55個');
INSERT INTO choices (question_id, choice_text) VALUES (110, 'D. 60個');

INSERT INTO choices (question_id, choice_text) VALUES (111, 'A. 80個');
INSERT INTO choices (question_id, choice_text) VALUES (111, 'B. 85個');
INSERT INTO choices (question_id, choice_text) VALUES (111, 'C. 90個');
INSERT INTO choices (question_id, choice_text) VALUES (111, 'D. 95個');

INSERT INTO choices (question_id, choice_text) VALUES (112, 'A. 70本');
INSERT INTO choices (question_id, choice_text) VALUES (112, 'B. 75本');
INSERT INTO choices (question_id, choice_text) VALUES (112, 'C. 80本');
INSERT INTO choices (question_id, choice_text) VALUES (112, 'D. 85本');

INSERT INTO choices (question_id, choice_text) VALUES (113, 'A. 30km/時');
INSERT INTO choices (question_id, choice_text) VALUES (113, 'B. 40km/時');
INSERT INTO choices (question_id, choice_text) VALUES (113, 'C. 50km/時');
INSERT INTO choices (question_id, choice_text) VALUES (113, 'D. 60km/時');

INSERT INTO choices (question_id, choice_text) VALUES (114, 'A. 6km');
INSERT INTO choices (question_id, choice_text) VALUES (114, 'B. 10km');
INSERT INTO choices (question_id, choice_text) VALUES (114, 'C. 12km');
INSERT INTO choices (question_id, choice_text) VALUES (114, 'D. 16km');

INSERT INTO choices (question_id, choice_text) VALUES (115, 'A. 80km');
INSERT INTO choices (question_id, choice_text) VALUES (115, 'B. 100km');
INSERT INTO choices (question_id, choice_text) VALUES (115, 'C. 120km');
INSERT INTO choices (question_id, choice_text) VALUES (115, 'D. 140km');

INSERT INTO choices (question_id, choice_text) VALUES (116, 'A. 1.5時間');
INSERT INTO choices (question_id, choice_text) VALUES (116, 'B. 2時間');
INSERT INTO choices (question_id, choice_text) VALUES (116, 'C. 2.5時間');
INSERT INTO choices (question_id, choice_text) VALUES (116, 'D. 3時間');

INSERT INTO choices (question_id, choice_text) VALUES (117, 'A. 2時間');
INSERT INTO choices (question_id, choice_text) VALUES (117, 'B. 2.5時間');
INSERT INTO choices (question_id, choice_text) VALUES (117, 'C. 3時間');
INSERT INTO choices (question_id, choice_text) VALUES (117, 'D. 3.5時間');

INSERT INTO choices (question_id, choice_text) VALUES (118, 'A. 15km/時');
INSERT INTO choices (question_id, choice_text) VALUES (118, 'B. 18km/時');
INSERT INTO choices (question_id, choice_text) VALUES (118, 'C. 20km/時');
INSERT INTO choices (question_id, choice_text) VALUES (118, 'D. 24km/時');

INSERT INTO choices (question_id, choice_text) VALUES (119, 'A. 3時間');
INSERT INTO choices (question_id, choice_text) VALUES (119, 'B. 4時間');
INSERT INTO choices (question_id, choice_text) VALUES (119, 'C. 5時間');
INSERT INTO choices (question_id, choice_text) VALUES (119, 'D. 6時間');

INSERT INTO choices (question_id, choice_text) VALUES (120, 'A. 7時45分');
INSERT INTO choices (question_id, choice_text) VALUES (120, 'B. 8時00分');
INSERT INTO choices (question_id, choice_text) VALUES (120, 'C. 8時15分');
INSERT INTO choices (question_id, choice_text) VALUES (120, 'D. 8時20分');

INSERT INTO choices (question_id, choice_text) VALUES (121, 'A. 50km/時');
INSERT INTO choices (question_id, choice_text) VALUES (121, 'B. 60km/時');
INSERT INTO choices (question_id, choice_text) VALUES (121, 'C. 70km/時');
INSERT INTO choices (question_id, choice_text) VALUES (121, 'D. 80km/時');

INSERT INTO choices (question_id, choice_text) VALUES (122, 'A. 30km');
INSERT INTO choices (question_id, choice_text) VALUES (122, 'B. 35km');
INSERT INTO choices (question_id, choice_text) VALUES (122, 'C. 40km');
INSERT INTO choices (question_id, choice_text) VALUES (122, 'D. 45km');

INSERT INTO choices (question_id, choice_text) VALUES (123, 'A. 100');
INSERT INTO choices (question_id, choice_text) VALUES (123, 'B. 110');
INSERT INTO choices (question_id, choice_text) VALUES (123, 'C. 120');
INSERT INTO choices (question_id, choice_text) VALUES (123, 'D. 130');
INSERT INTO choices (question_id, choice_text) VALUES (123, 'E. 140');

INSERT INTO choices (question_id, choice_text) VALUES (124, 'A. 35');
INSERT INTO choices (question_id, choice_text) VALUES (124, 'B. 30');
INSERT INTO choices (question_id, choice_text) VALUES (124, 'C. 25');
INSERT INTO choices (question_id, choice_text) VALUES (124, 'D. 20');
INSERT INTO choices (question_id, choice_text) VALUES (124, 'E. 15');

INSERT INTO choices (question_id, choice_text) VALUES (125, 'A. 150');
INSERT INTO choices (question_id, choice_text) VALUES (125, 'B. 180');
INSERT INTO choices (question_id, choice_text) VALUES (125, 'C. 200');
INSERT INTO choices (question_id, choice_text) VALUES (125, 'D. 240');
INSERT INTO choices (question_id, choice_text) VALUES (125, 'E. 270');

INSERT INTO choices (question_id, choice_text) VALUES (126, 'A. 70');
INSERT INTO choices (question_id, choice_text) VALUES (126, 'B. 80');
INSERT INTO choices (question_id, choice_text) VALUES (126, 'C. 90');
INSERT INTO choices (question_id, choice_text) VALUES (126, 'D. 100');
INSERT INTO choices (question_id, choice_text) VALUES (126, 'E. 110');

INSERT INTO choices (question_id, choice_text) VALUES (127, 'A. 100');
INSERT INTO choices (question_id, choice_text) VALUES (127, 'B. 120');
INSERT INTO choices (question_id, choice_text) VALUES (127, 'C. 140');
INSERT INTO choices (question_id, choice_text) VALUES (127, 'D. 160');
INSERT INTO choices (question_id, choice_text) VALUES (127, 'E. 180');

INSERT INTO choices (question_id, choice_text) VALUES (128, 'A. 300');
INSERT INTO choices (question_id, choice_text) VALUES (128, 'B. 350');
INSERT INTO choices (question_id, choice_text) VALUES (128, 'C. 400');
INSERT INTO choices (question_id, choice_text) VALUES (128, 'D. 450');
INSERT INTO choices (question_id, choice_text) VALUES (128, 'E. 500');

INSERT INTO choices (question_id, choice_text) VALUES (129, 'A. 20');
INSERT INTO choices (question_id, choice_text) VALUES (129, 'B. 25');
INSERT INTO choices (question_id, choice_text) VALUES (129, 'C. 30');
INSERT INTO choices (question_id, choice_text) VALUES (129, 'D. 35');
INSERT INTO choices (question_id, choice_text) VALUES (129, 'E. 40');

INSERT INTO choices (question_id, choice_text) VALUES (130, 'A. 70');
INSERT INTO choices (question_id, choice_text) VALUES (130, 'B. 80');
INSERT INTO choices (question_id, choice_text) VALUES (130, 'C. 90');
INSERT INTO choices (question_id, choice_text) VALUES (130, 'D. 100');
INSERT INTO choices (question_id, choice_text) VALUES (130, 'E. 110');

INSERT INTO choices (question_id, choice_text) VALUES (131, 'A. 600');
INSERT INTO choices (question_id, choice_text) VALUES (131, 'B. 700');
INSERT INTO choices (question_id, choice_text) VALUES (131, 'C. 800');
INSERT INTO choices (question_id, choice_text) VALUES (131, 'D. 900');
INSERT INTO choices (question_id, choice_text) VALUES (131, 'E. 1000');

INSERT INTO choices (question_id, choice_text) VALUES (132, 'A. 110');
INSERT INTO choices (question_id, choice_text) VALUES (132, 'B. 120');
INSERT INTO choices (question_id, choice_text) VALUES (132, 'C. 130');
INSERT INTO choices (question_id, choice_text) VALUES (132, 'D. 140');
INSERT INTO choices (question_id, choice_text) VALUES (132, 'E. 150');

INSERT INTO choices (question_id, choice_text) VALUES (133, 'A. H');
INSERT INTO choices (question_id, choice_text) VALUES (133, 'B. N');
INSERT INTO choices (question_id, choice_text) VALUES (133, 'C. O');
INSERT INTO choices (question_id, choice_text) VALUES (133, 'D. 上の表からは決まらない');

INSERT INTO choices (question_id, choice_text) VALUES (134, 'A. 600個');
INSERT INTO choices (question_id, choice_text) VALUES (134, 'B. 500個');
INSERT INTO choices (question_id, choice_text) VALUES (134, 'C. 700個');
INSERT INTO choices (question_id, choice_text) VALUES (134, 'D. 800個');

INSERT INTO choices (question_id, choice_text) VALUES (135, 'A. 200人');
INSERT INTO choices (question_id, choice_text) VALUES (135, 'B. 150人');
INSERT INTO choices (question_id, choice_text) VALUES (135, 'C. 250人');
INSERT INTO choices (question_id, choice_text) VALUES (135, 'D. 300人');

INSERT INTO choices (question_id, choice_text) VALUES (136, 'A. 25%');
INSERT INTO choices (question_id, choice_text) VALUES (136, 'B. 30%');
INSERT INTO choices (question_id, choice_text) VALUES (136, 'C. 45%');
INSERT INTO choices (question_id, choice_text) VALUES (136, 'D. 50%');

INSERT INTO choices (question_id, choice_text) VALUES (137, 'A. 200万円');
INSERT INTO choices (question_id, choice_text) VALUES (137, 'B. 300万円');
INSERT INTO choices (question_id, choice_text) VALUES (137, 'C. 400万円');
INSERT INTO choices (question_id, choice_text) VALUES (137, 'D. 500万円');

INSERT INTO choices (question_id, choice_text) VALUES (138, 'A. Na');
INSERT INTO choices (question_id, choice_text) VALUES (138, 'B. Cl');
INSERT INTO choices (question_id, choice_text) VALUES (138, 'C. K');
INSERT INTO choices (question_id, choice_text) VALUES (138, 'D. 上の表からは決まらない');

INSERT INTO choices (question_id, choice_text) VALUES (139, 'A. 600個');
INSERT INTO choices (question_id, choice_text) VALUES (139, 'B. 500個');
INSERT INTO choices (question_id, choice_text) VALUES (139, 'C. 700個');
INSERT INTO choices (question_id, choice_text) VALUES (139, 'D. 800個');

INSERT INTO choices (question_id, choice_text) VALUES (140, 'A. 1000万円');
INSERT INTO choices (question_id, choice_text) VALUES (140, 'B. 2000万円');
INSERT INTO choices (question_id, choice_text) VALUES (140, 'C. 3000万円');
INSERT INTO choices (question_id, choice_text) VALUES (140, 'D. 4000万円');

INSERT INTO choices (question_id, choice_text) VALUES (141, 'A. H');
INSERT INTO choices (question_id, choice_text) VALUES (141, 'B. O');
INSERT INTO choices (question_id, choice_text) VALUES (141, 'C. N');
INSERT INTO choices (question_id, choice_text) VALUES (141, 'D. 上の表からは決まらない');

INSERT INTO choices (question_id, choice_text) VALUES (142, 'A. 20人');
INSERT INTO choices (question_id, choice_text) VALUES (142, 'B. 30人');
INSERT INTO choices (question_id, choice_text) VALUES (142, 'C. 40人');
INSERT INTO choices (question_id, choice_text) VALUES (142, 'D. 50人');

INSERT INTO choices (question_id, choice_text) VALUES (143, 'A. 2個');
INSERT INTO choices (question_id, choice_text) VALUES (143, 'B. 3個');
INSERT INTO choices (question_id, choice_text) VALUES (143, 'C. 4個');
INSERT INTO choices (question_id, choice_text) VALUES (143, 'D. 5個');
INSERT INTO choices (question_id, choice_text) VALUES (143, 'E. 6個');
INSERT INTO choices (question_id, choice_text) VALUES (143, 'F. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (144, 'A. 5足');
INSERT INTO choices (question_id, choice_text) VALUES (144, 'B. 6足');
INSERT INTO choices (question_id, choice_text) VALUES (144, 'C. 7足');
INSERT INTO choices (question_id, choice_text) VALUES (144, 'D. 8足');
INSERT INTO choices (question_id, choice_text) VALUES (144, 'E. 9足');
INSERT INTO choices (question_id, choice_text) VALUES (144, 'F. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (145, 'A. 2本');
INSERT INTO choices (question_id, choice_text) VALUES (145, 'B. 3本');
INSERT INTO choices (question_id, choice_text) VALUES (145, 'C. 4本 ');
INSERT INTO choices (question_id, choice_text) VALUES (145, 'D. 5本');
INSERT INTO choices (question_id, choice_text) VALUES (145, 'E. 6本');
INSERT INTO choices (question_id, choice_text) VALUES (145, 'F. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (146, 'A. 5個');
INSERT INTO choices (question_id, choice_text) VALUES (146, 'B. 6個');
INSERT INTO choices (question_id, choice_text) VALUES (146, 'C. 7個');
INSERT INTO choices (question_id, choice_text) VALUES (146, 'D. 8個');
INSERT INTO choices (question_id, choice_text) VALUES (146, 'E. 9個');
INSERT INTO choices (question_id, choice_text) VALUES (146, 'F. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (147, 'A. 4冊');
INSERT INTO choices (question_id, choice_text) VALUES (147, 'B. 5冊');
INSERT INTO choices (question_id, choice_text) VALUES (147, 'C. 6冊');
INSERT INTO choices (question_id, choice_text) VALUES (147, 'D. 7冊');
INSERT INTO choices (question_id, choice_text) VALUES (147, 'E. 8冊');
INSERT INTO choices (question_id, choice_text) VALUES (147, 'F. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (148, 'A. 3足');
INSERT INTO choices (question_id, choice_text) VALUES (148, 'B. 4足');
INSERT INTO choices (question_id, choice_text) VALUES (148, 'C. 5足');
INSERT INTO choices (question_id, choice_text) VALUES (148, 'D. 6足');
INSERT INTO choices (question_id, choice_text) VALUES (148, 'E. 7足');
INSERT INTO choices (question_id, choice_text) VALUES (148, 'F. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (149, 'A. 2個');
INSERT INTO choices (question_id, choice_text) VALUES (149, 'B. 3個');
INSERT INTO choices (question_id, choice_text) VALUES (149, 'C. 4個');
INSERT INTO choices (question_id, choice_text) VALUES (149, 'D. 5個');
INSERT INTO choices (question_id, choice_text) VALUES (149, 'E. 6個');
INSERT INTO choices (question_id, choice_text) VALUES (149, 'F. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (150, 'A. 5枚');
INSERT INTO choices (question_id, choice_text) VALUES (150, 'B. 6枚');
INSERT INTO choices (question_id, choice_text) VALUES (150, 'C. 7枚');
INSERT INTO choices (question_id, choice_text) VALUES (150, 'D. 8枚');
INSERT INTO choices (question_id, choice_text) VALUES (150, 'E. 9枚');
INSERT INTO choices (question_id, choice_text) VALUES (150, 'F. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (151, 'A. 3個');
INSERT INTO choices (question_id, choice_text) VALUES (151, 'B. 4個');
INSERT INTO choices (question_id, choice_text) VALUES (151, 'C. 5個');
INSERT INTO choices (question_id, choice_text) VALUES (151, 'D. 6個');
INSERT INTO choices (question_id, choice_text) VALUES (151, 'E. 7個');
INSERT INTO choices (question_id, choice_text) VALUES (151, 'F. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (152, 'A. 3本');
INSERT INTO choices (question_id, choice_text) VALUES (152, 'B. 4本');
INSERT INTO choices (question_id, choice_text) VALUES (152, 'C. 5本');
INSERT INTO choices (question_id, choice_text) VALUES (152, 'D. 6本');
INSERT INTO choices (question_id, choice_text) VALUES (152, 'E. 7本');
INSERT INTO choices (question_id, choice_text) VALUES (152, 'F. AからEのいずれでもない');

-- 正解と解説を挿入
-- 正解の番号が違うので後で修正
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (1, 5, '1_1_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (2, 10, '1_1_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (3, 17, '1_1_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (4, 23, '1_1_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (5, 25, '1_1_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (6, 34, '1_1_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (7, 37, '1_1_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (8, 46, '1_1_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (9, 54, '1_1_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (10, 58, '1_1_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (11, 62, '1_2_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (12, 69, '1_2_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (13, 75, '1_2_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (14, 79, '1_2_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (15, 85, '1_2_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (16, 87, '1_2_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (17, 92, '1_2_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (18, 98, '1_2_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (19, 101, '1_2_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (20, 107, '1_2_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (21, 111, '1_2_11');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (22, 118, '1_2_12');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (23, 125, '1_3_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (24, 130, '1_3_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (25, 132, '1_3_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (26, 140, '1_3_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (27, 144, '1_3_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (28, 148, '1_3_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (29, 153, '1_3_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (30, 159, '1_3_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (31, 165, '1_3_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (32, 166, '1_3_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (33, 174, '1_4_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (34, 178, '1_4_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (35, 185, '1_4_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (36, 186, '1_4_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (37, 192, '1_4_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (38, 199, '1_4_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (39, 201, '1_4_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (40, 206, '1_4_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (41, 211, '1_4_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (42, 216, '1_4_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (43, 221, '1_5_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (44, 229, '1_5_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (45, 233, '1_5_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (46, 237, '1_5_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (47, 241, '1_5_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (48, 246, '1_5_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (49, 251, '1_5_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (50, 256, '1_5_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (51, 261, '1_5_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (52, 266, '1_5_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (53, 272, '2_1_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (54, 278, '2_1_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (55, 280, '2_1_3'); 
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (56, 284, '2_1_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (57, 288, '2_1_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (58, 291, '2_1_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (59, 295, '2_1_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (60, 300, '2_1_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (61, 305, '2_1_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (62, 308, '2_1_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (63, 312, '2_2_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (64, 317, '2_2_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (65, 320, '2_2_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (66, 324 ,'2_2_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (67, 328, '2_2_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (68, 333, '2_2_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (69, 337, '2_2_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (70, 339, '2_2_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (71, 345, '2_2_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (72, 350, '2_2_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (73, 352, '2_3_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (74, 357, '2_3_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (75, 361, '2_3_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (76, 363, '2_3_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (77, 368, '2_3_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (78, 374, '2_3_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (79, 376, '2_3_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (80, 379, '2_3_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (81, 385, '2_3_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (82, 388, '2_3_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (83, 393, '2_4_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (84, 398, '2_4_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (85, 400, '2_4_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (86, 404, '2_4_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (87, 408, '2_4_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (88, 414, '2_4_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (89, 416, '2_4_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (90, 419, '2_4_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (91, 425, '2_4_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (92, 428, '2_4_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (93, 432, '2_5_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (94, 436, '2_5_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (95, 439, '2_5_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (96, 444, '2_5_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (97, 448, '2_5_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (98, 453, '2_5_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (99, 458, '2_5_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (100, 460, '2_5_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (101, 464, '2_5_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (102, 470, '2_5_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (103, 471, '2_6_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (104, 476, '2_6_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (105, 481, '2_6_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (106, 484, '2_6_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (107, 489, '2_6_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (108, 493, '2_6_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (109, 496, '2_6_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (110, 500, '2_6_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (111, 505, '2_6_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (112, 509, '2_6_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (113, 512, '2_7_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (114, 516, '2_7_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (115, 520, '2_7_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (116, 524, '2_7_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (117, 529, '2_7_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (118, 534, '2_7_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (119, 537, '2_7_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (120, 540, '2_7_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (121, 545, '2_7_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (122, 549, '2_7_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (123, 551, '2_8_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (124, 556, '2_8_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (125, 561, '2_8_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (126, 566, '2_8_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (127, 572, '2_8_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (128, 576, '2_8_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (129, 583, '2_8_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (130, 588, '2_8_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (131, 591, '2_8_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (132, 598, '2_8_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (133, 601, '2_9_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (134, 605, '2_9_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (135, 609, '2_9_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (136, 613, '2_9_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (137, 618, '2_9_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (138, 622, '2_9_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (139, 626, '2_9_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (140, 630, '2_9_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (141, 634, '2_9_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (142, 638, '2_9_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (143, 644, '2_10_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (144, 650, '2_10_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (145, 655, '2_10_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (146, 661, '2_10_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (147, 668, '2_10_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (148, 674, '2_10_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (149, 679, '2_10_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (150, 684, '2_10_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (151, 690, '2_10_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (152, 697, '2_10_10');



