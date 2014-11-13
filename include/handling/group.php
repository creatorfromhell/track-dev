<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/23/14
 * Time: 12:12 PM
 * Version: Beta 1
 * Last Modified: 8/23/14 at 12:12 PM
 * Last Modified by Daniel Vidmar.
 */

global $language, $langmanager;

//name, admin, preset, permissions-value, captcha
if(isset($_POST['add-group'])) {
    if(isset($_POST['name']) && trim($_POST['name']) != '') {
        if(isset($_POST['admin']) && trim($_POST['admin']) != '') {
            if(isset($_POST['preset']) && trim($_POST['preset']) != '') {
                if(!Group::exists(cleanInput($_POST['name']))) {
                    if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && checkCaptcha(cleanInput($_POST['captcha']))) {
                        $group = new Group();
                        $group->name = cleanInput($_POST['name']);
                        $group->admin = (cleanInput($_POST['admin']) == '1') ? true : false;
                        $group->preset = (cleanInput($_POST['preset']) == '1') ? true : false;
                        $group->permissions = explode(",", cleanInput($_POST['permissions-value']));
                        Group::add($group);
                        $params = "name:".cleanInput($_POST['name']).",admin:".cleanInput($_POST['admin']).",preset:".cleanInput($_POST['preset']);
                        ActivityFunc::log($currentUser->name, "none", "none", "group:add", $params, 0, date("Y-m-d H:i:s"));
                        destroySession("userspluscaptcha");
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site/forms/invalidcaptcha")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site/forms/group/taken")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->group->nopreset")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->group->noadmin")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->project->noname")).'");';
        echo '</script>';
    }
}

if(isset($_POST['edit-group'])) {
    if(isset($_POST['id']) && trim($_POST['id']) != '' && Group::validID(cleanInput($_POST['id']))) {
        $oldName = Group::getName(cleanInput($_POST['id']));
        if(isset($_POST['name']) && trim($_POST['name']) != '') {
            if(isset($_POST['admin']) && trim($_POST['admin']) != '') {
                if(isset($_POST['preset']) && trim($_POST['preset']) != '') {
                    if(cleanInput($_POST['name']) != $oldName && !Group::exists(cleanInput($_POST['name'])) || cleanInput($_POST['name']) == $oldName) {
                        if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && checkCaptcha(cleanInput($_POST['captcha']))) {
                            if($_POST['preset'] == '1') {
                                $old = Group::load(Group::preset());
                                $old->preset = 0;
                                $old->save();
                            }
                            $group = Group::load(cleanInput($_POST['id']));
                            $group->name = cleanInput($_POST['name']);
                            $group->admin = (cleanInput($_POST['admin']) == '1') ? true : false;
                            $group->preset = (cleanInput($_POST['preset']) == '1') ? true : false;
                            $group->permissions = explode(",", cleanInput($_POST['permissions-value']));
                            $group->save();
                            $params = "prevname:".$oldName.",name:".cleanInput($_POST['name']).",admin:".cleanInput($_POST['admin']).",preset:".cleanInput($_POST['preset']);
                            ActivityFunc::log($currentUser->name, "none", "none", "group:edit", $params, 0, date("Y-m-d H:i:s"));
                            destroySession("userspluscaptcha");
                        } else {
                            echo '<script type="text/javascript">';
                            echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->invalidcaptcha")).'");';
                            echo '</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->group->taken")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->group->nopreset")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->group->noadmin")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->project->noname")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->invalidid")).'");';
        echo '</script>';
    }
}