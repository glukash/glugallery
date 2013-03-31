<?php

require_once('glugal/lib/glu.gallery.php');

$gGalleryAdmin = new GluGallery($galRoot,$galRootUrl);

if ( !isset( $gParams[0] ) )
{
    set_msg('Gallery name error!','','success',5,'bottom');
    gRedirect('/galleries');
}

$galName = $gParams[0];

$gCookie = get_json_cookie('glugal-cookie-'.$galName);

if ( !isne( $galName ) )
{
    set_msg('No gallery directory!','','error',5,'bottom');
    gRedirect('/galleries');
}

if ( !empty( $pdata['glugal'] ) )
{
    if ( !isset( $pdata['glugal']['items'] ) )
    {
        $pdata['glugal']['items']=array();
    }
        //debug($pdata['glugal']['items']);
        $gGalleryAdmin->save_items($galName,$pdata['glugal']['items']);

    $gGalleryAdmin->save_info($galName,$pdata['glugal']['info']);
    set_msg('Gallery saved!','','success',5,'bottom');
    gRedirect('/gallery/'.$galName);
}

$admin_gallery=array();
//$admin_gallery['items'] = $gGalleryAdmin->get_gallery($galName);
//$admin_gallery['info'] = $gGalleryAdmin->read_info($galName);

$admin_gallery = $gGalleryAdmin->get_gallery($galName, true, true, true);

$qHead['js'][] ='glugal/js/jquery.mousewheel.min.js';
