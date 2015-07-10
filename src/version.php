<?php

/**
 * Created by Daniel Vidmar.
 * Date: 10/25/14
 * Time: 1:32 AM
 * Version: Beta 2
 * Last Modified: 10/25/14 at 1:32 AM
 * Last Modified by Daniel Vidmar.
 */
$id = 0;
if(isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: index.php?".$previous);
}
include("include/header.php");