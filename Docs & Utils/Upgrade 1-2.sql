ALTER TABLE  `pl_loginattempt` ADD  `success` TINYINT NOT NULL DEFAULT  '0' AFTER  `password`;
ALTER TABLE  `pl_posts` CHANGE  `title`  `title` BLOB NOT NULL, CHANGE  `content`  `content` LONGBLOB NOT NULL,CHANGE  `iv`  `iv` TINYBLOB NULL DEFAULT NULL, CHANGE  `key`  `key` BLOB NOT NULL, ADD `salt` BLOB DEFAULT NULL AFTER `key;
