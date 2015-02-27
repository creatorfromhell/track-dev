<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/23/14
 * Time: 12:12 PM
 * Version: Beta 1
 * Last Modified: 8/23/14 at 12:12 PM
 * Last Modified by Daniel Vidmar.
 */
//name, admin, preset, permissions-value, captcha
if(isset($_POST['add-group'])) {
    if(isset($_POST['name']) && trim($_POST['name']) != '') {
        if(isset($_POST['admin']) && trim($_POST['admin']) != '') {
            if(isset($_POST['preset']) && trim($_POST['preset']) != '') {
                if(!has_values("groups", " WHERE group_name = '".clean_input($_POST['name'])."'")) {
                    if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(clean_input($_POST['captcha']))) {
                        $group = new Group();
                        $group->name = clean_input($_POST['name']);
                        $group->admin = (clean_input($_POST['admin']) == '1') ? true : false;
                        $group->preset = (clean_input($_POST['preset']) == '1') ? true : false;
                        $group->permissions = explode(",", clean_input($_POST['permissions-value']));
                        $params = "name:".clean_input($_POST['name']).",admin:".clean_input($_POST['admin']).",preset:".clean_input($_POST['preset']);
                        ActivityFunc::log($current_user->name, "none", "none", "group:add", $params, 0, date("Y-m-d H:i:s"));

                        $group_created_hook = new GroupCreatedHook($group->name, $group->admin, $group->preset, $group->permissions);
                        $plugin_manager->trigger($group_created_hook);

                        Group::add_group($group);
                        destroy_session("userspluscaptcha");
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site/forms/invalidcaptcha")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site/forms/group/taken")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->group->nopreset")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->group->noadmin")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->noname")).'");';
        echo '</script>';
    }
}

if(isset($_POST['edit-group'])) {
    if(isset($_POST['id']) && trim($_POST['id']) != '' && has_values("groups", " WHERE id = '".clean_input($_POST['id'])."'")) {
        if(isset($_POST['name']) && trim($_POST['name']) != '') {
            if(isset($_POST['admin']) && trim($_POST['admin']) != '') {
                if(isset($_POST['preset']) && trim($_POST['preset']) != '') {
                    $id = clean_input($_POST['id']);
                    $group = Group::load($id);
                    if(clean_input($_POST['name']) != $group->name && !has_values("groups", " WHERE group_name = '".clean_input($_POST['name'])."'") || clean_input($_POST['name']) == $oldName) {
                        if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(clean_input($_POST['captcha']))) {
                            $name = clean_input($_POST['name']);
                            $admin = clean_input($_POST['admin']);
                            $preset = clean_input($_POST['preset']);
                            $permissions = explode(",", clean_input($_POST['permissions-value']));

                            if($preset == '1') {
                                $old = Group::load(Group::preset());
                                $old->preset = 0;
                                $old->save();
                            }

                            $params = "prevname:".$group->name.",name:".$name.",admin:".$admin.",preset:".$preset;
                            ActivityFunc::log($current_user->name, "none", "none", "group:edit", $params, 0, date("Y-m-d H:i:s"));

                            $group_modified_hook = new GroupModifiedHook($id, $group->name, $name, $group->admin, $admin, $group->preset, $preset, $group->permissions, $permissions);
                            $plugin_manager->trigger($group_modified_hook);

                            $group->name = $name;
                            $group->admin = ($admin == '1') ? true : false;
                            $group->preset = ($preset == '1') ? true : false;
                            $group->permissions = $permissions;
                            $group->save();
                            destroy_session("userspluscaptcha");
                        } else {
                            echo '<script type="text/javascript">';
                            echo 'showMessage("error", "'.$formatter->replace_shortcuts($langmanager->getValue($language_manager, "site->forms->invalidcaptcha")).'");';
                            echo '</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($langmanager->getValue($language_manager, "site->forms->group->taken")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($langmanager->getValue($language_manager, "site->forms->group->nopreset")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replace_shortcuts($langmanager->getValue($language_manager, "site->forms->group->noadmin")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replace_shortcuts($langmanager->getValue($language_manager, "site->forms->project->noname")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replace_shortcuts($langmanager->getValue($language_manager, "site->forms->invalidid")).'");';
        echo '</script>';
    }
}