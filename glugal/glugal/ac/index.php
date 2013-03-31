<?php

if ( isset( $gParams[0] ) )
{
    if ( $gParams[0]=='logout' )
    {
        session_destroy();
        set_msg('Logout successful!','','success',10,'bottom');
        gRedirect('/index');
    }
}

if ( !empty( $pdata ) )
{
    $_SESSION['gUser'] = gLogin( $pdata['login']['username'], $pdata['login']['password'], $gAuthUsersFile, $gAuthSecurity );

    if ( $_SESSION['gUser'] == false )
    {
        set_msg('Wrong username or password!','','error',10,'bottom');
        gRedirect('/index');
    }
    else
    {
        set_msg('Login successful!','','success',10,'bottom');
        gRedirect('/index');
    }

}
