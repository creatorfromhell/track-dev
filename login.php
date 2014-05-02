<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/18/14
 * Time: 8:31 PM
 * Version: Beta 1
 * Last Modified: 1/18/14 at 8:31 PM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");
include("include/handling/loginform.php");
?>

    <div id="main">
        <form id="log_in" method="post">
            <h3>Login</h3>
            <div id="holder">
                <div id="page_1">
                    <fieldset id="inputs">
                        <input id="username" name="username" type="text" placeholder="Username">
                        <input id="password" name="password" type="password" placeholder="Password">
                    </fieldset>
                    <fieldset id="links">
                        <input type="submit" id="submit" name="login" value="Login">
                        <label id="other">Need an account? <a href="register.php">Register</a></label>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>

<?php
include("include/footer.php");
?>