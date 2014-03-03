<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/2/14
 * Time: 12:51 PM
 * Version: Beta 1
 * Last Modified: 3/2/14 at 12:51 PM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");
?>

    <div id="main">
        <form id="register" action="/include/handling/registerform.php" method="post">
            <h1>Register</h1>
            <div id="holder">
                <div id="page_1">
                    <fieldset id="inputs">
                        <input id="username" type="text" placeholder="Username">
                        <input id="email" type="text" placeholder="Email">
                    </fieldset>
                    <fieldset id="links">
                        <label id="other">Have an account? <a href="">Login</a></label>
                        <button id="submit" onclick="switchPage(event, 'page_1', 'page_2'); return false;">Next</button>
                    </fieldset>
                </div>
                <div id="page_2">
                    <fieldset id="inputs">
                        <input id="password" type="password" placeholder="Password">
                        <input id="c_password" type="password" placeholder="Confirm Password">
                    </fieldset>
                    <fieldset id="links">
                        <button id="submit_2" onclick="switchPage(event, 'page_2', 'page_1'); return false;">Back</button>
                        <input type="submit" id="submit" value="Register">
                    </fieldset>
                </div>
            </div>
        </form>
    </div>

<?php
include("include/footer.php");
?>