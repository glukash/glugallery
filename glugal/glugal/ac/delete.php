<?php
//if ( !class_exists( 'GluGallery',false ) )
//{
    require_once('glugal/lib/glu.gallery.php');
//}
//require_once('site/lib/glu.image.php');
//
//$gGalleryResize = new GluGallery($galRoot,$galRootUrl);

if ( !empty( $pdata['delete'] ) )
{
    if ( isne( $pdata['delete']['galleryall'] ) )
    {
        $galName = $pdata['delete']['galleryall'];
        $gGalleryDelete = new GluGallery($galRoot,$galRootUrl);
        $res = $gGalleryDelete->delete_gallery($galName);
        //$res['status']='error';
        //$res['info']='Error';
        echo json_encode($res);
        exit;
    }
    else
    {
        $galName = $pdata['delete']['gallery'];
        $type = $pdata['delete']['type'];
        $file = $pdata['delete']['file'];

        $dstPath = $galRoot.$galName.'/'.$type.'/'.$file; //to delete
        $dstUrl = $galRootUrl.$galName.'/'.$type.'/'.$file; //to return

        //$info = $gGalleryResize->get_image_info($s_src);
        //$s_ratio = $info['width']/$info['height'];
        //$d_ratio = $width/$height;

        if ( is_file( $dstPath ) && file_exists( $dstPath ) )
        {
            if ( !unlink($dstPath) )
            {
                $res['status']='error';
                $res['info']='Error';
                echo json_encode($res);
                exit;
            }
            else
            {
                $res['status']='success';
                $res['url']=$dstUrl;
                echo json_encode($res);
                exit;
            }
        }
        else
        {
            $res['status']='success';
            $res['url']=$dstUrl;
            echo json_encode($res);
            exit;
        }
    }
}

echo json_encode('empty');
exit;

//redirect('/?glugal');
