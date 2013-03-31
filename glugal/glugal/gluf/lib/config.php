<?php

$gScriptDirName = dirname($_SERVER['SCRIPT_NAME']);

$gRoot = $_SERVER['DOCUMENT_ROOT'];
if ( $gScriptDirName == '/' )
{
    $gRoot = $gRoot.'/';
}
else
{
    $gRoot = $gRoot.$gScriptDirName.'/';
}


$gRootUrl = selfURL(true);
if ( $gScriptDirName == '/' )
{
    $gRootUrl=$gRootUrl.'/';
}
else
{
    $gRootUrl=$gRootUrl.$gScriptDirName.'/';
}


$gDefLayout = 'default';
$gLayout = $gDefLayout;
