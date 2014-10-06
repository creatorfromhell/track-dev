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
$type = "project";
if(isset($_GET['t'])) {
    $type = $_GET['t'];
}
$return .= "&t=".$type;
?>

    <div id="main">
        <?php
            if($type == "calendar" || $type == "calendarview") {
                include("include/pages/overview/calendar.php");
            } else {
                include("include/pages/overview/project.php");
            }
        ?>
        <div class="clear"></div>
    </div>

<?php
include("include/footer.php");
?>