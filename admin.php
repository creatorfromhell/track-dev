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
$type = "dashboard";
if(isset($_GET['t'])) {
    $type = $_GET['t'];
}
?>
<div id="main" style="min-height:330px;">
    <nav class="sideNav">
        <ul>
            <li <?php if($type == "dashboard") { echo 'class="active"'; } ?>><a href="admin.php?t=dashboard">Dashboard</a></li>
            <li <?php if($type == "activity") { echo 'class="active"'; } ?>><a href="admin.php?t=activity">Activity</a></li>
            <li <?php if($type == "groups") { echo 'class="active"'; } ?>><a href="admin.php?t=groups">Groups</a></li>
            <li <?php if($type == "options") { echo 'class="active"'; } ?>><a href="admin.php?t=options">Options</a></li>
            <li <?php if($type == "permissions") { echo 'class="active"'; } ?>><a href="admin.php?t=dashboard">Permissions</a></li>
            <li <?php if($type == "addons") { echo 'class="active"'; } ?>><a href="admin.php?t=addons">Addons</a></li>
            <li <?php if($type == "users") { echo 'class="active"'; } ?>><a href="admin.php?t=users">Users</a></li>
        </ul>
    </nav>
    <?php
        if($type == "groups") {
            include("include/admin/groups.php");
        } else if($type == "permissions") {
            include("include/admin/permissions.php");
        } else if($type == "options") {
            include("include/admin/options.php");
        } else if($type == "addons") {
            include("include/admin/addons.php");
        } else if($type == "users") {
            include("include/admin/users.php");
        } else if($type == "activity") {
            include("include/admin/activity.php");
        } else {
            include("include/admin/dashboard.php");
        }
    ?>
</div>

<?php
include("include/footer.php");
?>