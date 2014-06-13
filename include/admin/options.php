<?php
/**
 * Created by Daniel Vidmar.
 * Date: 5/13/14
 * Time: 6:20 PM
 * Version: Beta 1
 * Last Modified: 5/13/14 at 6:20 PM
 * Last Modified by Daniel Vidmar.
 */
?>
<div class="content">
    <h3>Options</h3>
    <h4>Trackr Details</h4>
    <p>Version: <?php echo $configuration->config["trackr"]["version"]; ?></p><br /><br />
    <h4>Main Options</h4>
    <?php $registration = ($configuration->config["main"]["registration"] == 1) ? "true" : "false"; ?>
    <p>Registration: <?php echo $registration; ?><br />
    <?php $activation = ($configuration->config["main"]["email_activation"] == 1) ? "true" : "false"; ?>
       Email Activation: <?php echo $activation; ?><br />
       Theme: <?php echo $configuration->config["main"]["theme"]; ?><br />
       Language: <?php echo $configuration->config["main"]["language"]; ?><br />
       Date Format: <?php echo $configuration->config["main"]["dateformat"]; ?><br />
       Blacklist: <?php echo $configuration->config["main"]["blacklist"]; ?><br />
    </p><br /><br />
    <h4>Email Options</h4>
    <p>Reply Email: <?php echo $configuration->config["email"]["replyemail"]; ?><br /></p><br /><br />
    <h4>Database Options</h4>
    <p>
       Prefix: <?php echo $configuration->config["database"]["db_prefix"]; ?><br />
    </p><br /><br />
    <h4>URL Options</h4>
    <p>
       Base URL: <?php echo $configuration->config["urls"]["base_url"]; ?><br />
       Installation Path: <?php echo $configuration->config["urls"]["installation_path"]; ?><br />
    </p>
</div>