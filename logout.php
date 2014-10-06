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
ActivityFunc::log($currentUser->name, "none", "none", "user:logout", "", 0, date("Y-m-d H:i:s"));
$date = date("Y-m-d H:i:s");
$currentUser->loggedIn = $date;
$currentUser->online = 0;
$currentUser->save();
destroySession("usersplusprofile");
?>
<main>
    <p class="announce">You have been logged out successfully.</p>
    <script>
        window.location.assign("login.php");
    </script>
</main>
<?php
include("include/footer.php");
?>