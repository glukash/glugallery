<?php

$gScriptDirName = dirname($_SERVER['SCRIPT_NAME']);

$gRoot = $_SERVER['DOCUMENT_ROOT'];
if ( $gScriptDirName == DIRECTORY_SEPARATOR )
{
    $gRoot = $gRoot.'/';
}
else
{
    $gRoot = $gRoot.$gScriptDirName.'/';
}


$gRootUrl = selfURL(true);
if ( $gScriptDirName == DIRECTORY_SEPARATOR )
{
    $gRootUrl=$gRootUrl.'/';
}
else
{
    $gRootUrl=$gRootUrl.$gScriptDirName.'/';
}


$gTmpPath = G_APP_PATH.'tmp/';

if ( !is_dir( $gTmpPath ) )
{
    mkdir( $gTmpPath );
}

$qHead=array();
