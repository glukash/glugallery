<?php
ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);
mb_internal_encoding("UTF-8");
session_name('glugal');
session_start();
?>
<?php
    define( 'G_ROOT', realpath(dirname(__FILE__)).'/');
    define( 'G_APP_NAME', 'glugal' );
    define( 'G_APP_DIR', 'glugal' );
    define( 'G_APP_PATH', G_ROOT.G_APP_DIR.'/' );
    define( 'G_LIB_DIR', 'gflib' );
    define( 'G_LIB_PATH', G_APP_PATH.G_LIB_DIR.'/' );
?>
<?php require_once G_LIB_PATH.'lib.php'; ?>
<?php require_once G_LIB_PATH.'config.php'; ?>
<?php require_once G_LIB_PATH.'bootstrap.php'; ?>
<?php require_once G_LIB_PATH.'router.php'; ?>
<?php
?>
<?php if  (isae($_POST['request'],'ajax')) exit; ?>
<?php

    if ( is_file( G_APP_PATH.'layout/'.$gLayout.'.php' ) )
    {
        include_once G_APP_PATH.'layout/'.$gLayout.'.php';
    }
    elseif ( is_file( G_APP_PATH.'layout/'.G_APP_NAME.'.php' ) )
    {
        include_once G_APP_PATH.'layout/'.G_APP_NAME.'.php';
    }
    else
    {
        die( 'SITE ERROR: No layout file: '.G_APP_PATH.'layout/'.$gLayout.'.php' );
    }

    if ( isset($_GET['debug']))
    {
        include G_LIB_PATH.'debug.php';
    }
