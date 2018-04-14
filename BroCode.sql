create database dbms_project;
use dbms_project;
create table user (username varchar(20), name varchar(30), email_id varchar(30), password varchar(64));
ALTER TABLE `dbms_project`.`user` 
CHANGE COLUMN `username` `username` VARCHAR(20) NOT NULL ,
CHANGE COLUMN `name` `name` VARCHAR(30) NOT NULL ,
CHANGE COLUMN `email_id` `email_id` VARCHAR(30) NOT NULL ,
CHANGE COLUMN `password` `password` VARCHAR(64) NOT NULL ,
ADD PRIMARY KEY (`username`);
ALTER TABLE `dbms_project`.`user` 
CHANGE COLUMN `username` `user_id` VARCHAR(20) NOT NULL ;
create table login_table (id int, token varchar(64), user_id varchar(20));
ALTER TABLE `dbms_project`.`login_table` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `token` `token` VARCHAR(64) NOT NULL ,
CHANGE COLUMN `user_id` `user_id` VARCHAR(20) NOT NULL ,
ADD PRIMARY KEY (`id`);
create table userDetails (user_id varchar(20), phone varchar(15), address varchar(50), dateOfBirth date, profilePic varchar(50));
ALTER TABLE `dbms_project`.`userDetails` 
CHANGE COLUMN `user_id` `user_id` VARCHAR(20) NOT NULL ,
ADD PRIMARY KEY (`user_id`),
ADD UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC),
ADD UNIQUE INDEX `phone_UNIQUE` (`phone` ASC);
ALTER TABLE `dbms_project`.`userDetails` 
ADD COLUMN `followers` INT NOT NULL AFTER `profilePic`,
ADD COLUMN `following` INT NOT NULL AFTER `followers`;
ALTER TABLE `dbms_project`.`userDetails` 
CHANGE COLUMN `followers` `followers` INT(11) NOT NULL DEFAULT 0 ,
CHANGE COLUMN `following` `following` INT(11) NOT NULL DEFAULT 0 ;
create table followers (id int, user_id varchar(20), follower_id varchar(20));
ALTER TABLE `dbms_project`.`followers` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL ,
CHANGE COLUMN `user_id` `user_id` VARCHAR(20) NOT NULL ,
CHANGE COLUMN `follower_id` `follower_id` VARCHAR(20) NOT NULL ,
ADD PRIMARY KEY (`id`);
ALTER TABLE `dbms_project`.`followers` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;
create table posts (id int, text varchar(140), image varchar(100), posted_at datetime, user_id varchar(20), likes int);
ALTER TABLE `dbms_project`.`posts` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `text` `text` VARCHAR(140) NULL ,
CHANGE COLUMN `posted_at` `posted_at` DATETIME NOT NULL ,
CHANGE COLUMN `user_id` `user_id` VARCHAR(20) NOT NULL ,
CHANGE COLUMN `likes` `likes` INT(11) NOT NULL ,
ADD PRIMARY KEY (`id`);
select * from posts;