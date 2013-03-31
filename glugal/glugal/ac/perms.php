<?php

function trim_values(&$value)
{
    $value = trim($value);
}

if ( !gHasRole('admin') )
{
    gRedirect('/index');
}

$gAuthPermsTreeFile = $gRoot.$gAppDir.'/config/perms-tree.auth';

if ( isset( $pdata['jsondata'] ) )
{

    $arrPermsTree=array();
    $arrPermsTree = json_decode($pdata['jsondata'],true);

    array_walk_recursive($arrPermsTree,'trim_values');

    save_json_file( $gAuthPermsTreeFile,$arrPermsTree );

    $arrPermsTree = json_decode($pdata['jsondata'],true);
    $arrPerms = array();
    if ( isset( $arrPermsTree[0] ) )
    {
        $first_key = $arrPermsTree[0]['data'];
        $arrPerms[$first_key] = array();
        if ( isset( $arrPermsTree[0]['children'] ) )
        {
            foreach( $arrPermsTree[0]['children'] as $child1)
            {
                if ( $child1['attr']['rel'] == 'default' )
                {
                    $arrPerms[$first_key]['roles']=$child1['data']!='-'?$child1['data']:'';
                }
                if ( $child1['attr']['rel'] == 'folder' )
                {
                    $second_key = $child1['data'];
                    $arrPerms[$first_key][$second_key]=array();
                }
                if ( isset( $child1['children'] ) )
                {
                    foreach( $child1['children'] as $child2)
                    {
                        if ( $child2['attr']['rel'] == 'default' )
                        {
                            $arrPerms[$first_key][$second_key]['roles']=$child2['data']!='-'?$child2['data']:'';
                        }
                        if ( $child2['attr']['rel'] == 'folder' )
                        {
                            $third_key = $child2['data'];
                            $arrPerms[$first_key][$second_key][$third_key]=array();
                        }
                        if ( isset( $child2['children'] ) )
                        {
                            foreach( $child2['children'] as $child3 )
                            {
                                if ( $child3['attr']['rel'] == 'default' )
                                {
                                    $arrPerms[$first_key][$second_key][$third_key]['roles']=$child3['data']!='-'?$child3['data']:'';
                                }
                                //if ( $child3['attr']['rel'] == 'folder' )  // should never happen
                                //{
                                //    $fourth_key = $child3['data'];
                                //    $arrPerms[$first_key][$second_key][$third_key][$fourth_key]=array();
                                //}
                            }
                        }
                    }
                }
            }
        }
    }

    save_json_file( $gAuthPermsFile,$arrPerms );

    die( json_encode('success') );
}


$qHead['css'][]='glugal/js/jquery.jstree/themes/default/style.css';
$qHead['js'][] ='glugal/js/jquery.jstree/_lib/jquery.hotkeys.js';
$qHead['js'][] ='glugal/js/jquery.jstree/jquery.jstree.js';

$arr=false;
if ( is_file( $gAuthPermsTreeFile ) )
{
    $arr = read_json_file( $gAuthPermsTreeFile );
    $json_tree = json_encode($arr);
}

