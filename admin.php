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
include_once("include/utils.php");
$currentUser = $_SESSION['userplusprofile'];
if(pageLockedAdmin($currentUser)) { header('LOCATION: index.php'); }
include("include/header.php");
$type = "dashboard";
if(isset($_GET['t'])) {
    $type = $_GET['t'];
}
$pn = 1;
if(isset($_GET['pn'])) {
    if($_GET['pn'] > 0) {
        $pn = $_GET['pn'];
    }
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
            include("include/pages/admin/groups.php");
        } else if($type == "permissions") {
            include("include/pages/admin/permissions.php");
        } else if($type == "options") {
            include("include/pages/admin/options.php");
        } else if($type == "addons") {
            include("include/pages/admin/addons.php");
        } else if($type == "users") {
            include("include/pages/admin/users.php");
        } else if($type == "activity") {
            include("include/pages/admin/activity.php");
        } else {
            include("include/pages/admin/dashboard.php");
        }
    ?>
</div>

<?php
include("include/footer.php");
?>