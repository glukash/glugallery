<?php
//$root=realpath( dirname('../index.php'));
//$root=$root.'/public_html/';

//if ( isne($_POST['data']) )
//{
//    $pdata = $_POST['data'];
//}



//$gDirName = 'gluf';

//$gPath = $gRoot.GDIR.'/';

$gTmpPath = GAPPPATH.'tmp/';

if ( !is_dir( $gTmpPath ) )
{
    mkdir( $gTmpPath );
}

$qHead=array();
