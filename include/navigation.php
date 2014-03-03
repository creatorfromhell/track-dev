<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/23/14
 * Time: 4:13 PM
 * Version: Beta 1
 * Last Modified: 1/23/14 at 4:45 PM
 * Last Modified by Daniel Vidmar.
 */

?>
<div class="login">
    <p>
        <?php if(isset($_SESSION["username"])) {
            echo "Welcome, ".$username;
        } else { ?>
            <a href="#">Login</a> or <a href="#">Register</a>
        <?php } ?>
    </p>
</div>
<nav>
    <ul>
        <li class="active"><a href="#">Overview</a></li>
        <li>
            <a href="#">Dashboards</a>
            <ul>
                <li><a href="#">Project</a></li>
                <?php if(isset($_SESSION["username"]) && UserFunc::isAdmin($username)) { ?>
                    <li><a href="#">Admin</a></li>
                <?php } ?>
            </ul>
        </li>
        <li>
            <a href="#">Projects</a>
            <ul>
                <?php //TODO: Print available projects. ?>
                <li><a href="#">Default</a></li>
                <li><a href="#">Secondary</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Lists</a>
            <ul>
                <?php //TODO: Print lists for  current project. ?>
                <li><a href="#">Main</a></li>
                <li><a href="#">Example</a></li>
            </ul>
        </li>

    </ul>
</nav>