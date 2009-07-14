CREATE TABLE  `pl_posts` (
 `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `title` VARCHAR(255) NOT NULL,
 `content` LONGTEXT NOT NULL,
 `time` DATETIME NOT NULL,
 `weather` VARCHAR(20),
 `location` VARCHAR(40),
 `ip` VARCHAR(20),
 `key` CHAR(40) NOT NULL,
 `algorithm` VARCHAR(5) NOT NULL,
 `mode` CHAR(3) NOT NULL,
 `iv` VARCHAR(32)
);

CREATE TABLE  `pl_adminlog` (
 `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `action` VARCHAR(200) NOT NULL,
 `pid` INT NOT NULL,
 `ip` VARCHAR(20),
 `time` DATETIME NOT NULL
);

CREATE TABLE  `pl_loginattempt` (
 `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `username` VARCHAR(25) NOT NULL,
 `password` VARCHAR(40) NOT NULL,
 `ip` VARCHAR(20),
 `time` DATETIME NOT NULL
);