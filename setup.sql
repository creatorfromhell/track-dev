--
-- Projects Table
--
CREATE TABLE IF NOT EXISTS `todo_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `preset` tinyint(1) NOT NULL DEFAULT '0',
  `main` tinyint(1) NOT NULL DEFAULT '0',
  `creator` varchar(40) CHARACTER SET utf8 NOT NULL,
  `created` date NOT NULL DEFAULT '0000-00-00',
  `overseer` varchar(40) CHARACTER SET utf8 NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Lists Table
--
CREATE TABLE IF NOT EXISTS `todo_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `project` varchar(40) NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `creator` varchar(40) CHARACTER SET utf8 NOT NULL,
  `created` date NOT NULL DEFAULT '0000-00-00',
  `overseer` varchar(40) CHARACTER SET utf8 NOT NULL,
  `guestview` tinyint(1) NOT NULL DEFAULT '1',
  `guestedit` tinyint(1) NOT NULL DEFAULT '0',
  `viewpermission` tinyint(3) NOT NULL DEFAULT '0',
  `editpermission` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Groups Table
--
CREATE TABLE IF NOT EXISTS `todo_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `permission` tinyint(3) NOT NULL DEFAULT '0',
  `preset` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Versions Table
--
CREATE TABLE IF NOT EXISTS `todo_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `project` varchar(40) NOT NULL,
  `due` date NOT NULL DEFAULT '0000-00-00',
  `released` date NOT NULL DEFAULT '0000-00-00',
  `versiontype` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Version Types Table
--
CREATE TABLE IF NOT EXISTS `todo_versions_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Labels Table
--
CREATE TABLE IF NOT EXISTS `todo_labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` varchar(40) NOT NULL,
  `listname` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `color` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Activity Table
--
CREATE TABLE IF NOT EXISTS `todo_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `project` varchar(40) NOT NULL,
  `listname` varchar(40) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Users Table
--
CREATE TABLE IF NOT EXISTS `todo_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) CHARACTER SET utf8 NOT NULL,
  `password` varchar(220) CHARACTER SET utf8 NOT NULL,
  `usergroup` tinyint(4) NOT NULL DEFAULT '1',
  `registered` date NOT NULL DEFAULT '0000-00-00',
  `lastlogin` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(80) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `email` varchar(220) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activationkey` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Task Table
--