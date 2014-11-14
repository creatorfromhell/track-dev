<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/2/14
 * Time: 12:51 PM
 * Version: Beta 1
 * Last Modified: 3/2/14 at 12:51 PM
 * Last Modified by Daniel Vidmar.
 */
session_start();
include_once("include/utils.php");
$currentUser = $_SESSION['usersplusprofile'];
if($currentUser !== null) { header('LOCATION: index.php'); }

include("include/header.php");
include("include/handling/register.php");
?>

    <div id="main">
        <?php if($configuration->config["main"]["registration"]) { ?>
            <form method="post" action="register.php">
                <h3>Register</h3>
                <div id="holder">
                    <div id="page_1" class="form-page">
                        <fieldset id="inputs">
                            <input id="username" name="username" type="text" placeholder="Username">
                            <input id="email" name="email" type="text" placeholder="Email">
                            <input id="password" name="password" type="password" placeholder="Password">
                            <input id="c_password" name="c_password" type="password" placeholder="Confirm Password">
                            <?php
                            $captcha = new Captcha();
                            $captcha->printImage();
                            $_SESSION['userspluscaptcha'] = $captcha->code;
                            ?>
                            <br />
                            <input id="captcha" name="captcha" type="text" placeholder="Enter characters above">
                        </fieldset>
                        <fieldset id="links">
                            <input type="submit" class="submit" name="register" value="Register">
                            <label id="other">Have an account? <a href="login.php">Login</a></label>
                        </fieldset>
                    </div>
                </div>
            </form>
        <?php } else { ?>
        <p class="announce">I'm sorry, but registration has been disabled.</p>
        <?php } ?>
    </div>

<?php
include("include/footer.php");
?>