<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/14
 * Time: 5:30 PM
 * Version: Beta 1
 * Last Modified: 2/26/14 at 5:30 PM
 * Last Modified by Daniel Vidmar.
 */
?>
<footer>
    <p class="theme"><?php echo $manager->replaceShortcuts((string)$theme->name, (string)$theme->copyright); ?></p>
    <p class="copyright">Copyright &copy; 2013 - <?php echo date("Y");  ?> <a href="http://creatorfromhell.com">Daniel Vidmar</a></p>
    <label for="languageSelection">Language:</label>
    <select name="languageSelection" class="languageSelection" onchange="changeLanguage(this.value)">
        <?php
            foreach($langmanager->languages as &$lang) {
                $selected = ((string)$lang->short == $language) ? "Selected" : "";
                echo '<option value="'.(string)$lang->short.'" '.$selected.'>'.(string)$lang->name.'</option>';
            }
        ?>
    </select>
</footer>
</body>
</html>