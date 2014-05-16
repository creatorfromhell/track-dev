<?php
/**
 * Created by Daniel Vidmar.
 * Date: 5/13/14
 * Time: 6:20 PM
 * Version: Beta 1
 * Last Modified: 5/13/14 at 6:20 PM
 * Last Modified by Daniel Vidmar.
 */
?>
<table id="themes" class="taskTable">
    <thead>
        <tr>
            <th id="themeName" class="large"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->name)); ?></th>
            <th id="themeAuthor" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->author)); ?></th>
            <th id="themeVersion" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->version)); ?></th>
            <th id="themeAction" class="action"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($manager->themes as &$t) {
            $name = (string)$t->name;
            echo "<tr>";
            echo "<td class='name'>".$name."</td>";
            echo "<td class='author'>".(string)$t->author."</td>";
            echo "<td class='version'>".(string)$t->version."</td>";
            echo "<td class='actions'>".$formatter->replaceShortcuts('%none')."</td>";
            echo "</tr>";
        }
    ?>
    </tbody>
</table>