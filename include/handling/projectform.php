<?php
/**
 * Created by Daniel Vidmar.
 * Date: 4/25/14
 * Time: 6:04 PM
 * Version: Beta 1
 * Last Modified: 4/25/14 at 6:04 PM
 * Last Modified by Daniel Vidmar.
 */
/*
 * Fields
 * name, author, public, mainproject, overseer
 */
if(isset($_POST['add'])) {
    if(isset($_POST['name']) && trim($_POST['name']) != "") {
        if(isset($_POST['author']) && trim($_POST['author']) != "") {
            if(isset($_POST['public']) && trim($_POST['public']) != "") {
                if(isset($_POST['mainproject']) && trim($_POST['mainproject']) != "") {
                    if(isset($_POST['overseer']) && trim($_POST['overseer']) != "") {
                        if(!ProjectFunc::exists($_POST['name'])) {
                            $created = date("Y-m-d H:i:s");
                            if($_POST['mainproject'] != 0) {
                                ProjectFunc::removePreset();
                            }
                            ProjectFunc::add($_POST['name'], $_POST['mainproject'], 0, $_POST['author'], $created, $_POST['overseer'], $_POST['public']);
                            $params = "public:".$_POST['public'].",overseer:".$_POST['overseer'];
                            ActivityFunc::log($username, $_POST['name'], "none", "project:add", $params, 0, $created);
                        } else {
                            echo '<script type="text/javascript">';
                            echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->taken)).'");';
                            echo '</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->nooverseer)).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->nomain)).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->nopublic)).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->noauthor)).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->noname)).'");';
        echo '</script>';
    }
}

if(isset($_POST['edit'])) {
    if(isset($_POST['id']) && trim($_POST['id']) != "") {
        if(isset($_POST['name']) && trim($_POST['name']) != "") {
            if(isset($_POST['public']) && trim($_POST['public']) != "") {
                if(isset($_POST['mainproject']) && trim($_POST['mainproject']) != "") {
                    if(isset($_POST['mainlist']) && trim($_POST['mainlist']) != "") {
                        if(isset($_POST['overseer']) && trim($_POST['overseer']) != "") {
                            $details = ProjectFunc::getDetails($_POST['id']);
                            if($_POST['name'] == $details['name'] || $_POST['name'] != $details['name'] && !ProjectFunc::exists($_POST['name'])) {
                                $created = date("Y-m-d H:i:s");
                                if($details['preset'] == 0 && $_POST['mainproject'] == 1) {
                                    ProjectFunc::removePreset();
                                }
                                if($details['name'] != $_POST['name']) {
                                    ProjectFunc::rename($_POST['id'], $details['name'], $_POST['name']);
                                }
                                ProjectFunc::edit($_POST['id'], $_POST['name'], $_POST['mainproject'], $_POST['mainlist'], $_POST['overseer'], $_POST['public']);
                                $params = "id:".$_POST['id'].",public:".$_POST['public'].",overseer:".$_POST['overseer'];
                                ActivityFunc::log($username, $_POST['name'], "none", "project:edit", $params, 0, date("Y-m-d H:i:s"));
                            } else {
                                echo '<script type="text/javascript">';
                                echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->taken)).'");';
                                echo '</script>';
                            }
                        } else {
                            echo '<script type="text/javascript">';
                            echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->nooverseer)).'");';
                            echo '</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->nomainlist)).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->nomain)).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->nopublic)).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->noname)).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->noid)).'");';
        echo '</script>';
    }
}
?>