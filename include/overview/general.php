<?php
/**
 * Created by Daniel Vidmar.
 * Date: 4/9/14
 * Time: 4:07 PM
 * Version: Beta 1
 * Last Modified: 4/9/14 at 4:07 PM
 * Last Modified by Daniel Vidmar.
 */
?>
<div class="module">
    <h4>Latest Users</h4>
    <?php
    $users = UserFunc::latestUsers();
    foreach($users as &$user) {
        echo '<div class="user"><a href="#">'.$formatter->replace($user).'</a></div>';
    }?>
</div>