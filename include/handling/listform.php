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
 * name, author, project, public, minimal, mainlist, overseer, guestview, guestedit, viewpermission, editpermission
 */
if(isset($_POST['add'])) {
    if(isset($_POST['name']) && trim($_POST['name']) != "") {
        if(isset($_POST['author']) && trim($_POST['author']) != "") {
            if(isset($_POST['project']) && trim($_POST['project']) != "") {
                if(isset($_POST['public']) && trim($_POST['public']) != "") {
                    if(isset($_POST['minimal']) && trim($_POST['minimal']) != "") {
                        if(isset($_POST['mainlist']) && trim($_POST['mainlist']) != "") {
                            if(isset($_POST['overseer']) && trim($_POST['overseer']) != "") {
                                if(isset($_POST['guestview']) && trim($_POST['guestview']) != "") {
                                    if(isset($_POST['guestedit']) && trim($_POST['guestedit']) != "") {
                                        if(isset($_POST['viewpermission']) && trim($_POST['viewpermission']) != "") {
                                            if(isset($_POST['editpermission']) && trim($_POST['editpermission']) != "") {
                                                if(ProjectFunc::exists($_POST['project'])) {
                                                    if(!ListFunc::exists($_POST['project'], $_POST['name'])) {
                                                        $created = date("Y-m-d H:i:s");
                                                        ListFunc::add($_POST['name'], $_POST['project'], $_POST['public'], $_POST['author'], $created, $_POST['overseer'], $_POST['minimal'], $_POST['guestview'], $_POST['guestedit'], $_POST['viewpermission'], $_POST['editpermission']);
                                                        ListFunc::create($_POST['project'], $_POST['name']);
                                                        if($_POST['mainlist'] != 0) {
                                                            ProjectFunc::changeMain(ProjectFunc::getID($_POST['project']), ListFunc::getID($_POST['project'], $_POST['name']));
                                                        }
                                                        echo '<script type="text/javascript">';
                                                        echo 'showMessage("success", "'.$formatter->replaceShortcuts(str_ireplace("%list", $_POST['name'], (string)$languageinstance->site->forms->list->created)).'");';
                                                        echo '</script>';
                                                    } else {
                                                        echo '<script type="text/javascript">';
                                                        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->taken)).'");';
                                                        echo '</script>';
                                                    }
                                                } else {
                                                    echo '<script type="text/javascript">';
                                                    echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->invalidproject)).'");';
                                                    echo '</script>';
                                                }
                                            } else {
                                                echo '<script type="text/javascript">';
                                                echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->noeditperm)).'");';
                                                echo '</script>';
                                            }
                                        } else {
                                            echo '<script type="text/javascript">';
                                            echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->noviewperm)).'");';
                                            echo '</script>';
                                        }
                                    } else {
                                        echo '<script type="text/javascript">';
                                        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->noguestedit)).'");';
                                        echo '</script>';
                                    }
                                } else {
                                    echo '<script type="text/javascript">';
                                    echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->noguestview)).'");';
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
                        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->nominimal)).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->nopublic)).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->noproject)).'");';
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
            if(isset($_POST['project']) && trim($_POST['project']) != "") {
                if(isset($_POST['public']) && trim($_POST['public']) != "") {
                    if(isset($_POST['minimal']) && trim($_POST['minimal']) != "") {
                        if(isset($_POST['mainlist']) && trim($_POST['mainlist']) != "") {
                            if(isset($_POST['overseer']) && trim($_POST['overseer']) != "") {
                                if(isset($_POST['guestview']) && trim($_POST['guestview']) != "") {
                                    if(isset($_POST['guestedit']) && trim($_POST['guestedit']) != "") {
                                        if(isset($_POST['viewpermission']) && trim($_POST['viewpermission']) != "") {
                                            if(isset($_POST['editpermission']) && trim($_POST['editpermission']) != "") {
                                                if(ProjectFunc::exists($_POST['project'])) {
                                                    $id = $_POST['id'];
                                                    $details = ListFunc::getDetails($id);
                                                    if($_POST['name'] == $details['name'] || $_POST['name'] != $details['name'] && !ListFunc::exists($_POST['project'], $_POST['name'])) {
                                                        $created = date("Y-m-d H:i:s");
                                                        if($_POST['project'] != $details['project']) {
                                                            ListFunc::changeProject($id, $_POST['project']);
                                                        }

                                                        if($_POST['name'] != $details['name']) {
                                                            ListFunc::rename($id, $_POST['name']);
                                                        }

                                                        if(ProjectFunc::getMain(ProjectFunc::getID($details['project'])) != $id && $_POST['mainlist'] == 1) {
                                                            ProjectFunc::changeMain(ProjectFunc::getID($_POST['project']), ListFunc::getID($_POST['project'], $_POST['name']));
                                                        }
                                                        ListFunc::edit($id, $_POST['name'], $_POST['project'], $_POST['public'], $_POST['overseer'], $_POST['minimal'], $_POST['guestview'], $_POST['guestedit'], $_POST['viewpermission'], $_POST['editpermission']);
                                                        echo '<script type="text/javascript">';
                                                        echo 'showMessage("success", "'.$formatter->replaceShortcuts(str_ireplace("%list", $_POST['name'], (string)$languageinstance->site->forms->list->created)).'");';
                                                        echo '</script>';
                                                    } else {
                                                        echo '<script type="text/javascript">';
                                                        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->taken)).'");';
                                                        echo '</script>';
                                                    }
                                                } else {
                                                    echo '<script type="text/javascript">';
                                                    echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->invalidproject)).'");';
                                                    echo '</script>';
                                                }
                                            } else {
                                                echo '<script type="text/javascript">';
                                                echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->noeditperm)).'");';
                                                echo '</script>';
                                            }
                                        } else {
                                            echo '<script type="text/javascript">';
                                            echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->noviewperm)).'");';
                                            echo '</script>';
                                        }
                                    } else {
                                        echo '<script type="text/javascript">';
                                        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->noguestedit)).'");';
                                        echo '</script>';
                                    }
                                } else {
                                    echo '<script type="text/javascript">';
                                    echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->noguestview)).'");';
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
                        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->nominimal)).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->nopublic)).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->noproject)).'");';
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