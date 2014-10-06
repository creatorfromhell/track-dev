<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/18/14
 * Time: 8:31 PM
 * Version: Beta 1
 * Last Modified: 1/18/14 at 8:31 PM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_SESSION['usersplusprofile'])) {
    header("Location: index.php");
}

$location = "index.php?t=project";
if(isset($_GET['return'])) {
    $location = $_GET['return'];
}
include("include/header.php");
include("include/handling/login.php");
?>

    <div id="main">
        <form method="post" action="login.php">
            <h3>Login</h3>
            <div id="holder">
                <div id="page_1" class="form-page">
                    <fieldset id="inputs">
                        <input id="username" name="username" type="text" placeholder="Username or Email">
                        <input id="password" name="password" type="password" placeholder="Password">
                        <?php
                        $captcha = new Captcha();
                        $captcha->printImage();
                        $_SESSION['userspluscaptcha'] = $captcha->code;
                        ?>
                        <br />
                        <input id="captcha" name="captcha" type="text" placeholder="Enter characters above">
                    </fieldset>
                    <fieldset id="links">
                        <input type="submit" class="submit" name="login" value="Login">
                        <label id="other">Need an account? <a href="register.php">Register</a></label>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>

<?php
include("include/footer.php");
?>