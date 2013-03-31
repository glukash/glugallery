<?php

require_once('glugal/lib/glu.gallery.php');

$gGalleryAdmin = new GluGallery($galRoot,$galRootUrl);

//$galName = $gParams[0];

//$gCookie = get_json_cookie('glugal-cookie-'.$galName);

//if ( !isne( $galName ) )
//{
//    die('Gallery not specified!');
//}

if ( !empty( $pdata['glugal'] ) )
{
    //echo '<br /><br /><br /><br /><br /><br /><br /><br /><br />';
    //debug( $pdata['glugal'] );

    $create_new = trim( $pdata['glugal']['create'] );
    $new='';
    if ( $create_new != '' )
    {
        $gGalleryAdmin->create_gallery( $create_new );
        $new = 'New gallery directory '.$create_new.' has been created!';
    }

    foreach ( $pdata['glugal']['galleries'] as $key=>$gal )
    {
        if ( !isset($gal['shw']) )
        {
            $pdata['glugal']['galleries'][$key]['shw']=0;
        }
    }

    $gGalleryAdmin->save_info(false,$pdata['glugal']['galleries']);

    set_msg('Galleries saved!',$new,'success',5,'bottom');
    gRedirect('./galleries');


    //if ( !empty( $pdata['glugal']['items'] ) )
    //{
    //    $gGalleryAdmin->admin_save_items($galName,$pdata['glugal']['items']);
    //}
    //$gGalleryAdmin->admin_save_info($galName,$pdata['glugal']['info']);
    //set_msg('Gallery saved!','','success',5,'bottom');
    //gRedirect('./?glugal/gallery/'.$galName);
}

//$admin_galleries=array();
$admin_galleries = $gGalleryAdmin->get_galleries(true);

//galerie bez uprawnien usuwamy
//foreach ( $admin_galleries as $galKey => $galVal )
//{
//    if ( !gAllowed( '/glugal/gallery/'.$galKey ) )
//    {
//        unset( $admin_galleries[$galKey] );
//    }
//}

$admin_galleries_count = count($admin_galleries);


//debug($admin_galleries);

//if (!isset($admin_gallery['info']['thumb'])) $admin_gallery['info']['thumb']='';
