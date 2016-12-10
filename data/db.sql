DROP SCHEMA IF EXISTS Mars;

CREATE SCHEMA Mars CHARSET utf8;

USE Mars;

CREATE TABLE User(
	id_user INTEGER      NOT NULL AUTO_INCREMENT,
	login VARCHAR(20)    NOT NULL,
	pw VARCHAR(60)       NOT NULL,
	create_date DATETIME NOT NULL,
	update_date DATETIME NULL,
	is_valid TINYINT(1)	 NULL,
	CONSTRAINT pkId_user PRIMARY KEY (id_user),
	CONSTRAINT uLogin UNIQUE (login)
);

CREATE TABLE Comment(
	id_comment INTEGER NOT NULL AUTO_INCREMENT,
	comment_instance NVARCHAR(250) NOT NULL,	
	id_user INTEGER NOT NULL,
	create_date DATETIME NOT NULL,
	update_date DATETIME NULL,
	is_valid TINYINT(1)	 NULL,
	CONSTRAINT pkId_comment PRIMARY KEY(id_comment),
	CONSTRAINT fkId_user FOREIGN KEY(id_user) REFERENCES User(id_user)
);

CREATE TABLE UserLike(
	id_user_like INTEGER NOT NULL AUTO_INCREMENT,
	id_user INTEGER NOT NULL,
	id_comment INTEGER NOT NULL,
	create_date DATETIME NOT NULL,
	update_date DATETIME NULL,
	is_valid TINYINT(1)	 NULL,
	CONSTRAINT pkId_user_like PRIMARY KEY(id_user_like),
	CONSTRAINT fkId_user_like FOREIGN KEY(id_user) REFERENCES User(id_user),
	CONSTRAINT fkId_comment FOREIGN KEY(id_comment) REFERENCES Comment(id_comment)
);

INSERT INTO User(login, pw, create_date, is_valid) VALUES 
('apple', md5('1'), NOW(), 1),
('peach', md5('1'), NOW(), 1);