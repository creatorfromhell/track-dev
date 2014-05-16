<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/24/14
 * Time: 2:37 PM
 * Version: Beta 1
 * Last Modified: 1/24/14 at 2:37 PM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");
$type = "charts";
if(isset($_GET['t'])) {
    $type = $_GET['t'];
}
?>

    <div id="main">
        <?php
            if($type == "calendar" || $type == "calendarview") {
                include("include/overview/calendar.php");
            } else if($type == "project") {
                include("include/overview/project.php");
            } else {
                include("include/overview/general.php");
            }
        ?>
        <div class="clear"></div>
    </div>

<?php
include("include/footer.php");
?>