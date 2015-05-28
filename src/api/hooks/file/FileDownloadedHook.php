<?php
/**
 * Created by Daniel Vidmar.
 * Date: 4/25/2015
 * Time: 1:17 AM
 * Version: Beta 2
 * Last Modified: 4/25/2015 at 1:17 AM
 * Last Modified by Daniel Vidmar.
 */

class FileDownloadedHook extends FileHook {

    public function __construct($project = 'not initialized', $downloads = 'not initialized') {
        parent::__construct("file_downloaded_hook");
        $this->web = true;
        $this->arguments = array(
            'project' => $project,
            'downloads' => $downloads
        );
    }
}