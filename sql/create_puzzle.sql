
CREATE DATABASE IF NOT EXISTS puzzle;

CREATE TABLE IF NOT EXISTS `person` (
uid INT  NOT NULL AUTO_INCREMENT,
lastame varchar(255) NOT NULL,
firstname varchar(255) NOT NULL,
created_at datetime NOT NULL DEFAULT NOW(),
PRIMARY KEY (uid)
);

