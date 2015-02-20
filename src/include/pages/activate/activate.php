<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/18/14
 * Time: 1:52 PM
 * Version: Beta 1
 * Last Modified: 8/18/14 at 1:52 PM
 * Last Modified by Daniel Vidmar.
 */
$rules['site']['content']['announce'] = 'Your account has been activated!';
if(!isset($_GET['name']) || !isset($_GET['key'])) {
    $rules['site']['content']['announce'] = 'Invalid request.';
}
$email = (!validEmail($_GET['name'])) ? false : true;
if(!User::exists(cleanInput($_GET['name']), $email)) {
    $rules['site']['content']['announce'] = 'The specified user does not exist.';
}
$user = User::load(cleanInput($_GET['name']), $email);
if($user->activationKey != $_GET['key']) {
    $rules['site']['content']['announce'] = 'Invalid activation key.';
}

$user->activationKey = "";
$user->activated = 1;
$user->save();
?>