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
    correct_choice_id INT,
    explanation TEXT NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE
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
    badge_file TEXT NOT NULL -- バッジの画像
);

DROP TABLE IF EXISTS owned_badge;
CREATE TABLE owned_badge (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userid int(255) NOT NULL ,    
    badge_id INT NOT NULL
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
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (11,1,1,30,'二語の関係','1_1_11','才能：画才');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (12,1,1,30,'二語の関係','1_1_12','作家：執筆');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (13,1,1,30,'二語の関係','1_1_13','野球：スポーツ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (14,1,1,30,'二語の関係','1_1_14','チョコレート：カカオ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (15,1,1,30,'二語の関係','1_1_15','植物：すみれ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (16,1,1,30,'二語の関係','1_1_16','芸術：音楽');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (17,1,1,30,'二語の関係','1_1_17','医者：診察');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (18,1,1,30,'二語の関係','1_1_18','類似：相違');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (19,1,1,30,'二語の関係','1_1_19','両生類：蛙');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (20,1,1,30,'二語の関係','1_1_20','定規：計測');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (21,1,2,30,'熟語の意味','1_2_1','はかりごとをめぐらして');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (22,1,2,30,'熟語の意味','1_2_2','いみじくも');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (23,1,2,30,'熟語の意味','1_2_3','妨げが多くて、物事');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (24,1,2,30,'熟語の意味','1_2_4','上の人に対して意見');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (25,1,2,30,'熟語の意味','1_2_5','うわべをじょうずに');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (26,1,2,30,'熟語の意味','1_2_6','一流の人をまねるだけ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (27,1,2,30,'熟語の意味','1_2_7','古くさくてありふれた');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (28,1,2,30,'熟語の意味','1_2_8','事件や問題などの間');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (29,1,2,30,'熟語の意味','1_2_9','それぞれのよいところ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (30,1,2,30,'熟語の意味','1_2_10','自慢げに見せること');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (31,1,2,30,'熟語の意味','1_2_11','その時々に応じた');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (32,1,2,30,'熟語の意味','1_2_12','しつこく、ねばり強いこと');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (33,1,2,30,'熟語の意味','1_2_13','言葉や態度が不明瞭で、はっきりしないこと');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (34,1,2,30,'熟語の意味','1_2_14','他人の弱みや欠点を巧みに攻撃すること');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (35,1,2,30,'熟語の意味','1_2_15','ひとつの物事にこだわり');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (36,1,2,30,'熟語の意味','1_2_16','表面は平静を装いながら');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (37,1,2,30,'熟語の意味','1_2_17','相手を手厳しく叱りつけること');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (38,1,2,30,'熟語の意味','1_2_18','全体を見渡すことができるほど視界が広がること');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (39,1,2,30,'熟語の意味','1_2_19','何事にも動じず、冷静に対処する性質');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (40,1,2,30,'熟語の意味','1_2_20','自分の立場や利益を守るため');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (41,1,3,30,'語句の用法','1_3_1','自分が「先」に立って歩く');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (42,1,3,30,'語句の用法','1_3_2','怪しい「空」模様');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (43,1,3,30,'語句の用法','1_3_3','彼は医者「と」なった');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (44,1,3,30,'語句の用法','1_3_4','電話を「きる」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (45,1,3,30,'語句の用法','1_3_5','バス「で」行く');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (46,1,3,30,'語句の用法','1_3_6','消費者の「目」が肥えてきた');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (47,1,3,30,'語句の用法','1_3_7','知り合いから頼ま「れる」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (48,1,3,30,'語句の用法','1_3_8','母「の」でよければお使いください');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (49,1,3,30,'語句の用法','1_3_9','食卓に「のぼる」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (50,1,3,30,'語句の用法','1_3_10','一人で行く「そうだ」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (51,1,3,30,'語句の用法','1_3_11','はさみ「で」切る');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (52,1,3,30,'語句の用法','1_3_12','絵画に「目」が利く');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (53,1,3,30,'語句の用法','1_3_13','とても信じら「れる」ことではない');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (54,1,3,30,'語句の用法','1_3_14','桜を「かんしょう」する');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (55,1,3,30,'語句の用法','1_3_15','彼の「腹」が分からない');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (56,1,3,30,'語句の用法','1_3_16','気体が液体「に」なる');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (57,1,3,30,'語句の用法','1_3_17','己をもって人を「はかる」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (58,1,3,30,'語句の用法','1_3_18','「味」を占める');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (59,1,3,30,'語句の用法','1_3_19','彼は努力家だった「そうだ」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (60,1,3,30,'語句の用法','1_3_20','「手」を抜く');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (61,1,4,30,'文章整序','1_4_1','動物倫理は');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (62,1,4,30,'文章整序','1_4_2','現代では');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (63,1,4,30,'文章整序','1_4_3','ウイルスと細菌は');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (64,1,4,30,'文章整序','1_4_4','日本においては');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (65,1,4,30,'文章整序','1_4_5','在宅医療は');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (66,1,4,30,'文章整序','1_4_6','気体をさらに');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (67,1,4,30,'文章整序','1_4_7','科学雑誌や映画や');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (68,1,4,30,'文章整序','1_4_8','職場の仕事の');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (69,1,4,30,'文章整序','1_4_9','国会は憲法により');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (70,1,4,30,'文章整序','1_4_10','第二次世界大戦後の');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (71,1,4,30,'文章整序','1_4_11','フェイクニュースとは');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (72,1,4,30,'文章整序','1_4_12','ア　遺伝子の働きによりインスリン');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (73,1,4,30,'文章整序','1_4_13','脳のどの部分が活動したのか');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (74,1,4,30,'文章整序','1_4_14','最近のレインコート');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (75,1,4,30,'文章整序','1_4_15','ア　また、歯や歯茎の状態');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (76,1,4,30,'文章整序','1_4_16','ア　彼は新しいプロジェクト');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (77,1,4,30,'文章整序','1_4_17','ア　以後、藤原氏の氏寺として栄え');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (78,1,4,30,'文章整序','1_4_18','ア　特に近年では、AI');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (79,1,4,30,'文章整序','1_4_19','ア　その謎を解明する鍵');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (80,1,4,30,'文章整序','1_4_20','ア　舞台に立ち');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (81,1,5,30,'空欄補充','1_5_1','ひとつは自らの内側にある[]だ。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (82,1,5,30,'空欄補充','1_5_2','[]になって反論する');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (83,1,5,30,'空欄補充','1_5_3','[]を呑んで見守る');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (84,1,5,30,'空欄補充','1_5_4','部下を[]にかけて育てる');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (85,1,5,30,'空欄補充','1_5_5','感涙に[]。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (86,1,5,30,'空欄補充','1_5_6','[]にもかかわらず、注意や努力が足りず');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (87,1,5,30,'空欄補充','1_5_7','ビジネスにおいて、[]思考は身につけるべき重要なスキル');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (88,1,5,30,'空欄補充','1_5_8','歌手の[]にも置けない');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (89,1,5,30,'空欄補充','1_5_9','いよいよ作業に[]を入れる');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (90,1,5,30,'空欄補充','1_5_10','油断していると,[] 失敗しそうだ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (91,1,5,30,'空欄補充','1_5_11','学校教員の仕事は授業以外にも');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (92,1,5,30,'空欄補充','1_5_12','めきめきと[]をあらわす');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (93,1,5,30,'空欄補充','1_5_13','彼と私では[]の差だ。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (94,1,5,30,'空欄補充','1_5_14','社長が[]を押す。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (95,1,5,30,'空欄補充','1_5_15','熊は[]獲物に飛びかかった。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (96,1,5,30,'空欄補充','1_5_16','紀元前3世紀初めにゼノン');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (97,1,5,30,'空欄補充','1_5_17','私たちの「運命への関心」');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (98,1,5,30,'空欄補充','1_5_18','多くの論者が指摘しているよう');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (99,1,5,30,'空欄補充','1_5_19','今年の夏は特に（　１　）が厳しく');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (100,1,5,30,'空欄補充','1_5_20','新しい（　１　）の建設が発表された際');


-- 非言語問題
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (101,2,1,30,'場合の数','2_1_1','男子8人、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (102,2,1,30,'場合の数','2_1_2','ゼミのメンバー7人が');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (103,2,1,30,'場合の数','2_1_3','ゼミのメンバー10人が');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (104,2,1,30,'場合の数','2_1_4','テニス部の３年生には、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (105,2,1,30,'場合の数','2_1_5','1、2、3、4、5の5つから');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (106,2,1,30,'場合の数','2_1_6','コイントスを5回行った。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (107,2,1,30,'場合の数','2_1_7','2つのサイコロP');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (108,2,1,30,'場合の数','2_1_8','数字の1、2、3を使って');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (109,2,1,30,'場合の数','2_1_9','倉庫には白と黒のボール');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (110,2,1,30,'場合の数','2_1_10','大きいボール、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (111,2,2,30,'推論','2_2_1','7枚のカードに1〜7の数字が');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (112,2,2,30,'推論','2_2_2','PQRSの4人チームで');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (113,2,2,30,'推論','2_2_3','以下の表に、P、Q、Rの3つの学校'); -- 要修正
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (114,2,2,30,'推論','2_2_4','ある高校の学生180人の');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (115,2,2,30,'推論','2_2_5','1個150円のパンと1個100円のおにぎり');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (116,2,2,30,'推論','2_2_6','A~Eの5人が50m走を行った結果、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (117,2,2,30,'推論','2_2_7','A,B,C,D,E,Fの6人で');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (118,2,2,30,'推論','2_2_8','P,Q,R,Sの4人がある試験を受けた。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (119,2,2,30,'推論','2_2_9','P、Q、R、Sの4人が100点満点');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (120,2,2,30,'推論','2_2_10','ア、イ、ウ、エの4人が剣道で');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (121,2,3,30,'割合','2_3_1','ある高校では全校生徒の80%が');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (122,2,3,30,'割合','2_3_2','ある高校で、大学へ進学する人は');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (123,2,3,30,'割合','2_3_3','薬品AとBを2:3で混ぜた混合液Xと、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (124,2,3,30,'割合','2_3_4','ある高校で出身中学校の調査をしたところ、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (125,2,3,30,'割合','2_3_5','ある高校で自転車通学している');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (126,2,3,30,'割合','2_3_6',' ある人がSPIの問題集を購入し');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (127,2,3,30,'割合','2_3_7','ある町で、60%の世帯が農家である。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (128,2,3,30,'割合','2_3_8','ある大学の「SPI対策」という');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (129,2,3,30,'割合','2_3_9','ある高校で、全生徒の90%が');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (130,2,3,30,'割合','2_3_10','ある会社のA支店、B支店、C支店の');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (131,2,4,30,'確率','2_4_1','1P、Qを含む5人が買い物に出かける。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (132,2,4,30,'確率','2_4_2','ハートの1から13まで、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (133,2,4,30,'確率','2_4_3','2つの講演会P、Qの参加者の抽選をした。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (134,2,4,30,'確率','2_4_4','ある飲食店の従業員は20人であり、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (135,2,4,30,'確率','2_4_5','10円玉が3枚、5円玉が3枚ある。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (136,2,4,30,'確率','2_4_6','XとYがゲームをする。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (137,2,4,30,'確率','2_4_7','1〜7までの数字が書かれた');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (138,2,4,30,'確率','2_4_8','赤玉3個、白玉5個、黄玉2個が');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (139,2,4,30,'確率','2_4_9','AとBの2人が資格試験');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (140,2,4,30,'確率','2_4_10','ある人がダーツを行っている。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (141,2,5,30,'金額計算','2_5_1','X、Y、Zの3人で、Pのお祝い');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (142,2,5,30,'金額計算','2_5_2','あるカフェでは2時間以上利用すると');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (143,2,5,30,'金額計算','2_5_3','1個の原価が500円の商品を300個仕入れて、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (144,2,5,30,'金額計算','2_5_4','P、Q、Rの3人が5000円ずつ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (145,2,5,30,'金額計算','2_5_5','P、Q、Rの3人が居酒屋でお酒とラーメンを');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (146,2,5,30,'金額計算','2_5_6','あるコートは、9時から23時まで');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (147,2,5,30,'金額計算','2_5_7','あるスーパー銭湯の入浴券は600円である。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (148,2,5,30,'金額計算','2_5_8','あるビデオ屋では、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (149,2,5,30,'金額計算','2_5_9','美術館に行く際、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (150,2,5,30,'金額計算','2_5_10','原価100円の商品を200個仕入れた。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (151,2,6,30,'分担計算','2_6_1','代金を数回に分けて支払う');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (152,2,6,30,'分担計算','2_6_2','購入で分割払いをすることにした。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (153,2,6,30,'分担計算','2_6_3','ある人は3日間かけて資料整理する。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (154,2,6,30,'分担計算','2_6_4','ある仕事をP、Q、Rの3人で分担した。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (155,2,6,30,'分担計算','2_6_5','排水ポンプX、Yと、給水ポンプP、Qがある。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (156,2,6,30,'分担計算','2_6_6','英語と数学の宿題。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (157,2,6,30,'分担計算','2_6_7','ある予備校のテスト採点は、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (158,2,6,30,'分担計算','2_6_8','今年1年間はお小遣いを毎月1万円');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (159,2,6,30,'分担計算','2_6_9','国語と数学の宿題があります。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (160,2,6,30,'分担計算','2_6_10','ある書類の処理を全て終わらせるのに、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (161,2,7,30,'速度算','2_7_1','各チーム8人で競う駅伝、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (162,2,7,30,'速度算','2_7_2','各チーム8人で競う駅伝が行われた。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (163,2,7,30,'速度算','2_7_3','各チーム8人で競う駅伝が行われた。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (164,2,7,30,'速度算','2_7_4','列車PはS駅からV駅に向かい、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (165,2,7,30,'速度算','2_7_5','列車PはS駅からV駅に向かい、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (166,2,7,30,'速度算','2_7_6','Pは普段、自宅から学校まで');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (167,2,7,30,'速度算','2_7_7','ある公園の外周は2kmである。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (168,2,7,30,'速度算','2_7_8','P及びQの歩くスピードは、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (169,2,7,30,'速度算','2_7_9','子は2.4km/時、母は3.2km/時で歩くものとする。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (170,2,7,30,'速度算','2_7_10','1周1.6kmのウォーキングコースがある。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (171,2,8,30,'集合','2_8_1','ある出版社が購読者100人を対象に、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (172,2,8,30,'集合','2_8_2','中学生120人に野球、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (173,2,8,30,'集合','2_8_3','犬を飼っているか、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (174,2,8,30,'集合','2_8_4','クラス41人に対して、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (175,2,8,30,'集合','2_8_5','中学生120人に野球、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (176,2,8,30,'集合','2_8_6','会社の社員300人に調査を行ったところ、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (177,2,8,30,'集合','2_8_7','朝食にお茶を飲むか牛乳を飲むか、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (178,2,8,30,'集合','2_8_8','部活のメンバー46人のうち、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (179,2,8,30,'集合','2_8_9','大学生200人を対象に、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (180,2,8,30,'集合','2_8_10','小学生180人に対し、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (181,2,9,30,'表の読み取り','2_9_1','表は、ある年の日本、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (182,2,9,30,'表の読み取り','2_9_2','4種類の食品に含まれる栄養素');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (183,2,9,30,'表の読み取り','2_9_3','あるイベント会社が会場');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (184,2,9,30,'表の読み取り','2_9_4','この表は山形、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (185,2,9,30,'表の読み取り','2_9_5','20代、30代、40代それぞれ');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (186,2,9,30,'表の読み取り','2_9_6','ショッピングセンターA、B');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (187,2,9,30,'表の読み取り','2_9_7','ある年の2月、7月、12月における');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (188,2,9,30,'表の読み取り','2_9_8','ある電車はA駅を出発して、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (189,2,9,30,'表の読み取り','2_9_9','A駅で乗車し、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (190,2,9,30,'表の読み取り','2_9_10','飲食店Aの利用者に対して');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (191,2,10,30,'特殊計算','2_10_1','ある親子は今、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (192,2,10,30,'特殊計算','2_10_2','4種類のお菓子がある。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (193,2,10,30,'特殊計算','2_10_3','100円の商品と125円の商品');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (194,2,10,30,'特殊計算','2_10_4','商品詰め合わせを作ることにした。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (195,2,10,30,'特殊計算','2_10_5','10円、50円、100円、500円の4種類');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (196,2,10,30,'特殊計算','2_10_6','300円と200円の2種類');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (197,2,10,30,'特殊計算','2_10_7','ある家庭の父親は現在38歳で、');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (198,2,10,30,'特殊計算','2_10_8','円形の花壇に円状に花を植える。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (199,2,10,30,'特殊計算','2_10_9','まっすぐの花壇に花を並べて植える。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (200,2,10,30,'特殊計算','2_10_10','ある自動車学校には105人生徒がいる。');




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

INSERT INTO choices (question_id, choice_text) VALUES (11, 'A.ア'); -- 56
INSERT INTO choices (question_id, choice_text) VALUES (11, 'B.イ'); -- 57〇
INSERT INTO choices (question_id, choice_text) VALUES (11, 'C.ウ'); -- 58
INSERT INTO choices (question_id, choice_text) VALUES (11, 'D.アとイ'); -- 59
INSERT INTO choices (question_id, choice_text) VALUES (11, 'E.アとウ'); -- 60
INSERT INTO choices (question_id, choice_text) VALUES (11, 'F.イとウ'); -- 61

INSERT INTO choices (question_id, choice_text) VALUES (12, 'A.ア'); -- 62
INSERT INTO choices (question_id, choice_text) VALUES (12, 'B.イ'); -- 63
INSERT INTO choices (question_id, choice_text) VALUES (12, 'C.ウ'); -- 64
INSERT INTO choices (question_id, choice_text) VALUES (12, 'D.アとイ'); -- 65
INSERT INTO choices (question_id, choice_text) VALUES (12, 'E.アとウ'); -- 66
INSERT INTO choices (question_id, choice_text) VALUES (12, 'F.イとウ'); -- 67〇

INSERT INTO choices (question_id, choice_text) VALUES (13, 'A.文房具'); -- 68〇
INSERT INTO choices (question_id, choice_text) VALUES (13, 'B.学校'); -- 69
INSERT INTO choices (question_id, choice_text) VALUES (13, 'C.消しゴム'); -- 70
INSERT INTO choices (question_id, choice_text) VALUES (13, 'D.筆記'); -- 71
INSERT INTO choices (question_id, choice_text) VALUES (13, 'E.ボールペン'); -- 72

INSERT INTO choices (question_id, choice_text) VALUES (14, 'A.調理'); -- 73
INSERT INTO choices (question_id, choice_text) VALUES (14, 'B.練り製品'); -- 74
INSERT INTO choices (question_id, choice_text) VALUES (14, 'C.魚'); -- 75〇
INSERT INTO choices (question_id, choice_text) VALUES (14, 'D.ちくわ'); -- 76
INSERT INTO choices (question_id, choice_text) VALUES (14, 'E.まな板'); -- 77

INSERT INTO choices (question_id, choice_text) VALUES (15, 'A.ア'); -- 78
INSERT INTO choices (question_id, choice_text) VALUES (15, 'B.イ'); -- 79
INSERT INTO choices (question_id, choice_text) VALUES (15, 'C.ウ'); -- 80
INSERT INTO choices (question_id, choice_text) VALUES (15, 'D.アとイ'); -- 81
INSERT INTO choices (question_id, choice_text) VALUES (15, 'E.アとウ'); -- 82〇
INSERT INTO choices (question_id, choice_text) VALUES (15, 'F.イとウ'); -- 83

INSERT INTO choices (question_id, choice_text) VALUES (16, 'A.ア'); -- 84
INSERT INTO choices (question_id, choice_text) VALUES (16, 'B.イ'); -- 85
INSERT INTO choices (question_id, choice_text) VALUES (16, 'C.ウ'); -- 86
INSERT INTO choices (question_id, choice_text) VALUES (16, 'D.アとイ'); -- 87
INSERT INTO choices (question_id, choice_text) VALUES (16, 'E.アとウ'); -- 88〇
INSERT INTO choices (question_id, choice_text) VALUES (16, 'F.イとウ'); -- 89

INSERT INTO choices (question_id, choice_text) VALUES (17, 'A.握手'); -- 90
INSERT INTO choices (question_id, choice_text) VALUES (17, 'B.舞台'); -- 91
INSERT INTO choices (question_id, choice_text) VALUES (17, 'C.演技'); -- 92〇
INSERT INTO choices (question_id, choice_text) VALUES (17, 'D.テレビ'); -- 93
INSERT INTO choices (question_id, choice_text) VALUES (17, 'E.写真'); -- 94

INSERT INTO choices (question_id, choice_text) VALUES (18, 'A.一般'); -- 95
INSERT INTO choices (question_id, choice_text) VALUES (18, 'B.抽象'); -- 96
INSERT INTO choices (question_id, choice_text) VALUES (18, 'C.散財'); -- 97
INSERT INTO choices (question_id, choice_text) VALUES (18, 'D.概略'); -- 98
INSERT INTO choices (question_id, choice_text) VALUES (18, 'E.演繹'); -- 99〇

INSERT INTO choices (question_id, choice_text) VALUES (19, 'A.ア'); -- 100
INSERT INTO choices (question_id, choice_text) VALUES (19, 'B.イ'); -- 101
INSERT INTO choices (question_id, choice_text) VALUES (19, 'C.ウ'); -- 102
INSERT INTO choices (question_id, choice_text) VALUES (19, 'D.アとイ'); -- 103〇
INSERT INTO choices (question_id, choice_text) VALUES (19, 'E.アとウ'); -- 104
INSERT INTO choices (question_id, choice_text) VALUES (19, 'F.イとウ'); -- 105

INSERT INTO choices (question_id, choice_text) VALUES (20, 'A.ア'); -- 106
INSERT INTO choices (question_id, choice_text) VALUES (20, 'B.イ'); -- 107
INSERT INTO choices (question_id, choice_text) VALUES (20, 'C.ウ'); -- 108〇
INSERT INTO choices (question_id, choice_text) VALUES (20, 'D.アとイ'); -- 109
INSERT INTO choices (question_id, choice_text) VALUES (20, 'E.アとウ'); -- 110
INSERT INTO choices (question_id, choice_text) VALUES (20, 'F.イとウ'); -- 111

INSERT INTO choices (question_id, choice_text) VALUES (21, 'A.遂行'); -- 112
INSERT INTO choices (question_id, choice_text) VALUES (21, 'B.発案'); -- 113
INSERT INTO choices (question_id, choice_text) VALUES (21, 'C.策略'); -- 114
INSERT INTO choices (question_id, choice_text) VALUES (21, 'D.画策'); -- 115〇
INSERT INTO choices (question_id, choice_text) VALUES (21, 'E.考案'); -- 116

INSERT INTO choices (question_id, choice_text) VALUES (22, 'A.適切に'); -- 117〇
INSERT INTO choices (question_id, choice_text) VALUES (22, 'B.けなげにも'); -- 118
INSERT INTO choices (question_id, choice_text) VALUES (22, 'C.理路整然と'); -- 119
INSERT INTO choices (question_id, choice_text) VALUES (22, 'D.きっぱりと'); -- 120
INSERT INTO choices (question_id, choice_text) VALUES (22, 'E.突然に'); -- 121

INSERT INTO choices (question_id, choice_text) VALUES (23, 'A.困難'); -- 122
INSERT INTO choices (question_id, choice_text) VALUES (23, 'B.逆境'); -- 123
INSERT INTO choices (question_id, choice_text) VALUES (23, 'C.渋滞'); -- 124
INSERT INTO choices (question_id, choice_text) VALUES (23, 'D.遅延'); -- 125
INSERT INTO choices (question_id, choice_text) VALUES (23, 'E.難航'); -- 126〇

INSERT INTO choices (question_id, choice_text) VALUES (24, 'A.甘言'); -- 127
INSERT INTO choices (question_id, choice_text) VALUES (24, 'B.過言'); -- 128
INSERT INTO choices (question_id, choice_text) VALUES (24, 'C.提言'); -- 129
INSERT INTO choices (question_id, choice_text) VALUES (24, 'D.進言'); -- 130〇
INSERT INTO choices (question_id, choice_text) VALUES (24, 'E.直言'); -- 131

INSERT INTO choices (question_id, choice_text) VALUES (25, 'A.たやすく'); -- 132
INSERT INTO choices (question_id, choice_text) VALUES (25, 'B.そっけなく'); -- 133
INSERT INTO choices (question_id, choice_text) VALUES (25, 'C.すばやく'); -- 134
INSERT INTO choices (question_id, choice_text) VALUES (25, 'D.急激に'); -- 135
INSERT INTO choices (question_id, choice_text) VALUES (25, 'E.なだらかに'); -- 136〇

INSERT INTO choices (question_id, choice_text) VALUES (26, 'A.亜流'); -- 137〇
INSERT INTO choices (question_id, choice_text) VALUES (26, 'B.二流'); -- 138
INSERT INTO choices (question_id, choice_text) VALUES (26, 'C.正統'); -- 139
INSERT INTO choices (question_id, choice_text) VALUES (26, 'D.骨董'); -- 140
INSERT INTO choices (question_id, choice_text) VALUES (26, 'E.質素'); -- 141

INSERT INTO choices (question_id, choice_text) VALUES (27, 'A.陳腐'); -- 142〇
INSERT INTO choices (question_id, choice_text) VALUES (27, 'B.古来'); -- 143
INSERT INTO choices (question_id, choice_text) VALUES (27, 'C.卑小'); -- 144
INSERT INTO choices (question_id, choice_text) VALUES (27, 'D.旧式'); -- 145
INSERT INTO choices (question_id, choice_text) VALUES (27, 'E.常套（とう）'); -- 146

INSERT INTO choices (question_id, choice_text) VALUES (28, 'A.仲介'); -- 147
INSERT INTO choices (question_id, choice_text) VALUES (28, 'B.潜入'); -- 148
INSERT INTO choices (question_id, choice_text) VALUES (28, 'C.介入'); -- 149〇
INSERT INTO choices (question_id, choice_text) VALUES (28, 'D.調停'); -- 150
INSERT INTO choices (question_id, choice_text) VALUES (28, 'E.関与'); -- 151

INSERT INTO choices (question_id, choice_text) VALUES (29, 'A.混合'); -- 152
INSERT INTO choices (question_id, choice_text) VALUES (29, 'B.合同'); -- 153
INSERT INTO choices (question_id, choice_text) VALUES (29, 'C.折半'); -- 154
INSERT INTO choices (question_id, choice_text) VALUES (29, 'D.併合'); -- 155
INSERT INTO choices (question_id, choice_text) VALUES (29, 'E.折衷'); -- 156〇

INSERT INTO choices (question_id, choice_text) VALUES (30, 'A.高慢'); -- 157
INSERT INTO choices (question_id, choice_text) VALUES (30, 'B.披露'); -- 158
INSERT INTO choices (question_id, choice_text) VALUES (30, 'C.優越'); -- 159
INSERT INTO choices (question_id, choice_text) VALUES (30, 'D.披瀝（れき）'); -- 160
INSERT INTO choices (question_id, choice_text) VALUES (30, 'E.誇示'); -- 161〇

INSERT INTO choices (question_id, choice_text) VALUES (31, 'A.策謀'); -- 162
INSERT INTO choices (question_id, choice_text) VALUES (31, 'B.策定'); -- 163
INSERT INTO choices (question_id, choice_text) VALUES (31, 'C.機略'); -- 164〇
INSERT INTO choices (question_id, choice_text) VALUES (31, 'D.陰謀'); -- 165
INSERT INTO choices (question_id, choice_text) VALUES (31, 'E.策略'); -- 166

INSERT INTO choices (question_id, choice_text) VALUES (32, 'A.根気'); -- 167
INSERT INTO choices (question_id, choice_text) VALUES (32, 'B.粘着'); -- 168
INSERT INTO choices (question_id, choice_text) VALUES (32, 'C.偏屈'); -- 169
INSERT INTO choices (question_id, choice_text) VALUES (32, 'D.辛抱'); -- 170
INSERT INTO choices (question_id, choice_text) VALUES (32, 'E.執拗（よう）'); -- 171〇

INSERT INTO choices (question_id, choice_text) VALUES (33, 'A.晦渋'); -- 172〇
INSERT INTO choices (question_id, choice_text) VALUES (33, 'B.曖昧'); -- 173
INSERT INTO choices (question_id, choice_text) VALUES (33, 'C.含蓄'); -- 174
INSERT INTO choices (question_id, choice_text) VALUES (33, 'D.模糊'); -- 175

INSERT INTO choices (question_id, choice_text) VALUES (34, 'A.皮肉'); -- 176
INSERT INTO choices (question_id, choice_text) VALUES (34, 'B.辛辣'); -- 177
INSERT INTO choices (question_id, choice_text) VALUES (34, 'C.揶揄'); -- 178〇
INSERT INTO choices (question_id, choice_text) VALUES (34, 'D.呵責'); -- 179

INSERT INTO choices (question_id, choice_text) VALUES (35, 'A.執着'); -- 180
INSERT INTO choices (question_id, choice_text) VALUES (35, 'B.独断'); -- 181
INSERT INTO choices (question_id, choice_text) VALUES (35, 'C.偏向'); -- 182
INSERT INTO choices (question_id, choice_text) VALUES (35, 'D.偏執'); -- 183〇

INSERT INTO choices (question_id, choice_text) VALUES (36, 'A.冷静沈着'); -- 184
INSERT INTO choices (question_id, choice_text) VALUES (36, 'B.内憂外患'); -- 185
INSERT INTO choices (question_id, choice_text) VALUES (36, 'C.表裏一体'); -- 186
INSERT INTO choices (question_id, choice_text) VALUES (36, 'D.慇懃無礼'); -- 187〇

INSERT INTO choices (question_id, choice_text) VALUES (37, 'A.糾弾'); -- 188
INSERT INTO choices (question_id, choice_text) VALUES (37, 'B.叱責'); -- 189
INSERT INTO choices (question_id, choice_text) VALUES (37, 'C.痛罵'); -- 190〇
INSERT INTO choices (question_id, choice_text) VALUES (37, 'D.詰問'); -- 191

INSERT INTO choices (question_id, choice_text) VALUES (38, 'A.俯瞰'); -- 192〇
INSERT INTO choices (question_id, choice_text) VALUES (38, 'B.瞭然'); -- 193
INSERT INTO choices (question_id, choice_text) VALUES (38, 'C.包括'); -- 194
INSERT INTO choices (question_id, choice_text) VALUES (38, 'D.展望'); -- 195

INSERT INTO choices (question_id, choice_text) VALUES (39, 'A.鉄面皮'); -- 196
INSERT INTO choices (question_id, choice_text) VALUES (39, 'B.豪胆'); -- 197
INSERT INTO choices (question_id, choice_text) VALUES (39, 'C.不屈'); -- 198
INSERT INTO choices (question_id, choice_text) VALUES (39, 'D.泰然自若'); -- 199〇

INSERT INTO choices (question_id, choice_text) VALUES (40, 'A.迎合'); -- 200
INSERT INTO choices (question_id, choice_text) VALUES (40, 'B.狡猾'); -- 201
INSERT INTO choices (question_id, choice_text) VALUES (40, 'C.変節'); -- 202〇
INSERT INTO choices (question_id, choice_text) VALUES (40, 'D.二枚舌'); -- 203

INSERT INTO choices (question_id, choice_text) VALUES (41, 'A.天気があやしいので「先」を急ぐことにした'); -- 204
INSERT INTO choices (question_id, choice_text) VALUES (41, 'B.こんな調子では「先」が思いやられる'); -- 205
INSERT INTO choices (question_id, choice_text) VALUES (41, 'C.みんなより「先」に帰ることにした'); -- 206
INSERT INTO choices (question_id, choice_text) VALUES (41, 'D.あまりにおいしいので「先」を争って食べた'); -- 207〇
INSERT INTO choices (question_id, choice_text) VALUES (41, 'E.「先」に料金を払うことになっている'); -- 208

INSERT INTO choices (question_id, choice_text) VALUES (42, 'A.「空」が気になる'); -- 209〇
INSERT INTO choices (question_id, choice_text) VALUES (42, 'B.「空」を飛んでみたい'); -- 210
INSERT INTO choices (question_id, choice_text) VALUES (42, 'C.他人の「空」似だった'); -- 211
INSERT INTO choices (question_id, choice_text) VALUES (42, 'D.うわの「空」で聞く'); -- 212
INSERT INTO choices (question_id, choice_text) VALUES (42, 'E.「空」で覚えている'); -- 213

INSERT INTO choices (question_id, choice_text) VALUES (43, 'A.友人「と」美術館に出かけた'); -- 214
INSERT INTO choices (question_id, choice_text) VALUES (43, 'B.引っ越しは今月「と」決まった'); -- 215〇
INSERT INTO choices (question_id, choice_text) VALUES (43, 'C.くすくす「と」笑う'); -- 216
INSERT INTO choices (question_id, choice_text) VALUES (43, 'D.間違っている「と」指摘する'); -- 217
INSERT INTO choices (question_id, choice_text) VALUES (43, 'E.意見「と」事実を分けるべきだ'); -- 218


INSERT INTO choices (question_id, choice_text) VALUES (44, 'A.期限を「きる」ことが大事だ'); -- 219
INSERT INTO choices (question_id, choice_text) VALUES (44, 'B.たんかを「きる」'); -- 220
INSERT INTO choices (question_id, choice_text) VALUES (44, 'C.親子の縁を「きる」'); -- 221〇
INSERT INTO choices (question_id, choice_text) VALUES (44, 'D.かじを「きる」'); -- 222
INSERT INTO choices (question_id, choice_text) VALUES (44, 'E.油を「きる」'); -- 223

INSERT INTO choices (question_id, choice_text) VALUES (45, 'A.花「で」飾る'); -- 224〇
INSERT INTO choices (question_id, choice_text) VALUES (45, 'B.歯痛「で」痛む'); -- 225
INSERT INTO choices (question_id, choice_text) VALUES (45, 'C.書店「で」買う'); -- 226
INSERT INTO choices (question_id, choice_text) VALUES (45, 'D.家族「で」暮らす'); -- 227
INSERT INTO choices (question_id, choice_text) VALUES (45, 'E.すぐに飛ん「で」いきたい'); -- 228

INSERT INTO choices (question_id, choice_text) VALUES (46, 'A.「目」を凝らしてよく見た'); -- 229
INSERT INTO choices (question_id, choice_text) VALUES (46, 'B.「目」がまわる忙しさだ'); -- 230
INSERT INTO choices (question_id, choice_text) VALUES (46, 'C.マナーの悪が「目」にあまる'); -- 231
INSERT INTO choices (question_id, choice_text) VALUES (46, 'D.まさかと「目」を疑う'); -- 232
INSERT INTO choices (question_id, choice_text) VALUES (46, 'E.これを選ぶとは「目」が高い'); -- 233〇

INSERT INTO choices (question_id, choice_text) VALUES (47, 'A.うれしい知らせが待た「れる」'); -- 234
INSERT INTO choices (question_id, choice_text) VALUES (47, 'B.誰でも登「れる」'); -- 235
INSERT INTO choices (question_id, choice_text) VALUES (47, 'C.夜露にぬ「れる」'); -- 236
INSERT INTO choices (question_id, choice_text) VALUES (47, 'D.ビルがこわさ「れる」'); -- 237〇
INSERT INTO choices (question_id, choice_text) VALUES (47, 'E.先生が話さ「れる」'); -- 238

INSERT INTO choices (question_id, choice_text) VALUES (48, 'A.コートの裏地が敗れた「の」です'); -- 239
INSERT INTO choices (question_id, choice_text) VALUES (48, 'B.それは私「の」コートです'); -- 240
INSERT INTO choices (question_id, choice_text) VALUES (48, 'C.コートは軽い「の」がいい'); -- 241〇
INSERT INTO choices (question_id, choice_text) VALUES (48, 'D.私「の」なくしたコートが見つかった'); -- 242
INSERT INTO choices (question_id, choice_text) VALUES (48, 'E.コートがない「の」、マフラーがない「の」と騒ぐ'); -- 243

INSERT INTO choices (question_id, choice_text) VALUES (49, 'A.トップの座に「のぼる」'); -- 244
INSERT INTO choices (question_id, choice_text) VALUES (49, 'B.話題に「のぼる」'); -- 245〇
INSERT INTO choices (question_id, choice_text) VALUES (49, 'C.猫が木に「のぼる」'); -- 246
INSERT INTO choices (question_id, choice_text) VALUES (49, 'D.来場者が100万人に「のぼる」'); -- 247
INSERT INTO choices (question_id, choice_text) VALUES (49, 'E.煙が「のぼる」'); -- 248

INSERT INTO choices (question_id, choice_text) VALUES (50, 'A.あっちもおもしろ「そうだ」'); -- 249
INSERT INTO choices (question_id, choice_text) VALUES (50, 'B.雨でも降り「そうだ」'); -- 250
INSERT INTO choices (question_id, choice_text) VALUES (50, 'C.今年は黒字になり「そうだ」'); -- 251
INSERT INTO choices (question_id, choice_text) VALUES (50, 'D.少しも悲しくなさ「そうだ」'); -- 252
INSERT INTO choices (question_id, choice_text) VALUES (50, 'E.夜更けから雪になる「そうだ」'); -- 253〇

INSERT INTO choices (question_id, choice_text) VALUES (51, 'A.病気「で」学校を休む'); -- 254
INSERT INTO choices (question_id, choice_text) VALUES (51, 'B.雪「で」飛行機が欠航する'); -- 255
INSERT INTO choices (question_id, choice_text) VALUES (51, 'C.電車「で」行く'); -- 256〇
INSERT INTO choices (question_id, choice_text) VALUES (51, 'D.海「で」泳ぐ'); -- 257
INSERT INTO choices (question_id, choice_text) VALUES (51, 'E.みんな「で」頑張る'); -- 258

INSERT INTO choices (question_id, choice_text) VALUES (52, 'A.人「目」を引く格好'); -- 259
INSERT INTO choices (question_id, choice_text) VALUES (52, 'B.「目」が悪くてぼやける'); -- 260
INSERT INTO choices (question_id, choice_text) VALUES (52, 'C.見た「目」が良くない'); -- 261
INSERT INTO choices (question_id, choice_text) VALUES (52, 'D.ひどい「目」にあう'); -- 262
INSERT INTO choices (question_id, choice_text) VALUES (52, 'E.お「目」が高いですね'); -- 263〇

INSERT INTO choices (question_id, choice_text) VALUES (53, 'A.昔が思いださ「れる」'); -- 264
INSERT INTO choices (question_id, choice_text) VALUES (53, 'B.ご主人様が休ま「れる」'); -- 265
INSERT INTO choices (question_id, choice_text) VALUES (53, 'C.足を踏ま「れる」'); -- 266
INSERT INTO choices (question_id, choice_text) VALUES (53, 'D.外に押し出さ「れる」'); -- 267
INSERT INTO choices (question_id, choice_text) VALUES (53, 'E.徒歩でも行か「れる」'); -- 268〇

INSERT INTO choices (question_id, choice_text) VALUES (54, 'A.他人に「かんしょう」する'); -- 269
INSERT INTO choices (question_id, choice_text) VALUES (54, 'B.絵画を「かんしょう」する'); -- 270
INSERT INTO choices (question_id, choice_text) VALUES (54, 'C.「かんしょう」にひたる'); -- 271
INSERT INTO choices (question_id, choice_text) VALUES (54, 'D.熱帯魚を「かんしょう」する'); -- 272〇
INSERT INTO choices (question_id, choice_text) VALUES (54, 'E.試合で「かんしょう」する'); -- 273

INSERT INTO choices (question_id, choice_text) VALUES (55, 'A.「腹」に一物'); -- 274〇
INSERT INTO choices (question_id, choice_text) VALUES (55, 'B.「腹」が痛い'); -- 275
INSERT INTO choices (question_id, choice_text) VALUES (55, 'C.「腹」が据わっている'); -- 276
INSERT INTO choices (question_id, choice_text) VALUES (55, 'D.「腹」を立てる'); -- 277
INSERT INTO choices (question_id, choice_text) VALUES (55, 'E.指の「腹」'); -- 278

INSERT INTO choices (question_id, choice_text) VALUES (56, 'A.今は大学「に」います'); -- 279
INSERT INTO choices (question_id, choice_text) VALUES (56, 'B.彼は学者「に」なる'); -- 280〇
INSERT INTO choices (question_id, choice_text) VALUES (56, 'C.見学「に」行く'); -- 281
INSERT INTO choices (question_id, choice_text) VALUES (56, 'D.姉「に」叱られる'); -- 282
INSERT INTO choices (question_id, choice_text) VALUES (56, 'E.待ち「に」待った運動会'); -- 283

INSERT INTO choices (question_id, choice_text) VALUES (57, 'A.100m走のタイムを「はかる」'); -- 284
INSERT INTO choices (question_id, choice_text) VALUES (57, 'B.委員会に「はかる」'); -- 285
INSERT INTO choices (question_id, choice_text) VALUES (57, 'C.彼女の気持ちを「はかる」'); -- 286〇
INSERT INTO choices (question_id, choice_text) VALUES (57, 'D.うまく進むように「はかる」'); -- 287
INSERT INTO choices (question_id, choice_text) VALUES (57, 'E.暗殺を「はかる」'); -- 288

INSERT INTO choices (question_id, choice_text) VALUES (58, 'A.貧乏の「味」を知る'); -- 289〇
INSERT INTO choices (question_id, choice_text) VALUES (58, 'B.スープの「味」が濃い'); -- 290
INSERT INTO choices (question_id, choice_text) VALUES (58, 'C.「味」のある演奏'); -- 291
INSERT INTO choices (question_id, choice_text) VALUES (58, 'D.「味」な趣向'); -- 292
INSERT INTO choices (question_id, choice_text) VALUES (58, 'E.薄「味」せんべい'); -- 293

INSERT INTO choices (question_id, choice_text) VALUES (59, 'A.テストは難しい「そうだ」'); -- 294〇
INSERT INTO choices (question_id, choice_text) VALUES (59, 'B.彼は物分かりが良さ「そうだ」'); -- 295
INSERT INTO choices (question_id, choice_text) VALUES (59, 'C.雪が降ってき「そうだ」'); -- 296
INSERT INTO choices (question_id, choice_text) VALUES (59, 'D.今日も冷え込み「そうだ」'); -- 297
INSERT INTO choices (question_id, choice_text) VALUES (59, 'E.デザートがおいし「そうだ」'); -- 298

INSERT INTO choices (question_id, choice_text) VALUES (60, 'A.もっとうまい「手」を探す'); -- 299
INSERT INTO choices (question_id, choice_text) VALUES (60, 'B.そろばんの「手」が上がる'); -- 300
INSERT INTO choices (question_id, choice_text) VALUES (60, 'C.敵と「手」を結ぶ'); -- 301
INSERT INTO choices (question_id, choice_text) VALUES (60, 'D.「手」のこんだプレゼント'); -- 302〇
INSERT INTO choices (question_id, choice_text) VALUES (60, 'E.先生の「手」が入る'); -- 303

INSERT INTO choices (question_id, choice_text) VALUES (61, 'A.ベジタリアン増加の'); -- 304
INSERT INTO choices (question_id, choice_text) VALUES (61, 'B.具体的に扱うのは'); -- 305
INSERT INTO choices (question_id, choice_text) VALUES (61, 'C.人と動物との本来あるべき関係や'); -- 306
INSERT INTO choices (question_id, choice_text) VALUES (61, 'D.動物の権利を問う学問であり'); -- 307
INSERT INTO choices (question_id, choice_text) VALUES (61, 'E.肉食といった問題であるため'); -- 308〇

INSERT INTO choices (question_id, choice_text) VALUES (62, 'A.さらにそのデータを'); -- 309〇
INSERT INTO choices (question_id, choice_text) VALUES (62, 'B.あらゆる情報がデジタル化され'); -- 310
INSERT INTO choices (question_id, choice_text) VALUES (62, 'C.生活がより便利になった一方で'); -- 311
INSERT INTO choices (question_id, choice_text) VALUES (62, 'D.膨大な個人情報が広がっていくことへの'); -- 312
INSERT INTO choices (question_id, choice_text) VALUES (62, 'E.分析できるようになったおかげで'); -- 313

INSERT INTO choices (question_id, choice_text) VALUES (63, 'A.細菌は一つの細胞でできており'); -- 314〇
INSERT INTO choices (question_id, choice_text) VALUES (63, 'B.ウイルスは細菌の50分の1ほどの大きさで'); -- 315
INSERT INTO choices (question_id, choice_text) VALUES (63, 'C.単細胞生物と呼ばれるのに対し'); -- 316
INSERT INTO choices (question_id, choice_text) VALUES (63, 'D.自分で細胞を持たず'); -- 317
INSERT INTO choices (question_id, choice_text) VALUES (63, 'E.どちらも微生物だが'); -- 318

INSERT INTO choices (question_id, choice_text) VALUES (64, 'A. ア 日本においては軍事や国防と密接に結びつけられてきた'); -- 319〇
INSERT INTO choices (question_id, choice_text) VALUES (64, 'B. イ この条約の改正は大きな反対運動、いわゆる安保闘争を招いた'); -- 320
INSERT INTO choices (question_id, choice_text) VALUES (64, 'C. ウ 契機は「日米安全保障条約」の締結だと考えられる'); -- 321
INSERT INTO choices (question_id, choice_text) VALUES (64, 'D. エ その結果、“Security”は「安全保障」よりも「安保」として定着した'); -- 322
INSERT INTO choices (question_id, choice_text) VALUES (64, 'E. オ 「安全保障」という言葉は英語の“Security”の訳語であるが'); -- 323

INSERT INTO choices (question_id, choice_text) VALUES (65, 'A.自宅などの生活の場で'); -- 324
INSERT INTO choices (question_id, choice_text) VALUES (65, 'B.第３の医療提供形態として'); -- 325
INSERT INTO choices (question_id, choice_text) VALUES (65, 'C.入院医療、外来医療に次ぐ'); -- 326〇
INSERT INTO choices (question_id, choice_text) VALUES (65, 'D.通院が困難な患者が'); -- 327
INSERT INTO choices (question_id, choice_text) VALUES (65, 'E.療養を行えるようにする医療であり'); -- 328

INSERT INTO choices (question_id, choice_text) VALUES (66, 'A.この状態をプラズマと呼びます。'); -- 329〇
INSERT INTO choices (question_id, choice_text) VALUES (66, 'B.マイナスの電荷を持った電子に解離します。'); -- 330
INSERT INTO choices (question_id, choice_text) VALUES (66, 'C.またプラズマが運動すると電場や磁場が生まれ、'); -- 331
INSERT INTO choices (question_id, choice_text) VALUES (66, 'D.プラズマは電場や磁場を感じると運動が変化します。'); -- 332
INSERT INTO choices (question_id, choice_text) VALUES (66, 'E.原子がプラスの電荷を持つイオンと、'); -- 333

INSERT INTO choices (question_id, choice_text) VALUES (67, 'A.しかし過去の生物を直接知る手がかりは、化石記録しかありません。'); -- 334〇
INSERT INTO choices (question_id, choice_text) VALUES (67, 'B.古代の生物の様子がまるで見てきたかのような'); -- 335
INSERT INTO choices (question_id, choice_text) VALUES (67, 'C.ですから、その生物の姿勢や動き、色や模様は、'); -- 336
INSERT INTO choices (question_id, choice_text) VALUES (67, 'D.カラーイラストで描かれているのをよく目にします。'); -- 337

INSERT INTO choices (question_id, choice_text) VALUES (68, 'A. ア 職場の仕事の他に、家事育児や介護といった労働を「ケア労働」という'); -- 338
INSERT INTO choices (question_id, choice_text) VALUES (68, 'B. イ 日本では有償労働は男性に'); -- 339〇
INSERT INTO choices (question_id, choice_text) VALUES (68, 'C. ウ 働く女性はダブルワークを担わなくてはならないという問題がある'); -- 340
INSERT INTO choices (question_id, choice_text) VALUES (68, 'D. エ 無償のケア労働は女性に偏っている'); -- 341
INSERT INTO choices (question_id, choice_text) VALUES (68, 'E. オ そのため、女性の社会進出が叫ばれている一方で'); -- 342

INSERT INTO choices (question_id, choice_text) VALUES (69, 'A.「二院制」がとられているのは、'); -- 343
INSERT INTO choices (question_id, choice_text) VALUES (69, 'B.その二つとは「衆議院」と「参議院」です。'); -- 344
INSERT INTO choices (question_id, choice_text) VALUES (69, 'C.国会は二つの議会からなる「二院制」がとられていて、'); -- 345〇
INSERT INTO choices (question_id, choice_text) VALUES (69, 'D.さまざまな意見を取り入れて慎重に話し合うという目的のためです。'); -- 346
INSERT INTO choices (question_id, choice_text) VALUES (69, 'E.「唯一の立法機関」と定められています。'); -- 347

INSERT INTO choices (question_id, choice_text) VALUES (70, 'A.「冷蔵庫」「洗濯機」「白黒テレビ」が、'); -- 348
INSERT INTO choices (question_id, choice_text) VALUES (70, 'B.「三種の神器」と呼ばれました。'); -- 349
INSERT INTO choices (question_id, choice_text) VALUES (70, 'C.一般の家庭でも使える電化製品が次々と現れました。'); -- 350
INSERT INTO choices (question_id, choice_text) VALUES (70, 'D.例えば高度経済成長期のさなか登場した'); -- 351
INSERT INTO choices (question_id, choice_text) VALUES (70, 'E.人々の生活を豊かにするための'); -- 352〇

INSERT INTO choices (question_id, choice_text) VALUES (71, 'A.A'); -- 353〇
INSERT INTO choices (question_id, choice_text) VALUES (71, 'B.B'); -- 354
INSERT INTO choices (question_id, choice_text) VALUES (71, 'C.C'); -- 355
INSERT INTO choices (question_id, choice_text) VALUES (71, 'D.D'); -- 356
INSERT INTO choices (question_id, choice_text) VALUES (71, 'E.E'); -- 357

INSERT INTO choices (question_id, choice_text) VALUES (72, 'A.ア'); -- 358
INSERT INTO choices (question_id, choice_text) VALUES (72, 'B.ウ'); -- 359
INSERT INTO choices (question_id, choice_text) VALUES (72, 'C.エ'); -- 360
INSERT INTO choices (question_id, choice_text) VALUES (72, 'D.オ'); -- 361〇
INSERT INTO choices (question_id, choice_text) VALUES (72, 'E.イが最後の文'); -- 362

INSERT INTO choices (question_id, choice_text) VALUES (73, 'A.A'); -- 363
INSERT INTO choices (question_id, choice_text) VALUES (73, 'B.B'); -- 364
INSERT INTO choices (question_id, choice_text) VALUES (73, 'C.C'); -- 365
INSERT INTO choices (question_id, choice_text) VALUES (73, 'D.D'); -- 366
INSERT INTO choices (question_id, choice_text) VALUES (73, 'E.E'); -- 367〇

INSERT INTO choices (question_id, choice_text) VALUES (74, 'A.A'); -- 368
INSERT INTO choices (question_id, choice_text) VALUES (74, 'B.B'); -- 369
INSERT INTO choices (question_id, choice_text) VALUES (74, 'C.C'); -- 370
INSERT INTO choices (question_id, choice_text) VALUES (74, 'D.D'); -- 371
INSERT INTO choices (question_id, choice_text) VALUES (74, 'E.E'); -- 372〇

INSERT INTO choices (question_id, choice_text) VALUES (75, 'A.アとイ'); -- 373
INSERT INTO choices (question_id, choice_text) VALUES (75, 'B.イとア'); -- 374
INSERT INTO choices (question_id, choice_text) VALUES (75, 'C.イとエ'); -- 375
INSERT INTO choices (question_id, choice_text) VALUES (75, 'D.エとイ'); -- 376
INSERT INTO choices (question_id, choice_text) VALUES (75, 'E.オとア'); -- 377〇
INSERT INTO choices (question_id, choice_text) VALUES (75, 'F.オとエ'); -- 378

INSERT INTO choices (question_id, choice_text) VALUES (76, 'A.アとイ'); -- 379
INSERT INTO choices (question_id, choice_text) VALUES (76, 'B.イとア'); -- 380〇
INSERT INTO choices (question_id, choice_text) VALUES (76, 'C.イとエ'); -- 381
INSERT INTO choices (question_id, choice_text) VALUES (76, 'D.エとイ'); -- 382
INSERT INTO choices (question_id, choice_text) VALUES (76, 'E.オとア'); -- 383
INSERT INTO choices (question_id, choice_text) VALUES (76, 'F.オとエ'); -- 384

INSERT INTO choices (question_id, choice_text) VALUES (77, 'A.ア'); -- 385
INSERT INTO choices (question_id, choice_text) VALUES (77, 'B.イ'); -- 386
INSERT INTO choices (question_id, choice_text) VALUES (77, 'C.ウ'); -- 387
INSERT INTO choices (question_id, choice_text) VALUES (77, 'D.エ'); -- 388
INSERT INTO choices (question_id, choice_text) VALUES (77, 'E.オ'); -- 389〇
INSERT INTO choices (question_id, choice_text) VALUES (77, 'F.カが最後の文'); -- 390

INSERT INTO choices (question_id, choice_text) VALUES (78, 'A.ア'); -- 391
INSERT INTO choices (question_id, choice_text) VALUES (78, 'B.イ'); -- 392
INSERT INTO choices (question_id, choice_text) VALUES (78, 'C.ウ'); -- 393
INSERT INTO choices (question_id, choice_text) VALUES (78, 'D.エが最後の文'); -- 394
INSERT INTO choices (question_id, choice_text) VALUES (78, 'E.オ'); -- 395〇
INSERT INTO choices (question_id, choice_text) VALUES (78, 'F.カ'); -- 396

INSERT INTO choices (question_id, choice_text) VALUES (79, 'A.アとイ'); -- 397
INSERT INTO choices (question_id, choice_text) VALUES (79, 'B.ウとオ'); -- 398
INSERT INTO choices (question_id, choice_text) VALUES (79, 'C.オとウ'); -- 399
INSERT INTO choices (question_id, choice_text) VALUES (79, 'D.エとア'); -- 400
INSERT INTO choices (question_id, choice_text) VALUES (79, 'E.アとエ'); -- 401
INSERT INTO choices (question_id, choice_text) VALUES (79, 'F.イとア'); -- 402〇

INSERT INTO choices (question_id, choice_text) VALUES (80, 'A.アとウ'); -- 403
INSERT INTO choices (question_id, choice_text) VALUES (80, 'B.ウとオ'); -- 404
INSERT INTO choices (question_id, choice_text) VALUES (80, 'C.エとウ'); -- 405
INSERT INTO choices (question_id, choice_text) VALUES (80, 'D.エとア'); -- 406〇
INSERT INTO choices (question_id, choice_text) VALUES (80, 'E.アとエ'); -- 407
INSERT INTO choices (question_id, choice_text) VALUES (80, 'F.イとア'); -- 408

INSERT INTO choices (question_id, choice_text) VALUES (81, 'A.才能'); -- 409
INSERT INTO choices (question_id, choice_text) VALUES (81, 'B.幻想'); -- 410
INSERT INTO choices (question_id, choice_text) VALUES (81, 'C.夢'); -- 411
INSERT INTO choices (question_id, choice_text) VALUES (81, 'D.怠惰'); -- 412
INSERT INTO choices (question_id, choice_text) VALUES (81, 'E.力み'); -- 413〇
INSERT INTO choices (question_id, choice_text) VALUES (81, 'F.迷い'); -- 414

INSERT INTO choices (question_id, choice_text) VALUES (82, 'A.躍起'); -- 415〇
INSERT INTO choices (question_id, choice_text) VALUES (82, 'B.一筋'); -- 416
INSERT INTO choices (question_id, choice_text) VALUES (82, 'C.強引'); -- 417
INSERT INTO choices (question_id, choice_text) VALUES (82, 'D.本腰'); -- 418
INSERT INTO choices (question_id, choice_text) VALUES (82, 'E.一向'); -- 419

INSERT INTO choices (question_id, choice_text) VALUES (83, 'A.苦虫'); -- 420
INSERT INTO choices (question_id, choice_text) VALUES (83, 'B.眉唾'); -- 421
INSERT INTO choices (question_id, choice_text) VALUES (83, 'C.言葉'); -- 422
INSERT INTO choices (question_id, choice_text) VALUES (83, 'D.良薬'); -- 423
INSERT INTO choices (question_id, choice_text) VALUES (83, 'E.固唾'); -- 424〇

INSERT INTO choices (question_id, choice_text) VALUES (84, 'A.丹精'); -- 425
INSERT INTO choices (question_id, choice_text) VALUES (84, 'B.手塩'); -- 426〇
INSERT INTO choices (question_id, choice_text) VALUES (84, 'C.拍車'); -- 427
INSERT INTO choices (question_id, choice_text) VALUES (84, 'D.腕'); -- 428
INSERT INTO choices (question_id, choice_text) VALUES (84, 'E.輪'); -- 429

INSERT INTO choices (question_id, choice_text) VALUES (85, 'A.ふける'); -- 430
INSERT INTO choices (question_id, choice_text) VALUES (85, 'B.寄せる'); -- 431
INSERT INTO choices (question_id, choice_text) VALUES (85, 'C.つきる'); -- 432
INSERT INTO choices (question_id, choice_text) VALUES (85, 'D.むせぶ'); -- 433〇
INSERT INTO choices (question_id, choice_text) VALUES (85, 'E.徹する'); -- 434

INSERT INTO choices (question_id, choice_text) VALUES (86, 'A.新しいことにチャレンジする意欲がある'); -- 435
INSERT INTO choices (question_id, choice_text) VALUES (86, 'B.失敗だと気づかずに通り過ぎてきた'); -- 436
INSERT INTO choices (question_id, choice_text) VALUES (86, 'C.どんなに失敗を繰り返しても許される状況だった'); -- 437
INSERT INTO choices (question_id, choice_text) VALUES (86, 'D.過去の失敗事例から回避する手段がわかっている'); -- 438〇

INSERT INTO choices (question_id, choice_text) VALUES (87, 'A.批判的'); -- 439
INSERT INTO choices (question_id, choice_text) VALUES (87, 'B.論理的'); -- 440〇
INSERT INTO choices (question_id, choice_text) VALUES (87, 'C.普遍的'); -- 441
INSERT INTO choices (question_id, choice_text) VALUES (87, 'D.哲学的'); -- 442
INSERT INTO choices (question_id, choice_text) VALUES (87, 'E.感覚的'); -- 443
INSERT INTO choices (question_id, choice_text) VALUES (87, 'F.実証的'); -- 444

INSERT INTO choices (question_id, choice_text) VALUES (88, 'A.余所'); -- 445
INSERT INTO choices (question_id, choice_text) VALUES (88, 'B.底辺'); -- 446
INSERT INTO choices (question_id, choice_text) VALUES (88, 'C.道中'); -- 447
INSERT INTO choices (question_id, choice_text) VALUES (88, 'D.風上'); -- 448〇
INSERT INTO choices (question_id, choice_text) VALUES (88, 'E.一角'); -- 449

INSERT INTO choices (question_id, choice_text) VALUES (89, 'A.本腰'); -- 450〇
INSERT INTO choices (question_id, choice_text) VALUES (89, 'B.年季'); -- 451
INSERT INTO choices (question_id, choice_text) VALUES (89, 'C.本気'); -- 452
INSERT INTO choices (question_id, choice_text) VALUES (89, 'D.念頭'); -- 453
INSERT INTO choices (question_id, choice_text) VALUES (89, 'E.故障'); -- 454

INSERT INTO choices (question_id, choice_text) VALUES (90, 'A.さしずめ'); -- 455
INSERT INTO choices (question_id, choice_text) VALUES (90, 'B.ともすれば'); -- 456〇
INSERT INTO choices (question_id, choice_text) VALUES (90, 'C.ひっきょう'); -- 457
INSERT INTO choices (question_id, choice_text) VALUES (90, 'D.ようとして'); -- 458
INSERT INTO choices (question_id, choice_text) VALUES (90, 'E.なまじっか'); -- 459

INSERT INTO choices (question_id, choice_text) VALUES (91, 'A.1．絶対的　2．同質化'); -- 460
INSERT INTO choices (question_id, choice_text) VALUES (91, 'B.1．相対的　2．組織化'); -- 461
INSERT INTO choices (question_id, choice_text) VALUES (91, 'C.1．経時的　2．多忙化'); -- 462
INSERT INTO choices (question_id, choice_text) VALUES (91, 'D.1．絶対的　2．組織化'); -- 463
INSERT INTO choices (question_id, choice_text) VALUES (91, 'E.1．相対的　2．多忙化'); -- 464〇
INSERT INTO choices (question_id, choice_text) VALUES (91, 'F.1．経時的　2．同質化'); -- 465

INSERT INTO choices (question_id, choice_text) VALUES (92, 'A.馬脚'); -- 466
INSERT INTO choices (question_id, choice_text) VALUES (92, 'B.卓抜'); -- 467
INSERT INTO choices (question_id, choice_text) VALUES (92, 'C.頭角'); -- 468〇
INSERT INTO choices (question_id, choice_text) VALUES (92, 'D.台頭'); -- 469
INSERT INTO choices (question_id, choice_text) VALUES (92, 'E.媚態'); -- 470

INSERT INTO choices (question_id, choice_text) VALUES (93, 'A.雲泥'); -- 471〇
INSERT INTO choices (question_id, choice_text) VALUES (93, 'B.犬猿'); -- 472
INSERT INTO choices (question_id, choice_text) VALUES (93, 'C.珠玉'); -- 473
INSERT INTO choices (question_id, choice_text) VALUES (93, 'D.幾多'); -- 474
INSERT INTO choices (question_id, choice_text) VALUES (93, 'E.朝夕'); -- 475

INSERT INTO choices (question_id, choice_text) VALUES (94, 'A.横紙'); -- 476
INSERT INTO choices (question_id, choice_text) VALUES (94, 'B.専横'); -- 477
INSERT INTO choices (question_id, choice_text) VALUES (94, 'C.横暴'); -- 478
INSERT INTO choices (question_id, choice_text) VALUES (94, 'D.横槍'); -- 479
INSERT INTO choices (question_id, choice_text) VALUES (94, 'E.横車'); -- 480〇

INSERT INTO choices (question_id, choice_text) VALUES (95, 'A.やにわに'); -- 481〇
INSERT INTO choices (question_id, choice_text) VALUES (95, 'B.つぶさに'); -- 482
INSERT INTO choices (question_id, choice_text) VALUES (95, 'C.おのずと'); -- 483
INSERT INTO choices (question_id, choice_text) VALUES (95, 'D.おもむろに'); -- 484
INSERT INTO choices (question_id, choice_text) VALUES (95, 'E.おいそれと'); -- 485

INSERT INTO choices (question_id, choice_text) VALUES (96, 'A.一定'); -- 486
INSERT INTO choices (question_id, choice_text) VALUES (96, 'B.物理'); -- 487
INSERT INTO choices (question_id, choice_text) VALUES (96, 'C.遺伝'); -- 488
INSERT INTO choices (question_id, choice_text) VALUES (96, 'D.自然'); -- 489〇
INSERT INTO choices (question_id, choice_text) VALUES (96, 'E.経済'); -- 490

INSERT INTO choices (question_id, choice_text) VALUES (97, 'A.1．無限回　2．積み重ね'); -- 491
INSERT INTO choices (question_id, choice_text) VALUES (97, 'B.1．計算上　2．一回限り'); -- 492
INSERT INTO choices (question_id, choice_text) VALUES (97, 'C.1．一回　　2．無限回'); -- 493
INSERT INTO choices (question_id, choice_text) VALUES (97, 'D.1．無限回　2．一回限り'); -- 494〇
INSERT INTO choices (question_id, choice_text) VALUES (97, 'E.1．一回　　2．積み重ね'); -- 495
INSERT INTO choices (question_id, choice_text) VALUES (97, 'F.1．計算上　2．無限回'); -- 496

INSERT INTO choices (question_id, choice_text) VALUES (98, 'A.1．遮蔽　2．自立的'); -- 497〇
INSERT INTO choices (question_id, choice_text) VALUES (98, 'B.1．開放　2．自立的'); -- 498
INSERT INTO choices (question_id, choice_text) VALUES (98, 'C.1．遮蔽　2．幻想的'); -- 499
INSERT INTO choices (question_id, choice_text) VALUES (98, 'D.1．開放　2．幻想的'); -- 500
INSERT INTO choices (question_id, choice_text) VALUES (98, 'E.1．遮蔽　2．虚構的'); -- 501
INSERT INTO choices (question_id, choice_text) VALUES (98, 'F.1．開放　2．虚構的'); -- 502

INSERT INTO choices (question_id, choice_text) VALUES (99, 'A.1．雨量 2．雲量'); -- 503
INSERT INTO choices (question_id, choice_text) VALUES (99, 'B.1．熱波 2．水不足'); -- 504〇
INSERT INTO choices (question_id, choice_text) VALUES (99, 'C.1．寒波 2．積雪'); -- 505
INSERT INTO choices (question_id, choice_text) VALUES (99, 'D.1．豪雨 2．風景'); -- 506
INSERT INTO choices (question_id, choice_text) VALUES (99, 'E.1．台風 2．雹（ひょう）'); -- 507

INSERT INTO choices (question_id, choice_text) VALUES (100, 'A.1．図書館 2．生活'); -- 508
INSERT INTO choices (question_id, choice_text) VALUES (100, 'B.1．学校 2．経済'); -- 509
INSERT INTO choices (question_id, choice_text) VALUES (100, 'C.1．公園 2．交通'); -- 510
INSERT INTO choices (question_id, choice_text) VALUES (100, 'D.1．病院 2．安全'); -- 511〇
INSERT INTO choices (question_id, choice_text) VALUES (100, 'E.1．スタジアム 2．環境'); -- 512


-- 非言語問題
INSERT INTO choices (question_id, choice_text) VALUES (101, 'A. 13 通り'); -- 513
INSERT INTO choices (question_id, choice_text) VALUES (101, 'B. 18 通り'); -- 514
INSERT INTO choices (question_id, choice_text) VALUES (101, 'C. 24 通り'); -- 515
INSERT INTO choices (question_id, choice_text) VALUES (101, 'D. 40 通り'); -- 516〇
INSERT INTO choices (question_id, choice_text) VALUES (101, 'E. 80 通り'); -- 517

INSERT INTO choices (question_id, choice_text) VALUES (102, 'A. 7 通り'); -- 518
INSERT INTO choices (question_id, choice_text) VALUES (102, 'B. 21 通り'); -- 519
INSERT INTO choices (question_id, choice_text) VALUES (102, 'C. 35 通り'); -- 520〇
INSERT INTO choices (question_id, choice_text) VALUES (102, 'D. 91 通り'); -- 521
INSERT INTO choices (question_id, choice_text) VALUES (102, 'E. 140 通り'); -- 522

INSERT INTO choices (question_id, choice_text) VALUES (103, 'A. 100 通り'); -- 523
INSERT INTO choices (question_id, choice_text) VALUES (103, 'B. 700 通り'); -- 524
INSERT INTO choices (question_id, choice_text) VALUES (103, 'C. 1600 通り'); -- 525
INSERT INTO choices (question_id, choice_text) VALUES (103, 'D. 4200 通り'); -- 526〇
INSERT INTO choices (question_id, choice_text) VALUES (103, 'E. 7200 通り'); -- 527

INSERT INTO choices (question_id, choice_text) VALUES (104, 'A. 12 通り'); -- 528
INSERT INTO choices (question_id, choice_text) VALUES (104, 'B. 24 通り'); -- 529〇
INSERT INTO choices (question_id, choice_text) VALUES (104, 'C. 48 通り'); -- 530
INSERT INTO choices (question_id, choice_text) VALUES (104, 'D. 80 通り'); -- 531
INSERT INTO choices (question_id, choice_text) VALUES (104, 'E. 120 通り'); -- 532

INSERT INTO choices (question_id, choice_text) VALUES (105, 'A. 4 通り'); -- 533
INSERT INTO choices (question_id, choice_text) VALUES (105, 'B. 6 通り'); -- 534〇
INSERT INTO choices (question_id, choice_text) VALUES (105, 'C. 10 通り'); -- 535
INSERT INTO choices (question_id, choice_text) VALUES (105, 'D. 12 通り'); -- 536
INSERT INTO choices (question_id, choice_text) VALUES (105, 'E. AからDのいずれでもない'); -- 537

INSERT INTO choices (question_id, choice_text) VALUES (106, 'A. 5 通り'); -- 538
INSERT INTO choices (question_id, choice_text) VALUES (106, 'B. 6 通り'); -- 539〇
INSERT INTO choices (question_id, choice_text) VALUES (106, 'C. 12 通り'); -- 540
INSERT INTO choices (question_id, choice_text) VALUES (106, 'D. 20 通り'); -- 541
INSERT INTO choices (question_id, choice_text) VALUES (106, 'E. AからDのいずれでもない'); -- 542

INSERT INTO choices (question_id, choice_text) VALUES (107, 'A. 3 通り'); -- 543
INSERT INTO choices (question_id, choice_text) VALUES (107, 'B. 5 通り'); -- 544
INSERT INTO choices (question_id, choice_text) VALUES (107, 'C. 6 通り'); -- 545〇
INSERT INTO choices (question_id, choice_text) VALUES (107, 'D. 10 通り'); -- 546
INSERT INTO choices (question_id, choice_text) VALUES (107, 'E. AからDのいずれでもない'); -- 547

INSERT INTO choices (question_id, choice_text) VALUES (108, 'A. 3'); -- 548
INSERT INTO choices (question_id, choice_text) VALUES (108, 'B. 6'); -- 549
INSERT INTO choices (question_id, choice_text) VALUES (108, 'C. 21'); -- 550
INSERT INTO choices (question_id, choice_text) VALUES (108, 'D. 27'); -- 551〇

INSERT INTO choices (question_id, choice_text) VALUES (109, 'A. 3 通り'); -- 552
INSERT INTO choices (question_id, choice_text) VALUES (109, 'B. 4 通り'); -- 553〇
INSERT INTO choices (question_id, choice_text) VALUES (109, 'C. 8 通り'); -- 554
INSERT INTO choices (question_id, choice_text) VALUES (109, 'D. 12 通り'); -- 555

INSERT INTO choices (question_id, choice_text) VALUES (110, 'A. 5 通り'); -- 556
INSERT INTO choices (question_id, choice_text) VALUES (110, 'B. 6 通り'); -- 557〇
INSERT INTO choices (question_id, choice_text) VALUES (110, 'C. 9 通り'); -- 558
INSERT INTO choices (question_id, choice_text) VALUES (110, 'D. 10 通り'); -- 559
INSERT INTO choices (question_id, choice_text) VALUES (110, 'E. AからDのいずれでもない'); -- 560

INSERT INTO choices (question_id, choice_text) VALUES (111, 'A. 1'); -- 561
INSERT INTO choices (question_id, choice_text) VALUES (111, 'B. 2'); -- 562
INSERT INTO choices (question_id, choice_text) VALUES (111, 'C. 3'); -- 563
INSERT INTO choices (question_id, choice_text) VALUES (111, 'D. 4'); -- 564〇
INSERT INTO choices (question_id, choice_text) VALUES (111, 'E. 5'); -- 565

INSERT INTO choices (question_id, choice_text) VALUES (112, 'A. SRPQ'); -- 566
INSERT INTO choices (question_id, choice_text) VALUES (112, 'B. SRQP'); -- 567〇
INSERT INTO choices (question_id, choice_text) VALUES (112, 'C. PRSQ'); -- 568
INSERT INTO choices (question_id, choice_text) VALUES (112, 'D. RPQS'); -- 569

INSERT INTO choices (question_id, choice_text) VALUES (113, 'A. アもイも正しい'); -- 570
INSERT INTO choices (question_id, choice_text) VALUES (113, 'B. アは正しいがイは誤り'); -- 571
INSERT INTO choices (question_id, choice_text) VALUES (113, 'C. アはどちらとも言えないがイは誤り'); -- 572
INSERT INTO choices (question_id, choice_text) VALUES (113, 'D. アは誤りだがイは正しい'); -- 573〇
INSERT INTO choices (question_id, choice_text) VALUES (113, 'E. アもイもどちらとも言えない'); -- 574

INSERT INTO choices (question_id, choice_text) VALUES (114, 'A. 5'); -- 575〇
INSERT INTO choices (question_id, choice_text) VALUES (114, 'B. 10'); -- 576
INSERT INTO choices (question_id, choice_text) VALUES (114, 'C. 15'); -- 577
INSERT INTO choices (question_id, choice_text) VALUES (114, 'D. 20'); -- 578
INSERT INTO choices (question_id, choice_text) VALUES (114, 'E. 25'); -- 579

INSERT INTO choices (question_id, choice_text) VALUES (115, 'A. 2'); -- 580
INSERT INTO choices (question_id, choice_text) VALUES (115, 'B. 3'); -- 581
INSERT INTO choices (question_id, choice_text) VALUES (115, 'C. 4'); -- 582
INSERT INTO choices (question_id, choice_text) VALUES (115, 'D. 5'); -- 583〇
INSERT INTO choices (question_id, choice_text) VALUES (115, 'E. 6'); -- 584

INSERT INTO choices (question_id, choice_text) VALUES (116, 'A. A-C-D-E-B'); -- 585
INSERT INTO choices (question_id, choice_text) VALUES (116, 'B. B-D-E-A-C'); -- 586
INSERT INTO choices (question_id, choice_text) VALUES (116, 'C. D-E-A-C-B'); -- 587〇
INSERT INTO choices (question_id, choice_text) VALUES (116, 'D. E-D-C-B-A'); -- 588
INSERT INTO choices (question_id, choice_text) VALUES (116, 'E. D-A-E-B-C'); -- 589

INSERT INTO choices (question_id, choice_text) VALUES (117, 'A. A'); -- 590
INSERT INTO choices (question_id, choice_text) VALUES (117, 'B. B'); -- 591〇
INSERT INTO choices (question_id, choice_text) VALUES (117, 'C. C'); -- 592
INSERT INTO choices (question_id, choice_text) VALUES (117, 'D. D'); -- 593
INSERT INTO choices (question_id, choice_text) VALUES (117, 'E. E'); -- 594

INSERT INTO choices (question_id, choice_text) VALUES (118, 'A. 1'); -- 595
INSERT INTO choices (question_id, choice_text) VALUES (118, 'B. 2'); -- 596
INSERT INTO choices (question_id, choice_text) VALUES (118, 'C. 3'); -- 597〇
INSERT INTO choices (question_id, choice_text) VALUES (118, 'D. 4'); -- 598

INSERT INTO choices (question_id, choice_text) VALUES (119, 'A. アだけ'); -- 599
INSERT INTO choices (question_id, choice_text) VALUES (119, 'B. イだけ'); -- 600
INSERT INTO choices (question_id, choice_text) VALUES (119, 'C. ウだけ'); -- 601〇
INSERT INTO choices (question_id, choice_text) VALUES (119, 'D. アとイ'); -- 602

INSERT INTO choices (question_id, choice_text) VALUES (120, 'A. アとイの両方'); -- 603
INSERT INTO choices (question_id, choice_text) VALUES (120, 'B. アとウの両方'); -- 604
INSERT INTO choices (question_id, choice_text) VALUES (120, 'C. アとエの両方'); -- 605
INSERT INTO choices (question_id, choice_text) VALUES (120, 'D. イとウの両方'); -- 606
INSERT INTO choices (question_id, choice_text) VALUES (120, 'E. イとエの両方'); -- 607〇


INSERT INTO choices (question_id, choice_text) VALUES (121, 'A. 21%'); -- 608
INSERT INTO choices (question_id, choice_text) VALUES (121, 'B. 24%'); -- 609〇
INSERT INTO choices (question_id, choice_text) VALUES (121, 'C. 27%'); -- 610
INSERT INTO choices (question_id, choice_text) VALUES (121, 'D. 29%'); -- 611

INSERT INTO choices (question_id, choice_text) VALUES (122, 'A. 15%'); -- 612
INSERT INTO choices (question_id, choice_text) VALUES (122, 'B. 17%'); -- 613
INSERT INTO choices (question_id, choice_text) VALUES (122, 'C. 21%'); -- 614
INSERT INTO choices (question_id, choice_text) VALUES (122, 'D. 25%'); -- 615〇

INSERT INTO choices (question_id, choice_text) VALUES (123, 'A. 25%'); -- 616
INSERT INTO choices (question_id, choice_text) VALUES (123, 'B. 35%'); -- 617〇
INSERT INTO choices (question_id, choice_text) VALUES (123, 'C. 45%'); -- 618
INSERT INTO choices (question_id, choice_text) VALUES (123, 'D. 50%'); -- 619

INSERT INTO choices (question_id, choice_text) VALUES (124, 'A. 60人'); -- 620〇
INSERT INTO choices (question_id, choice_text) VALUES (124, 'B. 80人'); -- 621
INSERT INTO choices (question_id, choice_text) VALUES (124, 'C. 100人'); -- 622
INSERT INTO choices (question_id, choice_text) VALUES (124, 'D. 110人'); -- 623

INSERT INTO choices (question_id, choice_text) VALUES (125, 'A. 70%'); -- 624
INSERT INTO choices (question_id, choice_text) VALUES (125, 'B. 80%'); -- 625
INSERT INTO choices (question_id, choice_text) VALUES (125, 'C. 87%'); -- 626
INSERT INTO choices (question_id, choice_text) VALUES (125, 'D. 93%'); -- 627〇

INSERT INTO choices (question_id, choice_text) VALUES (126, 'A. 3/5'); -- 628
INSERT INTO choices (question_id, choice_text) VALUES (126, 'B. 3/11'); -- 629
INSERT INTO choices (question_id, choice_text) VALUES (126, 'C. 9/20'); -- 630
INSERT INTO choices (question_id, choice_text) VALUES (126, 'D. 17/20'); -- 631〇

INSERT INTO choices (question_id, choice_text) VALUES (127, 'A. 3%'); -- 632〇
INSERT INTO choices (question_id, choice_text) VALUES (127, 'B. 9%'); -- 633
INSERT INTO choices (question_id, choice_text) VALUES (127, 'C. 15%'); -- 634
INSERT INTO choices (question_id, choice_text) VALUES (127, 'D. 18%'); -- 635

INSERT INTO choices (question_id, choice_text) VALUES (128, 'A. 1%'); -- 636
INSERT INTO choices (question_id, choice_text) VALUES (128, 'B. 3%'); -- 637
INSERT INTO choices (question_id, choice_text) VALUES (128, 'C. 5%'); -- 638
INSERT INTO choices (question_id, choice_text) VALUES (128, 'D. 8%'); -- 639〇

INSERT INTO choices (question_id, choice_text) VALUES (129, 'A. 18%'); -- 640
INSERT INTO choices (question_id, choice_text) VALUES (129, 'B. 20%'); -- 641
INSERT INTO choices (question_id, choice_text) VALUES (129, 'C. 22%'); -- 642〇
INSERT INTO choices (question_id, choice_text) VALUES (129, 'D. 24%'); -- 643

INSERT INTO choices (question_id, choice_text) VALUES (130, 'A. 60人'); -- 644
INSERT INTO choices (question_id, choice_text) VALUES (130, 'B. 80人'); -- 645
INSERT INTO choices (question_id, choice_text) VALUES (130, 'C. 100人'); -- 646〇
INSERT INTO choices (question_id, choice_text) VALUES (130, 'D. 120人'); -- 647

INSERT INTO choices (question_id, choice_text) VALUES (131, 'A. 2/25'); -- 648
INSERT INTO choices (question_id, choice_text) VALUES (131, 'B. 2/5'); -- 649
INSERT INTO choices (question_id, choice_text) VALUES (131, 'C. 1/10'); -- 650〇
INSERT INTO choices (question_id, choice_text) VALUES (131, 'D. 3/5'); -- 651

INSERT INTO choices (question_id, choice_text) VALUES (132, 'A. 5/26'); -- 652
INSERT INTO choices (question_id, choice_text) VALUES (132, 'B. 5/13'); -- 653
INSERT INTO choices (question_id, choice_text) VALUES (132, 'C. 109/169'); -- 654
INSERT INTO choices (question_id, choice_text) VALUES (132, 'D. 60/169'); -- 655〇

INSERT INTO choices (question_id, choice_text) VALUES (133, 'A. 0.42'); -- 656
INSERT INTO choices (question_id, choice_text) VALUES (133, 'B. 0.54'); -- 657〇
INSERT INTO choices (question_id, choice_text) VALUES (133, 'C. 0.72'); -- 658
INSERT INTO choices (question_id, choice_text) VALUES (133, 'D. 0.90'); -- 659

INSERT INTO choices (question_id, choice_text) VALUES (134, 'A. 6人'); -- 660
INSERT INTO choices (question_id, choice_text) VALUES (134, 'B. 7人'); -- 661
INSERT INTO choices (question_id, choice_text) VALUES (134, 'C. 8人'); -- 662
INSERT INTO choices (question_id, choice_text) VALUES (134, 'D. 9人'); -- 663〇

INSERT INTO choices (question_id, choice_text) VALUES (135, 'A. 2/16'); -- 664
INSERT INTO choices (question_id, choice_text) VALUES (135, 'B. 8/21'); -- 665
INSERT INTO choices (question_id, choice_text) VALUES (135, 'C. 11/13'); -- 666
INSERT INTO choices (question_id, choice_text) VALUES (135, 'D. 5/32'); -- 667〇

INSERT INTO choices (question_id, choice_text) VALUES (136, 'A. 7/16'); -- 668〇
INSERT INTO choices (question_id, choice_text) VALUES (136, 'B. 7/8'); -- 669
INSERT INTO choices (question_id, choice_text) VALUES (136, 'C. 3/8'); -- 670
INSERT INTO choices (question_id, choice_text) VALUES (136, 'D. 4/5'); -- 671

INSERT INTO choices (question_id, choice_text) VALUES (137, 'A. 4/9'); -- 672
INSERT INTO choices (question_id, choice_text) VALUES (137, 'B. 5/8'); -- 673
INSERT INTO choices (question_id, choice_text) VALUES (137, 'C. 3/7'); -- 674〇
INSERT INTO choices (question_id, choice_text) VALUES (137, 'D. 1/6'); -- 675

INSERT INTO choices (question_id, choice_text) VALUES (138, 'A. 1/5'); -- 676
INSERT INTO choices (question_id, choice_text) VALUES (138, 'B. 1/6'); -- 677〇
INSERT INTO choices (question_id, choice_text) VALUES (138, 'C. 1/18'); -- 678
INSERT INTO choices (question_id, choice_text) VALUES (138, 'D. 1/30'); -- 679

INSERT INTO choices (question_id, choice_text) VALUES (139, 'A. 0.15'); -- 680
INSERT INTO choices (question_id, choice_text) VALUES (139, 'B. 0.45'); -- 681
INSERT INTO choices (question_id, choice_text) VALUES (139, 'C. 0.56'); -- 682〇
INSERT INTO choices (question_id, choice_text) VALUES (139, 'D. 0.67'); -- 683

INSERT INTO choices (question_id, choice_text) VALUES (140, 'A. 0.12'); -- 684〇
INSERT INTO choices (question_id, choice_text) VALUES (140, 'B. 0.13'); -- 685
INSERT INTO choices (question_id, choice_text) VALUES (140, 'C. 0.23'); -- 686
INSERT INTO choices (question_id, choice_text) VALUES (140, 'D. 0.42'); -- 687

INSERT INTO choices (question_id, choice_text) VALUES (141, 'A. Xに4600円Yは3000円支払う'); -- 688
INSERT INTO choices (question_id, choice_text) VALUES (141, 'B. Xに5400円Yは2100円支払う'); -- 689〇
INSERT INTO choices (question_id, choice_text) VALUES (141, 'C. Xに5400円Yは2900円支払う'); -- 690
INSERT INTO choices (question_id, choice_text) VALUES (141, 'D. Xに7500円支払う'); -- 691
INSERT INTO choices (question_id, choice_text) VALUES (141, 'E. Yに9600円支払う'); -- 692

INSERT INTO choices (question_id, choice_text) VALUES (142, 'A. 5600円'); -- 693
INSERT INTO choices (question_id, choice_text) VALUES (142, 'B. 5350円'); -- 694
INSERT INTO choices (question_id, choice_text) VALUES (142, 'C. 5950円'); -- 695〇
INSERT INTO choices (question_id, choice_text) VALUES (142, 'D. 5550円'); -- 696

INSERT INTO choices (question_id, choice_text) VALUES (143, 'A. 3850円'); -- 697
INSERT INTO choices (question_id, choice_text) VALUES (143, 'B. 115000円'); -- 698
INSERT INTO choices (question_id, choice_text) VALUES (143, 'C. 45000円'); -- 699
INSERT INTO choices (question_id, choice_text) VALUES (143, 'D. 38500円'); -- 700〇

INSERT INTO choices (question_id, choice_text) VALUES (144, 'A. 15000円'); -- 701
INSERT INTO choices (question_id, choice_text) VALUES (144, 'B. 13800円'); -- 702
INSERT INTO choices (question_id, choice_text) VALUES (144, 'C. 10000円'); -- 703
INSERT INTO choices (question_id, choice_text) VALUES (144, 'D. 13200円'); -- 704〇
INSERT INTO choices (question_id, choice_text) VALUES (144, 'E. 9600円'); -- 705

INSERT INTO choices (question_id, choice_text) VALUES (145, 'A. 負担額は揃っている'); -- 706
INSERT INTO choices (question_id, choice_text) VALUES (145, 'B. PにQが4900円 Rが2500円'); -- 707
INSERT INTO choices (question_id, choice_text) VALUES (145, 'C. PにQが2500円 Rも2500円'); -- 708〇
INSERT INTO choices (question_id, choice_text) VALUES (145, 'D. PがQとRに450円ずつ'); -- 709

INSERT INTO choices (question_id, choice_text) VALUES (146, 'A. 12時〜18時'); -- 710
INSERT INTO choices (question_id, choice_text) VALUES (146, 'B. 9時〜15時'); -- 711
INSERT INTO choices (question_id, choice_text) VALUES (146, 'C. 10時〜16時'); -- 712
INSERT INTO choices (question_id, choice_text) VALUES (146, 'D. 11時〜17時'); -- 713〇

INSERT INTO choices (question_id, choice_text) VALUES (147, 'A. P：475円 Q：450円'); -- 714〇
INSERT INTO choices (question_id, choice_text) VALUES (147, 'B. P：500円 Q：450円'); -- 715
INSERT INTO choices (question_id, choice_text) VALUES (147, 'C. P：470円 Q：425円'); -- 716
INSERT INTO choices (question_id, choice_text) VALUES (147, 'D. P：525円 Q：425円'); -- 717

INSERT INTO choices (question_id, choice_text) VALUES (148, 'A. 1200円'); -- 718
INSERT INTO choices (question_id, choice_text) VALUES (148, 'B. 400円'); -- 719〇
INSERT INTO choices (question_id, choice_text) VALUES (148, 'C. 200円'); -- 720
INSERT INTO choices (question_id, choice_text) VALUES (148, 'D. 500円'); -- 721

INSERT INTO choices (question_id, choice_text) VALUES (149, 'A. 25人'); -- 722〇
INSERT INTO choices (question_id, choice_text) VALUES (149, 'B. 28人'); -- 723
INSERT INTO choices (question_id, choice_text) VALUES (149, 'C. 35人'); -- 724
INSERT INTO choices (question_id, choice_text) VALUES (149, 'D. 70人'); -- 725

INSERT INTO choices (question_id, choice_text) VALUES (150, 'A. 150円'); -- 726
INSERT INTO choices (question_id, choice_text) VALUES (150, 'B. 200円'); -- 727〇
INSERT INTO choices (question_id, choice_text) VALUES (150, 'C. 220円'); -- 728
INSERT INTO choices (question_id, choice_text) VALUES (150, 'D. 300円'); -- 729

INSERT INTO choices (question_id, choice_text) VALUES (151, 'A. 5/21'); -- 730
INSERT INTO choices (question_id, choice_text) VALUES (151, 'B. 2/3'); -- 731
INSERT INTO choices (question_id, choice_text) VALUES (151, 'C. 31/51'); -- 732〇
INSERT INTO choices (question_id, choice_text) VALUES (151, 'D. 46/51'); -- 733

INSERT INTO choices (question_id, choice_text) VALUES (152, 'A. 4/21'); -- 734〇
INSERT INTO choices (question_id, choice_text) VALUES (152, 'B. 1/21'); -- 735
INSERT INTO choices (question_id, choice_text) VALUES (152, 'C. 1/7'); -- 736
INSERT INTO choices (question_id, choice_text) VALUES (152, 'D. 12/35'); -- 737

INSERT INTO choices (question_id, choice_text) VALUES (153, 'A. 1/14'); -- 738
INSERT INTO choices (question_id, choice_text) VALUES (153, 'B. 17/24'); -- 739
INSERT INTO choices (question_id, choice_text) VALUES (153, 'C. 10/21'); -- 740
INSERT INTO choices (question_id, choice_text) VALUES (153, 'D. 7/12'); -- 741〇

INSERT INTO choices (question_id, choice_text) VALUES (154, 'A. 1.5'); -- 742
INSERT INTO choices (question_id, choice_text) VALUES (154, 'B. 1.6'); -- 743〇
INSERT INTO choices (question_id, choice_text) VALUES (154, 'C. 1.7'); -- 744
INSERT INTO choices (question_id, choice_text) VALUES (154, 'D. 1.8'); -- 745

INSERT INTO choices (question_id, choice_text) VALUES (155, 'A. 3時間'); -- 746〇
INSERT INTO choices (question_id, choice_text) VALUES (155, 'B. 4時間'); -- 747
INSERT INTO choices (question_id, choice_text) VALUES (155, 'C. 5時間'); -- 748
INSERT INTO choices (question_id, choice_text) VALUES (155, 'D. 6時間'); -- 749

INSERT INTO choices (question_id, choice_text) VALUES (156, 'A. 5分'); -- 750
INSERT INTO choices (question_id, choice_text) VALUES (156, 'B. 10分'); -- 751
INSERT INTO choices (question_id, choice_text) VALUES (156, 'C. 15分'); -- 752
INSERT INTO choices (question_id, choice_text) VALUES (156, 'D. 20分'); -- 753〇

INSERT INTO choices (question_id, choice_text) VALUES (157, 'A. 3時間'); -- 754
INSERT INTO choices (question_id, choice_text) VALUES (157, 'B. 5時間'); -- 755
INSERT INTO choices (question_id, choice_text) VALUES (157, 'C. 8時間'); -- 756
INSERT INTO choices (question_id, choice_text) VALUES (157, 'D. 10時間'); -- 757〇

INSERT INTO choices (question_id, choice_text) VALUES (158, 'A. 13000円'); -- 758
INSERT INTO choices (question_id, choice_text) VALUES (158, 'B. 15000円'); -- 759
INSERT INTO choices (question_id, choice_text) VALUES (158, 'C. 18000円'); -- 760
INSERT INTO choices (question_id, choice_text) VALUES (158, 'D. 20000円'); -- 761〇

INSERT INTO choices (question_id, choice_text) VALUES (159, 'A. 15分後'); -- 762
INSERT INTO choices (question_id, choice_text) VALUES (159, 'B. 20分後'); -- 763〇
INSERT INTO choices (question_id, choice_text) VALUES (159, 'C. 25分後'); -- 764
INSERT INTO choices (question_id, choice_text) VALUES (159, 'D. 30分後'); -- 765

INSERT INTO choices (question_id, choice_text) VALUES (160, 'A. 5日目'); -- 766〇
INSERT INTO choices (question_id, choice_text) VALUES (160, 'B. 6日目'); -- 767
INSERT INTO choices (question_id, choice_text) VALUES (160, 'C. 7日目'); -- 768
INSERT INTO choices (question_id, choice_text) VALUES (160, 'D. 8日目'); -- 769


INSERT INTO choices (question_id, choice_text) VALUES (161, 'A. 0.3km/時'); -- 770
INSERT INTO choices (question_id, choice_text) VALUES (161, 'B. 18.0km/時'); -- 771〇
INSERT INTO choices (question_id, choice_text) VALUES (161, 'C. 10.5km/時'); -- 772
INSERT INTO choices (question_id, choice_text) VALUES (161, 'D. 12.5km/時'); -- 773

INSERT INTO choices (question_id, choice_text) VALUES (162, 'A. 10.0km/時'); -- 774
INSERT INTO choices (question_id, choice_text) VALUES (162, 'B. 12.0km/時'); -- 775
INSERT INTO choices (question_id, choice_text) VALUES (162, 'C. 12.5km/時'); -- 776
INSERT INTO choices (question_id, choice_text) VALUES (162, 'D. 13.5km/時'); -- 777〇

INSERT INTO choices (question_id, choice_text) VALUES (163, 'A. 12.0km/時'); -- 778
INSERT INTO choices (question_id, choice_text) VALUES (163, 'B. 14.0km/時'); -- 779
INSERT INTO choices (question_id, choice_text) VALUES (163, 'C. 16.0km/時'); -- 780
INSERT INTO choices (question_id, choice_text) VALUES (163, 'D. 18.0km/時'); -- 781〇

INSERT INTO choices (question_id, choice_text) VALUES (164, 'A. 72.0'); -- 782
INSERT INTO choices (question_id, choice_text) VALUES (164, 'B. 128.0'); -- 783
INSERT INTO choices (question_id, choice_text) VALUES (164, 'C. 164.0'); -- 784〇
INSERT INTO choices (question_id, choice_text) VALUES (164, 'D. 218.0'); -- 785

INSERT INTO choices (question_id, choice_text) VALUES (165, 'A. 45km/時'); -- 786
INSERT INTO choices (question_id, choice_text) VALUES (165, 'B. 78km/時'); -- 787
INSERT INTO choices (question_id, choice_text) VALUES (165, 'C. 120km/時'); -- 788
INSERT INTO choices (question_id, choice_text) VALUES (165, 'D. 135km/時'); -- 789〇

INSERT INTO choices (question_id, choice_text) VALUES (166, 'A. 9'); -- 790〇
INSERT INTO choices (question_id, choice_text) VALUES (166, 'B. 10'); -- 791
INSERT INTO choices (question_id, choice_text) VALUES (166, 'C. 11'); -- 792
INSERT INTO choices (question_id, choice_text) VALUES (166, 'D. 12'); -- 793

INSERT INTO choices (question_id, choice_text) VALUES (167, 'A. 6分'); -- 794
INSERT INTO choices (question_id, choice_text) VALUES (167, 'B. 7分'); -- 795
INSERT INTO choices (question_id, choice_text) VALUES (167, 'C. 8分'); -- 796
INSERT INTO choices (question_id, choice_text) VALUES (167, 'D. 9分'); -- 797〇

INSERT INTO choices (question_id, choice_text) VALUES (168, 'A. 12分'); -- 798
INSERT INTO choices (question_id, choice_text) VALUES (168, 'B. 15分'); -- 799〇
INSERT INTO choices (question_id, choice_text) VALUES (168, 'C. 20分'); -- 800
INSERT INTO choices (question_id, choice_text) VALUES (168, 'D. 25分'); -- 801

INSERT INTO choices (question_id, choice_text) VALUES (169, 'A. 12分'); -- 802
INSERT INTO choices (question_id, choice_text) VALUES (169, 'B. 15分'); -- 803〇
INSERT INTO choices (question_id, choice_text) VALUES (169, 'C. 20分'); -- 804
INSERT INTO choices (question_id, choice_text) VALUES (169, 'D. 25分'); -- 805

INSERT INTO choices (question_id, choice_text) VALUES (170, 'A. 12分'); -- 806〇
INSERT INTO choices (question_id, choice_text) VALUES (170, 'B. 15分'); -- 807
INSERT INTO choices (question_id, choice_text) VALUES (170, 'C. 20分'); -- 808
INSERT INTO choices (question_id, choice_text) VALUES (170, 'D. 25分'); -- 809

INSERT INTO choices (question_id, choice_text) VALUES (171, 'A. 34人'); -- 810
INSERT INTO choices (question_id, choice_text) VALUES (171, 'B. 36人'); -- 811
INSERT INTO choices (question_id, choice_text) VALUES (171, 'C. 38人'); -- 812
INSERT INTO choices (question_id, choice_text) VALUES (171, 'D. 40人'); -- 813〇

INSERT INTO choices (question_id, choice_text) VALUES (172, 'A. 70人'); -- 814
INSERT INTO choices (question_id, choice_text) VALUES (172, 'B. 75人'); -- 815〇
INSERT INTO choices (question_id, choice_text) VALUES (172, 'C. 80人'); -- 816
INSERT INTO choices (question_id, choice_text) VALUES (172, 'D. 85人'); -- 817

INSERT INTO choices (question_id, choice_text) VALUES (173, 'A. 51人'); -- 818〇
INSERT INTO choices (question_id, choice_text) VALUES (173, 'B. 53人'); -- 819
INSERT INTO choices (question_id, choice_text) VALUES (173, 'C. 55人'); -- 820
INSERT INTO choices (question_id, choice_text) VALUES (173, 'D. 57人'); -- 821

INSERT INTO choices (question_id, choice_text) VALUES (174, 'A. 6人'); -- 822
INSERT INTO choices (question_id, choice_text) VALUES (174, 'B. 7人'); -- 823
INSERT INTO choices (question_id, choice_text) VALUES (174, 'C. 8人'); -- 824
INSERT INTO choices (question_id, choice_text) VALUES (174, 'D. 9人'); -- 825〇

INSERT INTO choices (question_id, choice_text) VALUES (175, 'A. 50人'); -- 826
INSERT INTO choices (question_id, choice_text) VALUES (175, 'B. 60人'); -- 827
INSERT INTO choices (question_id, choice_text) VALUES (175, 'C. 70人'); -- 828〇
INSERT INTO choices (question_id, choice_text) VALUES (175, 'D. 80人'); -- 829

INSERT INTO choices (question_id, choice_text) VALUES (176, 'A. 5人'); -- 830
INSERT INTO choices (question_id, choice_text) VALUES (176, 'B. 10人'); -- 831〇
INSERT INTO choices (question_id, choice_text) VALUES (176, 'C. 15人'); -- 832
INSERT INTO choices (question_id, choice_text) VALUES (176, 'D. 20人'); -- 833

INSERT INTO choices (question_id, choice_text) VALUES (177, 'A. 10人'); -- 834〇
INSERT INTO choices (question_id, choice_text) VALUES (177, 'B. 11人'); -- 835
INSERT INTO choices (question_id, choice_text) VALUES (177, 'C. 12人'); -- 836
INSERT INTO choices (question_id, choice_text) VALUES (177, 'D. 13人'); -- 837

INSERT INTO choices (question_id, choice_text) VALUES (178, 'A. 13人'); -- 838
INSERT INTO choices (question_id, choice_text) VALUES (178, 'B. 14人'); -- 839
INSERT INTO choices (question_id, choice_text) VALUES (178, 'C. 15人'); -- 840〇
INSERT INTO choices (question_id, choice_text) VALUES (178, 'D. 16人'); -- 841

INSERT INTO choices (question_id, choice_text) VALUES (179, 'A. 30人'); -- 842
INSERT INTO choices (question_id, choice_text) VALUES (179, 'B. 35人'); -- 843〇
INSERT INTO choices (question_id, choice_text) VALUES (179, 'C. 40人'); -- 844
INSERT INTO choices (question_id, choice_text) VALUES (179, 'D. 45人'); -- 845

INSERT INTO choices (question_id, choice_text) VALUES (180, 'A. 135人'); -- 846
INSERT INTO choices (question_id, choice_text) VALUES (180, 'B. 140人'); -- 847
INSERT INTO choices (question_id, choice_text) VALUES (180, 'C. 145人'); -- 848
INSERT INTO choices (question_id, choice_text) VALUES (180, 'D. 150人'); -- 849〇


INSERT INTO choices (question_id, choice_text) VALUES (181, 'A. 38.3%'); -- 850
INSERT INTO choices (question_id, choice_text) VALUES (181, 'B. 42.3%'); -- 851〇
INSERT INTO choices (question_id, choice_text) VALUES (181, 'C. 44.3%'); -- 852
INSERT INTO choices (question_id, choice_text) VALUES (181, 'D. 45.3%'); -- 853

INSERT INTO choices (question_id, choice_text) VALUES (182, 'A. 38.3%'); -- 854
INSERT INTO choices (question_id, choice_text) VALUES (182, 'B. 40.3%'); -- 855
INSERT INTO choices (question_id, choice_text) VALUES (182, 'C. 42.3%'); -- 856〇
INSERT INTO choices (question_id, choice_text) VALUES (182, 'D. 44.3%'); -- 857

INSERT INTO choices (question_id, choice_text) VALUES (183, 'A. 5%'); -- 858
INSERT INTO choices (question_id, choice_text) VALUES (183, 'B. 10%'); -- 859
INSERT INTO choices (question_id, choice_text) VALUES (183, 'C. 15%'); -- 860〇
INSERT INTO choices (question_id, choice_text) VALUES (183, 'D. 20%'); -- 861

INSERT INTO choices (question_id, choice_text) VALUES (184, 'A. 1.4倍'); -- 862
INSERT INTO choices (question_id, choice_text) VALUES (184, 'B. 2.9倍'); -- 863
INSERT INTO choices (question_id, choice_text) VALUES (184, 'C. 7.9倍'); -- 864〇
INSERT INTO choices (question_id, choice_text) VALUES (184, 'D. 9.4倍'); -- 865

INSERT INTO choices (question_id, choice_text) VALUES (185, 'A. 60人'); -- 866〇
INSERT INTO choices (question_id, choice_text) VALUES (185, 'B. 65人'); -- 867
INSERT INTO choices (question_id, choice_text) VALUES (185, 'C. 70人'); -- 868
INSERT INTO choices (question_id, choice_text) VALUES (185, 'D. 75人'); -- 869

INSERT INTO choices (question_id, choice_text) VALUES (186, 'A. 20%'); -- 870
INSERT INTO choices (question_id, choice_text) VALUES (186, 'B. 24%'); -- 871〇
INSERT INTO choices (question_id, choice_text) VALUES (186, 'C. 28%'); -- 872
INSERT INTO choices (question_id, choice_text) VALUES (186, 'D. 32%'); -- 873

INSERT INTO choices (question_id, choice_text) VALUES (187, 'A. 9.0%'); -- 874
INSERT INTO choices (question_id, choice_text) VALUES (187, 'B. 9.1%'); -- 875
INSERT INTO choices (question_id, choice_text) VALUES (187, 'C. 9.2%'); -- 876〇
INSERT INTO choices (question_id, choice_text) VALUES (187, 'D. 9.3%'); -- 877

INSERT INTO choices (question_id, choice_text) VALUES (188, 'A. 377人'); -- 878
INSERT INTO choices (question_id, choice_text) VALUES (188, 'B. 778人'); -- 879
INSERT INTO choices (question_id, choice_text) VALUES (188, 'C. 868人'); -- 880〇
INSERT INTO choices (question_id, choice_text) VALUES (188, 'D. 948人'); -- 881

INSERT INTO choices (question_id, choice_text) VALUES (189, 'A. 10人'); -- 882
INSERT INTO choices (question_id, choice_text) VALUES (189, 'B. 17人'); -- 883
INSERT INTO choices (question_id, choice_text) VALUES (189, 'C. 18人'); -- 884〇
INSERT INTO choices (question_id, choice_text) VALUES (189, 'D. 19人'); -- 885

INSERT INTO choices (question_id, choice_text) VALUES (190, 'A. 1150人'); -- 886〇
INSERT INTO choices (question_id, choice_text) VALUES (190, 'B. 1170人'); -- 887
INSERT INTO choices (question_id, choice_text) VALUES (190, 'C. 1190人'); -- 888
INSERT INTO choices (question_id, choice_text) VALUES (190, 'D. 1210人'); -- 889

INSERT INTO choices (question_id, choice_text) VALUES (191, 'A. 5年後'); -- 890
INSERT INTO choices (question_id, choice_text) VALUES (191, 'B. 12年後'); -- 891
INSERT INTO choices (question_id, choice_text) VALUES (191, 'C. 18年後'); -- 892
INSERT INTO choices (question_id, choice_text) VALUES (191, 'D. 24年後'); -- 893〇

INSERT INTO choices (question_id, choice_text) VALUES (192, 'A. 0個'); -- 894
INSERT INTO choices (question_id, choice_text) VALUES (192, 'B. 1個'); -- 895〇
INSERT INTO choices (question_id, choice_text) VALUES (192, 'C. 2個'); -- 896
INSERT INTO choices (question_id, choice_text) VALUES (192, 'D. 3個'); -- 897

INSERT INTO choices (question_id, choice_text) VALUES (193, 'A. 200個'); -- 898〇
INSERT INTO choices (question_id, choice_text) VALUES (193, 'B. 300個'); -- 899
INSERT INTO choices (question_id, choice_text) VALUES (193, 'C. 400個'); -- 900
INSERT INTO choices (question_id, choice_text) VALUES (193, 'D. 600個'); -- 901

INSERT INTO choices (question_id, choice_text) VALUES (194, 'A. 5個'); -- 902
INSERT INTO choices (question_id, choice_text) VALUES (194, 'B. 6個'); -- 903
INSERT INTO choices (question_id, choice_text) VALUES (194, 'C. 7個'); -- 904
INSERT INTO choices (question_id, choice_text) VALUES (194, 'D. 8個'); -- 905〇

INSERT INTO choices (question_id, choice_text) VALUES (195, 'A. 1枚'); -- 906
INSERT INTO choices (question_id, choice_text) VALUES (195, 'B. 2枚'); -- 907〇
INSERT INTO choices (question_id, choice_text) VALUES (195, 'C. 3枚'); -- 908
INSERT INTO choices (question_id, choice_text) VALUES (195, 'D. 4枚'); -- 909

INSERT INTO choices (question_id, choice_text) VALUES (196, 'A. 1個'); -- 910
INSERT INTO choices (question_id, choice_text) VALUES (196, 'B. 3個'); -- 911
INSERT INTO choices (question_id, choice_text) VALUES (196, 'C. 5個'); -- 912〇
INSERT INTO choices (question_id, choice_text) VALUES (196, 'D. 7個'); -- 913

INSERT INTO choices (question_id, choice_text) VALUES (197, 'A. 2年後'); -- 914
INSERT INTO choices (question_id, choice_text) VALUES (197, 'B. 4年後'); -- 915〇
INSERT INTO choices (question_id, choice_text) VALUES (197, 'C. 8年後'); -- 916
INSERT INTO choices (question_id, choice_text) VALUES (197, 'D. 12年後'); -- 917

INSERT INTO choices (question_id, choice_text) VALUES (198, 'A. 18本'); -- 918
INSERT INTO choices (question_id, choice_text) VALUES (198, 'B. 19本'); -- 919
INSERT INTO choices (question_id, choice_text) VALUES (198, 'C. 20本'); -- 920〇
INSERT INTO choices (question_id, choice_text) VALUES (198, 'D. 21本'); -- 921

INSERT INTO choices (question_id, choice_text) VALUES (199, 'A. 38本'); -- 922
INSERT INTO choices (question_id, choice_text) VALUES (199, 'B. 39本'); -- 923
INSERT INTO choices (question_id, choice_text) VALUES (199, 'C. 40本'); -- 924
INSERT INTO choices (question_id, choice_text) VALUES (199, 'D. 41本'); -- 925〇

INSERT INTO choices (question_id, choice_text) VALUES (200, 'A. 50人'); -- 926
INSERT INTO choices (question_id, choice_text) VALUES (200, 'B. 55人'); -- 927
INSERT INTO choices (question_id, choice_text) VALUES (200, 'C. 65人'); -- 928
INSERT INTO choices (question_id, choice_text) VALUES (200, 'D. 80人'); -- 929〇

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
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (11, 57, '1_1_11');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (12, 67, '1_1_12');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (13, 68, '1_1_13');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (14, 75, '1_1_14');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (15, 82, '1_1_15');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (16, 88, '1_1_16');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (17, 92, '1_1_17');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (18, 99, '1_1_18');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (19, 103, '1_1_19');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (20, 108, '1_1_20');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (21, 115, '1_2_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (22, 117, '1_2_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (23, 126, '1_2_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (24, 130, '1_2_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (25, 136, '1_2_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (26, 137, '1_2_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (27, 142, '1_2_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (28, 149, '1_2_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (29, 156, '1_2_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (30, 161, '1_2_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (31, 164, '1_2_11');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (32, 171, '1_2_12');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (33, 172, '1_2_13');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (34, 178, '1_2_14');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (35, 183, '1_2_15');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (36, 187, '1_2_16');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (37, 190, '1_2_17');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (38, 192, '1_2_18');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (39, 199, '1_2_19');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (40, 202, '1_2_20');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (41, 207, '1_3_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (42, 209, '1_3_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (43, 215, '1_3_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (44, 221, '1_3_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (45, 224, '1_3_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (46, 233, '1_3_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (47, 237, '1_3_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (48, 241, '1_3_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (49, 245, '1_3_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (50, 253, '1_3_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (51, 256, '1_3_11');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (52, 263, '1_3_12');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (53, 268, '1_3_13');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (54, 272, '1_3_14');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (55, 274, '1_3_15');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (56, 280, '1_3_16');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (57, 286, '1_3_17');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (58, 289, '1_3_18');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (59, 294, '1_3_19');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (60, 302, '1_3_20');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (61, 308, '1_4_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (62, 309, '1_4_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (63, 314, '1_4_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (64, 319, '1_4_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (65, 326, '1_4_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (66, 329, '1_4_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (67, 334, '1_4_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (68, 339, '1_4_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (69, 345, '1_4_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (70, 352, '1_4_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (71, 353, '1_4_11');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (72, 361, '1_4_12');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (73, 367, '1_4_13');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (74, 372, '1_4_14');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (75, 377, '1_4_15');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (76, 380, '1_4_16');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (77, 389, '1_4_17');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (78, 395, '1_4_18');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (79, 402, '1_4_19');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (80, 406, '1_4_20');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (81, 413, '1_5_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (82, 415, '1_5_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (83, 424, '1_5_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (84, 426, '1_5_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (85, 433, '1_5_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (86, 438, '1_5_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (87, 440, '1_5_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (88, 448, '1_5_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (89, 450, '1_5_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (90, 456, '1_5_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (91, 464, '1_5_11');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (92, 468, '1_5_12');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (93, 471, '1_5_13');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (94, 480, '1_5_14');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (95, 481, '1_5_15');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (96, 489, '1_5_16');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (97, 494, '1_5_17');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (98, 497, '1_5_18');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (99, 504, '1_5_19');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (100, 511, '1_5_20');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (101, 516, '2_1_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (102, 520, '2_1_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (103, 526, '2_1_3'); 
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (104, 529, '2_1_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (105, 534, '2_1_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (106, 539, '2_1_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (107, 545, '2_1_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (108, 551, '2_1_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (109, 553, '2_1_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (110, 557, '2_1_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (111, 564, '2_2_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (112, 567, '2_2_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (113, 573, '2_2_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (114, 575 ,'2_2_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (115, 583, '2_2_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (116, 587, '2_2_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (117, 591, '2_2_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (118, 597, '2_2_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (119, 601, '2_2_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (120, 607, '2_2_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (121, 609, '2_3_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (122, 615, '2_3_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (123, 617, '2_3_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (124, 620, '2_3_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (125, 627, '2_3_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (126, 631, '2_3_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (127, 632, '2_3_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (128, 639, '2_3_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (129, 642, '2_3_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (130, 646, '2_3_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (131, 650, '2_4_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (132, 655, '2_4_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (133, 657, '2_4_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (134, 663, '2_4_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (135, 667, '2_4_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (136, 668, '2_4_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (137, 674, '2_4_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (138, 677, '2_4_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (139, 682, '2_4_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (140, 684, '2_4_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (141, 689, '2_5_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (142, 695, '2_5_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (143, 700, '2_5_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (144, 704, '2_5_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (145, 708, '2_5_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (146, 713, '2_5_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (147, 714, '2_5_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (148, 719, '2_5_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (149, 722, '2_5_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (150, 727, '2_5_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (151, 732, '2_6_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (152, 734, '2_6_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (153, 741, '2_6_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (154, 743, '2_6_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (155, 746, '2_6_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (156, 753, '2_6_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (157, 757, '2_6_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (158, 761, '2_6_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (159, 763, '2_6_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (160, 766, '2_6_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (161, 771, '2_7_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (162, 777, '2_7_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (163, 781, '2_7_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (164, 784, '2_7_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (165, 789, '2_7_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (166, 790, '2_7_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (167, 797, '2_7_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (168, 799, '2_7_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (169, 803, '2_7_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (170, 806, '2_7_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (171, 813, '2_8_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (172, 815, '2_8_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (173, 818, '2_8_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (174, 825, '2_8_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (175, 828, '2_8_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (176, 831, '2_8_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (177, 834, '2_8_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (178, 840, '2_8_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (179, 843, '2_8_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (180, 849, '2_8_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (181, 851, '2_9_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (182, 856, '2_9_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (183, 860, '2_9_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (184, 864, '2_9_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (185, 866, '2_9_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (186, 871, '2_9_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (187, 876, '2_9_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (188, 880, '2_9_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (189, 884, '2_9_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (190, 886, '2_9_10');

INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (191, 893, '2_10_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (192, 895, '2_10_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (193, 898, '2_10_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (194, 905, '2_10_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (195, 907, '2_10_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (196, 912, '2_10_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (197, 915, '2_10_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (198, 920, '2_10_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (199, 925, '2_10_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (200, 927, '2_10_10');
