<?php

class GluGallery
{
    public $galRoot;
    public $galRootUrl;

    /**
     * Summary
     * @param	Object	$galRoot	Description
     * @param	Object	$galRootUrl	Description
     * @return	object				Description
     */
    public function __construct($galRoot=null,$galRootUrl=null)
    {
        $this->galRoot = $galRoot;
        $this->galRootUrl = $galRootUrl;
    }

    /**
    * @param undefined $path
    * @param undefined $url_path
    * @param undefined $sort
    * @param undefined $sort_type
    *
    */
    function ls_dir($path,$url_path=false,$sort=false,$sort_type='ASC')
    {

        $tab_pliki = array();
        $tab_pliki['f']=array();
        $tab_pliki['ff']=array();
        $tab_pliki['d']=array();
        $tab_pliki['df']=array();

        if (substr($path,-1)!=='/') $path.='/';

        if (!is_dir($path)) {echo 'NO DIRECTORY: '.$path.'<br />'; return false; }

        if ($url_path===false) $url_path=$path;
        if (substr($url_path,-1)!=='/') $url_path.='/';

        $handle = opendir($path);
        while ( false !== ($file = readdir($handle)) )
        {
            if (is_file($path.$file))
            {

                $tab_pliki['ff'][$file]['path'] = $path.$file;
                $tab_pliki['ff'][$file]['url'] =  $url_path.rawurlencode($file);
                $tab_pliki['ff'][$file]['realpath'] =  realpath($path.rawurlencode($file));
                $tab_pliki['ff'][$file]['realdir'] =  dirname(realpath($path.rawurlencode($file)));
                $tab_pliki['ff'][$file]['name'] = $file;
                $tab_pliki['ff'][$file]['size'] = filesize($path.$file);

                $tab_pliki['ff'][$file]['sizeKB'] = number_format($tab_pliki['ff'][$file]['size']/1024,2,'.','');
                $tab_pliki['ff'][$file]['sizeMB'] = number_format($tab_pliki['ff'][$file]['sizeKB']/1024,2,'.','');
                $tab_pliki['ff'][$file]['sizeGB'] = number_format($tab_pliki['ff'][$file]['sizeMB']/1024,2,'.','');

                $dotPos=strripos($file,'.');
                if ($dotPos!==false)
                {
                    $tab_pliki['ff'][$file]['ename']=substr($file,0,$dotPos);
                    $tab_pliki['ff'][$file]['ext']=substr($file,$dotPos+1);
                }

            }
            else if (is_dir($path.$file))
            {
                if ( ($file!='.') && ($file!='..')  )
                $tab_pliki['df'][$file]=$file;
            }
        }
        closedir($handle);

        if($sort==true)
        {
            if ($sort_type=='ASC')
            {
                ksort($tab_pliki['ff'],SORT_STRING);
                ksort($tab_pliki['df'],SORT_STRING);
            }
            elseif ($sort_type=='DESC')
            {
                krsort($tab_pliki['ff'],SORT_STRING);
                krsort($tab_pliki['df'],SORT_STRING);
            }
        }

        $cntr=0;
        foreach ($tab_pliki['ff'] as $kFF=>$vFF)
        {

            $tab_pliki['f'][$cntr]['path'] = 		$vFF['path'];
            $tab_pliki['f'][$cntr]['url'] = 		$vFF['url'];
            $tab_pliki['f'][$cntr]['realpath'] =	$vFF['realpath'];
            $tab_pliki['f'][$cntr]['realdir'] =		$vFF['realdir'];
            $tab_pliki['f'][$cntr]['name'] =		$vFF['name'];
            $tab_pliki['f'][$cntr]['size'] =		$vFF['size'];

            $tab_pliki['f'][$cntr]['sizeKB'] =		$vFF['sizeKB'];
            $tab_pliki['f'][$cntr]['sizeMB'] =		$vFF['sizeMB'];
            $tab_pliki['f'][$cntr]['sizeGB'] =		$vFF['sizeGB'];

            $tab_pliki['f'][$cntr]['ename']=		$vFF['ename'];
            $tab_pliki['f'][$cntr]['ext'] =			$vFF['ext'];
            ++$cntr;
        }

        $cntr=0;
        foreach($tab_pliki['df'] as $kFF=>$vFF)
        {
            $tab_pliki['d'][$file]=$vFF;
            ++$cntr;
        }

        $tab_pliki['cf'] = count($tab_pliki['f']);
        $tab_pliki['cd'] = count($tab_pliki['d']);
        return $tab_pliki;
    }

    /**
     * Summary
     * @param	object	$file		Description
     * @param	object	$arrData	Description
     * @return	object				Description
     */
    public function save_json_file( $file, $arrData )
    {
        //if ( empty( $arrData ) ) return false;
        if ( !isset( $arrData ) ) $arrData=array();

        $jsonData = json_encode( $arrData );

        if ( false !== file_put_contents( $file, $jsonData, LOCK_EX ) )
        {
            return true;
        }

        return false;
    }

    /**
     * Summary
     * @param	object	$file	Description
     * @return	object			Description
     */
    public function read_json_file( $file )
    {
        if ( !is_file( $file ) || !file_exists( $file ) )
        {
            return false;
        }

        $jsonData = file_get_contents( $file );
        $arrData = json_decode( $jsonData, true );
        return $arrData;
    }

    /**
     * Get gallery path
     * @param	object	$galName	Description
     * @return	object			Description
     */
    private function get_gallery_path( $galName )
    {
        /*$galPath =*/ return $this->galRoot.$galName.'/';
        //if ( is_dir( $galPath ) )
        //{
        //    return $galPath;
        //}
        //else
        //{
        //    echo '<div class="glugal-info error">GluGallery Error: No <b>'.$galName.'</b> Gallery Directory: '.$galPath.'</div>';
        //    return  false;
        //}
    }

    /**
     * Read gallery info file if $galName != false, read main galleries info file if $galName == false
     * @param	object	$galName	Description
     * @return	object			Description
     */
    public function read_info( $galName=false )
    {
        if ( $galName == false )
        {
            $galInfoPath = $this->galRoot;
        }
        else
        {
            $galInfoPath = $this->get_gallery_path( $galName );
        }

        $galInfoFile = $galInfoPath.'.info';

        if ( is_file( $galInfoFile ) )
        {
            return $this->read_json_file( $galInfoFile );
        }
        elseif ( $galName != false )
        {
            $this->create_gallery( $galName );
        }

        return array();
    }

    /**
     * Save galery info file if $galName != false, save main galleries info file if $galName == false
     * @param	object	$galName	Description
     * @param	object	$arrData	Description
     * @return	object				Description
     */
    public function save_info( $galName=false, $arrData )
    {
        if ( $galName == false )
        {
            $galInfoPath = $this->galRoot;
        }
        else
        {
            $galInfoPath = $this->get_gallery_path( $galName );
        }

        $galInfoFile = $galInfoPath.'.info';

        return $this->save_json_file( $galInfoFile, $arrData );
    }

    /**
     * Read gallery items file
     * @param	object	$galName	Description
     * @return	object			Description
     */
    public function read_items( $galName, $hidden=false, $info=false )
    {
        $gItemsPath = $this->get_gallery_path( $galName );
        $gItemsFile = $gItemsPath.'.items';

        if (is_file( $gItemsFile ))
        {
            $galItemsArray = $this->read_json_file( $gItemsFile );
        }
        else
        {
            $this->create_gallery( $galName );
            //echo '<div class="glugal-info error">GluGallery Error: No .items file: '.$galItems_file.'</div>';
            return  array();
        }


        if ( empty( $galItemsArray ) ) return array();

        foreach( $galItemsArray as $key => &$item )
        {
            //check if item is active
            if ( isset( $item['active'] ) )
            {
                $item['active']=1;
            }
            else
            {
                $item['active']=0;
            }

            //if item has file key
            if ( array_key_exists( 'file',$item ) )
            {
                $exists_anywhere=0;

                $item['min']['path']= $this->galRoot.$galName.'/min/'.$item['file'];
                $item['min']['url']= $this->galRootUrl.$galName.'/min/'.$item['file'];
                $item['min']['exists']=0;
                if (is_file( $this->galRoot.$galName.'/min/'.$item['file'] ))
                {
                    $item['min']['exists']=1;
                    $exists_anywhere=1;
                    if ($info) $item['min']['info']=$this->get_image_info( $item['min']['path'] );
                }

                $item['out']['path']= $this->galRoot.$galName.'/out/'.$item['file'];
                $item['out']['url']= $this->galRootUrl.$galName.'/out/'.$item['file'];
                $item['out']['exists']=0;
                if (is_file( $this->galRoot.$galName.'/out/'.$item['file'] ))
                {
                    $item['out']['exists']=1;
                    $exists_anywhere=1;
                    if ($info) $item['out']['info']=$this->get_image_info( $item['out']['path'] );
                }

                $item['src']['path']= $this->galRoot.$galName.'/src/'.$item['file'];
                $item['src']['url']= $this->galRootUrl.$galName.'/src/'.$item['file'];
                $item['src']['exists']=0;
                if (is_file( $this->galRoot.$galName.'/src/'.$item['file'] ))
                {
                    $item['src']['exists']=1;
                    $exists_anywhere=1;
                    if ($info) $item['src']['info']=$this->get_image_info( $item['src']['path'] );
                }

                $item['exists_anywhere']=$exists_anywhere;
                $item['indexed']=1;
            }

        }

        if ( !$hidden )
        {
            foreach( $galItemsArray as $key => &$item )
            {
                if ( !isset($item['active']) || $item['active']==0 )
                {
                    unset( $galItemsArray[$key] );
                }
            }
        }

        return array_values($galItemsArray);
    }

    /**
     * Summary
     * @param	object	$galName	Description
     * @param	object	$arrData	Description
     * @return	object				Description
     */
    public function save_items( $galName, $arrData )
    {
        $galItemsPath = $this->get_gallery_path( $galName );
        $galItemsFile = $galItemsPath.'.items';

        return $this->save_json_file( $galItemsFile, $arrData );
    }

    /**
     * Summary
     * @return	object		Description
     */
    public function get_galleries( $admin=false )
    {
        $galGalleriesList = array();
        $galGalleriesList['info'] = $this->read_info();
        $galGalleriesList['dirs'] = $this->ls_dir($this->galRoot,false,true,'DESC');
        $galGalleriesList['dirs'] = $galGalleriesList['dirs']['df'];

        //processing info key
        if ( !empty( $galGalleriesList['info'] ) )
        foreach ( $galGalleriesList['info'] as $key=>$gal )
        {
            if ( !is_dir( $this->galRoot.$gal['dir'] ) )
            {
                unset( $galGalleriesList['info'][$key] ); //check if there are real directiories according to info array
            }
            else
            {
                $this->create_gallery( $gal['dir'] ); //wont create if exists
            }
        }

        if ( $admin ) //if admin search for new galleries dirs
        {
            //processing dirs key
            if ( !empty( $galGalleriesList['dirs'] ) )
            foreach ( $galGalleriesList['dirs'] as $key=>$gal )
            {
                if ( isset( $galGalleriesList['info'][$key] ) )
                {
                    unset( $galGalleriesList['dirs'][$key] ); //check if dir is already in info key and unset if it is
                }
                else
                {
                    $this->create_gallery( $gal ); //wont create if exists
                    $galGalleriesList['dirs'][$key]=array();
                    $galGalleriesList['dirs'][$key]['dir']=$gal;
                    $galGalleriesList['dirs'][$key]['shw']=true;
                }
            }

            //merging galleries from dirs and ifno into one
            $galGalleriesList = $galGalleriesList['dirs']+$galGalleriesList['info'];

            //save new info file
            $this->save_info( false, $galGalleriesList );
        }
        else //unsetting hidden galleries
        {
            $galGalleriesList = $galGalleriesList['info'];

            foreach ( $galGalleriesList as $key => $gal )
            {
                if ( $gal['shw']==0 )
                {
                    unset( $galGalleriesList[$key] );
                }
            }
        }

        //reading info files from all galleries
        foreach ( $galGalleriesList as $key=>$gal )
        {
            $galGalleriesList[$key]['info']=array();
            $galGalleriesList[$key]['info'] = $this->read_info( $gal['dir'] );

            if ( isset( $galGalleriesList[$key]['info']['thumb'] ) )
            {
                if ( is_file( $this->galRoot.$gal['dir'].'/min/'.$galGalleriesList[$key]['info']['thumb'] ) )
                {
                    $galGalleriesList[$key]['info']['thumburl'] = $this->galRootUrl.$gal['dir'].'/min/'.$galGalleriesList[$key]['info']['thumb'];
                }
            }

            ////read all gallery
            //$galGalleriesList[$key]['info']['count']=0;
            //$galGalleriesList[$key]['info']['counti']=0;
            //$galGalleriesList[$key]['info']['counta']=0;
            $galGalleriesList[$key]['gallery'] = $this->get_gallery( $gal['dir'], $admin, true, $admin );
            //foreach( $galGalleriesList[$key]['gallery']['items'] as $gk=>$gv)
            //{
            //    if ( $gv['active']==1 )
            //    {
            //        $galGalleriesList[$key]['info']['count']++;
            //    }
            //    else
            //    {
            //        $galGalleriesList[$key]['info']['counti']++;
            //    }
            //    $galGalleriesList[$key]['info']['counta']++;
            //}

        }

        if ( !$admin ) //if !admin unset galleries with empty info file or no title
        {
            foreach ( $galGalleriesList as $key=>$gal )
            {
                if ( ( !isset($gal['info']) || empty($gal['info']) ) || ( !isset($gal['info']['title']) || empty($gal['info']['title']) ) )
                {
                    unset( $galGalleriesList[$key] );
                }
            }
        }
        //debug($galGalleriesList);
        return $galGalleriesList;
    }

    /**
     * Get gallery
     * @param	string	$galName	Gallery name
     * @param	Boolean	$hidden		Description
     * @param	Boolean	$info		Description
     * @param	Boolean	$new		Description
     * @return	Array				Description
     */
    public function get_gallery( $galName, $hidden=false, $info=false, $new=false )
    {
        $galGallery = array();

        //read indexed files
        $galItems=$this->read_items( $galName, $hidden, $info ); //debug($galItems);

        //count items and sizes
        $galCount = array('active'=>0,'inactive'=>0,'all'=>0,'indexed'=>0,'unindexed'=>0,'missrc'=>0,'mismin'=>0,'misout'=>0);
        //$galSizes = array('active'=>0,'inactive'=>0,'all'=>0,'indexed'=>0,'unindexed'=>0);

        foreach( $galItems as $ik=>$iv )
        {
            if ( $iv['active']==1 )
            {
                $galCount['active']++;
            }
            else
            {
                $galCount['inactive']++;
            }
            $galCount['all']++;
            $galCount['indexed']++;

            if ( $iv['src']['exists'] == 0 )
            {
                $galCount['missrc']++;
            }
            if ( $iv['out']['exists'] == 0 )
            {
                $galCount['misout']++;
            }
            if ( $iv['min']['exists'] == 0 )
            {
                $galCount['mismin']++;
            }

            //if ( $info )
            //{
            //    if ( isset( $iv['min']['info']['size']['B'] ) )
            //    {
            //
            //    }
            //}
        }


        if ( $new )
        {
            //looking for not indexed files in DESC order, they will ASC at array_unshift
            $src_dir = $this->ls_dir($this->galRoot.$galName.'/src/',false,true,'DESC');
            $src_dir = $src_dir['ff'];

            //unseting files already indexed
            if (!empty($galItems))
            foreach ( $galItems as $k => $img )
            {
                $name_to_check = $img['file'];
                if ( isset( $src_dir[$name_to_check] ) )
                {
                    unset( $src_dir[$name_to_check] );
                }
            }

            foreach ( $src_dir as $k => $new)
            {
                //create new element
                $galNewItem = array();

                $galNewItem['file']=$new['name'];
                $galNewItem['title']='';
                $galNewItem['description']='';
                $galNewItem['active']=1; $galCount['active']++; $galCount['all']++; $galCount['unindexed']++;
                $galNewItem['indexed']=0;

                $galNewItem['min']['path']= $this->galRoot.$galName.'/min/'.$galNewItem['file'];
                $galNewItem['min']['url']= $this->galRootUrl.$galName.'/min/'.$galNewItem['file'];
                $galNewItem['min']['exists']=0;
                if (is_file( $this->galRoot.$galName.'/min/'.$galNewItem['file'] ))
                {
                    $galNewItem['min']['exists']=1;
                    if ($info) $galNewItem['min']['info']=$this->get_image_info( $galNewItem['min']['path'] );
                }

                $galNewItem['out']['path']= $this->galRoot.$galName.'/out/'.$galNewItem['file'];
                $galNewItem['out']['url']= $this->galRootUrl.$galName.'/out/'.$galNewItem['file'];
                $galNewItem['out']['exists']=0;
                if (is_file( $this->galRoot.$galName.'/out/'.$galNewItem['file'] ))
                {
                    $galNewItem['out']['exists']=1;
                    if ($info) $galNewItem['out']['info']=$this->get_image_info( $galNewItem['out']['path'] );
                }

                $galNewItem['src']['path']= $this->galRoot.$galName.'/src/'.$galNewItem['file'];
                $galNewItem['src']['url']= $this->galRootUrl.$galName.'/src/'.$galNewItem['file'];
                $galNewItem['src']['exists']=0;
                if (is_file( $this->galRoot.$galName.'/src/'.$galNewItem['file'] ))
                {
                    $galNewItem['src']['exists']=1;
                    if ($info) $galNewItem['src']['info']=$this->get_image_info( $galNewItem['src']['path'] );
                }

                //put new element in front
                array_unshift($galItems,$galNewItem);
            }
        }

        $galGallery['count'] = $galCount;
        $galGallery['items'] = $galItems;
        $galGallery['info'] = $this->read_info( $galName );
        if (!isset($galGallery['info']['thumb'])) $galGallery['info']['thumb']='';

        return $galGallery;
    }

    /**
     * Summary
     * @param	object	$galName	Description
     * @param	Object	$truncate	Description
     * @return	object				Description
     */
    public function create_gallery( $galName, $truncate=false )
    {
        if( preg_match("/^[0-9a-zA-Z]+$/", $galName) == false ) return false;

        $galPath = $this->get_gallery_path( $galName );
        $galInfoFile = $galPath.'.info';
        $galItems_file = $galPath.'.items';
        $galSrcFile = $galPath.'src';
        $galOutDir = $galPath.'out';
        $galMinDir = $galPath.'min';

        if ( !is_dir( $galPath ) )
        {
            mkdir( $galPath );
        }

        if ( !is_writable( $galPath ) )
        {
            die('GALLERY ERROR: Directory is not writable: '.$galPath);
            return false;
        }

        if ( (!is_file( $galInfoFile ) && !file_exists( $galInfoFile ) ) || $truncate )
        {
            $fp = fopen( $galInfoFile, 'w' );
            fclose($fp);
        }

        if ( (!is_file( $galItems_file ) && !file_exists( $galItems_file ) ) || $truncate )
        {
            $fp = fopen( $galItems_file, 'w' );
            fclose($fp);
        }

        if ( !is_dir( $galSrcFile ) )
        {
            mkdir( $galSrcFile );
        }

        if ( !is_dir( $galOutDir ) )
        {
            mkdir( $galOutDir );
        }
        elseif ( $truncate )
        {
            rmdir( $galOutDir );
            mkdir( $galOutDir );
        }

        if ( !is_dir( $galMinDir ) )
        {
            mkdir( $galMinDir );
        }
        elseif ( $truncate )
        {
            rmdir( $galMinDir );
            mkdir( $galMinDir );
        }

        return true;
    }

    public function delete_gallery( $galName )
    {
        $res = array();

        if( preg_match("/^[0-9a-zA-Z]+$/", $galName) == false )
        {
            $res['status']='error';
            $res['info']='Gallery name contains wrong characters!';
            return $res;
        }

        $galPath = $this->get_gallery_path( $galName );

        require_once( GAPPPATH.'lib/lixlpixel.recursive.php' );

        $resDel = recursive_remove_directory( $galPath );

        if ( $resDel )
        {
            $res['status']='success';
            $res['info']='Gallery '.$galName.' successfuly removed!';
        }
        else
        {
            $res['status']='error';
            $res['info']='Error removing gallery '.$galName.' !';
        }
        return $res;
    }

    /**
     * Summary
     * @param	object	$path	Description
     * @return	object			Description
     */
    public function get_image_info( $path )
    {
        //$info_array=array();
        $info = getimagesize( $path );

        $info['width'] = $info[0]; unset( $info[0] );
        $info['height'] = $info[1]; unset( $info[1] );
        $info['type'] = $info[2]; unset( $info[2] );
        $info['html'] = $info[3]; unset( $info[3] );
        $info['wxh'] = $info['width'].'x'.$info['height'];

	    $info['size']['B'] = filesize($path);
		$info['size']['KB'] = number_format($info['size']['B']/1024,2,'.','');
		$info['size']['MB'] = number_format($info['size']['KB']/1024,2,'.','');
		$info['size']['GB'] = number_format($info['size']['MB']/1024,2,'.','');
        $info['size']['human'] = $this->humanize_filesize( $info['size']['B'] );

        return $info;
    }

    public function humanize_filesize( $size_in_bytes )
    {
        if ( $size_in_bytes > 1000000000 )
        {
            $size_human = ((($size_in_bytes / 1024) / 1024) / 1024);
            $size_human = number_format($size_human,2,'.','');
            $size_human .='GB';
        }
        elseif ( $size_in_bytes > 1000000 )
        {
            $size_human = (($size_in_bytes / 1024) / 1024);
            $size_human = number_format($size_human,2,'.','');
            $size_human .='MB';
        }
        elseif ( $size_in_bytes > 1000 )
        {
            $size_human = $size_in_bytes / 1024;
            $size_human = number_format($size_human,2,'.','');
            $size_human .='KB';
        }
        else
        {
            $size_human = $size_in_bytes;
            $size_human = number_format($size_human,2,'.','');
            $size_human .='B';
        }
        return $size_human;
    }
}
