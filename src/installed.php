<?php
/**
 * Created by creatorfromhell.
 * Date: 7/6/15
 * Time: 1:55 PM
 * Version: Beta 2
 */
include_once("include/header.php");
$msg = "Trackr has been successfully installed! The installation wizard has also been removed for your convenience.";
$rules['site']['page']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "basic/AnnounceContent.tpl").'}';
$rules['site']['content']['announce'] = $msg;

$dir = DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR;
$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
$files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
foreach($files as $file) {
    if ($file->isDir()){
        rmdir($file->getRealPath());
    } else {
        unlink($file->getRealPath());
    }
}
rmdir($dir);

new SimpleTemplate($theme_manager->get_template((string)$theme->name, "basic/Page.tpl"), $rules, true);