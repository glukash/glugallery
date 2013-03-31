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
    //elseif ( isne( $_SERVER['QUERY_STRING'] ) )
    //{
    //    $gQuery = $_SERVER['QUERY_STRING'];
    //}
    else
    {
        $gQuery = '';
    }
}
else
{
    //$gQuery = $_SERVER['QUERY_STRING'];
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
    //if ( is_file( $gRouter['dir']."/config/config.php" ) )
    if ( is_file( GAPPPATH."config/config.php" ) )
    {
        //include $gRouter['dir']."/config/config.php";
        include GAPPPATH."config/config.php";
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
            if ( isset( $gAuthPerms[GAPP]['roles'] ) ) //authorize controller
            {
                $gAuthorize = gAuthorize( $gUser, $gAuthPerms[GAPP]['roles'] );
            }

            if ( isset( $gAuthPerms[GAPP][$gRouter['act']]['roles'] ) ) //authorize action
            {
                $gAuthorize = gAuthorize( $gUser, $gAuthPerms[GAPP][$gRouter['act']]['roles'] );
            }

            if ( isset($gParams[0]) && isset( $gAuthPerms[GAPP][$gRouter['act']][$gParams[0]]['roles'] ) ) //authorize firt param
            {
                $gAuthorize = gAuthorize( $gUser, $gAuthPerms[GAPP][$gRouter['act']][$gParams[0]]['roles'] );
            }
        }

        if ( !$gAuthorize )
        {
            set_msg('You don\' have permissions to access this page!','','error',10,'bottom','half');
            gRedirect($gAuthLoginUrl);
        }
    }

    //if ( is_file( $gRouter['dir']."/ac/".$gRouter['act'].'.php' ) )
    if ( is_file( GAPPPATH."ac/".$gRouter['act'].'.php' ) )
    {
        //include $gRouter['dir']."/ac/".$gRouter['act'].'.php';
        include GAPPPATH."ac/".$gRouter['act'].'.php';
    }
    else
    {
        gLog('router.log','Action doesn\'t exists: '.GAPP.'/'.$gRouter['act']);
        //set_msg('The page doesn\'t exists!','','error',10,'bottom','half');
        //gRedirect('/'.$gRouter['con']);
        die('Action doesn\'t exists: '.GAPP.'/'.$gRouter['act']);
    }

if ($gAjaxCall)
{
    if ( !isne( $gView ) )
    {
        $gView = $gRouter['act'];
    }

    //if ( is_file( $gRouter['dir']."/av/".$gView.'.php' ) )
    if ( is_file( GAPPPATH."av/".$gView.'.php' ) )
    {
        //include $gRouter['dir']."/av/".$gView.'.php';
        include GAPPPATH."av/".$gView.'.php';
    }
}
