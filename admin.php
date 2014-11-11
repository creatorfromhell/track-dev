<?php
/**
 * Created by Daniel Vidmar.
 * Date: 5/9/14
 * Time: 10:48 AM
 * Version: Beta 1
 * Last Modified: 5/9/14 at 10:48 AM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");
if(pageLockedAdmin($currentUser)) { header('LOCATION: index.php'); }
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

$adminTabs = array(
	"dashboard" => array(
		"include" => "include/pages/admin/dashboard.php",
		"location" => "admin.php?t=dashboard",
		"translate" => "lang:"
	),
	"activity" => array(
		"include" => "include/pages/admin/activity.php",
		"location" => "admin.php?t=activity",
		"translate" => "lang:"
	),
	"groups" => array(
		"include" => "include/pages/admin/groups.php",
		"location" => "admin.php?t=groups",
		"translate" => "lang:"
	),
	"options" => array(
		"include" => "include/pages/admin/options.php",
		"location" => "admin.php?t=options",
		"translate" => "lang:"
	),
	"permissions" => array(
		"include" => "include/pages/admin/permissions.php",
		"location" => "admin.php?t=permissions",
		"translate" => "lang:"
	),
	"addons" => array(
		"include" => "include/pages/admin/addons.php",
		"location" => "admin.php?t=addons",
		"translate" => "lang:"
	),
	"users" => array(
		"include" => "include/pages/admin/users.php",
		"location" => "admin.php?t=users",
		"translate" => "lang:"
	)
);

?>
<div id="main" style="min-height:330px;">
    <nav class="sideNav">
        <ul>
			<?php
				$keys = array_keys($adminTabs);
				foreach($keys as &$tab) {
					$class = ($type == $tab) ? ' class="active"' : '';
					echo '<li'.$class.'><a href="'.$adminTabs[$tab]['location'].'">'.ucfirst($tab).'</a></li>';
				}
			?>
        </ul>
    </nav>
    <div class="admin-content">
    <?php
		if(array_key_exists($type, $adminTabs)) {
			include($adminTabs[$type]['include']);
		} else {
			echo '<p class="announce">The page you are looking for could not be found.</p>';
		}
    ?>
    </div>
</div>

<?php
include("include/footer.php");
?>