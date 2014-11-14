<?php
/**
 * Created by Daniel Vidmar.
 * Date: 11/13/14
 * Time: 9:36 PM
 * Version: Beta 2
 * Last Modified: 11/13/14 at 9:36 PM
 * Last Modified by Daniel Vidmar.
 */
function parseQueries($file) {
    $queries = array();
    $file = fopen($file, 'r');
    $comment = false;
    $longQuery = false;
    $queryStatement = '';
    while(!feof($file)) {
        $line = stream_get_line($file, 30000, "\n");
        $l = trim($line);
        if($l == '') { continue; }
        $chars = substr($l, 0, 2);
        if($chars == '--' || substr($chars, 0, 1) == '#') {
            continue;
        } else if($chars == '/*') {
            $comment = true;
            continue;
        } else if($chars == '*/') {
            $comment = false;
            continue;
        }
        if($comment) { continue; }
        if($longQuery) {
            $queryStatement .= $l;
            continue;
        }
        if(substr($l, 6) === 'CREATE') {
            $longQuery = true;
            $queryStatement = $l;
            continue;
        }
        if($longQuery && substr($l, -strlen(';')) === ';') {
            $queryStatement .= $l;
            $queries[] = $queryStatement;
            $queryStatement = '';
            $longQuery = false;
            continue;
        }
        $queries[] = $l;
    }
    fclose($file);
    return $queries;
}
?>