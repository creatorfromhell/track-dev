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
<div class="below-content" style="margin-top:30px;">
    <h3>Languages</h3>
</div>
<table id="languages" class="taskTable" style="padding-top:0px";>
    <thead>
        <tr>
            <th id="languageShort" class="small"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->short)); ?></th>
            <th id="languageIcon" class="small"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->icon)); ?></th>
            <th id="languageName" class="large"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->name)); ?></th>
            <th id="languageAuthor" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->author)); ?></th>
            <th id="languageVersion" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->version)); ?></th>
            <th id="languageAction" class="action"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($langmanager->languages as &$l) {
            echo "<tr>";
            echo "<td class='short'>".(string)$l->short."</td>";
            echo "<td class='icon'><img src='resources/themes/".(string)$theme->directory."/img/".(string)$l->symbol."' /></td>";
            echo "<td class='name'>".(string)$l->name."</td>";
            echo "<td class='author'>".(string)$l->author."</td>";
            echo "<td class='version'>".(string)$l->version."</td>";
            echo "<td class='actions'>".$formatter->replaceShortcuts('%none')."</td>";
            echo "</tr>";
        }
    ?>
    </tbody>
</table>
<div class="below-content">
    <h3>Themes</h3>
</div>
<table id="themes" class="taskTable"style="padding-top:0px";>
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
<div class="below-content">
    <h3>Plugins</h3>
</div>