<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/13/14
 * Time: 2:36 PM
 * Version: Beta 1
 * Last Modified: 3/13/14 at 2:36 PM
 * Last Modified by Daniel Vidmar.
 */
require_once("include/function/projectfunc.php");

$projects = ProjectFunc::projects();

foreach($projects as &$project) {
    echo "Project: ".$project."<br/>";

    $lists = ProjectFunc::lists($project);
    foreach($lists as &$list) {
        echo "- List: ".$list."<br/>";
    }
}
?>