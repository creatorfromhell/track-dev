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
		if(!has_values("version_types", " WHERE version_type = '".StringFormatter::clean_input($_POST['type-name'])."'")) {
			if(isset($_POST['type-description']) && trim($_POST['type-description']) != '') {
				if(isset($_POST['type-stable']) && trim($_POST['type-stable']) != '') {
					if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(StringFormatter::clean_input($_POST['captcha']))) {

						$name = StringFormatter::clean_input($_POST['type-name']);
						$description = StringFormatter::clean_input($_POST['type-description']);
						$stable = StringFormatter::clean_input($_POST['type-stable']);

                        $type_created_hook = new TypeCreatedHook($name, $stable, $description);
                        $plugin_manager->trigger($type_created_hook);

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
		$details = VersionFunc::type_details(StringFormatter::clean_input($_POST['id']));
		if(isset($_POST['type-name']) && trim($_POST['type-name']) != '') {
			if($details['name'] == StringFormatter::clean_input($_POST['type-name']) || $details['name'] != StringFormatter::clean_input($_POST['type-name']) && !has_values("version_types", " WHERE version_type = '".StringFormatter::clean_input($_POST['type-name'])."'")) {
				if(isset($_POST['type-description']) && trim($_POST['type-description']) != '') {
					if(isset($_POST['type-stable']) && trim($_POST['type-stable']) != '') {
						if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(StringFormatter::clean_input($_POST['captcha']))) {

							$id = StringFormatter::clean_input($_POST['id']);
                            $details = VersionFunc::type_details($id);

							$name = StringFormatter::clean_input($_POST['type-name']);
							$description = StringFormatter::clean_input($_POST['type-description']);
							$stable = StringFormatter::clean_input($_POST['type-stable']);

                            $type_modified_hook = new TypeModifiedHook($id, $details['name'], $name, $details['stability'], $stable, $details['description'], $description);
                            $plugin_manager->trigger($type_modified_hook);

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