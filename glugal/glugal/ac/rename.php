<?php

if ( !empty( $pdata['rename'] ) )
{
    $galName = $pdata['rename']['gallery'];
    $cur_filename = $pdata['rename']['cur_filename'];
    $new_filename = $pdata['rename']['new_filename'];

    $galPath = array();
    $galPath['main'] = $galRoot.$galName.'/';
    $galPath['files'] = array();
    $galPath['files']['src'] = $galPath['main'].'src/';
    $galPath['files']['out'] = $galPath['main'].'out/';
    $galPath['files']['min'] = $galPath['main'].'min/';

    $res = array();

    $rename_success=true;
    $new_file_already_exists = false;
    foreach( $galPath['files'] as $key => $filePath )
    {
        if ( $new_file_already_exists || is_file( $filePath.$new_filename ) )
        {
            $new_file_already_exists = true;
        }
    }

    if ( $new_file_already_exists )
    {
        $res['status']='error';
        $res['info']='File with new filename already exists!';
    }
    else
    {
        foreach( $galPath['files'] as $key => $filePath )
        {
            if ( is_file( $filePath.$cur_filename ) )
            {
                if ( rename($filePath.$cur_filename, $filePath.$new_filename) )
                {
                    $res['files'][$key]['status']='success';
                    $res['files'][$key]['filename']=$new_filename;
                }
                else
                {
                    $res['files'][$key]['status']='failure';
                    $res['files'][$key]['filename']=$cur_filename;
                    $rename_success=false;
                }
            }
        }

        //if even one file didn't chage must revert others
        if ( $rename_success == false )
        {
            foreach( $res['files'] as $key => $result )
            {
                if ( ($result['filename'] == $new_filename) && (is_file( $galPath['files'][$key].$result['filename'] ) ) )
                {
                    rename( $galPath['files'][$key].$result['filename'], $galPath['files'][$key].$cur_filename );
                }
            }
            $res['status']='error';
            $res['info']='Filenames change error!';
        }
        else
        {
            $res['status']='success';
            $res['info']='Filenames change success!';
        }
    }
    echo json_encode($res);
    exit;
}
