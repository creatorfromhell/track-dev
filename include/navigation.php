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
<nav class="main">
    <ul>
        <li <?php if($page == "index" || $page == "overviewgeneral" || $page == "overviewproject" || $page == "overviewcalendar") { echo 'class="active"'; } ?>><a href="index.php"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->pages->overview->navlink)); ?></a>
            <ul>
                <li><a href="?t=calendar">Calendar</a></li>
                <li><a href="?t=general">General</a></li>
                <li><a href="?t=project">Project</a></li>
            </ul>
        </li>
        <?php if(isset($_SESSION['username']) && UserFunc::isAdmin($username)) { ?>
        <li <?php if($page == "admin") { echo 'class="active"'; } ?>>
            <a href="admin.php"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->pages->admin->navlink)); ?></a>
        </li>
        <?php } ?>
        <li <?php if($page == "projects") { echo 'class="active"'; } ?>>
            <a href="projects.php"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->pages->projects->navlink)); ?></a>
            <ul>
                <?php
                foreach($projects as &$p) {
                    echo "<li><a href='lists.php?p=".$p."'>".$p."</a></li>";
                }
                ?>
            </ul>
        </li>
        <li <?php if($page == "list" || $page == "lists") { echo 'class="active"'; } ?>>
            <a href="lists.php"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->pages->lists->navlink)); ?></a>
            <ul>
                <?php
                foreach($lists as &$l) {
                    echo "<li><a href='list.php?p=".$project."&l=".$l."'>".$l."</a></li>";
                }
                ?>
            </ul>
        </li>

    </ul>
</nav>