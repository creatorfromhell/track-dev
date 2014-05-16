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
                <li><a href="index.php?t=calendar"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->pages->overview->calendar->navlink)); ?></a></li>
                <li><a href="index.php?t=general"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->pages->overview->general->navlink)); ?></a></li>
                <li><a href="index.php?t=project"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->pages->overview->project->navlink)); ?></a></li>
            </ul>
        </li>
        <?php if(UserFunc::isAdmin($username)) { ?>
        <li <?php if($page == "admin") { echo 'class="active"'; } ?>>
            <a href="admin.php"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->pages->admin->navlink)); ?></a>
            <ul>
                <li><a href="admin.php?t=groups">Groups</a></li>
                <li><a href="admin.php?t=options">Options</a></li>
                <li><a href="admin.php?t=themes">Themes</a></li>
                <li><a href="admin.php?t=languages">Languages</a></li>
                <li><a href="admin.php?t=users">Users</a></li>
            </ul>
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
                    echo "<li><a href='list.php?p=".$project."&amp;l=".$l."'>".$l."</a></li>";
                }
                ?>
            </ul>
        </li>

    </ul>
</nav>