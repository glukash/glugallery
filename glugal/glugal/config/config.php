<?php

//$galRoot = $gRoot.'files/gallery/';
//$galRootUrl = $gRootUrl.'files/gallery/';

$galRoot = $_SERVER['DOCUMENT_ROOT'].'/files/gallery/';
$galRootUrl =  'http://'.$_SERVER['HTTP_HOST'].'/files/gallery/';

$gAuth = true;
$gAuthSecurity='X122GfyoP';
$gAuthUsersFile = $gRoot.'/glugal/config/users.auth';
$gAuthPermsFile = $gRoot.'/glugal/config/perms.auth';
$gAuthLoginUrl = '/index';
//$gAuthRoles = 'admin manager';
//$gAuthPerms = array(
//    'glugal'=>array(
//        'roles'=>'admin manager dupa',
//        'index'=>array(
//            'roles'=>''
//        ),
//        'user'=>array(
//            'roles'=>''
//        )
//    )
//);
//save_json_file( $gAuthPermsFile,$gAuthPerms );
//$gAuth = array(
//    'glugal'=>array(
//        'roles'=>'admin manager',
//        'index'=>array(
//            'roles'=>''
//        ),
//        'user'=>array(
//            'roles'=>''
//        )
//    )
//);

//$gAuth = array(
//    'glugal'=>array(
//        'roles'=>'',
//        'index'=>array(
//            'roles'=>''
//        ),
//        'admin_galleries_browse'=>array(
//            'roles'=>'admin manager'
//        ),
//        'admin_gallery_browse'=>array(
//            'roles'=>'admin',
//            'main'=>array(
//                'roles'=>'admin manager'
//            )
//        )
//    )
//);

