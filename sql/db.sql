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
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (11,1,2,30,'語句の意味','1_2_1','「非常に優れていること、他よりも際立っていること」');
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
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (33,1,4,30,'文章整序','1_4_1','食生活の改善が [１][２][３][４][５] 健康的な体を保つために必要です。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (34,1,4,30,'文章整序','1_4_2','彼の意見は [１][２][３][４][５] 採用される可能性が高い。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (35,1,4,30,'文章整序','1_4_3','技術革新は [１][２][３][４][５] 社会の発展に大きく貢献しています。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (36,1,4,30,'文章整序','1_4_4','環境保護のためには [１][２][３][４][５] 取り組む必要があります。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (37,1,4,30,'文章整序','1_4_5','教育改革は [１][２][３][４][５] 成果を上げている。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (38,1,4,30,'文章整序','1_4_6','グローバル化は [１][２][３][４][５] 必要となっています。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (39,1,4,30,'文章整序','1_4_7','日本の伝統文化は [１][２][３][４][５] 継承されています。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (40,1,4,30,'文章整序','1_4_8','情報セキュリティは [１][２][３][４][５] 対策が重要です。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (41,1,4,30,'文章整序','1_4_9','自然災害に備えるために [１][２][３][４][５] 必要があります。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (42,1,4,30,'文章整序','1_4_10','人間関係のトラブルを解決するために[１][２][３][４][５] 必要です。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (43,1,5,30,'空欄補充','1_5_1','部長は新しい企画に[ ]を入れた。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (44,1,5,30,'空欄補充','1_5_2','この計画を実行するためには、彼の[ ]が不可欠だ。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (45,1,5,30,'空欄補充','1_5_3','彼は仕事に対して[ ]の精神を持っている。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (46,1,5,30,'空欄補充','1_5_4','会議中に彼は何度も[ ]を見せた。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (47,1,5,30,'空欄補充','1_5_5','彼は新しい環境に[ ]した。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (48,1,5,30,'空欄補充','1_5_6','この書類に[ ]をする必要がある。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (49,1,5,30,'空欄補充','1_5_7','彼はその問題に対して迅速に[ ]した。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (50,1,5,30,'空欄補充','1_5_8','新しい政策は市民の[ ]を引いた。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (51,1,5,30,'空欄補充','1_5_9','彼はチームの一員として[ ]している。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (52,1,5,30,'空欄補充','1_5_10','彼の発言は会議の[ ]を左右した。');

-- 非言語問題
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (53,2,1,30,'場合の数','2_1_1','6人のグループから3人を選ぶ方法は何通りありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (54,2,1,30,'場合の数','2_1_2','4人の中から1位と2位を選ぶ方法は何通りありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (55,2,1,30,'場合の数','2_1_3','5つの異なる本を2列に並べる方法は何通りありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (56,2,1,30,'場合の数','2_1_4','赤、青、緑、黄の4色のボールを一列に並べる方法は何通りありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (57,2,1,30,'場合の数','2_1_5','6人の中から2人を選び、さらにその2人の中で役割（リーダーとサブリーダー）を決める方法は何通りありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (58,2,1,30,'場合の数','2_1_6','A、B、C、D の4人を一列に並べる方法で、Aが常に最初に来るとすると何通りありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (59,2,1,30,'場合の数','2_1_7','5種類の異なるジュースから3つを選ぶ方法は何通りありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (60,2,1,30,'場合の数','2_1_8','5人の中から3人を選び、さらにその3人の中で役割（リーダー、副リーダー、メンバー）を決める方法は何通りありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (61,2,1,30,'場合の数','2_1_9','ある町の住民の70%がインターネットを使用しています。インターネットを使用していない住民が300人いる場合、この町の総人口は何人ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (62,2,1,30,'場合の数','2_1_10','ある試験で、全体の得点が200点中、180点を獲得した場合の得点率は何％ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (63,2,2,30,'推論','2_2_1','全ての猫は動物である。一部の猫は黒猫である。以下のうち正しいものはどれか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (64,2,2,30,'推論','2_2_2','全ての花は植物である。一部の植物は花を咲かせない。以下のうち正しいものはどれか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (65,2,2,30,'推論','2_2_3','全ての車は乗り物である。一部の車は電気自動車である。以下のうち正しいものはどれか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (66,2,2,30,'推論','2_2_4','全ての本は紙で作られている。一部の本は小説である。以下のうち正しいものはどれか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (67,2,2,30,'推論','2_2_5','全ての学生は試験を受ける。一部の学生は部活動をしている。以下のうち正しいものはどれか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (68,2,2,30,'推論','2_2_6','全ての鳥は卵を産む。一部の鳥は飛べない。以下のうち正しいものはどれか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (69,2,2,30,'推論','2_2_7','全ての果物は食べられる。一部の果物は酸っぱい。以下のうち正しいものはどれか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (70,2,2,30,'推論','2_2_8','全ての犬は哺乳類である。一部の犬は盲導犬である。以下のうち正しいものはどれか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (71,2,2,30,'推論','2_2_9','全ての映画はフィクションである。一部の映画はドキュメンタリーである。以下のうち正しいものはどれか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (72,2,2,30,'推論','2_2_10','全ての椅子は家具である。一部の椅子は木製である。以下のうち正しいものはどれか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (73,2,3,30,'割合','2_3_1','あるクラスに 30人の生徒がいます。そのうち18人が女性です。このクラスの生徒の何％が女性ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (74,2,3,30,'割合','2_3_2','100個のリンゴのうち20個が腐っていました。腐っているリンゴの割合は何％ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (75,2,3,30,'割合','2_3_3','ある会社には50人の従業員がいます。そのうち40%が管理職です。管理職は何人いますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (76,2,3,30,'割合','2_3_4','ある製品の価格は800円です。これに25%の割引が適用されました。割引後の価格はいくらですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (77,2,3,30,'割合','2_3_5','200人の学生のうち、150人が数学の試験に合格しました。合格率は何％ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (78,2,3,30,'割合','2_3_6','あるプロジェクトに60時間が割り当てられましたが、実際には45時間で完了しました。割り当て時間に対する実際の作業時間の割合は何％ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (79,2,3,30,'割合','2_3_7','ある町には5000人の住民がいます。そのうち60%が成人です。成人の人数は何人ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (80,2,3,30,'割合','2_3_8','ある商品の価格が15%上昇して、920円になりました。価格上昇前の価格はいくらですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (81,2,3,30,'割合','2_3_9','ある町の住民の 70%がインターネットを使用しています。インターネットを使用していない住民が 300 人いる場合、この町の総人口は何人ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (82,2,3,30,'割合','2_3_10','ある試験で、全体の得点が200点中、180点を獲得した場合の得点率は何％ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (83,2,4,30,'確率','2_4_1','1枚の公正なコインを1回投げたとき、表が出る確率は何ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (84,2,4,30,'確率','2_4_2','4人の中から1位と2位を選ぶ方法は何通りありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (85,2,4,30,'確率','2_4_3','5つの異なる本を2列に並べる方法は何通りありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (86,2,4,30,'確率','2_4_4','赤、青、緑、黄の4色のボールを一列に並べる方法は何通りありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (87,2,4,30,'確率','2_4_5','6人の中から2人を選び、さらにその2人の中で役割（リーダーとサブリーダー）を決める方法は何通りありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (88,2,4,30,'確率','2_4_6','あるプロジェクトに60時間が割り当てられましたが、実際には45時間で完了しました。割り当て時間に対する実際の作業時間の割合は何％ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (89,2,4,30,'確率','2_4_7','ある町には5000人の住民がいます。そのうち60%が成人です。成人の人数は何人ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (90,2,4,30,'確率','2_4_8','ある商品の価格が15%上昇して、920円になりました。価格上昇前の価格はいくらですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (91,2,4,30,'確率','2_4_9','ある町の住民の70%がインターネットを使用しています。インターネットを使用していない住民が300人いる場合、この町の総人口は何人ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (92,2,4,30,'確率','2_4_10','ある試験で、全体の得点が200点中、180点を獲得した場合の得点率は何％ですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (93,2,5,30,'金額計算','2_5_1','1 つ 150 円のリンゴを 5 個と、1 つ 120 円のオレンジを 3 個買いました。合計金額はいくらですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (94,2,5,30,'金額計算','2_5_2','1 つ 200 円のケーキを 3 個と、1 つ 100 円のドーナツを 4 個買いました。合計金額はいくらですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (95,2,5,30,'金額計算','2_5_3','1 つ 250 円のサンドイッチを 2 個と、1 つ 180 円のジュースを 3 本買いました。合計金額はいくらですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (96,2,5,30,'金額計算','2_5_4','1 つ 180 円のパンを 4 個と、1 つ 250 円のコーヒーを 2 杯買いました。合計金額はいくらですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (97,2,5,30,'金額計算','2_5_5','1 つ 350 円のピザを 1 枚と、1 つ 200 円のサラダを 2 つ買いました。合計金額はいくらですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (98,2,5,30,'金額計算','2_5_6','1 つ 120 円のアイスクリームを 5 個と、1 つ 300 円のケーキを 3 個買いました。合計金額はいくらですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (99,2,5,30,'金額計算','2_5_7','1 つ 90 円のチョコレートを 10 個と、1 つ 150 円のクッキーを 5 個買いました。合計金額はいくらですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (100,2,5,30,'金額計算','2_5_8','1 つ 500 円のステーキを 2 枚と、1 つ 300 円のスープを 3 杯買いました。合計金額はいくらですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (101,2,5,30,'金額計算','2_5_9','1 つ 400 円のパスタを 2 皿と、1 つ 150 円のドリンクを 4 杯買いました。合計金額はいくらですか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (102,2,5,30,'金額計算','2_5_10','1 つ 350 円のハンバーガーを 3 個と、1 つ 200 円のポテトを 4 つ買いました。合計金額はいくらですか？');




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

INSERT INTO choices (question_id, choice_text) VALUES (10, 'F.イとウ');
INSERT INTO choices (question_id, choice_text) VALUES (10, 'F.イとウ');
INSERT INTO choices (question_id, choice_text) VALUES (10, 'F.イとウ');
INSERT INTO choices (question_id, choice_text) VALUES (10, 'F.イとウ');
INSERT INTO choices (question_id, choice_text) VALUES (10, 'F.イとウ');

INSERT INTO choices (question_id, choice_text) VALUES (11, 'A.花を持たせる');
INSERT INTO choices (question_id, choice_text) VALUES (11, 'B.頭角を現す');
INSERT INTO choices (question_id, choice_text) VALUES (11, 'C.手を焼く');
INSERT INTO choices (question_id, choice_text) VALUES (11, 'D.道を開く');
INSERT INTO choices (question_id, choice_text) VALUES (11, 'E.目をかける');

INSERT INTO choices (question_id, choice_text) VALUES (12, 'A.花を持たせる');
INSERT INTO choices (question_id, choice_text) VALUES (12, 'B.頭角を現す');
INSERT INTO choices (question_id, choice_text) VALUES (12, 'C.手を焼く');
INSERT INTO choices (question_id, choice_text) VALUES (12, 'D.道を開く');
INSERT INTO choices (question_id, choice_text) VALUES (12, 'E.目をかける');

INSERT INTO choices (question_id, choice_text) VALUES (13, 'A.逸脱する');
INSERT INTO choices (question_id, choice_text) VALUES (13, 'B.話が弾む');
INSERT INTO choices (question_id, choice_text) VALUES (13, 'C.脱線する');
INSERT INTO choices (question_id, choice_text) VALUES (13, 'D.切り出す');
INSERT INTO choices (question_id, choice_text) VALUES (13, 'E.一矢報いる');

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
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (11, 61, '1_2_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (12, 72, '1_2_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (13, 79, '1_2_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (14, 83, '1_2_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (15, 89, '1_2_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (16, 91, '1_2_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (17, 96, '1_2_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (18, 102, '1_2_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (19, 105, '1_2_19');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (20, 111, '1_2_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (21, 118, '1_2_11');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (22, 122, '1_2_12');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (23, 129, '1_3_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (24, 134, '1_3_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (25, 136, '1_3_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (26, 144, '1_3_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (27, 148, '1_3_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (28, 152, '1_3_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (29, 157, '1_3_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (30, 163, '1_3_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (31, 169, '1_3_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (32, 170, '1_3_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (33, 176, '1_4_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (34, 182, '1_4_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (35, 189, '1_4_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (36, 190, '1_4_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (37, 196, '1_4_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (38, 203, '1_4_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (39, 205, '1_4_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (40, 209, '1_4_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (41, 215, '1_4_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (42, 220, '1_4_10');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (43, 225, '1_5_1');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (44, 233, '1_5_2');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (45, 237, '1_5_3');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (46, 241, '1_5_4');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (47, 245, '1_5_5');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (48, 250, '1_5_6');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (49, 255, '1_5_7');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (50, 260, '1_5_8');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (51, 265, '1_5_9');
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (52, 270, '1_5_2');





