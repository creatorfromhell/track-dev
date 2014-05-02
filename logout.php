<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/26/14
 * Time: 8:22 PM
 * Version: Beta 1
 * Last Modified: 3/26/14 at 8:22 PM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");
UserFunc::updateLoginDate($username);

if(!UserFunc::loggedIn($username)) {
    UserFunc::changeStatus($username);
}

unset($_SESSION["username"]);
?>

    <div id="main">
        <p>You have been logged out successfully!</p>
        <script>
            window.location.assign("login.php");
        </script>
    </div>

<?php
include("include/footer.php");
?>