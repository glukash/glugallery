<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);



//require_once '../../../../gflib/lib.php';
//require_once '../../../../gluf/lib/bootstrap.php';
//require_once '../../../../gluf/lib/config.php';
require_once '../../../../config/config.php';

$galTargetDirectory = $_GET['td'];


require('UploadHandler.php');
$upload_handler = new UploadHandler(
    array(
        'upload_dir' => $galRoot.$galTargetDirectory.'/src/',
        'upload_url' => $galRootUrl.$galTargetDirectory.'/src/',
        'image_versions' => array()
        )
    );
