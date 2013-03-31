<?php

if ( !isset( $_SESSION['gUser'] ) )
{
    gRedirect('/');
}

$userArray = read_json_file( $gAuthUsersFile );

$currentUser = $userArray[ $_SESSION['gUser']['username'] ];

if ( isset($pdata) )
{
    //debug($pdata['user']);

    if ( trim( $pdata['user']['newpassword'] ) == ''  )
    {
        set_msg('New password must not be empty!','','error',10,'bottom');
        gRedirect('/user');
    }

    $cp = gHash( trim($pdata['user']['currentpassword']),$gAuthSecurity );
    $np = gHash( trim($pdata['user']['newpassword']),$gAuthSecurity );
    $cfp = gHash( trim($pdata['user']['confirmpassword']),$gAuthSecurity );

    if ( $cp != $currentUser['password'] )
    {
        set_msg('Wrong current password!','','error',10,'bottom');
        gRedirect('/user');
    }

    if ( $np != $cfp )
    {
        set_msg('New password and confirmation password doesn\'t match!','','error',10,'bottom');
        gRedirect('/user');
    }

    $userArray[ $_SESSION['gUser']['username'] ]['password']=$np;
    if ( save_json_file( $gAuthUsersFile, $userArray ) )
    {
        set_msg('Your password has been changed!','','success',10,'bottom');
    }
    else
    {
        set_msg('Error changing password!','','error',10,'bottom');
    }
    gRedirect('/user');
}

//debug($gAuthSecurity);
//debug($cp);
//debug( $userArray );
//debug($currentUser);
