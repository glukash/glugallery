<?php
ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);
mb_internal_encoding("UTF-8");
session_name('gluf');
session_start();
?>
<?php
    define( 'GROOT', realpath(dirname(__FILE__)).'/');
    define( 'GAPP', 'glugal' );
    define( 'GAPPPATH', GROOT.GAPP.'/' );
    define( 'GDIR', 'gluf' );
    define( 'GDIRPATH', GAPPPATH.GDIR.'/' );
    define( 'GLIBPATH', GDIRPATH.'lib/' );
?>
<?php require_once GLIBPATH.'lib.php'; ?>
<?php require_once GLIBPATH.'config.php'; ?>
<?php require_once GLIBPATH.'bootstrap.php'; ?>
<?php require_once GLIBPATH.'router.php'; ?>
<?php
?>
<?php if  (isae($_POST['request'],'ajax')) exit; ?>
<?php

    if ( is_file( GAPPPATH.'layout/'.$gLayout.'.php' ) )
    {
        include_once GAPPPATH.'layout/'.$gLayout.'.php';
    }
    elseif ( is_file( GAPPPATH.'layout/'.GAPP.'.php' ) )
    {
        include_once GAPPPATH.'layout/'.GAPP.'.php';
    }
    else
    {
        die( 'SITE ERROR: No layout file: '.GAPPPATH.'layout/'.$gLayout.'.php' );
    }
