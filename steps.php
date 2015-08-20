<?php
/**
 * Created by creatorfromhell.
 * Date: 6/22/15
 * Time: 3:43 PM
 * Version: Beta 2
 * A steps file for PHPWAW modified for Trackr.
 */
$steps = array(
    array(
        'header' => 'Trackr Requirements',
        'buttons' => array(
            'left' => array(
                'text' => 'Back',
                'show' => false
            ),
            'right' => array(
                'text' => 'Next',
                'show' => true
            )
        ),
        'executions' => array(
            array(
                'type' => 'download',
                'order' => 'after',
                'location' => 'https://creatorfromhell.com/uploads/trackr-beta2.zip',
                'save' => 'temp.zip'
            ),
        ),
        'step_parts' => array(
            array(
                'type' => 'description',
                'value' => 'By clicking on the button below and installing Trackr, you show that you agree to the <a href="http://opensource.org/licenses/AGPL-3.0">License</a> under which Trackr is licensed.'
            ),
            array(
                'type' => 'checks',
                'label' => 'Server Requirements',
                'checks' => array(
                    array(
                        'type' => 'php-config',
                        'name' => 'php-version',
                        'check' => array('5.3.1', '>=')
                    ),
                    array(
                        'type' => 'php-extension',
                        'name' => 'loaded',
                        'check' => 'PDO_MYSQL'
                    )
                )
            ),
        ),
    ),
    array(
        'header' => 'Pre-Configurations',
        'buttons' => array(
            'left' => array(
                'text' => 'Back',
                'show' => false
            ),
            'right' => array(
                'text' => 'Next',
                'show' => true
            )
        ),
        'validation' => array(
            'inputs' => array(
                array(
                    'name' => 'language',
                    'rules' => array(
                        'required' => true,
                    )
                ),
                array(
                    'name' => 'db_host',
                    'rules' => array(
                        'required' => true,
                    )
                ),
                array(
                    'name' => 'db_name',
                    'rules' => array(
                        'required' => true,
                    )
                ),
                array(
                    'name' => 'db_username',
                    'rules' => array(
                        'required' => true,
                    )
                ),
                array(
                    'name' => 'db_password',
                    'rules' => array(
                        'required' => true,
                    )
                ),
                array(
                    'name' => 'sql_prefix',
                    'rules' => array(
                        'required' => true,
                    )
                ),
            )
        ),
        'step_parts' => array(
            array(
                'label' => 'Language: ',
                'name' => 'language',
                'type' => 'select',
                'value' => 'English',
                'newline' => 'input',
                'options' => array(
                    'en' => 'English',
                    'nl' => 'Dutch',
                    'dk' => 'Danish'
                )
            ),
            array(
                'label' => 'MySQL Host: ',
                'name' => 'db_host',
                'type' => 'text',
                'newline' => 'input',
            ),
            array(
                'label' => 'MySQL Database: ',
                'name' => 'db_name',
                'type' => 'text',
                'newline' => 'input',
            ),
            array(
                'label' => 'MySQL Username: ',
                'name' => 'db_username',
                'type' => 'text',
                'newline' => 'input',
            ),
            array(
                'label' => 'MySQL Password: ',
                'name' => 'db_password',
                'type' => 'password',
                'newline' => 'input',
            ),
            array(
                'label' => 'MySQL Prefix: ',
                'name' => 'sql_prefix',
                'type' => 'text',
                'newline' => 'input',
                'value' => 'todo'
            ),
        ),
        'executions' => array(
            array(
                'type' => 'function',
                'order' => 'before',
                'name' => 'unpack',
                'parameters' => array('temp.zip', '../')
            ),
            array(
                'type' => 'sql_query',
                'order' => 'after',
                'queries' => array(
                    array(
                        'query' => "CREATE TABLE IF NOT EXISTS `%sql_prefix%_activity` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `username` varchar(40) NOT NULL,
                                      `project` varchar(40) NOT NULL,
                                      `list` varchar(40) NOT NULL,
                                      `activity_type` text,
                                      `activity_parameters` text,
                                      `archived` tinyint(1) NOT NULL DEFAULT '0',
                                      `logged` date NOT NULL DEFAULT '0000-00-00',
                                      PRIMARY KEY (`id`)
                                    );"
                    ),
                    array(
                        'query' => "CREATE TABLE IF NOT EXISTS `%sql_prefix%_downloads` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `project_id` int(11) NOT NULL,
                                      `version_id` int(11) NOT NULL,
                                      `file_name` varchar(40) NOT NULL,
                                      `file_downloads` int(11) NOT NULL DEFAULT '0',
                                      PRIMARY KEY (`id`)
                                    );"
                    ),
                    array(
                        'query' => "CREATE TABLE IF NOT EXISTS `%sql_prefix%_groups` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `group_name` varchar(40) DEFAULT NULL,
                                      `group_permissions` text NOT NULL,
                                      `group_admin` tinyint(1) DEFAULT NULL,
                                      `group_preset` tinyint(1) DEFAULT NULL,
                                      PRIMARY KEY (`id`)
                                    );"
                    ),
                    array(
                        'query' => "CREATE TABLE IF NOT EXISTS `%sql_prefix%_labels` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `project` varchar(40) NOT NULL,
                                      `list` varchar(40) NOT NULL,
                                      `label_name` varchar(40) DEFAULT NULL,
                                      `text_color` varchar(30) DEFAULT NULL,
                                      `background_color` varchar(30) DEFAULT NULL,
                                      PRIMARY KEY (`id`)
                                    );"
                    ),
                    array(
                        'query' => "CREATE TABLE IF NOT EXISTS `%sql_prefix%_lists` (
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
                                    );"
                    ),
                    array(
                        'query' => "CREATE TABLE IF NOT EXISTS `%sql_prefix%_nodes` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `node_name` varchar(40) NOT NULL,
                                      `node_description` text NOT NULL,
                                      PRIMARY KEY (`id`),
                                      UNIQUE KEY `node_name` (`node_name`)
                                    );"
                    ),
                    array(
                        'query' => "CREATE TABLE IF NOT EXISTS `%sql_prefix%_projects` (
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
                                    );"
                    ),
                    array(
                        'query' => "CREATE TABLE IF NOT EXISTS `%sql_prefix%_users` (
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
                                    );"
                    ),
                    array(
                        'query' => "CREATE TABLE IF NOT EXISTS `%sql_prefix%_versions` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `version_name` varchar(40) NOT NULL,
                                      `project` varchar(40) NOT NULL,
                                      `version_status` tinyint(3) NOT NULL DEFAULT '0',
                                      `due` date NOT NULL DEFAULT '0000-00-00',
                                      `released` date NOT NULL DEFAULT '0000-00-00',
                                      `version_type` varchar(40) NOT NULL,
                                      PRIMARY KEY (`id`)
                                    );"
                    ),
                    array(
                        'query' => "CREATE TABLE IF NOT EXISTS `%sql_prefix%_version_types` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `version_type` varchar(40) NOT NULL,
                                      `description` text NOT NULL,
                                      `version_stability` tinyint(1) NOT NULL DEFAULT '0',
                                      PRIMARY KEY (`id`)
                                    );"
                    ),
                    array(
                        'query' => "INSERT INTO `%sql_prefix%_groups` (`id`, `group_name`, `group_permissions`, `group_admin`, `group_preset`) VALUES(1, 'User', '', 0, 1),(2, 'Administrator', '', 1, 0);"
                    )
                )
            )
        ),
    ),
    array(
        'header' => 'Default Configurations',
        'buttons' => array(
            'left' => array(
                'text' => 'Back',
                'show' => false
            ),
            'right' => array(
                'text' => 'Next',
                'show' => true
            )
        ),
        'validation' => array(
            'inputs' => array(
                array(
                    'name' => 'default_project',
                    'rules' => array(
                        'required' => true,
                    )
                ),
                array(
                    'name' => 'default_list',
                    'rules' => array(
                        'required' => true,
                    )
                ),
                array(
                    'name' => 'url_base',
                    'rules' => array(
                        'required' => true,
                    )
                ),
                array(
                    'name' => 'url_path',
                    'rules' => array(
                        'required' => true,
                    )
                ),
                array(
                    'name' => 'email_reply',
                    'rules' => array(
                        'required' => true,
                    )
                ),
            )
        ),
        'step_parts' => array(
            array(
                'label' => 'Default Project: ',
                'name' => 'default_project',
                'type' => 'text',
                'newline' => 'input'
            ),
            array(
                'label' => 'Default List: ',
                'name' => 'default_list',
                'type' => 'text',
                'newline' => 'input',
            ),
            array(
                'label' => 'Base URL: ',
                'name' => 'url_base',
                'type' => 'text',
                'newline' => 'input'
            ),
            array(
                'label' => 'Installation Path: ',
                'name' => 'url_path',
                'type' => 'text',
                'newline' => 'input',
            ),
            array(
                'label' => 'Reply Email: ',
                'name' => 'email_reply',
                'type' => 'text',
                'newline' => 'input',
            ),
        ),
        'executions' => array(
            array(
                'type' => 'sql_query',
                'order' => 'after',
                'queries' => array(
                    array(
                        'query' => "INSERT INTO `%sql_prefix%_projects` (`project`, `preset`, `main`, `creator`, `overseer`, `public`) VALUES('%default_project%', 1, 1, 'noone', 'noone', 1);"
                    ),
                    array(
                        'query' => "INSERT INTO `%sql_prefix%_lists` (`list`, `project`, `public`, `creator`, `overseer`, `minimal_view`) VALUES('%default_list%', '%default_project%', 1, 'noone', 'noone', 1);"
                    ),
                    array(
                        'query' => "CREATE TABLE IF NOT EXISTS `%sql_prefix%_%default_project%_%default_list%` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `title` varchar(40) NOT NULL,
                                      `description` text NOT NULL,
                                      `author` varchar(40) NOT NULL,
                                      `assignee` varchar(40) NOT NULL,
                                      `due` date NOT NULL DEFAULT '0000-00-00',
                                      `created` date NOT NULL DEFAULT '0000-00-00',
                                      `finished` date NOT NULL DEFAULT '0000-00-00',
                                      `task_version` int(11) DEFAULT NULL,
                                      `labels` text NOT NULL,
                                      `editable` tinyint(1) NOT NULL DEFAULT '1',
                                      `task_status` tinyint(3) DEFAULT NULL,
                                      `progress` tinyint(3) NOT NULL DEFAULT '0',
                                      PRIMARY KEY (`id`)
                                    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;",
                    )
                )
            ),
            array(
                'type' => 'function',
                'order' => 'after',
                'name' => 'create_configurations',
                'parameters' => array()
            )
        ),
    ),
    array(
        'header' => 'Administrator Account',
        'buttons' => array(
            'left' => array(
                'text' => 'Back',
                'show' => false
            ),
            'right' => array(
                'text' => 'Next',
                'show' => true
            )
        ),
        'validation' => array(
            'inputs' => array(
                array(
                    'name' => 'default_user_name',
                    'rules' => array(
                        'required' => true,
                    )
                ),
                array(
                    'name' => 'default_user_password',
                    'rules' => array(
                        'required' => true,
                    )
                ),
            )
        ),
        'step_parts' => array(
            array(
                'label' => 'Username: ',
                'name' => 'default_user_name',
                'type' => 'text',
                'newline' => 'input',
            ),
            array(
                'label' => 'Email: ',
                'name' => 'default_user_email',
                'type' => 'text',
                'newline' => 'input',
            ),
            array(
                'label' => 'Password: ',
                'name' => 'default_user_password',
                'type' => 'text',
                'newline' => 'input',
            ),
        ),
        'executions' => array(
            array(
                'type' => 'sql_query',
                'order' => 'after',
                'queries' => array(
                    array(
                        'query' => "INSERT INTO `%sql_prefix%_users` (`user_name`, `user_password`, `user_email`, `user_group`, `user_registered`, `user_activated`) VALUES('%default_user_name%', ?, '%default_user_email%', 2, ?, 1)",
                        'parameters' => array(hash('sha256', (isset($_SESSION['values']['default_user_password'])?$_SESSION['values']['default_user_password']:"")), date("Y-m-d H:i:s"))
                    )
                )
            )
        ),
    ),
    array(
        'header' => 'Trackr Installed',
        'buttons' => array(
            'left' => array(
                'text' => 'Back',
                'show' => false
            ),
            'right' => array(
                'text' => 'Finish',
                'show' => false
            )
        ),
        'executions' => array(
            array(
                'type' => 'function',
                'order' => 'before',
                'name' => 'complete',
                'parameters' => array()
            )
        ),
    ),
);