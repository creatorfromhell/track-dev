<?php
/**
 * Created by Daniel Vidmar.
 * Date: 4/25/14
 * Time: 9:44 PM
 * Version: Beta 1
 * Last Modified: 4/25/14 at 9:44 PM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");
$type = "charts";
if(isset($_GET['t'])) {
    $type = $_GET['t'];
}
?>

    <div id="main">
        <div class="taskInformation">
            <h3><?php //TODO: Print task title. ?></h3>
            <div class="progress"></div>
            <div class="description"></div>
        </div>
        <div class="taskDetails">
            <div class="version"></div>
            <div class="author"></div>
            <div class="assignee"></div>
            <div class="labels"></div>
        </div>
    </div>

<?php
include("include/footer.php");
?>