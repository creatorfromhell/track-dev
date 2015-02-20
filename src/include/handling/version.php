<?php

/**

 * Created by Daniel Vidmar.

 * Date: 10/27/14

 * Time: 12:59 AM

 * Version: Beta 2

 * Last Modified: 10/27/14 at 12:59 AM

 * Last Modified by Daniel Vidmar.

 */

if(isset($_POST['add-version'])) {
	if(isset($_POST['project']) && trim($_POST['project']) != "") {
		if(isset($_POST['version-name']) && trim($_POST['version-name']) != "") {
			if(!has_values("versions", " WHERE version_name = '".clean_input($_POST['version-name'])."'")) {
				if(isset($_POST['status']) && trim($_POST['status']) != "") {
					if(isset($_POST['version-type']) && trim($_POST['version-type']) != "") {
						if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(clean_input($_POST['captcha']))) {

							$version = clean_input($_POST['version-name']);
							$project = clean_input($_POST['project']);
							$status = clean_input($_POST['status']);
							$type = clean_input($_POST['version-type']);

							if(isset($_POST['version_download'])) {
								uploadFile($_FILES['version_download'], $project."-".$version);
							}
							$due = (isset($_POST['due-date']) && trim($_POST['due-date']) != "") ? clean_input($_POST['due-date']) : "0000-00-00";
							VersionFunc::add_version($version, $project, $status, $due, '0000-00-00', $type);
							destroy_session("userspluscaptcha");

						} else {
							echo '<script type="text/javascript">';
							echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidcaptcha")).'");';
							echo '</script>';
						}
					} else {
						echo '<script type="text/javascript">';
						echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->version->notype")).'");';
						echo '</script>';
					}
				} else {
					echo '<script type="text/javascript">';
					echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->invalidstatus")).'");';
					echo '</script>';
				}
			} else {
				echo '<script type="text/javascript">';
				echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->version->taken")).'");';
				echo '</script>';
			}
		} else {
			echo '<script type="text/javascript">';
			echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->noname")).'");';
			echo '</script>';
		}
	} else {
		echo '<script type="text/javascript">';
		echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->noproject")).'");';
		echo '</script>';
	}
}



if(isset($_POST['edit-version'])) {
	if(isset($_POST['id']) && trim($_POST['id']) != "") {
		$details = VersionFunc::version_details(clean_input($_POST['id']));
		if(isset($_POST['project']) && trim($_POST['project']) != "") {
			if(isset($_POST['version-name']) && trim($_POST['version-name']) != "") {
				if($details['name'] == clean_input($_POST['version-name']) || $details['name'] != clean_input($_POST['version-name']) && !has_values("versions", " WHERE version_name = '".clean_input($_POST['version-name'])."'")) {
					if(isset($_POST['status']) && trim($_POST['status']) != "") {
						if(isset($_POST['version-type']) && trim($_POST['version-type']) != "") {
							if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(clean_input($_POST['captcha']))) {

								$id = clean_input($_POST['id']);
								$version = clean_input($_POST['version-name']);
								$project = clean_input($_POST['project']);
								$status = clean_input($_POST['status']);
								$type = clean_input($_POST['version-type']);
								$due = (isset($_POST['due-date']) && trim($_POST['due-date']) != "") ? clean_input($_POST['due-date']) : "0000-00-00";

								VersionFunc::edit_version($id, $version, $project, $status, $due, '0000-00-00', $type);
								destroy_session("userspluscaptcha");
							} else {
								echo '<script type="text/javascript">';
								echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidcaptcha")).'");';
								echo '</script>';
							}
						} else {
							echo '<script type="text/javascript">';
							echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->version->notype")).'");';
							echo '</script>';
						}
					} else {
						echo '<script type="text/javascript">';
						echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->invalidstatus")).'");';
						echo '</script>';
					}
				} else {
					echo '<script type="text/javascript">';
					echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->version->taken")).'");';
					echo '</script>';
				}
			} else {
				echo '<script type="text/javascript">';
				echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->noname")).'");';
				echo '</script>';
			}
		} else {
			echo '<script type="text/javascript">';
			echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->noproject")).'");';
			echo '</script>';
		}
	} else {
		echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidid")).'");';
        echo '</script>';
    }
}