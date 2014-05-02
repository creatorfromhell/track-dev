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
                                                if(!ListFunc::exists($_POST['project'], $_POST['name'])) {
                                                    $created = date("Y-m-d H:i:s");
                                                    ListFunc::add($_POST['name'], $_POST['project'], $_POST['public'], $_POST['author'], $created, $_POST['overseer'], $_POST['minimal'], $_POST['guestview'], $_POST['guestedit'], $_POST['viewpermission'], $_POST['editpermission']);
                                                    if($_POST['mainlist'] != 0) {
                                                        ProjectFunc::changeMain(ProjectFunc::getID($_POST['project']), ListFunc::getID($_POST['project'], $_POST['name']));
                                                    }
                                                } else {

                                                }
                                            } else {

                                            }
                                        } else {

                                        }
                                    } else {

                                    }
                                } else {

                                }
                            } else {

                            }
                        } else {

                        }
                    } else {

                    }
                } else {

                }
            } else {

            }
        } else {

        }
    } else {

    }
}

if(isset($_POST['edit'])) {

}
?>