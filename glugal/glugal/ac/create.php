<?php
require_once('glugal/lib/glu.gallery.php');
require_once('glugal/lib/glu.image.php');

$gGalleryResize = new GluGallery($galRoot,$galRootUrl);

if ( !empty( $pdata['create'] ) )
{
    //$gInfo = $gGalleryResize->read_info( $pdata['create']['gallery'] );

    //$wkey = $type.'w';
    //$hkey = $type.'h';
    $method = $pdata['create']['method'];
    $enlarge =  json_decode($pdata['create']['enlarge'],true); //it comes as string from json so must be decoded
    $type = $pdata['create']['type'];
    $width = $pdata['create']['width'];
    $height = $pdata['create']['height'];

    $srcPath = $galRoot.$pdata['create']['gallery'].'/src/'.$pdata['create']['file'];
    $dstPath = $galRoot.$pdata['create']['gallery'].'/'.$pdata['create']['type'].'/'.$pdata['create']['file'];
    $dstUrl = $galRootUrl.$pdata['create']['gallery'].'/'.$pdata['create']['type'].'/'.$pdata['create']['file']; //to return

    if ( !is_file( $srcPath ) || !file_exists( $srcPath ) )
    {
        //if ( !unlink($dstPath) )
        //{
            $res['status']='error';
            $res['info']='No src file!';
            echo json_encode($res);
            exit;
        //}
    }

    $info = $gGalleryResize->get_image_info($srcPath);
    $s_ratio = $info['width']/$info['height'];
    $d_ratio = $width/$height;

            //$res['status']='error';
            //$res['info']=$s_ratio.' '.$d_ratio;
            //echo json_encode($res);
            //exit;

    if ( is_file( $dstPath ) && file_exists( $dstPath ) )
    {
        //if ( !unlink($dstPath) )
        //{
        //    $res['status']='error';
        //    echo json_encode($res);
        //    exit;
        //}
    }

    $resize_allow = true;
    //source smaller than destiny
    if ( ($info['width']<=$width) && ($info['height']<=$height) )
    {
        if ($method=='normal')
        {
            //$resize_allow = false;
            $resize_allow = $enlarge;
        }
        elseif( ($method=='background') && !$enlarge ) //if !$enlarge recalculate ratio
        {
            if ( $s_ratio > $d_ratio )
            {
                $width = $info['width'];
                $height = round($info['width']*(1/$d_ratio));
            }
            elseif( $s_ratio < $d_ratio )
            {
                $width = round($info['height']*$d_ratio);
                $height = $info['height'];
            }
            else
            {
                $width = $info['width'];
                $height = $info['height'];
            }
        }
        //elseif( $method=='shrink' )
        //{
        //    if ( $s_ratio > $d_ratio )
        //    {
        //        $width = $info['width'];
        //        $height = round($info['width']*(1/$d_ratio));
        //    }
        //    elseif( $s_ratio < $d_ratio )
        //    {
        //        $width = round($info['height']*$d_ratio);
        //        $height = $info['height'];
        //    }
        //    else
        //    {
        //        $width = $info['width'];
        //        $height = $info['height'];
        //    }
        //}
    }

    if ( $resize_allow == true )
    {
        $img = new image($srcPath,false);
        if ( $method=='normal' )
        {
            $img->resizeWithNoBackground($width, $height);
        }
        if ( $method=='background' )
        {
            $img->resizeWithBackground($width, $height);
        }
        if ( $method=='shrink' )
        {
            $img->shrink($width, $height, $enlarge);
        }
        if ( $method=='crop' )
        {
            $img->crop($width, $height);
        }
        if ($img->save($dstPath))
        {
            $dinfo = $gGalleryResize->get_image_info($srcPath);//jak nie ma tej linii to nie pokazuje dobrego rozmiaru za pierwszym razem
            $dinfo = $gGalleryResize->get_image_info($dstPath);
            $res['status']='success';
            $res['info']=$dinfo;
            $res['url'] = $dstUrl;
            echo json_encode($res);
            exit;
        }
        else
        {
            $res['status']='error';
            echo json_encode($res);
            exit;
        }
    }
    else
    {
        if ( copy( $srcPath, $dstPath ) )
        {
            $dinfo = $gGalleryResize->get_image_info($srcPath);
            $dinfo = $gGalleryResize->get_image_info($dstPath);
            $res['status']='success';
            $res['info']=$dinfo;
            $res['url'] = $dstUrl;
            echo json_encode($res);
            exit;
        }
        else
        {
            $res['status']='error';
            echo json_encode($res);
            exit;
        }
    }

}

echo json_encode('empty');
exit;
