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
		if(!VersionFunc::typeExists(cleanInput($_POST['type-name']))) {
			if(isset($_POST['type-description']) && trim($_POST['type-description']) != '') {
				if(isset($_POST['type-stable']) && trim($_POST['type-stable']) != '') {
					if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && checkCaptcha(cleanInput($_POST['captcha']))) {
						$name = cleanInput($_POST['type-name']);
						$description = cleanInput($_POST['type-description']);
						$stable = cleanInput($_POST['type-stable']);
						
						VersionFunc::addType($name, $description, $stable);
						
						destroySession("userspluscaptcha");
					} else {
						echo '<script type="text/javascript">';
						echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->invalidcaptcha)).'");';
						echo '</script>';
					}
				} else {
					echo '<script type="text/javascript">';
					echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->version->nostable)).'");';
					echo '</script>';
				}
			} else {
				echo '<script type="text/javascript">';
				echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->task->nodescription)).'");';
				echo '</script>';
			}
		} else {
		
		}
	} else {
		echo '<script type="text/javascript">';
		echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->noname)).'");';
		echo '</script>';
	}
}
 
if(isset($_POST['edit-version-type'])) {
	if(isset($_POST['id']) && trim($_POST['id']) != "") {
		$details = VersionFunc::getTypeDetails(cleanInput($_POST['id']));
		if(isset($_POST['type-name']) && trim($_POST['type-name']) != '') {
			if($details['name'] == cleanInput($_POST['type-name']) || $details['name'] != cleanInput($_POST['type-name']) && !VersionFunc::typeExists(cleanInput($_POST['type-name']))) {
				if(isset($_POST['type-description']) && trim($_POST['type-description']) != '') {
					if(isset($_POST['type-stable']) && trim($_POST['type-stable']) != '') {
						if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && checkCaptcha(cleanInput($_POST['captcha']))) {
							$id = cleanInput($_POST['id']);
							$name = cleanInput($_POST['type-name']);
							$description = cleanInput($_POST['type-description']);
							$stable = cleanInput($_POST['type-stable']);
							
							VersionFunc::editType($id, $name, $description, $stable);
							
							destroySession("userspluscaptcha");
						} else {
							echo '<script type="text/javascript">';
							echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->invalidcaptcha)).'");';
							echo '</script>';
						}
					} else {
						echo '<script type="text/javascript">';
						echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->version->nostable)).'");';
						echo '</script>';
					}
				} else {
					echo '<script type="text/javascript">';
					echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->task->nodescription)).'");';
					echo '</script>';
				}
			} else {
			
			}
		} else {
			echo '<script type="text/javascript">';
			echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->noname)).'");';
			echo '</script>';
		}
	} else {
		echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->invalidid)).'");';
        echo '</script>';
    }
}
?>