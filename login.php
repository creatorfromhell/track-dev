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
?>

    <div id="main">
        <form id="log_in" action="/include/handling/loginform.php" method="post">
            <h1>Login</h1>
            <fieldset id="inputs">
                <input id="username" type="text" placeholder="Username">
                <input id="password" type="password" placeholder="Password">
            </fieldset>
            <fieldset id="links">
                <input type="submit" id="submit" value="Login">
                <label id="other">Need an account? <a href="#">Register</a></label>
            </fieldset>
        </form>
    </div>

<?php
include("include/footer.php");
?>