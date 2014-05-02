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