<?php

if ( !gHasRole('admin') )
{
    gRedirect('/');
}

$arrUsers = read_json_file( $gAuthUsersFile );   //read users

ksort($arrUsers);   //sort users - sort array's keys contain usernames

//$userRoles = explode(' ',trim($gAuthRoles));    //explode user Roles from config file

$arrValidate=array();   //init validate array

if ( isset($pdata) )
{
    if ( !isset( $pdata['user']['newuser']['create'] ) ) //if new user checkbox checked
    {
        unset( $pdata['user']['newuser'] );
    }

    foreach( $pdata['user'] as $uk=>$arrUser )  //validate each users
    {
        $arrValidate[$uk] = gValidateUser( $arrUser, $arrUser['password'] || (isset($arrUser['create'])?$arrUser['create']:false) );

        //if was no errors unset current user from validate array
        if ( empty( $arrValidate[$uk] ) ) unset( $arrValidate[$uk] );
    }

    if ( !empty( $arrValidate ) )   //invalid data occurs
    {
        //rewrite $arrUsers to show in form
        $arrUsers = $pdata['user'];
    }
    else    //no invalid data - proceed saving
    {
        $arrUsersEdit = $pdata['user']; $skip=array();
        foreach( $arrUsersEdit as $uk=>&$arrUser )
        {
            if ( in_array( $uk,$skip ) )    //if a key is created in loop it must be skipped avoiding double hashing
            {
                continue;
            }

            if ( isset( $arrUser['delete'] ) )  //delete existing user if delete checked
            {
                unset( $arrUsersEdit[$uk] );
                continue;
            }

            if ( isset( $arrUser['create'] ) ) unset( $arrUser['create'] ); //if create checked - unset it's needless to save

            //if password was filled hash otherwise rewrite current password
            if ( !empty( $arrUser['password'] ) )
            {
                $arrUser['password'] = gHash( trim( $arrUser['password'] ),$gAuthSecurity );
            }
            else
            {
                $arrUser['password'] = $arrUsers[$uk]['password'];
            }
            unset( $arrUsersEdit[$uk]['passwordconfirmation'] );

            //if username changed create another key named after username
            if ( $uk != $arrUser['username'] )
            {
                $arrUsersEdit[$arrUser['username']]= $arrUser;
                $skip[] = $arrUser['username'];                     //key to skip
                unset( $arrUsersEdit[$uk] );                        //unset old username key
            }
        }

        //save users
        if ( save_json_file( $gAuthUsersFile, $arrUsersEdit ) )
        {
            set_msg('Users saved!','','success',10,'bottom');
            gRedirect('/users');
        }
        else
        {
            set_msg('Error saving users!','','error',10,'bottom');
            gRedirect('/users');
        }

    }

    //debug( $arrUsersEdit );
    //debug( $arrValidate );
    //debug($arrUsers);
}

