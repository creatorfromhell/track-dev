<?php

/**
 * Created by Daniel Vidmar.
 * Date: 10/27/14
 * Time: 12:59 AM
 * Version: Beta 2
 * Last Modified: 10/27/14 at 1:00 AM
 * Last Modified by Daniel Vidmar.
 */

if(isset($_POST['add-version-type'])) {
	if(isset($_POST['type-name']) && trim($_POST['type-name']) != '') {
		if(!has_values("version_types", " WHERE version_type = '".clean_input($_POST['type-name'])."'")) {
			if(isset($_POST['type-description']) && trim($_POST['type-description']) != '') {
				if(isset($_POST['type-stable']) && trim($_POST['type-stable']) != '') {
					if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(clean_input($_POST['captcha']))) {

						$name = clean_input($_POST['type-name']);
						$description = clean_input($_POST['type-description']);
						$stable = clean_input($_POST['type-stable']);
						VersionFunc::add_type($name, $description, $stable);
						destroy_session("userspluscaptcha");

					} else {
						echo '<script type="text/javascript">';
						echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidcaptcha")).'");';
						echo '</script>';
					}
				} else {
					echo '<script type="text/javascript">';
					echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->version->nostable")).'");';
					echo '</script>';
				}
			} else {
				echo '<script type="text/javascript">';
				echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->nodescription")).'");';
				echo '</script>';
			}
		} else {

		}
	} else {
		echo '<script type="text/javascript">';
		echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->noname")).'");';
		echo '</script>';
	}
}

 

if(isset($_POST['edit-version-type'])) {
	if(isset($_POST['id']) && trim($_POST['id']) != "") {
		$details = VersionFunc::type_details(clean_input($_POST['id']));
		if(isset($_POST['type-name']) && trim($_POST['type-name']) != '') {
			if($details['name'] == clean_input($_POST['type-name']) || $details['name'] != clean_input($_POST['type-name']) && !has_values("version_types", " WHERE version_type = '".clean_input($_POST['type-name'])."'")) {
				if(isset($_POST['type-description']) && trim($_POST['type-description']) != '') {
					if(isset($_POST['type-stable']) && trim($_POST['type-stable']) != '') {
						if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(clean_input($_POST['captcha']))) {

							$id = clean_input($_POST['id']);
							$name = clean_input($_POST['type-name']);
							$description = clean_input($_POST['type-description']);
							$stable = clean_input($_POST['type-stable']);

							VersionFunc::edit_type($id, $name, $description, $stable);
							destroy_session("userspluscaptcha");

						} else {
							echo '<script type="text/javascript">';
							echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidcaptcha")).'");';
							echo '</script>';
						}
					} else {
						echo '<script type="text/javascript">';
						echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->version->nostable")).'");';
						echo '</script>';
					}
				} else {
					echo '<script type="text/javascript">';
					echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->nodescription")).'");';
					echo '</script>';
				}
			} else {

			}
		} else {
			echo '<script type="text/javascript">';
			echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->noname")).'");';
			echo '</script>';
		}
	} else {
		echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidid")).'");';
        echo '</script>';
    }
}