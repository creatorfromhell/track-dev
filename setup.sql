--
-- Projects Table
--
CREATE TABLE IF NOT EXISTS `todo_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` varchar(40) NOT NULL,
  `preset` tinyint(1) NOT NULL DEFAULT '0',
  `main` tinyint(1) NOT NULL DEFAULT '0',
  `creator` varchar(40) CHARACTER SET utf8 NOT NULL,
  `created` date NOT NULL DEFAULT '0000-00-00',
  `overseer` varchar(40) CHARACTER SET utf8 NOT NULL,
  `project_permissions` text NOT NULL DEFAULT 'view:none,edit:none',
  `public` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=latin1;

--
-- Lists Table
--
CREATE TABLE IF NOT EXISTS `todo_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list` varchar(40) NOT NULL,
  `project` varchar(40) NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `creator` varchar(40) CHARACTER SET utf8 NOT NULL,
  `created` date NOT NULL DEFAULT '0000-00-00',
  `overseer` varchar(40) CHARACTER SET utf8 NOT NULL,
  `minimal_view` tinyint(1) NOT NULL DEFAULT '0',
  `guest_permissions` varchar(25) NOT NULL DEFAULT 'view:1,edit:0',
  `list_permissions` text NOT NULL DEFAULT 'view:none,edit:none',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=latin1;

--
-- Versions Table
--
CREATE TABLE IF NOT EXISTS `todo_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version_name` varchar(40) NOT NULL,
  `project` varchar(40) NOT NULL,
  `version_status` tinyint(3) NOT NULL DEFAULT '0',
  `due` date NOT NULL DEFAULT '0000-00-00',
  `released` date NOT NULL DEFAULT '0000-00-00',
  `version_type` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=latin1;

--
-- Version Types Table
--
CREATE TABLE IF NOT EXISTS `todo_version_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version_type` varchar(40) NOT NULL,
  `description` text NOT NULL,
  `version_stability` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=latin1;

--
-- Labels Table
--
CREATE TABLE IF NOT EXISTS `todo_labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` varchar(40) NOT NULL,
  `list` varchar(40) NOT NULL,
  `label_name` varchar(40) NOT NULL,
  `text_color` varchar(30) NOT NULL,
  `background_color` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=latin1;

--
-- Activity Table
--
CREATE TABLE IF NOT EXISTS `todo_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `project` varchar(40) NOT NULL,
  `list` varchar(40) NOT NULL,
  `activity_type` text NOT NULL,
  `activity_parameters` text NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `logged` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=latin1;

--
-- Task Table
--
CREATE TABLE IF NOT EXISTS `todo_project_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL,
  `description` text NOT NULL,
  `author` varchar(40) NOT NULL,
  `assignee` varchar(40) NOT NULL,
  `due` date NOT NULL DEFAULT '0000-00-00',
  `created` date NOT NULL DEFAULT '0000-00-00',
  `finished` date NOT NULL DEFAULT '0000-00-00',
  `version_name` varchar(40) NOT NULL,
  `labels` text NOT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  `task_status` tinyint(3) NOT NULL DEFAULT '0',
  `progress` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `todo_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(40) NOT NULL,
  `group_permissions` text NOT NULL DEFAULT '',
  `group_admin` tinyint(1) NOT NULL DEFAULT '0',
  `group_preset` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `todo_nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(40) NOT NULL,
  `node_description` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `node_name` (`node_name`)
) DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `todo_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(40) CHARACTER SET utf8 NOT NULL,
  `user_password` varchar(64) CHARACTER SET utf8 NOT NULL,
  `user_email` varchar(220) NOT NULL DEFAULT '',
  `user_group` int(11) NOT NULL,
  `user_permissions` text NOT NULL DEFAULT '',
  `user_avatar` text NOT NULL DEFAULT '',
  `user_ip` varchar(80) NOT NULL DEFAULT '',
  `user_registered` date NOT NULL DEFAULT '0000-00-00',
  `logged_in` date NOT NULL DEFAULT '0000-00-00',
  `user_banned` tinyint(1) NOT NULL DEFAULT '0',
  `user_online` tinyint(1) NOT NULL DEFAULT '0',
  `user_activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_key` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`)
) DEFAULT CHARSET=latin1;