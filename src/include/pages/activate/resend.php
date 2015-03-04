<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/18/14
 * Time: 1:52 PM
 * Version: Beta 1
 * Last Modified: 8/18/14 at 1:52 PM
 * Last Modified by Daniel Vidmar.
 */
$rules['site']['content']['announce'] = 'A new activation key has been sent to your email address.';
if(!isset($_GET['name'])) {
    $rules['site']['content']['announce'] = 'Invalid request.';
}
$email = (!valid_email($_GET['name'])) ? false : true;
if(!User::exists(StringFormatter::clean_input($_GET['name']), $email)) {
    $rules['site']['content']['announce'] = 'The specified user does not exist.';
}

$user = User::load(StringFormatter::clean_input($_GET['name']), $email);
$user->activation_key = generate_session_id(40);
$user->save();
$user->send_activation();