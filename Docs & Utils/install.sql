CREATE TABLE IF NOT EXISTS `pl_adminlog` (
  `id` int(11) NOT NULL auto_increment,
  `action` varchar(200) NOT NULL,
  `pid` int(11) NOT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pl_loginattempt` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(25) NOT NULL,
  `password` varchar(40) NOT NULL,
  `success` tinyint(4) NOT NULL DEFAULT 0,
  `ip` varchar(20) DEFAULT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pl_posts` (
  `id` int(11) NOT NULL auto_increment,
  `title` blob NOT NULL,
  `content` longblob NOT NULL,
  `time` int(11) NOT NULL,
  `weather` varchar(20) DEFAULT NULL,
  `location` varchar(40) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `key` blob NOT NULL,
  `salt` blob,
  `hint` varchar(160) DEFAULT NULL,
  `algorithm` varchar(5) NOT NULL,
  `mode` char(3) NOT NULL,
  `iv` tinyblob,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;