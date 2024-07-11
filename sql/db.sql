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
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (103,2,6,30,'分担計算','2_6_1','ある学校の生徒 150 人に対して、サッカーが好きな生徒が 90 人、バスケットボールが好きな生徒が 70 人いるとします。このうち、サッカーとバスケットボールの両方が好きな生徒が 30 人いる場合、どちらかのスポーツしか好きではない生徒の人数を求めなさい。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (104,2,6,30,'分担計算','2_6_2','12 人で 300 枚の書類を処理する場合、1 人あたり何枚の書類を処理する必要がありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (105,2,6,30,'分担計算','2_6_3','8 人で 240 個のボールを仕分ける場合、1 人あたり何個のボールを仕分ける必要がありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (106,2,6,30,'分担計算','2_6_4','15 人で 450 冊の本を分類する場合、1 人あたり何冊の本を分類する必要がありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (107,2,6,30,'分担計算','2_6_5','9 人で 540 ページの書類を読む場合、1 人あたり何ページの書類を読む必要がありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (108,2,6,30,'分担計算','2_6_6','20 人で 1000 個の部品を組み立てる場合、1 人あたり何個の部品を組み立てる必要がありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (109,2,6,30,'分担計算','2_6_7','6 人で 180 個のファイルを整理する場合、1 人あたり何個のファイルを整理する必要がありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (110,2,6,30,'分担計算','2_6_8','7 人で 350 個のピースをパズルにはめる場合、1 人あたり何個のピースをはめる必要がありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (111,2,6,30,'分担計算','2_6_9','4 人で 360 個のパーツを検査する場合、1 人あたり何個のパーツを検査する必要がありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (112,2,6,30,'分担計算','2_6_10','5 人で 400 本のペンをチェックする場合、1 人あたり何本のペンをチェックする必要がありますか？');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (113,2,7,30,'速度算','2_7_1','A 駅から B 駅までの距離は 120km である。A 駅を午前 9 時に出発し、B 駅に正午に到着するためには、どの速度で走行する必要があるか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (114,2,7,30,'速度算','2_7_2','X さんは毎朝自転車で通勤している。家から駅までの距離は 8km で、平均速度は 16km/時である。駅から会社までは電車で移動し、平均速度は 60km/時である。X さんが家を出てから会社に着くまでにかかる時間は 40 分である。駅から会社までの距離は何 km か。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (115,2,7,30,'速度算','2_7_3','A 地点から B 地点までの距離は 60km である。A 地点を時速 40km で出発し、B 地点で時速 30km に減速してさらに 40km 進むと、全体で 3 時間かかった。A 地点から B 地点までの距離を求めよ。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (116,2,7,30,'速度算','2_7_4','A 駅から B 駅までの距離は 75km で、B 駅から C 駅までの距離は 25km である。A 駅から C 駅までを時速 50km で移動する場合、所要時間は何時間か。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (117,2,7,30,'速度算','2_7_5','X さんと Y さんは同じ場所を同時に出発し、X さんは時速 10km、Y さんは時速 8km で歩く。X さんが出発してから 30 分後に Y さんが出発した場合、Y さんが X さんに追いつくまでにかかる時間は何時間か。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (118,2,7,30,'速度算','2_7_6','A 駅から B 駅までの距離は 30km で、A 駅を出発してから B 駅に着くまでにかかった時間は 1 時間 30 分である。途中で休憩を 15 分した場合、平均速度は何 km/時か。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (119,2,7,30,'速度算','2_7_7','A 地点から B 地点までの距離は 150km である。A 地点から B 地点までを時速 50km で移動し、B 地点で 1 時間休憩した後、時速 60km で C 地点までさらに 90km 移動した。全体でかかった時間は何時間か。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (120,2,7,30,'速度算','2_7_8','X さんは毎朝自宅から学校まで自転車で通学している。家から学校までの距離は 18km で、平均速度は 12km/時である。学校に遅刻しないためには 8 時 30 分までに到着する必要がある。X さんは何時までに家を出発しなければならないか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (121,2,7,30,'速度算','2_7_9','A 地点から B 地点までの距離は 90km である。A 地点を時速 60km で出発し、B 地点で 30 分休憩した後、時速 80km でさらに C 地点まで 60km 進むと、全体で 3 時間かかった。A 地点から C 地点までの平均速度を求めよ。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (122,2,7,30,'速度算','2_7_10','X さんと Y さんは互いに離れた場所から同時に出発し、X さんは時速 12km、Y さんは時速 8km で歩く。出発後 2 時間で X さんと Y さんが出会った場合、X さんと Y さんの出発点の距離は何 km か。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (123,2,8,30,'集合','2_8_1','ある学校の生徒 150 人に対して、サッカーが好きな生徒が 90 人、バスケットボールが好きな生徒が 70 人いるとします。このうち、サッカーとバスケットボールの両方が好きな生徒が 30 人いる場合、どちらかのスポーツしか好きではない生徒の人数を求めなさい。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (124,2,8,30,'集合','2_8_2','美術部のメンバー 45 人のうち、絵を描くのが好きな人が 30 人、彫刻をするのが好きな人が 25 人います。このうち、絵も彫刻も好きな人が 10 人いる場合、絵か彫刻のどちらかしか好きでない人の人数を求めなさい。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (125,2,8,30,'集合','2_8_3','ある会社の社員 300 人にアンケートを実施したところ、テニスが好きな人が 180 人、ゴルフが好きな人が 150 人いました。このうち、テニスとゴルフの両方が好きな人が 90 人いる場合、テニスかゴルフのどちらかしか好きでない人の人数を求めなさい。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (126,2,8,30,'集合','2_8_4','100 人の学生のうち、数学が好きな学生が 60 人、物理が好きな学生が 50 人いるとします。このうち、数学と物理の両方が好きな学生が 20 人いる場合、数学か物理のどちらかしか好きでない学生の人数を求めなさい。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (127,2,8,30,'集合','2_8_5','あるイベントに参加した 200 人のうち、ジャズが好きな人が 120 人、クラシックが好きな人が 80 人いました。このうち、ジャズとクラシックの両方が好きな人が 40 人いる場合、ジャズかクラシックのどちらかしか好きでない人の人数を求めなさい。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (128,2,8,30,'集合','2_8_6','ある地域の住民 500 人に調査を行ったところ、ランニングが好きな人が 300 人、サイクリングが好きな人が 200 人いました。このうち、ランニングとサイクリングの両方が好きな人が 100 人いる場合、ランニングかサイクリングのどちらかしか好きでない人の人数を求めなさい。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (129,2,8,30,'集合','2_8_7','あるクラスの生徒 50 人のうち、音楽が好きな生徒が 35 人、美術が好きな生徒が 25 人います。このうち、音楽と美術の両方が好きな生徒が 15 人いる場合、音楽か美術のどちらかしか好きでない生徒の人数を求めなさい。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (130,2,8,30,'集合','2_8_8','ある企業の社員 200 人に調査を行ったところ、読書が好きな社員が 120 人、映画が好きな社員が 90 人いました。このうち、読書と映画の両方が好きな社員が 60 人いる場合、読書か映画のどちらかしか好きでない社員の人数を求めなさい。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (131,2,8,30,'集合','2_8_9','ある地域の住民 1000 人にアンケートを行ったところ、コーヒーが好きな人が 600 人、紅茶が好きな人が 400 人いました。このうち、コーヒーと紅茶の両方が好きな人が 200 人いる場合、コーヒーか紅茶のどちらかしか好きでない人の人数を求めなさい。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (132,2,8,30,'集合','2_8_10','ある大学の学生 300 人に調査を行ったところ、数学が得意な学生が 150 人、科学が得意な学生が 120 人いました。このうち、数学と科学の両方が得意な学生が 70 人いる場合、数学か科学のどちらかしか得意でない学生の人数を求めなさい。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (133,2,9,30,'表の読み取り','2_9_1','化合物 A、B、C は H、N、O の 3 種類の原子でできている。A、B、C の 1 分子あたりの原子の個数比は以下の表の通りである。化合物 C の分子に占める H、N、O の各元素のうちで、重さが最も重い元素はどれか。ただし、H の重さを 1 とすると、N は 14、O は 16 であるとする。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (134,2,9,30,'表の読み取り','2_9_2','店 A、店 B、店 C の 3 つの店舗で販売されている商品 X の売上数量の割合は以下の表の通りである。店 A の売上数量は 1000 個、店 B の売上数量は 800 個である。店 C の売上数量はいくらか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (135,2,9,30,'表の読み取り','2_9_3','ある企業の部門 A、B、C の社員数の割合は以下の表の通りである。部門 A の社員数は 250 人、部門 B の社員数は 300 人である。部門 C の社員数はいくらか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (136,2,9,30,'表の読み取り','2_9_4','製品 P、Q、R の生産量はそれぞれ 1000 個、1500 個、2000 個である。これらの製品の売上構成比は以下の表の通りである。製品 R の売上構成比は何%か。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (137,2,9,30,'表の読み取り','2_9_5','企業 X、Y、Z の 3 社が共同で新製品を開発した。開発費用の負担割合は以下の表の通りである。企業 X の負担額は 500 万円、企業 Y の負担額は 300 万円である。企業 Z の負担額はいくらか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (138,2,9,30,'表の読み取り','2_9_6','化合物 P、Q、R は Na、Cl、K の 3 種類の原子でできている。P、Q、R の 1 分子あたりの原子の個数比は以下の表の通りである。化合物 P の分子に占める Na、Cl、K の各元素のうちで、重さが最も重い元素はどれか。ただし、Na の重さを 1 とすると、Cl は 35、K は 39 であるとする。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (139,2,9,30,'表の読み取り','2_9_7','ある会社の部門 X、Y、Z の予算配分の割合は以下の表の通りである。部門 X の予算は 500 万円、部門 Y の予算は 300 万円である。部門 Z の予算はいくらか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (140,2,9,30,'表の読み取り','2_9_8','ある企業の部門 A、B、C の売上高の割合は以下の表の通りである。部門 A の売上高は 2000 万円、部門 B の売上高は 3000 万円である。部門 C の売上高はいくらか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (141,2,9,30,'表の読み取り','2_9_9','化合物 X、Y、Z は H、O、N の 3 種類の原子でできている。X、Y、Z の 1 分子あたりの原子の個数比は以下の表の通りである。化合物 X の分子に占める H、O、N の各元素のうちで、重さが最も重い元素はどれか。ただし、H の重さを 1 とすると、O は 16、N は 14 であるとする。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (142,2,9,30,'表の読み取り','2_9_10','ある学校のクラス A、B、C の生徒数の割合は以下の表の通りである。クラス A の生徒数は 40 人、クラス B の生徒数は 60 人である。クラス C の生徒数はいくらか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (143,2,10,30,'特殊計算','2_10_1','500 円と 300 円の 2 種類の定食がある。合計で 4000 円以内となるように 8 個買いたい。500 円の定食は一番多くて何個買えるか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (144,2,10,30,'特殊計算','2_10_2','700 円と 400 円の 2 種類のスニーカーがある。合計で 7000 円以内となるように 10 足買いたい。700 円のスニーカーは一番多くて何足買えるか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (145,2,10,30,'特殊計算','2_10_3','600 円と 250 円の 2 種類の鉛筆がある。合計で 3500 円以内となるように 9 本買いたい。600 円の鉛筆は一番多くて何本買えるか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (146,2,10,30,'特殊計算','2_10_4','800 円と 500 円の 2 種類のバッグがある。合計で 6000 円以内となるように 10 個買いたい。800 円のバッグは一番多くて何個買えるか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (147,2,10,30,'特殊計算','2_10_5','1000 円と 600 円の 2 種類のノートがある。合計で 7200 円以内となるように 10 冊買いたい。1000 円のノートは一番多くて何冊買えるか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (148,2,10,30,'特殊計算','2_10_6','3000 円と 2000 円の 2 種類の靴がある。合計で 20000 円以内となるように 8 足買いたい。3000 円の靴は一番多くて何足買えるか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (149,2,10,30,'特殊計算','2_10_7','1500 円と 1000 円の 2 種類のバッグがある。合計で 10000 円以内となるように 7 個買いたい。1500 円のバッグは一番多くて何個買えるか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (150,2,10,30,'特殊計算','2_10_8','1200 円と 800 円の 2 種類のシャツがある。合計で 9600 円以内となるように 10 枚買いたい。1200 円のシャツは一番多くて何枚買えるか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (151,2,10,30,'特殊計算','2_10_9','1800 円と 1100 円の 2 種類の帽子がある。合計で 12000 円以内となるように 8 個買いたい。1800 円の帽子は一番多くて何個買えるか。');
INSERT INTO questions (question_id,field_id,genre_id,interval_num,genre_text,question_text,sentence) VALUES (152,2,10,30,'特殊計算','2_10_10','2200 円と 1500 円の 2 種類のズボンがある。合計で 15000 円以内となるように 8 本買いたい。2200 円のズボンは一番多くて何本買えるか。');




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

INSERT INTO choices (question_id, choice_text) VALUES (10, 'A.イとウ');
INSERT INTO choices (question_id, choice_text) VALUES (10, 'B.イとウ');
INSERT INTO choices (question_id, choice_text) VALUES (10, 'C.イとウ');
INSERT INTO choices (question_id, choice_text) VALUES (10, 'D.イとウ');
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
INSERT INTO choices (question_id, choice_text) VALUES (143, 'A. 6個');
INSERT INTO choices (question_id, choice_text) VALUES (143, 'B. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (144, 'A. 5足');
INSERT INTO choices (question_id, choice_text) VALUES (144, 'B. 6足');
INSERT INTO choices (question_id, choice_text) VALUES (144, 'C. 7足');
INSERT INTO choices (question_id, choice_text) VALUES (144, 'D. 8足');
INSERT INTO choices (question_id, choice_text) VALUES (144, 'A. 9足');
INSERT INTO choices (question_id, choice_text) VALUES (144, 'B. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (145, 'A. 2本');
INSERT INTO choices (question_id, choice_text) VALUES (145, 'B. 3本');
INSERT INTO choices (question_id, choice_text) VALUES (145, 'C. 4本 ');
INSERT INTO choices (question_id, choice_text) VALUES (145, 'D. 5本');
INSERT INTO choices (question_id, choice_text) VALUES (145, 'A. 6本');
INSERT INTO choices (question_id, choice_text) VALUES (145, 'B. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (146, 'A. 5個');
INSERT INTO choices (question_id, choice_text) VALUES (146, 'B. 6個');
INSERT INTO choices (question_id, choice_text) VALUES (146, 'C. 7個');
INSERT INTO choices (question_id, choice_text) VALUES (146, 'D. 8個');
INSERT INTO choices (question_id, choice_text) VALUES (146, 'A. 9個');
INSERT INTO choices (question_id, choice_text) VALUES (146, 'B. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (147, 'A. 4冊');
INSERT INTO choices (question_id, choice_text) VALUES (147, 'B. 5冊');
INSERT INTO choices (question_id, choice_text) VALUES (147, 'C. 6冊');
INSERT INTO choices (question_id, choice_text) VALUES (147, 'D. 7冊');
INSERT INTO choices (question_id, choice_text) VALUES (147, 'A. 8冊');
INSERT INTO choices (question_id, choice_text) VALUES (147, 'B. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (148, 'A. 3足');
INSERT INTO choices (question_id, choice_text) VALUES (148, 'B. 4足');
INSERT INTO choices (question_id, choice_text) VALUES (148, 'C. 5足');
INSERT INTO choices (question_id, choice_text) VALUES (148, 'D. 6足');
INSERT INTO choices (question_id, choice_text) VALUES (148, 'A. 7足');
INSERT INTO choices (question_id, choice_text) VALUES (148, 'B. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (149, 'A. 2個');
INSERT INTO choices (question_id, choice_text) VALUES (149, 'B. 3個');
INSERT INTO choices (question_id, choice_text) VALUES (149, 'C. 4個');
INSERT INTO choices (question_id, choice_text) VALUES (149, 'D. 5個');
INSERT INTO choices (question_id, choice_text) VALUES (149, 'A. 6個');
INSERT INTO choices (question_id, choice_text) VALUES (149, 'B. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (150, 'A. 5枚');
INSERT INTO choices (question_id, choice_text) VALUES (150, 'B. 6枚');
INSERT INTO choices (question_id, choice_text) VALUES (150, 'C. 7枚');
INSERT INTO choices (question_id, choice_text) VALUES (150, 'D. 8枚');
INSERT INTO choices (question_id, choice_text) VALUES (150, 'A. 9枚');
INSERT INTO choices (question_id, choice_text) VALUES (150, 'B. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (151, 'A. 3個');
INSERT INTO choices (question_id, choice_text) VALUES (151, 'B. 4個');
INSERT INTO choices (question_id, choice_text) VALUES (151, 'C. 5個');
INSERT INTO choices (question_id, choice_text) VALUES (151, 'D. 6個');
INSERT INTO choices (question_id, choice_text) VALUES (151, 'A. 7個');
INSERT INTO choices (question_id, choice_text) VALUES (151, 'B. AからEのいずれでもない');

INSERT INTO choices (question_id, choice_text) VALUES (152, 'A. 3本');
INSERT INTO choices (question_id, choice_text) VALUES (152, 'B. 4本');
INSERT INTO choices (question_id, choice_text) VALUES (152, 'C. 5本');
INSERT INTO choices (question_id, choice_text) VALUES (152, 'D. 6本');
INSERT INTO choices (question_id, choice_text) VALUES (152, 'A. 7本');
INSERT INTO choices (question_id, choice_text) VALUES (152, 'B. AからEのいずれでもない');

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
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (19, 105, '1_2_9');
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
INSERT INTO answers (question_id, correct_choice_id, explanation) VALUES (52, 270, '1_5_10');





