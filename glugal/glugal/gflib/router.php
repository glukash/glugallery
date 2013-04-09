<?php

if ( isne($_POST['data']) )
{
    $pdata = $_POST['data'];
}

$gRouter=array(); $gParams=array(); $gParamsNamed=array();

if ( isset( $_POST['request'] ) && ( $_POST['request']=='ajax' ) ) //ajax calls
{
    $gAjaxCall = true;
}
else
{
    $gAjaxCall = false;
}

if ($gAjaxCall)
{
    if ( isne( $_POST['query'] ) )
    {
        $gQuery = $_POST['query'];
    }
    elseif ( isne( $_GET['url'] ) )
    {
        $gQuery = $_GET['url'];
    }
    else
    {
        $gQuery = '';
    }
}
else
{
    if ( isne( $_GET['url'] ) )
    {
        $gQuery = $_GET['url'];
    }
    else
    {
        $gQuery = '';
    }
}

    $gAppDir = gRouter( $gRouter, $gParams, $gParamsNamed, $gQuery );
    $gAppUrl = $gRootUrl.$gAppDir.'/';

    if ( is_file( G_APP_PATH."config/config.php" ) )
    {
        include G_APP_PATH."config/config.php";
    }

    if ( !isset( $gAuth ) || ( $gAuth == false ) )
    {
        $gUser = array('username'=>'admin','roles'=>'admin');
    }

    if ( isset( $gAuth ) && ( $gAuth == true ) )
    {
        if ( isset( $_SESSION['gUser'] ) )
        {
            $gUser = $_SESSION['gUser'];
        }
        else
        {
            $gUser = array('username'=>'','roles'=>'');
        }

        if ( !isset( $gAuthPerms ) && isset( $gAuthPermsFile ) && is_file( $gAuthPermsFile ) )
        {
            $gAuthPerms = read_json_file( $gAuthPermsFile );
            $gAuthorize = false;
        }
        elseif ( isset( $gAuthPerms ) )
        {
            $gAuthorize = false;
        }
        else
        {
            $gAuthorize = true;
        }

        if ( $gAuthorize == false )
        {
            if ( isset( $gAuthPerms[G_APP_NAME]['roles'] ) ) //authorize controller
            {
                $gAuthorize = gAuthorize( $gUser, $gAuthPerms[G_APP_NAME]['roles'] );
            }

            if ( isset( $gAuthPerms[G_APP_NAME][$gRouter['act']]['roles'] ) ) //authorize action
            {
                $gAuthorize = gAuthorize( $gUser, $gAuthPerms[G_APP_NAME][$gRouter['act']]['roles'] );
            }

            if ( isset($gParams[0]) && isset( $gAuthPerms[G_APP_NAME][$gRouter['act']][$gParams[0]]['roles'] ) ) //authorize firt param
            {
                $gAuthorize = gAuthorize( $gUser, $gAuthPerms[G_APP_NAME][$gRouter['act']][$gParams[0]]['roles'] );
            }
        }

        if ( !$gAuthorize )
        {
            set_msg('You don\' have permissions to access this page!','','error',10,'bottom','half');
            gRedirect($gAuthLoginUrl);
        }
    }

    if ( is_file( G_APP_PATH."ac/".$gRouter['act'].'.php' ) )
    {
        include G_APP_PATH."ac/".$gRouter['act'].'.php';
    }
    else
    {
        //set_msg('The page doesn\'t exists!','','error',10,'bottom','half');
        //gRedirect('/'.$gRouter['con']);
        gLog('router.log','Action doesn\'t exists: '.G_APP_DIR.'/'.$gRouter['act']);
        die('Action doesn\'t exists: '.G_APP_DIR.'/'.$gRouter['act']);
    }

if ($gAjaxCall)
{
    if ( !isne( $gView ) )
    {
        $gView = $gRouter['act'];
    }

    if ( is_file( G_APP_PATH."av/".$gView.'.php' ) )
    {
        include G_APP_PATH."av/".$gView.'.php';
    }
}
