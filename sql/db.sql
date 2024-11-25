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
    last_login DATETIME,
    exp INT NOT NULL DEFAULT 0, -- 正解した問題数
    level INT NOT NULL DEFAULT 1, -- レベル
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

DROP TABLE IF EXISTS kanrisyainfoinfo;
CREATE TABLE kanrisyainfo (
    userid    int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username  varchar(100) NOT NULL,
    email     varchar(100) NOT NULL,
    password  varchar(100) NOT NULL
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

DROP TABLE IF EXISTS question_statistics;
CREATE TABLE question_statistics (
    question_id INT NOT NULL,
    total_answers INT NOT NULL DEFAULT 0, -- 総回答数
    incorrect_answers INT NOT NULL DEFAULT 0, -- 間違えた回数
    PRIMARY KEY (question_id),
    FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS badge_collections;
CREATE TABLE badge_collections (
    badge_id INT AUTO_INCREMENT PRIMARY KEY,
    badge_file TEXT NOT NULL, -- バッジの画像
);

DROP TABLE IF EXISTS owned_badge;
CREATE TABLE owned_badge (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userid int(255) NOT NULL ,    
    badge_id INT NOT NULL,
);

-- 問題を挿入
INSERT INTO badge_collections (badge_id,badge_file) VALUES (1,'badge1');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (2,'badge2');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (3,'badge3');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (4,'badge4');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (5,'badge5');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (6,'badge6');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (7,'badge7');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (8,'badge8');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (9,'badge9');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (10,'badge10');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (11,'badge11');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (12,'badge12');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (13,'badge13');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (14,'badge14');
INSERT INTO badge_collections (badge_id,badge_file) VALUES (15,'badge15');

-- 問題を挿入
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (1,1,1,30,'二語の関係','1_1_1','相対的：絶対的');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (2,1,1,30,'二語の関係','1_1_2','海流：暖流');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (3,1,1,30,'二語の関係','1_1_3','植物：生物');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (4,1,1,30,'二語の関係','1_1_4','学校：教育');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (5,1,1,30,'二語の関係','1_1_5','緊張：弛緩');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (6,1,1,30,'二語の関係','1_1_6','校則：規則');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (7,1,1,30,'二語の関係','1_1_7','進歩的：保守的');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (8,1,1,30,'二語の関係','1_1_8','安全：危険');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (9,1,1,30,'二語の関係','1_1_9','家具：ベッド');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (10,1,1,30,'二語の関係','1_1_10','チーズ：牛乳');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (11,1,2,30,'熟語の意味','1_2_1','はかりごとをめぐらして');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (12,1,2,30,'熟語の意味','1_2_2','いみじくも');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (13,1,2,30,'熟語の意味','1_2_3','妨げが多くて、物事');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (14,1,2,30,'熟語の意味','1_2_4','上の人に対して意見');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (15,1,2,30,'熟語の意味','1_2_5','うわべをじょうずに');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (16,1,2,30,'熟語の意味','1_2_6','一流の人をまねるだけ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (17,1,2,30,'熟語の意味','1_2_7','古くさくてありふれた');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (18,1,2,30,'熟語の意味','1_2_8','事件や問題などの間');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (19,1,2,30,'熟語の意味','1_2_9','それぞれのよいところ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (20,1,2,30,'熟語の意味','1_2_10','自慢げに見せること');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (21,1,2,30,'熟語の意味','1_2_11','その時々に応じた');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (22,1,2,30,'熟語の意味','1_2_12','しつこく、ねばり強いこと');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (23,1,3,30,'語句の用法','1_3_1','自分が「先」に立って歩く');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (24,1,3,30,'語句の用法','1_3_2','怪しい「空」模様');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (25,1,3,30,'語句の用法','1_3_3','彼は医者「と」なった');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (26,1,3,30,'語句の用法','1_3_4','電話を「きる」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (27,1,3,30,'語句の用法','1_3_5','バス「で」行く');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (28,1,3,30,'語句の用法','1_3_6','消費者の「目」が肥えてきた');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (29,1,3,30,'語句の用法','1_3_7','知り合いから頼ま「れる」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (30,1,3,30,'語句の用法','1_3_8','母「の」でよければお使いください');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (31,1,3,30,'語句の用法','1_3_9','食卓に「のぼる」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (32,1,3,30,'語句の用法','1_3_10','一人で行く「そうだ」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (33,1,4,30,'文章整序','1_4_1','動物倫理は');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (34,1,4,30,'文章整序','1_4_2','現代では');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (35,1,4,30,'文章整序','1_4_3','ウイルスと細菌は');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (36,1,4,30,'文章整序','1_4_4','日本においては');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (37,1,4,30,'文章整序','1_4_5','在宅医療は');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (38,1,4,30,'文章整序','1_4_6','気体をさらに');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (39,1,4,30,'文章整序','1_4_7','科学雑誌や映画や');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (40,1,4,30,'文章整序','1_4_8','職場の仕事の');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (41,1,4,30,'文章整序','1_4_9','国会は憲法により');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (42,1,4,30,'文章整序','1_4_10','第二次世界大戦後の');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (43,1,5,30,'空欄補充','1_5_1','ひとつは自らの内側にある[]だ。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (44,1,5,30,'空欄補充','1_5_2','[]になって反論する');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (45,1,5,30,'空欄補充','1_5_3','[]を呑んで見守る');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (46,1,5,30,'空欄補充','1_5_4','部下を[]にかけて育てる');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (47,1,5,30,'空欄補充','1_5_5','感涙に[]。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (48,1,5,30,'空欄補充','1_5_6','[]にもかかわらず、注意や努力が足りず');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (49,1,5,30,'空欄補充','1_5_7','ビジネスにおいて、[]思考は身につけるべき重要なスキル');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (50,1,5,30,'空欄補充','1_5_8','歌手の[]にも置けない');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (51,1,5,30,'空欄補充','1_5_9','いよいよ作業に[]を入れる');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (52,1,5,30,'空欄補充','1_5_10','油断していると,[] 失敗しそうだ');

-- 非言語問題
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (53,2,1,30,'場合の数','2_1_1','男子8人、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (54,2,1,30,'場合の数','2_1_2','ゼミのメンバー7人が');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (55,2,1,30,'場合の数','2_1_3','ゼミのメンバー10人が');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (56,2,1,30,'場合の数','2_1_4','テニス部の３年生には、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (57,2,1,30,'場合の数','2_1_5','1、2、3、4、5の5つから');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (58,2,1,30,'場合の数','2_1_6','コイントスを5回行った。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (59,2,1,30,'場合の数','2_1_7','2つのサイコロP');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (60,2,1,30,'場合の数','2_1_8','数字の1、2、3を使って');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (61,2,1,30,'場合の数','2_1_9','倉庫には白と黒のボール');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (62,2,1,30,'場合の数','2_1_10','大きいボール、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (63,2,2,30,'推論','2_2_1','7枚のカードに1〜7の数字が');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (64,2,2,30,'推論','2_2_2','PQRSの4人チームで');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (65,2,2,30,'推論','2_2_3','以下の表に、P、Q、Rの3つの学校'); -- 要修正
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (66,2,2,30,'推論','2_2_4','ある高校の学生180人の');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (67,2,2,30,'推論','2_2_5','1個150円のパンと1個100円のおにぎり');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (68,2,2,30,'推論','2_2_6','A~Eの5人が50m走を行った結果、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (69,2,2,30,'推論','2_2_7','A,B,C,D,E,Fの6人で');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (70,2,2,30,'推論','2_2_8','P,Q,R,Sの4人がある試験を受けた。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (71,2,2,30,'推論','2_2_9','P、Q、R、Sの4人が100点満点');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (72,2,2,30,'推論','2_2_10','ア、イ、ウ、エの4人が剣道で');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (73,2,3,30,'割合','2_3_1','ある高校では全校生徒の80%が');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (74,2,3,30,'割合','2_3_2','ある高校で、大学へ進学する人は');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (75,2,3,30,'割合','2_3_3','薬品AとBを2:3で混ぜた混合液Xと、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (76,2,3,30,'割合','2_3_4','ある高校で出身中学校の調査をしたところ、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (77,2,3,30,'割合','2_3_5','ある高校で自転車通学している');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (78,2,3,30,'割合','2_3_6',' ある人がSPIの問題集を購入し');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (79,2,3,30,'割合','2_3_7','ある町で、60%の世帯が農家である。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (80,2,3,30,'割合','2_3_8','ある大学の「SPI対策」という');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (81,2,3,30,'割合','2_3_9','ある高校で、全生徒の90%が');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (82,2,3,30,'割合','2_3_10','ある会社のA支店、B支店、C支店の');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (83,2,4,30,'確率','2_4_1','1P、Qを含む5人が買い物に出かける。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (84,2,4,30,'確率','2_4_2','ハートの1から13まで、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (85,2,4,30,'確率','2_4_3','2つの講演会P、Qの参加者の抽選をした。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (86,2,4,30,'確率','2_4_4','ある飲食店の従業員は20人であり、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (87,2,4,30,'確率','2_4_5','10円玉が3枚、5円玉が3枚ある。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (88,2,4,30,'確率','2_4_6','XとYがゲームをする。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (89,2,4,30,'確率','2_4_7','1〜7までの数字が書かれた');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (90,2,4,30,'確率','2_4_8','赤玉3個、白玉5個、黄玉2個が');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (91,2,4,30,'確率','2_4_9','AとBの2人が資格試験');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (92,2,4,30,'確率','2_4_10','ある人がダーツを行っている。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (93,2,5,30,'金額計算','2_5_1','X、Y、Zの3人で、Pのお祝い');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (94,2,5,30,'金額計算','2_5_2','あるカフェでは2時間以上利用すると');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (95,2,5,30,'金額計算','2_5_3','1個の原価が500円の商品を300個仕入れて、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (96,2,5,30,'金額計算','2_5_4','P、Q、Rの3人が5000円ずつ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (97,2,5,30,'金額計算','2_5_5','P、Q、Rの3人が居酒屋でお酒とラーメンを');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (98,2,5,30,'金額計算','2_5_6','あるコートは、9時から23時まで');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (99,2,5,30,'金額計算','2_5_7','あるスーパー銭湯の入浴券は600円である。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (100,2,5,30,'金額計算','2_5_8','あるビデオ屋では、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (101,2,5,30,'金額計算','2_5_9','美術館に行く際、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (102,2,5,30,'金額計算','2_5_10','原価100円の商品を200個仕入れた。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (103,2,6,30,'分担計算','2_6_1','代金を数回に分けて支払う');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (104,2,6,30,'分担計算','2_6_2','購入で分割払いをすることにした。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (105,2,6,30,'分担計算','2_6_3','ある人は3日間かけて資料整理する。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (106,2,6,30,'分担計算','2_6_4','ある仕事をP、Q、Rの3人で分担した。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (107,2,6,30,'分担計算','2_6_5','排水ポンプX、Yと、給水ポンプP、Qがある。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (108,2,6,30,'分担計算','2_6_6','英語と数学の宿題。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (109,2,6,30,'分担計算','2_6_7','ある予備校のテスト採点は、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (110,2,6,30,'分担計算','2_6_8','今年1年間はお小遣いを毎月1万円');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (111,2,6,30,'分担計算','2_6_9','国語と数学の宿題があります。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (112,2,6,30,'分担計算','2_6_10','ある書類の処理を全て終わらせるのに、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (113,2,7,30,'速度算','2_7_1','各チーム8人で競う駅伝、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (114,2,7,30,'速度算','2_7_2','各チーム8人で競う駅伝が行われた。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (115,2,7,30,'速度算','2_7_3','各チーム8人で競う駅伝が行われた。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (116,2,7,30,'速度算','2_7_4','列車PはS駅からV駅に向かい、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (117,2,7,30,'速度算','2_7_5','列車PはS駅からV駅に向かい、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (118,2,7,30,'速度算','2_7_6','Pは普段、自宅から学校まで');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (119,2,7,30,'速度算','2_7_7','ある公園の外周は2kmである。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (120,2,7,30,'速度算','2_7_8','P及びQの歩くスピードは、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (121,2,7,30,'速度算','2_7_9','子は2.4km/時、母は3.2km/時で歩くものとする。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (122,2,7,30,'速度算','2_7_10','1周1.6kmのウォーキングコースがある。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (123,2,8,30,'集合','2_8_1','ある出版社が購読者100人を対象に、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (124,2,8,30,'集合','2_8_2','中学生120人に野球、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (125,2,8,30,'集合','2_8_3','犬を飼っているか、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (126,2,8,30,'集合','2_8_4','クラス41人に対して、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (127,2,8,30,'集合','2_8_5','中学生120人に野球、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (128,2,8,30,'集合','2_8_6','会社の社員300人に調査を行ったところ、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (129,2,8,30,'集合','2_8_7','朝食にお茶を飲むか牛乳を飲むか、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (130,2,8,30,'集合','2_8_8','部活のメンバー46人のうち、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (131,2,8,30,'集合','2_8_9','大学生200人を対象に、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (132,2,8,30,'集合','2_8_10','小学生180人に対し、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (133,2,9,30,'表の読み取り','2_9_1','表は、ある年の日本、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (134,2,9,30,'表の読み取り','2_9_2','4種類の食品に含まれる栄養素');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (135,2,9,30,'表の読み取り','2_9_3','あるイベント会社が会場');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (136,2,9,30,'表の読み取り','2_9_4','この表は山形、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (137,2,9,30,'表の読み取り','2_9_5','20代、30代、40代それぞれ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (138,2,9,30,'表の読み取り','2_9_6','ショッピングセンターA、B');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (139,2,9,30,'表の読み取り','2_9_7','ある年の2月、7月、12月における');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (140,2,9,30,'表の読み取り','2_9_8','ある電車はA駅を出発して、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (141,2,9,30,'表の読み取り','2_9_9','A駅で乗車し、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (142,2,9,30,'表の読み取り','2_9_10','飲食店Aの利用者に対して');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (143,2,10,30,'特殊計算','2_10_1','ある親子は今、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (144,2,10,30,'特殊計算','2_10_2','4種類のお菓子がある。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (145,2,10,30,'特殊計算','2_10_3','100円の商品と125円の商品');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (146,2,10,30,'特殊計算','2_10_4','商品詰め合わせを作ることにした。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (147,2,10,30,'特殊計算','2_10_5','10円、50円、100円、500円の4種類');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (148,2,10,30,'特殊計算','2_10_6','300円と200円の2種類');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (149,2,10,30,'特殊計算','2_10_7','ある家庭の父親は現在38歳で、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (150,2,10,30,'特殊計算','2_10_8','円形の花壇に円状に花を植える。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (151,2,10,30,'特殊計算','2_10_9','まっすぐの花壇に花を並べて植える。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (152,2,10,30,'特殊計算','2_10_10','ある自動車学校には105人生徒がいる。');




-- 選択肢を挿入
-- 言語問題
INSERT INTO choices (question_id, choice_text) VALUES (1, 'A.アだけ'); -- 1
INSERT INTO choices (question_id, choice_text) VALUES (1, 'B.イだけ'); -- 2
INSERT INTO choices (question_id, choice_text) VALUES (1, 'C.ウだけ'); -- 3
INSERT INTO choices (question_id, choice_text) VALUES (1, 'D.アとイ'); -- 4
INSERT INTO choices (question_id, choice_text) VALUES (1, 'E.アとウ'); -- 5〇
INSERT INTO choices (question_id, choice_text) VALUES (1, 'F.イとウ'); -- 6

INSERT INTO choices (question_id, choice_text) VALUES (2, 'A.アだけ'); -- 7
INSERT INTO choices (question_id, choice_text) VALUES (2, 'B.イだけ'); -- 8〇
INSERT INTO choices (question_id, choice_text) VALUES (2, 'C.ウだけ'); -- 9
INSERT INTO choices (question_id, choice_text) VALUES (2, 'D.アとイ'); -- 10
INSERT INTO choices (question_id, choice_text) VALUES (2, 'E.アとウ'); -- 11
INSERT INTO choices (question_id, choice_text) VALUES (2, 'F.イとウ'); -- 12

INSERT INTO choices (question_id, choice_text) VALUES (3, 'A.アだけ'); -- 13〇
INSERT INTO choices (question_id, choice_text) VALUES (3, 'B.イだけ'); -- 14
INSERT INTO choices (question_id, choice_text) VALUES (3, 'C.ウだけ'); -- 15
INSERT INTO choices (question_id, choice_text) VALUES (3, 'D.アとイ'); -- 16
INSERT INTO choices (question_id, choice_text) VALUES (3, 'E.アとウ'); -- 17
INSERT INTO choices (question_id, choice_text) VALUES (3, 'F.イとウ'); -- 18

INSERT INTO choices (question_id, choice_text) VALUES (4, 'A.アだけ'); -- 19
INSERT INTO choices (question_id, choice_text) VALUES (4, 'B.イだけ'); -- 20〇
INSERT INTO choices (question_id, choice_text) VALUES (4, 'C.ウだけ'); -- 21
INSERT INTO choices (question_id, choice_text) VALUES (4, 'D.アとイ'); -- 22
INSERT INTO choices (question_id, choice_text) VALUES (4, 'E.アとウ'); -- 23
INSERT INTO choices (question_id, choice_text) VALUES (4, 'F.イとウ'); -- 24

INSERT INTO choices (question_id, choice_text) VALUES (5, 'A.アだけ'); -- 25
INSERT INTO choices (question_id, choice_text) VALUES (5, 'B.イだけ'); -- 26〇
INSERT INTO choices (question_id, choice_text) VALUES (5, 'C.ウだけ'); -- 27
INSERT INTO choices (question_id, choice_text) VALUES (5, 'D.アとイ'); -- 28
INSERT INTO choices (question_id, choice_text) VALUES (5, 'E.アとウ'); -- 29
INSERT INTO choices (question_id, choice_text) VALUES (5, 'F.イとウ'); -- 30

INSERT INTO choices (question_id, choice_text) VALUES (6, 'A.キロメートル：センチメートル'); -- 31
INSERT INTO choices (question_id, choice_text) VALUES (6, 'B.キロメートル：単位'); -- 32〇
INSERT INTO choices (question_id, choice_text) VALUES (6, 'C.キロメートル：定規'); -- 33
INSERT INTO choices (question_id, choice_text) VALUES (6, 'D.キロメートル：地図'); -- 34
INSERT INTO choices (question_id, choice_text) VALUES (6, 'E.キロメートル：測量'); -- 35

INSERT INTO choices (question_id, choice_text) VALUES (7, 'A.楽観的：活動的'); -- 36
INSERT INTO choices (question_id, choice_text) VALUES (7, 'B.楽観的：実践的'); -- 37
INSERT INTO choices (question_id, choice_text) VALUES (7, 'C.楽観的：全体的'); -- 38
INSERT INTO choices (question_id, choice_text) VALUES (7, 'D.楽観的：飛躍的'); -- 39
INSERT INTO choices (question_id, choice_text) VALUES (7, 'E.楽観的：悲観的'); -- 40〇

INSERT INTO choices (question_id, choice_text) VALUES (8, 'A.露骨：入念'); -- 41
INSERT INTO choices (question_id, choice_text) VALUES (8, 'B.露骨：密集'); -- 42
INSERT INTO choices (question_id, choice_text) VALUES (8, 'C.露骨：内輪'); -- 43
INSERT INTO choices (question_id, choice_text) VALUES (8, 'D.露骨：端的'); -- 44
INSERT INTO choices (question_id, choice_text) VALUES (8, 'E.露骨：婉曲'); -- 45〇

INSERT INTO choices (question_id, choice_text) VALUES (9, 'A.塗料：鉛筆'); -- 46
INSERT INTO choices (question_id, choice_text) VALUES (9, 'B.塗料：ペンキ'); -- 47〇
INSERT INTO choices (question_id, choice_text) VALUES (9, 'C.塗料：工作'); -- 48
INSERT INTO choices (question_id, choice_text) VALUES (9, 'D.塗料：塗装'); -- 49
INSERT INTO choices (question_id, choice_text) VALUES (9, 'E.塗料：看板'); -- 50

INSERT INTO choices (question_id, choice_text) VALUES (10, 'A.しょうゆ：減塩'); -- 51
INSERT INTO choices (question_id, choice_text) VALUES (10, 'B.しょうゆ：みそ'); -- 52
INSERT INTO choices (question_id, choice_text) VALUES (10, 'C.しょうゆ：ソース'); -- 53
INSERT INTO choices (question_id, choice_text) VALUES (10, 'D.しょうゆ：ドレッシング'); -- 54
INSERT INTO choices (question_id, choice_text) VALUES (10, 'E.しょうゆ：大豆'); -- 55〇

INSERT INTO choices (question_id, choice_text) VALUES (11, 'A.遂行'); -- 56
INSERT INTO choices (question_id, choice_text) VALUES (11, 'B.発案'); -- 57
INSERT INTO choices (question_id, choice_text) VALUES (11, 'C.策略'); -- 58
INSERT INTO choices (question_id, choice_text) VALUES (11, 'D.画策'); -- 59〇
INSERT INTO choices (question_id, choice_text) VALUES (11, 'E.考案'); -- 60

INSERT INTO choices (question_id, choice_text) VALUES (12, 'A.適切に'); -- 61〇
INSERT INTO choices (question_id, choice_text) VALUES (12, 'B.けなげにも'); -- 62
INSERT INTO choices (question_id, choice_text) VALUES (12, 'C.理路整然と'); -- 63
INSERT INTO choices (question_id, choice_text) VALUES (12, 'D.きっぱりと'); -- 64
INSERT INTO choices (question_id, choice_text) VALUES (12, 'E.突然に'); -- 65

INSERT INTO choices (question_id, choice_text) VALUES (13, 'A.困難'); -- 66
INSERT INTO choices (question_id, choice_text) VALUES (13, 'B.逆境'); -- 67
INSERT INTO choices (question_id, choice_text) VALUES (13, 'C.渋滞'); -- 68
INSERT INTO choices (question_id, choice_text) VALUES (13, 'D.遅延'); -- 69
INSERT INTO choices (question_id, choice_text) VALUES (13, 'E.難航'); -- 70〇

INSERT INTO choices (question_id, choice_text) VALUES (14, 'A.甘言'); -- 71
INSERT INTO choices (question_id, choice_text) VALUES (14, 'B.過言'); -- 72
INSERT INTO choices (question_id, choice_text) VALUES (14, 'C.提言'); -- 73
INSERT INTO choices (question_id, choice_text) VALUES (14, 'D.進言'); -- 74〇
INSERT INTO choices (question_id, choice_text) VALUES (14, 'E.直言'); -- 75

INSERT INTO choices (question_id, choice_text) VALUES (15, 'A.たやすく'); -- 76
INSERT INTO choices (question_id, choice_text) VALUES (15, 'B.そっけなく'); -- 77
INSERT INTO choices (question_id, choice_text) VALUES (15, 'C.すばやく'); -- 78
INSERT INTO choices (question_id, choice_text) VALUES (15, 'D.急激に'); -- 79
INSERT INTO choices (question_id, choice_text) VALUES (15, 'E.なだらかに'); -- 80〇

INSERT INTO choices (question_id, choice_text) VALUES (16, 'A.亜流'); -- 81〇
INSERT INTO choices (question_id, choice_text) VALUES (16, 'B.二流'); -- 82
INSERT INTO choices (question_id, choice_text) VALUES (16, 'C.低俗'); -- 83
INSERT INTO choices (question_id, choice_text) VALUES (16, 'D.劣等'); -- 84
INSERT INTO choices (question_id, choice_text) VALUES (16, 'E.模倣'); -- 85

INSERT INTO choices (question_id, choice_text) VALUES (17, 'A.陳腐'); -- 86〇
INSERT INTO choices (question_id, choice_text) VALUES (17, 'B.古来'); -- 87
INSERT INTO choices (question_id, choice_text) VALUES (17, 'C.卑小'); -- 88
INSERT INTO choices (question_id, choice_text) VALUES (17, 'D.旧式'); -- 89
INSERT INTO choices (question_id, choice_text) VALUES (17, 'E.常套（とう）'); -- 90

INSERT INTO choices (question_id, choice_text) VALUES (18, 'A.仲介'); -- 91
INSERT INTO choices (question_id, choice_text) VALUES (18, 'B.潜入'); -- 92
INSERT INTO choices (question_id, choice_text) VALUES (18, 'C.介入'); -- 93〇
INSERT INTO choices (question_id, choice_text) VALUES (18, 'D.調停'); -- 94
INSERT INTO choices (question_id, choice_text) VALUES (18, 'E.関与'); -- 95

INSERT INTO choices (question_id, choice_text) VALUES (19, 'A.混合'); -- 96
INSERT INTO choices (question_id, choice_text) VALUES (19, 'B.合同'); -- 97
INSERT INTO choices (question_id, choice_text) VALUES (19, 'C.折半'); -- 98
INSERT INTO choices (question_id, choice_text) VALUES (19, 'D.併合'); -- 99
INSERT INTO choices (question_id, choice_text) VALUES (19, 'E.折衷'); -- 100〇

INSERT INTO choices (question_id, choice_text) VALUES (20, 'A.高慢'); -- 101
INSERT INTO choices (question_id, choice_text) VALUES (20, 'B.披露'); -- 102
INSERT INTO choices (question_id, choice_text) VALUES (20, 'C.優越'); -- 103
INSERT INTO choices (question_id, choice_text) VALUES (20, 'D.披瀝（れき）'); -- 104
INSERT INTO choices (question_id, choice_text) VALUES (20, 'E.誇示'); -- 105〇

INSERT INTO choices (question_id, choice_text) VALUES (21, 'A.策謀'); -- 106
INSERT INTO choices (question_id, choice_text) VALUES (21, 'B.策定'); -- 107
INSERT INTO choices (question_id, choice_text) VALUES (21, 'C.機略'); -- 108〇
INSERT INTO choices (question_id, choice_text) VALUES (21, 'D.陰謀'); -- 109
INSERT INTO choices (question_id, choice_text) VALUES (21, 'E.策略'); -- 110

INSERT INTO choices (question_id, choice_text) VALUES (22, 'A.根気'); -- 111
INSERT INTO choices (question_id, choice_text) VALUES (22, 'B.粘着'); -- 112
INSERT INTO choices (question_id, choice_text) VALUES (22, 'C.偏屈'); -- 113
INSERT INTO choices (question_id, choice_text) VALUES (22, 'D.辛抱'); -- 114
INSERT INTO choices (question_id, choice_text) VALUES (22, 'E.執拗（よう）'); -- 115〇

INSERT INTO choices (question_id, choice_text) VALUES (23, 'A.天気があやしいので「先」を急ぐことにした'); -- 116
INSERT INTO choices (question_id, choice_text) VALUES (23, 'B.こんな調子では「先」が思いやられる'); -- 117
INSERT INTO choices (question_id, choice_text) VALUES (23, 'C.みんなより「先」に帰ることにした'); -- 118
INSERT INTO choices (question_id, choice_text) VALUES (23, 'D.あまりにおいしいので「先」を争って食べた'); -- 119〇
INSERT INTO choices (question_id, choice_text) VALUES (23, 'E.「先」に料金を払うことになっている'); -- 120

INSERT INTO choices (question_id, choice_text) VALUES (24, 'A.「空」が気になる'); -- 121〇
INSERT INTO choices (question_id, choice_text) VALUES (24, 'B.「空」を飛んでみたい'); -- 122
INSERT INTO choices (question_id, choice_text) VALUES (24, 'C.他人の「空」似だった'); -- 123
INSERT INTO choices (question_id, choice_text) VALUES (24, 'D.うわの「空」で聞く'); -- 124
INSERT INTO choices (question_id, choice_text) VALUES (24, 'E.「空」で覚えている'); -- 125

INSERT INTO choices (question_id, choice_text) VALUES (25, 'A.友人「と」美術館に出かけた'); -- 126
INSERT INTO choices (question_id, choice_text) VALUES (25, 'B.引っ越しは今月「と」決まった'); -- 127〇
INSERT INTO choices (question_id, choice_text) VALUES (25, 'C.くすくす「と」笑う'); -- 128
INSERT INTO choices (question_id, choice_text) VALUES (25, 'D.間違っている「と」指摘する'); -- 129
INSERT INTO choices (question_id, choice_text) VALUES (25, 'E.美しい形だ「と」思う'); -- 130

INSERT INTO choices (question_id, choice_text) VALUES (26, 'A.期限を「きる」ことが大事だ'); -- 131
INSERT INTO choices (question_id, choice_text) VALUES (26, 'B.たんかを「きる」'); -- 132
INSERT INTO choices (question_id, choice_text) VALUES (26, 'C.親子の縁を「きる」'); -- 133〇
INSERT INTO choices (question_id, choice_text) VALUES (26, 'D.かじを「きる」'); -- 134
INSERT INTO choices (question_id, choice_text) VALUES (26, 'E.油を「きる」'); -- 135

INSERT INTO choices (question_id, choice_text) VALUES (27, 'A.花「で」飾る'); -- 136〇
INSERT INTO choices (question_id, choice_text) VALUES (27, 'B.歯痛「で」痛む'); -- 137
INSERT INTO choices (question_id, choice_text) VALUES (27, 'C.書店「で」買う'); -- 138
INSERT INTO choices (question_id, choice_text) VALUES (27, 'D.家族「で」暮らす'); -- 139
INSERT INTO choices (question_id, choice_text) VALUES (27, 'E.すぐに飛ん「で」いきたい'); -- 140

INSERT INTO choices (question_id, choice_text) VALUES (28, 'A.「目」を凝らしてよく見た'); -- 141
INSERT INTO choices (question_id, choice_text) VALUES (28, 'B.「目」がまわる忙しさだ'); -- 142
INSERT INTO choices (question_id, choice_text) VALUES (28, 'C.マナーの悪が「目」にあまる'); -- 143
INSERT INTO choices (question_id, choice_text) VALUES (28, 'D.まさかと「目」を疑う'); -- 144
INSERT INTO choices (question_id, choice_text) VALUES (28, 'E.これを選ぶとは「目」が高い'); -- 145〇

INSERT INTO choices (question_id, choice_text) VALUES (29, 'A.うれしい知らせが待た「れる」'); -- 146
INSERT INTO choices (question_id, choice_text) VALUES (29, 'B.誰でも登「れる」'); -- 147
INSERT INTO choices (question_id, choice_text) VALUES (29, 'C.夜露にぬ「れる」'); -- 148
INSERT INTO choices (question_id, choice_text) VALUES (29, 'D.ビルがこわさ「れる」'); -- 149〇
INSERT INTO choices (question_id, choice_text) VALUES (29, 'E.先生が話さ「れる」'); -- 150

INSERT INTO choices (question_id, choice_text) VALUES (30, 'A.コートの裏地が敗れた「の」です'); -- 151
INSERT INTO choices (question_id, choice_text) VALUES (30, 'B.それは私「の」コートです'); -- 152
INSERT INTO choices (question_id, choice_text) VALUES (30, 'C.コートは軽い「の」がいい'); -- 153〇
INSERT INTO choices (question_id, choice_text) VALUES (30, 'D.私「の」なくしたコートが見つかった'); -- 154
INSERT INTO choices (question_id, choice_text) VALUES (30, 'E.コートがない「の」、マフラーがない「の」と騒ぐ'); -- 155

INSERT INTO choices (question_id, choice_text) VALUES (31, 'A.トップの座に「のぼる」'); -- 156
INSERT INTO choices (question_id, choice_text) VALUES (31, 'B.話題に「のぼる」'); -- 157〇
INSERT INTO choices (question_id, choice_text) VALUES (31, 'C.猫が木に「のぼる」'); -- 158
INSERT INTO choices (question_id, choice_text) VALUES (31, 'D.来場者が100万人に「のぼる」'); -- 159
INSERT INTO choices (question_id, choice_text) VALUES (31, 'E.煙が「のぼる」'); -- 160

INSERT INTO choices (question_id, choice_text) VALUES (32, 'A.あっちもおもしろ「そうだ」'); -- 161
INSERT INTO choices (question_id, choice_text) VALUES (32, 'B.雨でも降り「そうだ」'); -- 162
INSERT INTO choices (question_id, choice_text) VALUES (32, 'C.今年は黒字になり「そうだ」'); -- 163
INSERT INTO choices (question_id, choice_text) VALUES (32, 'D.少しも悲しくなさ「そうだ」'); -- 164
INSERT INTO choices (question_id, choice_text) VALUES (32, 'E.夜更けから雪になる「そうだ」'); -- 165〇

INSERT INTO choices (question_id, choice_text) VALUES (33, 'A.ベジタリアン増加の'); -- 166
INSERT INTO choices (question_id, choice_text) VALUES (33, 'B.具体的に扱うのは'); -- 167
INSERT INTO choices (question_id, choice_text) VALUES (33, 'C.人と動物との本来あるべき関係や'); -- 168
INSERT INTO choices (question_id, choice_text) VALUES (33, 'D.動物の権利を問う学問であり'); -- 169
INSERT INTO choices (question_id, choice_text) VALUES (33, 'E.肉食といった問題であるため'); -- 170〇

INSERT INTO choices (question_id, choice_text) VALUES (34, 'A.さらにそのデータを'); -- 171〇
INSERT INTO choices (question_id, choice_text) VALUES (34, 'B.あらゆる情報がデジタル化され'); -- 172
INSERT INTO choices (question_id, choice_text) VALUES (34, 'C.生活がより便利になった一方で'); -- 173
INSERT INTO choices (question_id, choice_text) VALUES (34, 'D.膨大な個人情報が広がっていくことへの'); -- 174
INSERT INTO choices (question_id, choice_text) VALUES (34, 'E.分析できるようになったおかげで'); -- 175

INSERT INTO choices (question_id, choice_text) VALUES (35, 'A.細菌は一つの細胞でできており'); -- 176〇
INSERT INTO choices (question_id, choice_text) VALUES (35, 'B.ウイルスは細菌の50分の1ほどの大きさで'); -- 177
INSERT INTO choices (question_id, choice_text) VALUES (35, 'C.単細胞生物と呼ばれるのに対し'); -- 178
INSERT INTO choices (question_id, choice_text) VALUES (35, 'D.自分で細胞を持たず'); -- 179
INSERT INTO choices (question_id, choice_text) VALUES (35, 'E.どちらも微生物だが'); -- 180

INSERT INTO choices (question_id, choice_text) VALUES (36, 'A. ア 日本においては軍事や国防と密接に結びつけられてきた'); -- 181〇
INSERT INTO choices (question_id, choice_text) VALUES (36, 'B. イ この条約の改正は大きな反対運動、いわゆる安保闘争を招いた'); -- 182
INSERT INTO choices (question_id, choice_text) VALUES (36, 'C. ウ 契機は「日米安全保障条約」の締結だと考えられる'); -- 183
INSERT INTO choices (question_id, choice_text) VALUES (36, 'D. エ その結果、“Security”は「安全保障」よりも「安保」として定着した'); -- 184
INSERT INTO choices (question_id, choice_text) VALUES (36, 'E. オ 「安全保障」という言葉は英語の“Security”の訳語であるが'); -- 185

INSERT INTO choices (question_id, choice_text) VALUES (37, 'A.自宅などの生活の場で'); -- 186
INSERT INTO choices (question_id, choice_text) VALUES (37, 'B.第３の医療提供形態として'); -- 187
INSERT INTO choices (question_id, choice_text) VALUES (37, 'C.入院医療、外来医療に次ぐ'); -- 188〇
INSERT INTO choices (question_id, choice_text) VALUES (37, 'D.通院が困難な患者が'); -- 189
INSERT INTO choices (question_id, choice_text) VALUES (37, 'E.療養を行えるようにする医療であり'); -- 190

INSERT INTO choices (question_id, choice_text) VALUES (38, 'A.この状態をプラズマと呼びます。'); -- 191〇
INSERT INTO choices (question_id, choice_text) VALUES (38, 'B.マイナスの電荷を持った電子に解離します。'); -- 192
INSERT INTO choices (question_id, choice_text) VALUES (38, 'C.またプラズマが運動すると電場や磁場が生まれ、'); -- 193
INSERT INTO choices (question_id, choice_text) VALUES (38, 'D.プラズマは電場や磁場を感じると運動が変化します。'); -- 194
INSERT INTO choices (question_id, choice_text) VALUES (38, 'E.原子がプラスの電荷を持つイオンと、'); -- 195

INSERT INTO choices (question_id, choice_text) VALUES (39, 'A.しかし過去の生物を直接知る手がかりは、化石記録しかありません。'); -- 196〇
INSERT INTO choices (question_id, choice_text) VALUES (39, 'B.古代の生物の様子がまるで見てきたかのような'); -- 197
INSERT INTO choices (question_id, choice_text) VALUES (39, 'C.ですから、その生物の姿勢や動き、色や模様は、'); -- 198
INSERT INTO choices (question_id, choice_text) VALUES (39, 'D.カラーイラストで描かれているのをよく目にします。'); -- 199

INSERT INTO choices (question_id, choice_text) VALUES (40, 'A. ア 職場の仕事の他に、家事育児や介護といった労働を「ケア労働」という'); -- 200
INSERT INTO choices (question_id, choice_text) VALUES (40, 'B. イ 日本では有償労働は男性に'); -- 201〇
INSERT INTO choices (question_id, choice_text) VALUES (40, 'C. ウ 働く女性はダブルワークを担わなくてはならないという問題がある'); -- 202
INSERT INTO choices (question_id, choice_text) VALUES (40, 'D. エ 無償のケア労働は女性に偏っている'); -- 203
INSERT INTO choices (question_id, choice_text) VALUES (40, 'E. オ そのため、女性の社会進出が叫ばれている一方で'); -- 204

INSERT INTO choices (question_id, choice_text) VALUES (41, 'A.「二院制」がとられているのは、'); -- 205 
INSERT INTO choices (question_id, choice_text) VALUES (41, 'B.その二つとは「衆議院」と「参議院」です。'); -- 206 
INSERT INTO choices (question_id, choice_text) VALUES (41, 'C.国会は二つの議会からなる「二院制」がとられていて、'); -- 207〇
INSERT INTO choices (question_id, choice_text) VALUES (41, 'D.さまざまな意見を取り入れて慎重に話し合うという目的のためです。'); -- 208
INSERT INTO choices (question_id, choice_text) VALUES (41, 'E.「唯一の立法機関」と定められています。'); -- 209

INSERT INTO choices (question_id, choice_text) VALUES (42, 'A.「冷蔵庫」「洗濯機」「白黒テレビ」が、'); -- 210
INSERT INTO choices (question_id, choice_text) VALUES (42, 'B.「三種の神器」と呼ばれました。'); -- 211
INSERT INTO choices (question_id, choice_text) VALUES (42, 'C.一般の家庭でも使える電化製品が次々と現れました。'); -- 212
INSERT INTO choices (question_id, choice_text) VALUES (42, 'D.例えば高度経済成長期のさなか登場した'); -- 213
INSERT INTO choices (question_id, choice_text) VALUES (42, 'E.人々の生活を豊かにするための'); -- 214〇

INSERT INTO choices (question_id, choice_text) VALUES (43, 'A.才能'); -- 215
INSERT INTO choices (question_id, choice_text) VALUES (43, 'B.幻想'); -- 216
INSERT INTO choices (question_id, choice_text) VALUES (43, 'C.夢'); -- 217
INSERT INTO choices (question_id, choice_text) VALUES (43, 'D.怠惰'); -- 218
INSERT INTO choices (question_id, choice_text) VALUES (43, 'E.力み'); -- 219〇
INSERT INTO choices (question_id, choice_text) VALUES (43, 'F.迷い'); -- 220

INSERT INTO choices (question_id, choice_text) VALUES (44, 'A.躍起'); -- 221〇
INSERT INTO choices (question_id, choice_text) VALUES (44, 'B.一筋'); -- 222
INSERT INTO choices (question_id, choice_text) VALUES (44, 'C.強引'); -- 223
INSERT INTO choices (question_id, choice_text) VALUES (44, 'D.本腰'); -- 224
INSERT INTO choices (question_id, choice_text) VALUES (44, 'E.一向'); -- 225

INSERT INTO choices (question_id, choice_text) VALUES (45, 'A.苦虫'); -- 226
INSERT INTO choices (question_id, choice_text) VALUES (45, 'B.眉唾'); -- 227
INSERT INTO choices (question_id, choice_text) VALUES (45, 'C.言葉'); -- 228
INSERT INTO choices (question_id, choice_text) VALUES (45, 'D.良薬'); -- 229
INSERT INTO choices (question_id, choice_text) VALUES (45, 'E.固唾'); -- 230〇

INSERT INTO choices (question_id, choice_text) VALUES (46, 'A.丹精'); -- 231
INSERT INTO choices (question_id, choice_text) VALUES (46, 'B.手塩'); -- 232〇
INSERT INTO choices (question_id, choice_text) VALUES (46, 'C.拍車'); -- 233
INSERT INTO choices (question_id, choice_text) VALUES (46, 'D.腕'); -- 234
INSERT INTO choices (question_id, choice_text) VALUES (46, 'E.輪'); -- 235

INSERT INTO choices (question_id, choice_text) VALUES (47, 'A.ふける'); -- 236
INSERT INTO choices (question_id, choice_text) VALUES (47, 'B.寄せる'); -- 237
INSERT INTO choices (question_id, choice_text) VALUES (47, 'C.つきる'); -- 238
INSERT INTO choices (question_id, choice_text) VALUES (47, 'D.むせぶ'); -- 239〇
INSERT INTO choices (question_id, choice_text) VALUES (47, 'E.徹する'); -- 240

INSERT INTO choices (question_id, choice_text) VALUES (48, 'A.新しいことにチャレンジする意欲がある'); -- 241
INSERT INTO choices (question_id, choice_text) VALUES (48, 'B.失敗だと気づかずに通り過ぎてきた'); -- 242
INSERT INTO choices (question_id, choice_text) VALUES (48, 'C.どんなに失敗を繰り返しても許される状況だった'); -- 243
INSERT INTO choices (question_id, choice_text) VALUES (48, 'D.過去の失敗事例から回避する手段がわかっている'); -- 244〇

INSERT INTO choices (question_id, choice_text) VALUES (49, 'A.批判的'); -- 245
INSERT INTO choices (question_id, choice_text) VALUES (49, 'B.論理的'); -- 246〇
INSERT INTO choices (question_id, choice_text) VALUES (49, 'C.普遍的'); -- 247
INSERT INTO choices (question_id, choice_text) VALUES (49, 'D.哲学的'); -- 248
INSERT INTO choices (question_id, choice_text) VALUES (49, 'E.感覚的'); -- 249
INSERT INTO choices (question_id, choice_text) VALUES (49, 'F.実証的'); -- 250

INSERT INTO choices (question_id, choice_text) VALUES (50, 'A.余所'); -- 251
INSERT INTO choices (question_id, choice_text) VALUES (50, 'B.底辺'); -- 252
INSERT INTO choices (question_id, choice_text) VALUES (50, 'C.道中'); -- 253
INSERT INTO choices (question_id, choice_text) VALUES (50, 'D.風上'); -- 254〇
INSERT INTO choices (question_id, choice_text) VALUES (50, 'E.一角'); -- 255

INSERT INTO choices (question_id, choice_text) VALUES (51, 'A.本腰'); -- 256〇
INSERT INTO choices (question_id, choice_text) VALUES (51, 'B.年季'); -- 257
INSERT INTO choices (question_id, choice_text) VALUES (51, 'C.本気'); -- 258
INSERT INTO choices (question_id, choice_text) VALUES (51, 'D.念頭'); -- 259
INSERT INTO choices (question_id, choice_text) VALUES (51, 'E.故障'); -- 260

INSERT INTO choices (question_id, choice_text) VALUES (52, 'A.さしずめ'); -- 261
INSERT INTO choices (question_id, choice_text) VALUES (52, 'B.ともすれば'); -- 262〇
INSERT INTO choices (question_id, choice_text) VALUES (52, 'C.ひっきょう'); -- 263
INSERT INTO choices (question_id, choice_text) VALUES (52, 'D.ようとして'); -- 264
INSERT INTO choices (question_id, choice_text) VALUES (52, 'E.なまじっか'); -- 265

-- 非言語問題
INSERT INTO choices (question_id, choice_text) VALUES (53, 'A. 13 通り'); -- 266
INSERT INTO choices (question_id, choice_text) VALUES (53, 'B. 18 通り'); -- 267
INSERT INTO choices (question_id, choice_text) VALUES (53, 'C. 24 通り'); -- 268
INSERT INTO choices (question_id, choice_text) VALUES (53, 'D. 40 通り'); -- 269〇
INSERT INTO choices (question_id, choice_text) VALUES (53, 'E. 80 通り'); -- 270

INSERT INTO choices (question_id, choice_text) VALUES (54, 'A. 7 通り'); -- 271
INSERT INTO choices (question_id, choice_text) VALUES (54, 'B. 21 通り'); -- 272
INSERT INTO choices (question_id, choice_text) VALUES (54, 'C. 35 通り'); -- 273〇
INSERT INTO choices (question_id, choice_text) VALUES (54, 'D. 91 通り'); -- 274
INSERT INTO choices (question_id, choice_text) VALUES (54, 'E. 140 通り'); -- 275

INSERT INTO choices (question_id, choice_text) VALUES (55, 'A. 100 通り'); -- 276
INSERT INTO choices (question_id, choice_text) VALUES (55, 'B. 700 通り'); -- 277
INSERT INTO choices (question_id, choice_text) VALUES (55, 'C. 1600 通り'); -- 278
INSERT INTO choices (question_id, choice_text) VALUES (55, 'D. 4200 通り'); -- 279〇
INSERT INTO choices (question_id, choice_text) VALUES (55, 'E. 7200 通り'); -- 280

INSERT INTO choices (question_id, choice_text) VALUES (56, 'A. 12 通り'); -- 281
INSERT INTO choices (question_id, choice_text) VALUES (56, 'B. 24 通り'); -- 282〇
INSERT INTO choices (question_id, choice_text) VALUES (56, 'C. 48 通り'); -- 283
INSERT INTO choices (question_id, choice_text) VALUES (56, 'D. 80 通り'); -- 284
INSERT INTO choices (question_id, choice_text) VALUES (56, 'E. 120 通り'); -- 285

INSERT INTO choices (question_id, choice_text) VALUES (57, 'A. 4 通り'); -- 286
INSERT INTO choices (question_id, choice_text) VALUES (57, 'B. 6 通り'); -- 287〇
INSERT INTO choices (question_id, choice_text) VALUES (57, 'C. 10 通り'); -- 288
INSERT INTO choices (question_id, choice_text) VALUES (57, 'D. 12 通り'); -- 289
INSERT INTO choices (question_id, choice_text) VALUES (57, 'E. AからDのいずれでもない'); -- 290

INSERT INTO choices (question_id, choice_text) VALUES (58, 'A. 5 通り'); -- 291
INSERT INTO choices (question_id, choice_text) VALUES (58, 'B. 6 通り'); -- 292〇
INSERT INTO choices (question_id, choice_text) VALUES (58, 'C. 12 通り'); -- 293
INSERT INTO choices (question_id, choice_text) VALUES (58, 'D. 20 通り'); -- 294
INSERT INTO choices (question_id, choice_text) VALUES (58, 'E. AからDのいずれでもない'); -- 295

INSERT INTO choices (question_id, choice_text) VALUES (59, 'A. 3 通り'); -- 296
INSERT INTO choices (question_id, choice_text) VALUES (59, 'B. 5 通り'); -- 297
INSERT INTO choices (question_id, choice_text) VALUES (59, 'C. 6 通り'); -- 298〇
INSERT INTO choices (question_id, choice_text) VALUES (59, 'D. 10 通り'); -- 299
INSERT INTO choices (question_id, choice_text) VALUES (59, 'E. AからDのいずれでもない'); -- 300

INSERT INTO choices (question_id, choice_text) VALUES (60, 'A. 3'); -- 301
INSERT INTO choices (question_id, choice_text) VALUES (60, 'B. 6'); -- 302
INSERT INTO choices (question_id, choice_text) VALUES (60, 'C. 21'); -- 303
INSERT INTO choices (question_id, choice_text) VALUES (60, 'D. 27'); -- 304〇

INSERT INTO choices (question_id, choice_text) VALUES (61, 'A. 3 通り'); -- 305
INSERT INTO choices (question_id, choice_text) VALUES (61, 'B. 4 通り'); -- 306〇
INSERT INTO choices (question_id, choice_text) VALUES (61, 'C. 8 通り'); -- 307
INSERT INTO choices (question_id, choice_text) VALUES (61, 'D. 12 通り'); -- 308

INSERT INTO choices (question_id, choice_text) VALUES (62, 'A. 5 通り'); -- 309
INSERT INTO choices (question_id, choice_text) VALUES (62, 'B. 6 通り'); -- 310〇
INSERT INTO choices (question_id, choice_text) VALUES (62, 'C. 9 通り'); -- 311
INSERT INTO choices (question_id, choice_text) VALUES (62, 'D. 10 通り'); -- 312
INSERT INTO choices (question_id, choice_text) VALUES (62, 'E. AからDのいずれでもない'); -- 313

INSERT INTO choices (question_id, choice_text) VALUES (63, 'A. 1'); -- 314
INSERT INTO choices (question_id, choice_text) VALUES (63, 'B. 2'); -- 315
INSERT INTO choices (question_id, choice_text) VALUES (63, 'C. 3'); -- 316
INSERT INTO choices (question_id, choice_text) VALUES (63, 'D. 4'); -- 317〇
INSERT INTO choices (question_id, choice_text) VALUES (63, 'E. 5'); -- 318

INSERT INTO choices (question_id, choice_text) VALUES (64, 'A. SRPQ'); -- 319
INSERT INTO choices (question_id, choice_text) VALUES (64, 'B. SRQP'); -- 320〇
INSERT INTO choices (question_id, choice_text) VALUES (64, 'C. PRSQ'); -- 321
INSERT INTO choices (question_id, choice_text) VALUES (64, 'D. RPQS'); -- 322

INSERT INTO choices (question_id, choice_text) VALUES (65, 'A. アもイも正しい'); -- 323
INSERT INTO choices (question_id, choice_text) VALUES (65, 'B. アは正しいがイは誤り'); -- 324
INSERT INTO choices (question_id, choice_text) VALUES (65, 'C. アはどちらとも言えないがイは誤り'); -- 325
INSERT INTO choices (question_id, choice_text) VALUES (65, 'D. アは誤りだがイは正しい'); -- 326〇
INSERT INTO choices (question_id, choice_text) VALUES (65, 'E. アもイもどちらとも言えない'); -- 327

INSERT INTO choices (question_id, choice_text) VALUES (66, 'A. 5'); -- 328〇
INSERT INTO choices (question_id, choice_text) VALUES (66, 'B. 10'); -- 329
INSERT INTO choices (question_id, choice_text) VALUES (66, 'C. 15'); -- 330
INSERT INTO choices (question_id, choice_text) VALUES (66, 'D. 20'); -- 331
INSERT INTO choices (question_id, choice_text) VALUES (66, 'E. 25'); -- 332

INSERT INTO choices (question_id, choice_text) VALUES (67, 'A. 2'); -- 333
INSERT INTO choices (question_id, choice_text) VALUES (67, 'B. 3'); -- 334
INSERT INTO choices (question_id, choice_text) VALUES (67, 'C. 4'); -- 335
INSERT INTO choices (question_id, choice_text) VALUES (67, 'D. 5'); -- 336〇
INSERT INTO choices (question_id, choice_text) VALUES (67, 'E. 6'); -- 337

INSERT INTO choices (question_id, choice_text) VALUES (68, 'A. A-C-D-E-B'); -- 338
INSERT INTO choices (question_id, choice_text) VALUES (68, 'B. B-D-E-A-C'); -- 339
INSERT INTO choices (question_id, choice_text) VALUES (68, 'C. D-E-A-C-B'); -- 340〇
INSERT INTO choices (question_id, choice_text) VALUES (68, 'D. E-D-C-B-A'); -- 341
INSERT INTO choices (question_id, choice_text) VALUES (68, 'E. D-A-E-B-C'); -- 342


INSERT INTO choices (question_id, choice_text) VALUES (69, 'A. A'); -- 343
INSERT INTO choices (question_id, choice_text) VALUES (69, 'B. B'); -- 344〇
INSERT INTO choices (question_id, choice_text) VALUES (69, 'C. C'); -- 345
INSERT INTO choices (question_id, choice_text) VALUES (69, 'D. D'); -- 346
INSERT INTO choices (question_id, choice_text) VALUES (69, 'E. E'); -- 347


INSERT INTO choices (question_id, choice_text) VALUES (70, 'A. 1'); -- 348
INSERT INTO choices (question_id, choice_text) VALUES (70, 'B. 2'); -- 349
INSERT INTO choices (question_id, choice_text) VALUES (70, 'C. 3'); -- 350〇
INSERT INTO choices (question_id, choice_text) VALUES (70, 'D. 4'); -- 351


INSERT INTO choices (question_id, choice_text) VALUES (71, 'A. アだけ'); -- 352
INSERT INTO choices (question_id, choice_text) VALUES (71, 'B. イだけ'); -- 353
INSERT INTO choices (question_id, choice_text) VALUES (71, 'C. ウだけ'); -- 354〇
INSERT INTO choices (question_id, choice_text) VALUES (71, 'D. アとイ'); -- 355


INSERT INTO choices (question_id, choice_text) VALUES (72, 'A. アとイの両方'); -- 356
INSERT INTO choices (question_id, choice_text) VALUES (72, 'B. アとウの両方'); -- 357
INSERT INTO choices (question_id, choice_text) VALUES (72, 'C. アとエの両方'); -- 358
INSERT INTO choices (question_id, choice_text) VALUES (72, 'D. イとウの両方'); -- 359
INSERT INTO choices (question_id, choice_text) VALUES (72, 'E. イとエの両方'); -- 360〇


INSERT INTO choices (question_id, choice_text) VALUES (73, 'A. 21%'); -- 361
INSERT INTO choices (question_id, choice_text) VALUES (73, 'B. 24%'); -- 362〇
INSERT INTO choices (question_id, choice_text) VALUES (73, 'C. 27%'); -- 363
INSERT INTO choices (question_id, choice_text) VALUES (73, 'D. 29%'); -- 364


INSERT INTO choices (question_id, choice_text) VALUES (74, 'A. 15%'); -- 365
INSERT INTO choices (question_id, choice_text) VALUES (74, 'B. 17%'); -- 366
INSERT INTO choices (question_id, choice_text) VALUES (74, 'C. 21%'); -- 367
INSERT INTO choices (question_id, choice_text) VALUES (74, 'D. 25%'); -- 368〇


INSERT INTO choices (question_id, choice_text) VALUES (75, 'A. 25%'); -- 369
INSERT INTO choices (question_id, choice_text) VALUES (75, 'B. 35%'); -- 370〇
INSERT INTO choices (question_id, choice_text) VALUES (75, 'C. 45%'); -- 371
INSERT INTO choices (question_id, choice_text) VALUES (75, 'D. 50%'); -- 372


INSERT INTO choices (question_id, choice_text) VALUES (76, 'A. 60人'); -- 373〇
INSERT INTO choices (question_id, choice_text) VALUES (76, 'B. 80人'); -- 374
INSERT INTO choices (question_id, choice_text) VALUES (76, 'C. 100人'); -- 375
INSERT INTO choices (question_id, choice_text) VALUES (76, 'D. 110人'); -- 376


INSERT INTO choices (question_id, choice_text) VALUES (77, 'A. 70%'); -- 377
INSERT INTO choices (question_id, choice_text) VALUES (77, 'B. 80%'); -- 378
INSERT INTO choices (question_id, choice_text) VALUES (77, 'C. 87%'); -- 379
INSERT INTO choices (question_id, choice_text) VALUES (77, 'D. 93%'); -- 380〇


INSERT INTO choices (question_id, choice_text) VALUES (78, 'A. 3/5'); -- 381
INSERT INTO choices (question_id, choice_text) VALUES (78, 'B. 3/11'); -- 382
INSERT INTO choices (question_id, choice_text) VALUES (78, 'C. 9/20'); -- 383
INSERT INTO choices (question_id, choice_text) VALUES (78, 'D. 17/20'); -- 384〇


INSERT INTO choices (question_id, choice_text) VALUES (79, 'A. 3%'); -- 385〇
INSERT INTO choices (question_id, choice_text) VALUES (79, 'B. 9%'); -- 386
INSERT INTO choices (question_id, choice_text) VALUES (79, 'C. 15%'); -- 387
INSERT INTO choices (question_id, choice_text) VALUES (79, 'D. 18%'); -- 388


INSERT INTO choices (question_id, choice_text) VALUES (80, 'A. 1%'); -- 389
INSERT INTO choices (question_id, choice_text) VALUES (80, 'B. 3%'); -- 390
INSERT INTO choices (question_id, choice_text) VALUES (80, 'C. 5%'); -- 391
INSERT INTO choices (question_id, choice_text) VALUES (80, 'D. 8%'); -- 392〇


INSERT INTO choices (question_id, choice_text) VALUES (81, 'A. 18%'); -- 393
INSERT INTO choices (question_id, choice_text) VALUES (81, 'B. 20%'); -- 394
INSERT INTO choices (question_id, choice_text) VALUES (81, 'C. 22%'); -- 395〇
INSERT INTO choices (question_id, choice_text) VALUES (81, 'D. 24%'); -- 396


INSERT INTO choices (question_id, choice_text) VALUES (82, 'A. 60人'); -- 397
INSERT INTO choices (question_id, choice_text) VALUES (82, 'B. 80人'); -- 398
INSERT INTO choices (question_id, choice_text) VALUES (82, 'C. 100人'); -- 399〇
INSERT INTO choices (question_id, choice_text) VALUES (82, 'D. 120人'); -- 400


INSERT INTO choices (question_id, choice_text) VALUES (83, 'A. 2/25'); -- 401
INSERT INTO choices (question_id, choice_text) VALUES (83, 'B. 2/5'); -- 402
INSERT INTO choices (question_id, choice_text) VALUES (83, 'C. 1/10'); -- 403〇
INSERT INTO choices (question_id, choice_text) VALUES (83, 'D. 3/5'); -- 404


INSERT INTO choices (question_id, choice_text) VALUES (84, 'A. 5/26'); -- 405
INSERT INTO choices (question_id, choice_text) VALUES (84, 'B. 5/13'); -- 406
INSERT INTO choices (question_id, choice_text) VALUES (84, 'C. 109/169'); -- 407
INSERT INTO choices (question_id, choice_text) VALUES (84, 'D. 60/169'); -- 408〇


INSERT INTO choices (question_id, choice_text) VALUES (85, 'A. 0.42'); -- 409
INSERT INTO choices (question_id, choice_text) VALUES (85, 'B. 0.54'); -- 410〇
INSERT INTO choices (question_id, choice_text) VALUES (85, 'C. 0.72'); -- 411
INSERT INTO choices (question_id, choice_text) VALUES (85, 'D. 0.90'); -- 412


INSERT INTO choices (question_id, choice_text) VALUES (86, 'A. 6人'); -- 413
INSERT INTO choices (question_id, choice_text) VALUES (86, 'B. 7人'); -- 414
INSERT INTO choices (question_id, choice_text) VALUES (86, 'C. 8人'); -- 415
INSERT INTO choices (question_id, choice_text) VALUES (86, 'D. 9人'); -- 416〇


INSERT INTO choices (question_id, choice_text) VALUES (87, 'A. 2/16'); -- 417
INSERT INTO choices (question_id, choice_text) VALUES (87, 'B. 8/21'); -- 418
INSERT INTO choices (question_id, choice_text) VALUES (87, 'C. 11/13'); -- 419
INSERT INTO choices (question_id, choice_text) VALUES (87, 'D. 5/32'); -- 420〇


INSERT INTO choices (question_id, choice_text) VALUES (88, 'A. 7/16'); -- 421〇
INSERT INTO choices (question_id, choice_text) VALUES (88, 'B. 7/8'); -- 422
INSERT INTO choices (question_id, choice_text) VALUES (88, 'C. 3/8'); -- 423
INSERT INTO choices (question_id, choice_text) VALUES (88, 'D. 4/5'); -- 424


INSERT INTO choices (question_id, choice_text) VALUES (89, 'A. 4/9'); -- 425
INSERT INTO choices (question_id, choice_text) VALUES (89, 'B. 5/8'); -- 426
INSERT INTO choices (question_id, choice_text) VALUES (89, 'C. 3/7'); -- 427〇
INSERT INTO choices (question_id, choice_text) VALUES (89, 'D. 1/6'); -- 428


INSERT INTO choices (question_id, choice_text) VALUES (90, 'A. 1/5'); -- 429
INSERT INTO choices (question_id, choice_text) VALUES (90, 'B. 1/6'); -- 430〇
INSERT INTO choices (question_id, choice_text) VALUES (90, 'C. 1/18'); -- 431
INSERT INTO choices (question_id, choice_text) VALUES (90, 'D. 1/30'); -- 432


INSERT INTO choices (question_id, choice_text) VALUES (91, 'A. 0.15'); -- 433
INSERT INTO choices (question_id, choice_text) VALUES (91, 'B. 0.45'); -- 434
INSERT INTO choices (question_id, choice_text) VALUES (91, 'C. 0.56'); -- 435〇
INSERT INTO choices (question_id, choice_text) VALUES (91, 'D. 0.67'); -- 436


INSERT INTO choices (question_id, choice_text) VALUES (92, 'A. 0.12'); -- 437〇
INSERT INTO choices (question_id, choice_text) VALUES (92, 'B. 0.13'); -- 438
INSERT INTO choices (question_id, choice_text) VALUES (92, 'C. 0.23'); -- 439
INSERT INTO choices (question_id, choice_text) VALUES (92, 'D. 0.42'); -- 440


INSERT INTO choices (question_id, choice_text) VALUES (93, 'A. Xに4600円Yは3000円支払う'); -- 441
INSERT INTO choices (question_id, choice_text) VALUES (93, 'B. Xに5400円Yは2100円支払う'); -- 442〇
INSERT INTO choices (question_id, choice_text) VALUES (93, 'C. Xに5400円Yは2900円支払う'); -- 443
INSERT INTO choices (question_id, choice_text) VALUES (93, 'D. Xに7500円支払う'); -- 444
INSERT INTO choices (question_id, choice_text) VALUES (93, 'E. Yに9600円支払う'); -- 445


INSERT INTO choices (question_id, choice_text) VALUES (94, 'A. 5600円'); -- 446
INSERT INTO choices (question_id, choice_text) VALUES (94, 'B. 5350円'); -- 447
INSERT INTO choices (question_id, choice_text) VALUES (94, 'C. 5950円'); -- 448〇
INSERT INTO choices (question_id, choice_text) VALUES (94, 'D. 5550円'); -- 449


INSERT INTO choices (question_id, choice_text) VALUES (95, 'A. 3850円'); -- 450
INSERT INTO choices (question_id, choice_text) VALUES (95, 'B. 115000円'); -- 451
INSERT INTO choices (question_id, choice_text) VALUES (95, 'C. 45000円'); -- 452
INSERT INTO choices (question_id, choice_text) VALUES (95, 'D. 38500円'); -- 453〇


INSERT INTO choices (question_id, choice_text) VALUES (96, 'A. 15000円'); -- 454
INSERT INTO choices (question_id, choice_text) VALUES (96, 'B. 13800円'); -- 455
INSERT INTO choices (question_id, choice_text) VALUES (96, 'C. 10000円'); -- 456
INSERT INTO choices (question_id, choice_text) VALUES (96, 'D. 13200円'); -- 457〇
INSERT INTO choices (question_id, choice_text) VALUES (96, 'E. 9600円'); -- 458


INSERT INTO choices (question_id, choice_text) VALUES (97, 'A. 負担額は揃っている'); -- 459
INSERT INTO choices (question_id, choice_text) VALUES (97, 'B. PにQが4900円 Rが2500円'); -- 460
INSERT INTO choices (question_id, choice_text) VALUES (97, 'C. PにQが2500円 Rも2500円'); -- 461〇
INSERT INTO choices (question_id, choice_text) VALUES (97, 'D. PがQとRに450円ずつ'); -- 462


INSERT INTO choices (question_id, choice_text) VALUES (98, 'A. 12時〜18時'); -- 463
INSERT INTO choices (question_id, choice_text) VALUES (98, 'B. 9時〜15時'); -- 464
INSERT INTO choices (question_id, choice_text) VALUES (98, 'C. 10時〜16時'); -- 465
INSERT INTO choices (question_id, choice_text) VALUES (98, 'D. 11時〜17時'); -- 466〇


INSERT INTO choices (question_id, choice_text) VALUES (99, 'A. P：475円 Q：450円'); -- 467〇
INSERT INTO choices (question_id, choice_text) VALUES (99, 'B. P：500円 Q：450円'); -- 468
INSERT INTO choices (question_id, choice_text) VALUES (99, 'C. P：470円 Q：425円'); -- 469
INSERT INTO choices (question_id, choice_text) VALUES (99, 'D. P：525円 Q：425円'); -- 470


INSERT INTO choices (question_id, choice_text) VALUES (100, 'A. 1200円'); -- 471
INSERT INTO choices (question_id, choice_text) VALUES (100, 'B. 400円'); -- 472〇
INSERT INTO choices (question_id, choice_text) VALUES (100, 'C. 200円'); -- 473
INSERT INTO choices (question_id, choice_text) VALUES (100, 'D. 500円'); -- 474


INSERT INTO choices (question_id, choice_text) VALUES (101, 'A. 25人'); -- 475〇
INSERT INTO choices (question_id, choice_text) VALUES (101, 'B. 28人'); -- 476
INSERT INTO choices (question_id, choice_text) VALUES (101, 'C. 35人'); -- 477
INSERT INTO choices (question_id, choice_text) VALUES (101, 'D. 70人'); -- 478


INSERT INTO choices (question_id, choice_text) VALUES (102, 'A. 150円'); -- 479
INSERT INTO choices (question_id, choice_text) VALUES (102, 'B. 200円'); -- 480〇
INSERT INTO choices (question_id, choice_text) VALUES (102, 'C. 220円'); -- 481
INSERT INTO choices (question_id, choice_text) VALUES (102, 'D. 300円'); -- 482


INSERT INTO choices (question_id, choice_text) VALUES (103, 'A. 5/21'); -- 483
INSERT INTO choices (question_id, choice_text) VALUES (103, 'B. 2/3'); -- 484
INSERT INTO choices (question_id, choice_text) VALUES (103, 'C. 31/51'); -- 485〇
INSERT INTO choices (question_id, choice_text) VALUES (103, 'D. 46/51'); -- 486


INSERT INTO choices (question_id, choice_text) VALUES (104, 'A. 4/21'); -- 487〇
INSERT INTO choices (question_id, choice_text) VALUES (104, 'B. 1/21'); -- 488
INSERT INTO choices (question_id, choice_text) VALUES (104, 'C. 1/7'); -- 489
INSERT INTO choices (question_id, choice_text) VALUES (104, 'D. 12/35'); -- 490


INSERT INTO choices (question_id, choice_text) VALUES (105, 'A. 1/14'); -- 491
INSERT INTO choices (question_id, choice_text) VALUES (105, 'B. 17/24'); -- 492
INSERT INTO choices (question_id, choice_text) VALUES (105, 'C. 10/21'); -- 493
INSERT INTO choices (question_id, choice_text) VALUES (105, 'D. 7/12'); -- 494〇


INSERT INTO choices (question_id, choice_text) VALUES (106, 'A. 1.5'); -- 495
INSERT INTO choices (question_id, choice_text) VALUES (106, 'B. 1.6'); -- 496〇
INSERT INTO choices (question_id, choice_text) VALUES (106, 'C. 1.7'); -- 497
INSERT INTO choices (question_id, choice_text) VALUES (106, 'D. 1.8'); -- 498


INSERT INTO choices (question_id, choice_text) VALUES (107, 'A. 3時間'); -- 499〇
INSERT INTO choices (question_id, choice_text) VALUES (107, 'B. 4時間'); -- 500
INSERT INTO choices (question_id, choice_text) VALUES (107, 'C. 5時間'); -- 501
INSERT INTO choices (question_id, choice_text) VALUES (107, 'D. 6時間'); -- 502


INSERT INTO choices (question_id, choice_text) VALUES (108, 'A. 5分'); -- 503
INSERT INTO choices (question_id, choice_text) VALUES (108, 'B. 10分'); -- 504
INSERT INTO choices (question_id, choice_text) VALUES (108, 'C. 15分'); -- 505
INSERT INTO choices (question_id, choice_text) VALUES (108, 'D. 20分'); -- 506〇


INSERT INTO choices (question_id, choice_text) VALUES (109, 'A. 3時間'); -- 507
INSERT INTO choices (question_id, choice_text) VALUES (109, 'B. 5時間'); -- 508
INSERT INTO choices (question_id, choice_text) VALUES (109, 'C. 8時間'); -- 509
INSERT INTO choices (question_id, choice_text) VALUES (109, 'D. 10時間'); -- 510〇


INSERT INTO choices (question_id, choice_text) VALUES (110, 'A. 13000円'); -- 511
INSERT INTO choices (question_id, choice_text) VALUES (110, 'B. 15000円'); -- 512
INSERT INTO choices (question_id, choice_text) VALUES (110, 'C. 18000円'); -- 513
INSERT INTO choices (question_id, choice_text) VALUES (110, 'D. 20000円'); -- 514〇


INSERT INTO choices (question_id, choice_text) VALUES (111, 'A. 15分後'); -- 515
INSERT INTO choices (question_id, choice_text) VALUES (111, 'B. 20分後'); -- 516〇
INSERT INTO choices (question_id, choice_text) VALUES (111, 'C. 25分後'); -- 517
INSERT INTO choices (question_id, choice_text) VALUES (111, 'D. 30分後'); -- 518


INSERT INTO choices (question_id, choice_text) VALUES (112, 'A. 5日目'); -- 519〇
INSERT INTO choices (question_id, choice_text) VALUES (112, 'B. 6日目'); -- 520
INSERT INTO choices (question_id, choice_text) VALUES (112, 'C. 7日目'); -- 521
INSERT INTO choices (question_id, choice_text) VALUES (112, 'D. 8日目'); -- 522


INSERT INTO choices (question_id, choice_text) VALUES (113, 'A. 0.3km/時'); -- 523
INSERT INTO choices (question_id, choice_text) VALUES (113, 'B. 18.0km/時'); -- 524〇
INSERT INTO choices (question_id, choice_text) VALUES (113, 'C. 10.5km/時'); -- 525
INSERT INTO choices (question_id, choice_text) VALUES (113, 'D. 12.5km/時'); -- 526


INSERT INTO choices (question_id, choice_text) VALUES (114, 'A. 10.0km/時'); -- 527
INSERT INTO choices (question_id, choice_text) VALUES (114, 'B. 12.0km/時'); -- 528
INSERT INTO choices (question_id, choice_text) VALUES (114, 'C. 12.5km/時'); -- 529
INSERT INTO choices (question_id, choice_text) VALUES (114, 'D. 13.5km/時'); -- 530〇


INSERT INTO choices (question_id, choice_text) VALUES (115, 'A. 12.0km/時'); -- 531
INSERT INTO choices (question_id, choice_text) VALUES (115, 'B. 14.0km/時'); -- 532
INSERT INTO choices (question_id, choice_text) VALUES (115, 'C. 16.0km/時'); -- 533
INSERT INTO choices (question_id, choice_text) VALUES (115, 'D. 18.0km/時'); -- 534〇


INSERT INTO choices (question_id, choice_text) VALUES (116, 'A. 72.0'); -- 535
INSERT INTO choices (question_id, choice_text) VALUES (116, 'B. 128.0'); -- 536
INSERT INTO choices (question_id, choice_text) VALUES (116, 'C. 164.0'); -- 537〇
INSERT INTO choices (question_id, choice_text) VALUES (116, 'D. 218.0'); -- 538


INSERT INTO choices (question_id, choice_text) VALUES (117, 'A. 45km/時'); -- 539
INSERT INTO choices (question_id, choice_text) VALUES (117, 'B. 78km/時'); -- 540
INSERT INTO choices (question_id, choice_text) VALUES (117, 'C. 120km/時'); -- 541
INSERT INTO choices (question_id, choice_text) VALUES (117, 'D. 135km/時'); -- 542〇


INSERT INTO choices (question_id, choice_text) VALUES (118, 'A. 9'); -- 543〇
INSERT INTO choices (question_id, choice_text) VALUES (118, 'B. 10'); -- 544
INSERT INTO choices (question_id, choice_text) VALUES (118, 'C. 11'); -- 545
INSERT INTO choices (question_id, choice_text) VALUES (118, 'D. 12'); -- 546


INSERT INTO choices (question_id, choice_text) VALUES (119, 'A. 6分'); -- 547
INSERT INTO choices (question_id, choice_text) VALUES (119, 'B. 7分'); -- 548
INSERT INTO choices (question_id, choice_text) VALUES (119, 'C. 8分'); -- 549
INSERT INTO choices (question_id, choice_text) VALUES (119, 'D. 9分'); -- 550〇


INSERT INTO choices (question_id, choice_text) VALUES (120, 'A. 12分'); -- 551
INSERT INTO choices (question_id, choice_text) VALUES (120, 'B. 15分'); -- 552〇
INSERT INTO choices (question_id, choice_text) VALUES (120, 'C. 20分'); -- 553
INSERT INTO choices (question_id, choice_text) VALUES (120, 'D. 25分'); -- 554


INSERT INTO choices (question_id, choice_text) VALUES (121, 'A. 12分'); -- 555
INSERT INTO choices (question_id, choice_text) VALUES (121, 'B. 15分'); -- 556〇
INSERT INTO choices (question_id, choice_text) VALUES (121, 'C. 20分'); -- 557
INSERT INTO choices (question_id, choice_text) VALUES (121, 'D. 25分'); -- 558


INSERT INTO choices (question_id, choice_text) VALUES (122, 'A. 12分'); -- 559〇
INSERT INTO choices (question_id, choice_text) VALUES (122, 'B. 15分'); -- 560
INSERT INTO choices (question_id, choice_text) VALUES (122, 'C. 20分'); -- 561
INSERT INTO choices (question_id, choice_text) VALUES (122, 'D. 25分'); -- 562


INSERT INTO choices (question_id, choice_text) VALUES (123, 'A. 34人'); -- 563
INSERT INTO choices (question_id, choice_text) VALUES (123, 'B. 36人'); -- 564
INSERT INTO choices (question_id, choice_text) VALUES (123, 'C. 38人'); -- 565
INSERT INTO choices (question_id, choice_text) VALUES (123, 'D. 40人'); -- 566〇


INSERT INTO choices (question_id, choice_text) VALUES (124, 'A. 70人'); -- 567
INSERT INTO choices (question_id, choice_text) VALUES (124, 'B. 75人'); -- 568〇
INSERT INTO choices (question_id, choice_text) VALUES (124, 'C. 80人'); -- 569
INSERT INTO choices (question_id, choice_text) VALUES (124, 'D. 85人'); -- 570

INSERT INTO choices (question_id, choice_text) VALUES (125, 'A. 51人'); -- 571〇
INSERT INTO choices (question_id, choice_text) VALUES (125, 'B. 53人'); -- 572
INSERT INTO choices (question_id, choice_text) VALUES (125, 'C. 55人'); -- 573
INSERT INTO choices (question_id, choice_text) VALUES (125, 'D. 57人'); -- 574

INSERT INTO choices (question_id, choice_text) VALUES (126, 'A. 6人'); -- 575
INSERT INTO choices (question_id, choice_text) VALUES (126, 'B. 7人'); -- 576
INSERT INTO choices (question_id, choice_text) VALUES (126, 'C. 8人'); -- 577
INSERT INTO choices (question_id, choice_text) VALUES (126, 'D. 9人'); -- 578〇

INSERT INTO choices (question_id, choice_text) VALUES (127, 'A. 50人'); -- 579
INSERT INTO choices (question_id, choice_text) VALUES (127, 'B. 60人'); -- 580
INSERT INTO choices (question_id, choice_text) VALUES (127, 'C. 70人'); -- 581〇
INSERT INTO choices (question_id, choice_text) VALUES (127, 'D. 80人'); -- 582

INSERT INTO choices (question_id, choice_text) VALUES (128, 'A. 5人'); -- 583
INSERT INTO choices (question_id, choice_text) VALUES (128, 'B. 10人'); -- 584〇
INSERT INTO choices (question_id, choice_text) VALUES (128, 'C. 15人'); -- 585
INSERT INTO choices (question_id, choice_text) VALUES (128, 'D. 20人'); -- 586

INSERT INTO choices (question_id, choice_text) VALUES (129, 'A. 10人'); -- 587〇
INSERT INTO choices (question_id, choice_text) VALUES (129, 'B. 11人'); -- 588
INSERT INTO choices (question_id, choice_text) VALUES (129, 'C. 12人'); -- 589
INSERT INTO choices (question_id, choice_text) VALUES (129, 'D. 13人'); -- 590

INSERT INTO choices (question_id, choice_text) VALUES (130, 'A. 13人'); -- 591
INSERT INTO choices (question_id, choice_text) VALUES (130, 'B. 14人'); -- 592
INSERT INTO choices (question_id, choice_text) VALUES (130, 'C. 15人'); -- 593〇
INSERT INTO choices (question_id, choice_text) VALUES (130, 'D. 16人'); -- 594

INSERT INTO choices (question_id, choice_text) VALUES (131, 'A. 30人'); -- 595
INSERT INTO choices (question_id, choice_text) VALUES (131, 'B. 35人'); -- 596〇
INSERT INTO choices (question_id, choice_text) VALUES (131, 'C. 40人'); -- 597
INSERT INTO choices (question_id, choice_text) VALUES (131, 'D. 45人'); -- 598

INSERT INTO choices (question_id, choice_text) VALUES (132, 'A. 135人'); -- 599
INSERT INTO choices (question_id, choice_text) VALUES (132, 'B. 140人'); -- 600
INSERT INTO choices (question_id, choice_text) VALUES (132, 'C. 145人'); -- 601
INSERT INTO choices (question_id, choice_text) VALUES (132, 'D. 150人'); -- 602〇

INSERT INTO choices (question_id, choice_text) VALUES (133, 'A. 38.3%'); -- 603
INSERT INTO choices (question_id, choice_text) VALUES (133, 'B. 42.3%'); -- 604〇
INSERT INTO choices (question_id, choice_text) VALUES (133, 'C. 44.3%'); -- 605
INSERT INTO choices (question_id, choice_text) VALUES (133, 'D. 45.3%'); -- 606

INSERT INTO choices (question_id, choice_text) VALUES (134, 'A. 38.3%'); -- 607
INSERT INTO choices (question_id, choice_text) VALUES (134, 'B. 40.3%'); -- 608
INSERT INTO choices (question_id, choice_text) VALUES (134, 'C. 42.3%'); -- 609〇
INSERT INTO choices (question_id, choice_text) VALUES (134, 'D. 44.3%'); -- 610

INSERT INTO choices (question_id, choice_text) VALUES (135, 'A. 5%'); -- 611
INSERT INTO choices (question_id, choice_text) VALUES (135, 'B. 10%'); -- 612
INSERT INTO choices (question_id, choice_text) VALUES (135, 'C. 15%'); -- 613〇
INSERT INTO choices (question_id, choice_text) VALUES (135, 'D. 20%'); -- 614

INSERT INTO choices (question_id, choice_text) VALUES (136, 'A. 1.4倍'); -- 615
INSERT INTO choices (question_id, choice_text) VALUES (136, 'B. 2.9倍'); -- 616
INSERT INTO choices (question_id, choice_text) VALUES (136, 'C. 7.9倍'); -- 617
INSERT INTO choices (question_id, choice_text) VALUES (136, 'D. 9.4倍'); -- 618〇

INSERT INTO choices (question_id, choice_text) VALUES (137, 'A. 60人'); -- 619〇
INSERT INTO choices (question_id, choice_text) VALUES (137, 'B. 65人'); -- 620
INSERT INTO choices (question_id, choice_text) VALUES (137, 'C. 70人'); -- 621
INSERT INTO choices (question_id, choice_text) VALUES (137, 'D. 75人'); -- 622

INSERT INTO choices (question_id, choice_text) VALUES (138, 'A. 20%'); -- 623
INSERT INTO choices (question_id, choice_text) VALUES (138, 'B. 24%'); -- 624〇
INSERT INTO choices (question_id, choice_text) VALUES (138, 'C. 28%'); -- 625
INSERT INTO choices (question_id, choice_text) VALUES (138, 'D. 32%'); -- 626

INSERT INTO choices (question_id, choice_text) VALUES (139, 'A. 9.0%'); -- 627
INSERT INTO choices (question_id, choice_text) VALUES (139, 'B. 9.1%'); -- 628
INSERT INTO choices (question_id, choice_text) VALUES (139, 'C. 9.2%'); -- 629〇
INSERT INTO choices (question_id, choice_text) VALUES (139, 'D. 9.3%'); -- 630

INSERT INTO choices (question_id, choice_text) VALUES (140, 'A. 377人'); -- 631
INSERT INTO choices (question_id, choice_text) VALUES (140, 'B. 778人'); -- 632
INSERT INTO choices (question_id, choice_text) VALUES (140, 'C. 868人'); -- 633〇
INSERT INTO choices (question_id, choice_text) VALUES (140, 'D. 948人'); -- 634

INSERT INTO choices (question_id, choice_text) VALUES (141, 'A. 10人'); -- 635
INSERT INTO choices (question_id, choice_text) VALUES (141, 'B. 17人'); -- 636
INSERT INTO choices (question_id, choice_text) VALUES (141, 'C. 18人'); -- 637〇
INSERT INTO choices (question_id, choice_text) VALUES (141, 'D. 19人'); -- 638

INSERT INTO choices (question_id, choice_text) VALUES (142, 'A. 1150人'); -- 639〇
INSERT INTO choices (question_id, choice_text) VALUES (142, 'B. 1170人'); -- 640
INSERT INTO choices (question_id, choice_text) VALUES (142, 'C. 1190人'); -- 641
INSERT INTO choices (question_id, choice_text) VALUES (142, 'D. 1210人'); -- 642

INSERT INTO choices (question_id, choice_text) VALUES (143, 'A. 5年後'); -- 643
INSERT INTO choices (question_id, choice_text) VALUES (143, 'B. 12年後'); -- 644
INSERT INTO choices (question_id, choice_text) VALUES (143, 'C. 18年後'); -- 645
INSERT INTO choices (question_id, choice_text) VALUES (143, 'D. 24年後'); -- 646〇

INSERT INTO choices (question_id, choice_text) VALUES (144, 'A. 0個'); -- 647
INSERT INTO choices (question_id, choice_text) VALUES (144, 'B. 1個'); -- 648〇
INSERT INTO choices (question_id, choice_text) VALUES (144, 'C. 2個'); -- 649
INSERT INTO choices (question_id, choice_text) VALUES (144, 'D. 3個'); -- 650

INSERT INTO choices (question_id, choice_text) VALUES (145, 'A. 200個'); -- 651〇
INSERT INTO choices (question_id, choice_text) VALUES (145, 'B. 300個'); -- 652
INSERT INTO choices (question_id, choice_text) VALUES (145, 'C. 400個'); -- 653
INSERT INTO choices (question_id, choice_text) VALUES (145, 'D. 600個'); -- 654

INSERT INTO choices (question_id, choice_text) VALUES (146, 'A. 5個'); -- 655
INSERT INTO choices (question_id, choice_text) VALUES (146, 'B. 6個'); -- 656
INSERT INTO choices (question_id, choice_text) VALUES (146, 'C. 7個'); -- 657
INSERT INTO choices (question_id, choice_text) VALUES (146, 'D. 8個'); -- 658〇

INSERT INTO choices (question_id, choice_text) VALUES (147, 'A. 1枚'); -- 659
INSERT INTO choices (question_id, choice_text) VALUES (147, 'B. 2枚'); -- 660〇
INSERT INTO choices (question_id, choice_text) VALUES (147, 'C. 3枚'); -- 661
INSERT INTO choices (question_id, choice_text) VALUES (147, 'D. 4枚'); -- 662

INSERT INTO choices (question_id, choice_text) VALUES (148, 'A. 1個'); -- 663
INSERT INTO choices (question_id, choice_text) VALUES (148, 'B. 3個'); -- 664
INSERT INTO choices (question_id, choice_text) VALUES (148, 'C. 5個'); -- 665〇
INSERT INTO choices (question_id, choice_text) VALUES (148, 'D. 7個'); -- 666

INSERT INTO choices (question_id, choice_text) VALUES (149, 'A. 2年後'); -- 667
INSERT INTO choices (question_id, choice_text) VALUES (149, 'B. 4年後'); -- 668〇
INSERT INTO choices (question_id, choice_text) VALUES (149, 'C. 8年後'); -- 669
INSERT INTO choices (question_id, choice_text) VALUES (149, 'D. 12年後'); -- 670

INSERT INTO choices (question_id, choice_text) VALUES (150, 'A. 18本'); -- 671
INSERT INTO choices (question_id, choice_text) VALUES (150, 'B. 19本'); -- 672
INSERT INTO choices (question_id, choice_text) VALUES (150, 'C. 20本'); -- 673〇
INSERT INTO choices (question_id, choice_text) VALUES (150, 'D. 21本'); -- 674

INSERT INTO choices (question_id, choice_text) VALUES (151, 'A. 38本'); -- 675
INSERT INTO choices (question_id, choice_text) VALUES (151, 'B. 39本'); -- 676
INSERT INTO choices (question_id, choice_text) VALUES (151, 'C. 40本'); -- 677
INSERT INTO choices (question_id, choice_text) VALUES (151, 'D. 41本'); -- 678〇

INSERT INTO choices (question_id, choice_text) VALUES (152, 'A. 50人'); -- 679
INSERT INTO choices (question_id, choice_text) VALUES (152, 'B. 55人'); -- 680
INSERT INTO choices (question_id, choice_text) VALUES (152, 'C. 65人'); -- 681
INSERT INTO choices (question_id, choice_text) VALUES (152, 'D. 80人'); -- 682〇
-- 正解と解説を挿入
-- 正解の番号が違うので後で修正
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (1, 5, '1_1_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (2, 8, '1_1_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (3, 13, '1_1_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (4, 20, '1_1_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (5, 26, '1_1_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (6, 32, '1_1_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (7, 40, '1_1_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (8, 45, '1_1_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (9, 47, '1_1_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (10, 55, '1_1_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (11, 59, '1_2_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (12, 61, '1_2_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (13, 70, '1_2_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (14, 74, '1_2_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (15, 80, '1_2_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (16, 81, '1_2_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (17, 86, '1_2_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (18, 93, '1_2_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (19, 100, '1_2_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (20, 105, '1_2_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (21, 108, '1_2_11');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (22, 115, '1_2_12');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (23, 119, '1_3_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (24, 121, '1_3_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (25, 127, '1_3_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (26, 133, '1_3_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (27, 136, '1_3_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (28, 145, '1_3_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (29, 149, '1_3_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (30, 153, '1_3_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (31, 157, '1_3_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (32, 165, '1_3_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (33, 170, '1_4_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (34, 171, '1_4_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (35, 176, '1_4_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (36, 181, '1_4_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (37, 188, '1_4_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (38, 191, '1_4_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (39, 196, '1_4_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (40, 201, '1_4_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (41, 207, '1_4_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (42, 214, '1_4_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (43, 219, '1_5_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (44, 221, '1_5_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (45, 230, '1_5_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (46, 232, '1_5_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (47, 239, '1_5_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (48, 244, '1_5_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (49, 246, '1_5_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (50, 254, '1_5_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (51, 256, '1_5_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (52, 262, '1_5_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (53, 269, '2_1_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (54, 273, '2_1_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (55, 279, '2_1_3'); 
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (56, 282, '2_1_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (57, 287, '2_1_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (58, 292, '2_1_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (59, 298, '2_1_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (60, 304, '2_1_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (61, 306, '2_1_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (62, 310, '2_1_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (63, 317, '2_2_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (64, 320, '2_2_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (65, 326, '2_2_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (66, 328 ,'2_2_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (67, 336, '2_2_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (68, 340, '2_2_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (69, 344, '2_2_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (70, 350, '2_2_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (71, 354, '2_2_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (72, 360, '2_2_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (73, 362, '2_3_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (74, 368, '2_3_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (75, 370, '2_3_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (76, 373, '2_3_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (77, 380, '2_3_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (78, 384, '2_3_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (79, 385, '2_3_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (80, 392, '2_3_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (81, 395, '2_3_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (82, 399, '2_3_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (83, 403, '2_4_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (84, 408, '2_4_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (85, 410, '2_4_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (86, 416, '2_4_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (87, 420, '2_4_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (88, 421, '2_4_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (89, 427, '2_4_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (90, 430, '2_4_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (91, 435, '2_4_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (92, 437, '2_4_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (93, 442, '2_5_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (94, 448, '2_5_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (95, 453, '2_5_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (96, 457, '2_5_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (97, 461, '2_5_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (98, 466, '2_5_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (99, 467, '2_5_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (100, 472, '2_5_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (101, 475, '2_5_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (102, 480, '2_5_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (103, 485, '2_6_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (104, 487, '2_6_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (105, 494, '2_6_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (106, 496, '2_6_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (107, 499, '2_6_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (108, 506, '2_6_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (109, 510, '2_6_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (110, 514, '2_6_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (111, 516, '2_6_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (112, 519, '2_6_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (113, 524, '2_7_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (114, 530, '2_7_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (115, 534, '2_7_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (116, 537, '2_7_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (117, 542, '2_7_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (118, 543, '2_7_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (119, 550, '2_7_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (120, 552, '2_7_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (121, 556, '2_7_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (122, 559, '2_7_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (123, 566, '2_8_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (124, 568, '2_8_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (125, 571, '2_8_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (126, 578, '2_8_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (127, 581, '2_8_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (128, 584, '2_8_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (129, 587, '2_8_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (130, 593, '2_8_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (131, 596, '2_8_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (132, 602, '2_8_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (133, 604, '2_9_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (134, 609, '2_9_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (135, 613, '2_9_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (136, 618, '2_9_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (137, 619, '2_9_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (138, 624, '2_9_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (139, 629, '2_9_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (140, 633, '2_9_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (141, 637, '2_9_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (142, 639, '2_9_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (143, 646, '2_10_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (144, 648, '2_10_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (145, 651, '2_10_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (146, 658, '2_10_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (147, 660, '2_10_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (148, 665, '2_10_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (149, 668, '2_10_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (150, 673, '2_10_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (151, 678, '2_10_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (152, 682, '2_10_10');

