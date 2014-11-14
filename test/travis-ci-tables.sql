--
-- Table structure for table `todo_groups`
--

CREATE TABLE IF NOT EXISTS `todo_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(40) DEFAULT NULL,
  `group_permissions` text NOT NULL,
  `group_admin` tinyint(1) DEFAULT NULL,
  `group_preset` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `todo_groups` (`id`, `group_name`, `group_permissions`, `group_admin`, `group_preset`) VALUES
(1, 'User', '', 0, 1),
(2, 'Contributor', '', 0, 0);

--
-- Table structure for table `todo_labels`
--

CREATE TABLE IF NOT EXISTS `todo_labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` varchar(40) NOT NULL,
  `list` varchar(40) NOT NULL,
  `label_name` varchar(40) DEFAULT NULL,
  `text_color` varchar(30) DEFAULT NULL,
  `background_color` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `todo_labels` (`id`, `project`, `list`, `label_name`, `text_color`, `background_color`) VALUES
(1, 'Test', 'Main', 'bug', 'maroon', 'lightcoral'),
(2, 'Test', 'Main', 'enhancement', 'midnightblue', 'lightblue');

--
-- Table structure for table `todo_lists`
--

CREATE TABLE IF NOT EXISTS `todo_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list` varchar(40) NOT NULL,
  `project` varchar(40) NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `creator` varchar(40) CHARACTER SET utf8 NOT NULL,
  `created` date NOT NULL DEFAULT '0000-00-00',
  `overseer` varchar(40) CHARACTER SET utf8 NOT NULL,
  `minimal_view` tinyint(1) DEFAULT NULL,
  `guest_permissions` varchar(25) NOT NULL DEFAULT 'view:1,edit:0',
  `list_permissions` varchar(25) NOT NULL DEFAULT 'view:none,edit:none',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `todo_lists`
--

INSERT INTO `todo_lists` (`id`, `list`, `project`, `public`, `creator`, `created`, `overseer`, `minimal_view`, `guest_permissions`, `list_permissions`) VALUES
(1, 'Main', 'Test', 1, 'no one', '2014-03-13', 'no one', 0, 'view:1,edit:0', 'view:none,edit:none');

--
-- Table structure for table `todo_nodes`
--

CREATE TABLE IF NOT EXISTS `todo_nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(40) NOT NULL,
  `node_description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `node_name` (`node_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `todo_nodes` (`id`, `node_name`, `node_description`) VALUES
(1, 'Test.list.view', 'A permission node needed to view certain lists');

--
-- Table structure for table `todo_projects`
--

CREATE TABLE IF NOT EXISTS `todo_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` varchar(40) NOT NULL,
  `preset` tinyint(1) NOT NULL DEFAULT '0',
  `main` tinyint(1) NOT NULL DEFAULT '0',
  `creator` varchar(40) CHARACTER SET utf8 NOT NULL,
  `created` date NOT NULL DEFAULT '0000-00-00',
  `overseer` varchar(40) CHARACTER SET utf8 NOT NULL,
  `project_permissions` varchar(25) NOT NULL DEFAULT 'view:none,edit:none',
  `public` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `todo_projects` (`id`, `project`, `preset`, `main`, `creator`, `created`, `overseer`, `project_permissions`, `public`) VALUES
(1, 'Test', 1, 1, 'no one', '2014-03-13', 'no one', 'view:none,edit:none', 1);

--
-- Table structure for table `todo_Test_Main`
--

CREATE TABLE IF NOT EXISTS `todo_Test_Main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL,
  `description` text NOT NULL,
  `author` varchar(40) NOT NULL,
  `assignee` varchar(40) NOT NULL,
  `due` date NOT NULL DEFAULT '0000-00-00',
  `created` date NOT NULL DEFAULT '0000-00-00',
  `finished` date NOT NULL DEFAULT '0000-00-00',
  `version_name` varchar(40) DEFAULT NULL,
  `labels` text NOT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  `task_status` tinyint(3) DEFAULT NULL,
  `progress` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `todo_Test_Main` (`id`, `title`, `description`, `author`, `assignee`, `due`, `created`, `finished`, `version_name`, `labels`, `editable`, `task_status`, `progress`) VALUES
(1, 'Example', 'An example task.', 'no one', 'no one', '0000-00-00', '2014-07-31', '0000-00-00', '', '4', 1, 0, 0),
(2, 'Example2', 'Another example task.', 'no one', 'no one', '0000-00-00', '2014-07-30', '2014-07-31', '', '4', 1, 1, 95);

--
-- Table structure for table `todo_users`
--

CREATE TABLE IF NOT EXISTS `todo_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(40) DEFAULT NULL,
  `user_password` varchar(64) DEFAULT NULL,
  `user_email` varchar(220) DEFAULT NULL,
  `user_group` int(11) DEFAULT NULL,
  `user_permissions` text NOT NULL,
  `user_avatar` text NOT NULL,
  `user_ip` varchar(80) DEFAULT NULL,
  `user_registered` date DEFAULT NULL,
  `logged_in` date DEFAULT NULL,
  `user_banned` tinyint(1) DEFAULT NULL,
  `user_online` tinyint(1) DEFAULT NULL,
  `user_activated` tinyint(1) DEFAULT NULL,
  `activation_key` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`user_email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Table structure for table `todo_versions`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `todo_versions` (`id`, `version_name`, `project`, `version_status`, `due`, `released`, `version_type`) VALUES
(1, 'Beta 1', 'Test', 2, '0000-00-00', '0000-00-00', 'Alpha'),
(2, 'Beta 2', 'Test', 1, '2014-11-17', '0000-00-00', 'Beta');

--
-- Table structure for table `todo_version_types`
--

CREATE TABLE IF NOT EXISTS `todo_version_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version_type` varchar(40) NOT NULL,
  `description` text NOT NULL,
  `version_stability` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `todo_version_types` (`id`, `version_type`, `description`, `version_stability`) VALUES
(1, 'Alpha', 'Alpha releases are missing key features and contain bugs.', 0),
(2, 'Beta', 'Beta releases usually contain bugs and are pre-releases.', 0);