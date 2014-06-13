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
    <nav class="sideNav">
        <ul>
            <li <?php if($type == "groups") { echo 'class="active"'; } ?>><a href="admin.php?t=groups">Groups</a></li>
            <li <?php if($type == "options") { echo 'class="active"'; } ?>><a href="admin.php?t=options">Options</a></li>
            <li <?php if($type == "themes") { echo 'class="active"'; } ?>><a href="admin.php?t=themes">Themes</a></li>
            <li <?php if($type == "languages") { echo 'class="active"'; } ?>><a href="admin.php?t=languages">Languages</a></li>
            <li <?php if($type == "users") { echo 'class="active"'; } ?>><a href="admin.php?t=users">Users</a></li>
        </ul>
    </nav>
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