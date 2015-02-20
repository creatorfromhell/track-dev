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
$email = (!valid_email($_GET['name'])) ? false : true;
if(!User::exists(clean_input($_GET['name']), $email)) {
    $rules['site']['content']['announce'] = 'The specified user does not exist.';
}
$user = User::load(clean_input($_GET['name']), $email);
if($user->activation_key != $_GET['key']) {
    $rules['site']['content']['announce'] = 'Invalid activation key.';
}

$user->activation_key = "";
$user->activated = 1;
$user->save();