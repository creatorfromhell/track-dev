<?php
/**
 * Created by Daniel Vidmar.
 * Date: 5/13/14
 * Time: 6:20 PM
 * Version: Beta 1
 * Last Modified: 5/13/14 at 6:20 PM
 * Last Modified by Daniel Vidmar.
 */
$rules['pages']['admin']['options'] = array(
    'version' => $configuration->config["trackr"]["version"],
    'registration' => ($configuration->config["main"]["registration"] == 1) ? "true" : "false",
    'activation' => ($configuration->config["main"]["email_activation"] == 1) ? "true" : "false",
    'theme' => $configuration->config["main"]["theme"],
    'language' => $configuration->config["main"]["language"],
    'date_format' => $configuration->config["main"]["dateformat"],
    'blacklist' => (empty($configuration->config["main"]["blacklist"])) ? ' ' : $configuration->config["main"]["blacklist"],
    'reply_email' => $configuration->config["email"]["replyemail"],
    'database_prefix' => $configuration->config["database"]["db_prefix"],
    'url' => $configuration->config["urls"]["base_url"],
    'installation_path' => $configuration->config["urls"]["installation_path"],
);
?>