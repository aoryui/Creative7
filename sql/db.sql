set names utf8;
drop database if exists ilove;
create database ilove character set utf8 collate utf8_general_ci;

grant all privileges on ilove.* to Ilove@localhost identified by '11111';

use ilove;

DROP TABLE IF EXISTS question;
CREATE TABLE question (
    id          int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userid      int(255) NOT NULL,
    title       varchar(2000) NOT NULL,
    message     varchar(2000) NOT NULL,
    selection   varchar(50) NOT NULL,
    configtime  varchar(50) NOT NULL,
    updatetime  varchar(50) NOT NULL
);

DROP TABLE IF EXISTS answer;
CREATE TABLE answer (
    id        int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	userid    int(255) NOT NULL,
	text      varchar(2000) NOT NULL,
    ques_id   int(255) NOT NULL,
    datetime  varchar(50) NOT NULL,
    FOREIGN KEY (ques_id) REFERENCES question(id)
);

DROP TABLE IF EXISTS userinfo;
CREATE TABLE userinfo (
    userid    int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username  varchar(100) NOT NULL,
    subject   varchar(100) NOT NULL,
    email     varchar(100) NOT NULL,
    password  varchar(100) NOT NULL
);

DROP TABLE IF EXISTS profile;
CREATE TABLE profile (
    userid    int(255) NOT NULL PRIMARY KEY,
    age       int(10),
    interest  varchar(200),
    intro     varchar(500)
);

DROP TABLE IF EXISTS seikabutu;
CREATE TABLE seikabutu (
    id         int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userid     int(255) NOT NULL,
    title      varchar(2000) NOT NULL,
    message    varchar(10000) NOT NULL,
    site       varchar(500) NOT NULL,
    shosai     varchar(1000) NOT NULL,
    selection  varchar(50) NOT NULL,
    configtime  varchar(50) NOT NULL,
    updatetime  varchar(50) NOT NULL
);

DROP TABLE IF EXISTS anslike;
CREATE TABLE anslike (
    id        int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userid    int(255),
    ansid     int(255) NOT NULL
);

DROP TABLE IF EXISTS queslike;
CREATE TABLE queslike (
    id        int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userid    int(255),
    quesid    int(255) NOT NULL   
);

DROP TABLE IF EXISTS comment;
CREATE TABLE comment (
    id             int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	userid         int(255) NOT NULL,
	text           varchar(2000) NOT NULL,
    seikabutu_id   int(255) NOT NULL,
    datetime  varchar(50) NOT NULL
);

DROP TABLE IF EXISTS quespic;
CREATE TABLE quespic (
    id        int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    quesid    int(255) NOT NULL,
    filename  varchar(100) NOT NULL
);

DROP TABLE IF EXISTS seikapic;
CREATE TABLE seikapic (
    id        int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    seikaid   int(255) NOT NULL,
    filename  varchar(100) NOT NULL
);
