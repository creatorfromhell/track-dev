<?php
/**
 * Created by Daniel Vidmar.
 * Date: 5/9/14
 * Time: 10:48 AM
 * Version: Beta 1
 * Last Modified: 5/9/14 at 10:48 AM
 * Last Modified by Daniel Vidmar.
 */
session_start();
require_once("include/function/userfunc.php");
if(!UserFunc::isAdmin($_SESSION['username'])) {
    header("Location: index.php");
}
include("include/header.php");
$type = "users";
if(isset($_GET['t'])) {
    $type = $_GET['t'];
}
?>
<div id="main">
    <?php
        if($type == "groups") {
            include("include/admin/groups.php");
        } else if($type == "themes") {
            include("include/admin/themes.php");
        } else if($type == "options") {
            include("include/admin/options.php");
        } else if($type == "languages") {
            include("include/admin/languages.php");
        } else {
            include("include/admin/users.php");
        }
    ?>
</div>

<?php
include("include/footer.php");
?>