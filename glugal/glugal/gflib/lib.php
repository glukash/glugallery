<?php
/**
 * debug
 * @param	object	$content	Description
 * @param	Boolean	$exit		Description
 * @return	object				Description
 */
function debug($content,$exit=false)
{
    //echo '<div style="background-color: #FFF6C1; color: #000000;z-index:9999;position:absolute;width: 100%;padding: 10px;">';
    echo '<div style="background-color: #FFF6C1; color: #000000;padding: 10px;">';

    if ( is_array($content) )
    {
        echo '<pre>';
        print_r($content);
        echo '</pre>';
    }
    else
    {
        echo($content);
    }
    echo '</div>';

    if ( $exit == true )
    {
        exit;
        return true;
    }
}

function he( $string, $encoding = 'UTF-8' )
{
	return htmlentities ( $string , ENT_QUOTES, $encoding, false );
}

function hs( $string, $encoding = 'UTF-8' )
{
	return htmlspecialchars ( $string ,ENT_QUOTES, $encoding, false );
}

/**
 * isne
 * @param	object	$variable	Description
 * @return	object				Description
 */
function isne(&$variable)
{
    if ( isset($variable) )
    {
        if ( !empty( $variable ) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

/**
 * isae
 * @param	object	$variable	Description
 * @param	object	$value		Description
 * @return	object				Description
 */
function isae(&$variable,$value)
{
    if ( isset($variable) )
    {
        if ( $variable == $value )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}


/**
* @param undefined $s1
* @param undefined $s2
* Needed for selfURL()
*/
function strleft($s1, $s2)
{
	return substr($s1, 0, strpos($s1, $s2));
}

/**
* Function that works with Apache + IIS,
*/
function selfURL($server_only=false)
{
	if(!isset($_SERVER['REQUEST_URI']))
	{
		$serverrequri = $_SERVER['PHP_SELF'];
	}
	else
	{
		$serverrequri = $_SERVER['REQUEST_URI'];
	}
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
	$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
	$return = $protocol."://".$_SERVER['SERVER_NAME'].$port;
    if ($server_only == false)
    {
        $return.= $serverrequri;
    }
    return $return;
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

function gLog($logFile,$logMsg)
{
	global $gTmpPath;

	$logFile = $gTmpPath.$logFile;

	$bufor = file_get_contents($logFile);

	$fp = fopen( $logFile,'w' );
	flock($fp,LOCK_EX);
	$line='';
	$line.= "\n";
	$line.= 'DATE: '.date("Y-m-d H:i:s")."\n";
	$line.= 'IP  : '.$_SERVER['REMOTE_ADDR']."\n";
	$line.= 'URI : '.$_SERVER['REQUEST_URI']."\n";
	$line.= $logMsg."\n";
	$line.= "\n";
	$line.= "=======================================================================\n";
	$line.= $bufor;
	fwrite($fp, $line );
	flock($fp,LOCK_UN);
	fclose($fp);
}

function gValidateUser( $arrUser, $checkPassword='' )
{
    $validate=array();
    if ( trim($arrUser['username']) == '' )
    {
        $validate['username']='Username must not be empty!';
    }

    $checkPassword = trim($checkPassword);

    if ( $checkPassword != '' )
    {
        if ( trim($arrUser['password']) == '' )
        {
            $validate['password']='Password must not be empty!';
        }
        elseif ( $arrUser['password'] != $arrUser['passwordconfirmation'] )
        {
            $validate['password']='Password and password confirmation don\'t match!';
            $validate['passwordconfirmation']='Password and password confirmation don\'t match!';
        }
    }

	//if ( empty( $validate ) ) $validate = false;

    return $validate;
}

function gHash($password,$security)
{
	return md5($security.$password.$security);
}

function gLogin($username,$password, $authfile, $security)
{
	$logged=false;
	$userArray = read_json_file( $authfile );
	foreach( $userArray as $uk=>$user )
	{
		if ( $user['username'] == $username )
		{
			if ( $user['password'] == gHash($password,$security) )
			{
				$logged['username']=$user['username'];
				$logged['roles']=$user['roles'];
			}
		}
	}
	return $logged;
}

function gAllowed( $url )
{
	global $gAuthPerms;
	$arrUri = explode('/',$url);
	$arrUrl = array();
	foreach( $arrUri as $uri )
	{
		if ( trim( $uri ) != '' )
		{
			$arrUrl[]=trim( $uri );
		}
	}

	$permitted = false;

	if ( isset( $arrUrl[0] ) )
	{
		if ( !isset( $gAuthPerms[$arrUrl[0]]['roles'] ) )
		{
			$permitted = true;
		}
		elseif ( $gAuthPerms[$arrUrl[0]]['roles'] == '' )
		{
			$permitted = true;
		}
		else
		{
			$permitted = false;
			$roles = $gAuthPerms[$arrUrl[0]]['roles'];
			$arrRoles = explode(' ',$roles);
			foreach ( $arrRoles as $role )
			{
				if ( $permitted || gHasRole( $role ) )
				{
					$permitted = true;
				}
			}
		}
	}

	if ( isset( $arrUrl[1] ) )
	{
		if ( isset( $gAuthPerms[$arrUrl[0]][$arrUrl[1]]['roles'] ) )
		{
			if ( $gAuthPerms[$arrUrl[0]][$arrUrl[1]]['roles'] == '' )
			{
				$permitted = true;
			}
			else
			{
				$permitted = false;
				$roles = $gAuthPerms[$arrUrl[0]][$arrUrl[1]]['roles'];
				$arrRoles = explode(' ',$roles);
				foreach ( $arrRoles as $role )
				{
					if ( $permitted || gHasRole( $role ) )
					{
						$permitted = true;
					}
				}
			}
		}
	}

	if ( isset( $arrUrl[2] ) )
	{
		if ( isset( $gAuthPerms[$arrUrl[0]][$arrUrl[1]][$arrUrl[2]]['roles'] ) )
		{
			if ( $gAuthPerms[$arrUrl[0]][$arrUrl[1]][$arrUrl[2]]['roles'] == '' )
			{
				$permitted = true;
			}
			else
			{
				$permitted = false;
				$roles = $gAuthPerms[$arrUrl[0]][$arrUrl[1]][$arrUrl[2]]['roles'];
				$arrRoles = explode(' ',$roles);
				foreach ( $arrRoles as $role )
				{
					if ( $permitted || gHasRole( $role ) )
					{
						$permitted = true;
					}
				}
			}
		}
	}

	return $permitted;
}

function gHasRole( $role )
{
	if (  !isset( $GLOBALS['gAuth'] ) || !$GLOBALS['gAuth'] ) return true;

	if ( !isset( $GLOBALS['gUser'] ) || ( $GLOBALS['gUser']==false ) || empty( $GLOBALS['gUser']['username'] ) ) return false;

	$has = false;

	if ( stristr( $GLOBALS['gUser']['roles'], $role ) !== false )
	{
		$has = true;
	}

	return $has;
}

function gAuthorize($user,$roles)
{
	if ( empty( $roles ) ) return true;
	$authorize = false;
	$userRoles = explode(' ',$user['roles']);
	$needRoles = explode(' ',$roles);

	foreach( $userRoles as $userRole )
	{
		if ( $authorize || in_array( $userRole, $needRoles ) )
		{
			$authorize = true;
		}
	}

	return $authorize;
}

/**
 * gRouter
 * @param	object	$gRouter		Description
 * @param	object	$gParams		Description
 * @param	object	$gParamsNamed	Description
 * @param	object	$gQuery			Description
 * @param	String	$gDelim			Description
 * @return	object					Description
 */
function gRouter( &$gRouter, &$gParams, &$gParamsNamed, $gQuery, $gDelim='/' )
{
	$gRouter['uri']=$_SERVER['REQUEST_URI'];

	if ( $gQuery == '' || $gQuery == false || $gQuery == null )
	{
        $gRouter['act']='index';
		return G_APP_DIR;
	}

	$args=explode( $gDelim, $gQuery );

    if ( isne( $args[0] ) )
    {
        $gRouter['act']=trim( $args[0] );
    }
    else
    {
		$gRouter['act']='index';
    }

    foreach( $args as $k=>$v )
    {
        if ( $k <1 ) continue;

        $pnp = stripos( $v, ':' );

        if ( $pnp !== false )
        {
            $vs = explode(':',$v,2);
            $gParamsNamed[$vs[0]]=$vs[1];
        }
        else
        {
            $gParams[] = $v;
        }
    }

	return G_APP_DIR;
}

/**
 * redirect
 * @param	object	$url	Description
 * @return	object			Description
 */
function gRedirect($url)
{
	global $gRootUrl;

	$url = trim($url);

	if ( substr( $url,0,1 ) =='/' )
	{
		$url = substr($url,1);
	}

	if ( stripos($url,'http') === false )
	{
		$url = $gRootUrl.$url;
	}

	header('Location: '.$url);
	exit;
}

function gHead( $qHead )
{
	global $gRootUrl;
	if ( isset( $qHead['css'] ) )
	{
		foreach( $qHead['css'] as $k=>$media)
		{
			echo '<link type="text/css" rel="stylesheet" media="screen" href="'.$gRootUrl.$media.'" />';
		}
	}

	if ( isset( $qHead['js'] ) )
	{
		foreach( $qHead['js'] as $k=>$media)
		{
			echo '<script type="text/javascript" src="'.$gRootUrl.$media.'"></script>';
		}
	}
}

/**
 * view
 * @return	object		Description
 */
function view()
{
	global $gRouter;
	global $gView;
	if ( isne( $gView ) )
	{
		return G_APP_PATH."av/".$gView.'.php';
	}
	else
	{
		return G_APP_PATH."av/".$gRouter['act'].'.php';
	}
}

/**
 * element
 * @param	object	$element	Description
 * @param	Boolean	$global		Description
 * @return	object				Description
 */
function element($element,$global=false)
{
	global $gRouter;

	$el_src = G_APP_PATH.'element/';

	if ( $global )
	{
		$el_src = G_LIB_PATH.'element/';
	}

	if ( is_file( $el_src.$element.'.php' ) )
	{
		return $el_src.$element.'.php';
	}
	elseif ( is_file( $element ) )
	{
		return $element;
	}
	else
	{
		die( 'SITE ERROR: No element file: '.$element );
	}
}

/**
 * Summary
 * @param	object	$file		Description
 * @param	object	$arrData	Description
 * @return	object				Description
 */
function save_json_file( $file, $arrData )
{
    if ( empty( $arrData ) ) return false;

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
function read_json_file( $file )
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
 * set_json_cookie
 * @param	object	$name		Description
 * @param	object	$value		Description
 * @param	Number	$expire		Description
 * @param	String	$path		Description
 * @param	String	$domain		Description
 * @param	Object	$secure		Description
 * @param	Object	$httponly	Description
 * @return	object				Description
 */
function set_json_cookie( $name, $value, $expire = 0, $path='/', $domain='' ,$secure = false , $httponly = false )
{
    return setcookie ( $name, json_encode($value), $expire, $path, $domain, $secure, $httponly);
}

/**
 * get_json_cookie
 * @param	object	$name	Description
 * @return	object			Description
 */
function get_json_cookie( $name )
{
    if ( isset( $_COOKIE[$name] ) )
	{
		return json_decode($_COOKIE[$name],true);
	}
	else
	{
		return false;
	}
}

/**
 * set_msg
 * @param	object	$msg	Description
 * @param	Boolean	$dsc	Description
 * @param	Boolean	$class	Description
 * @param	Boolean	$time	Description
 * @param	Boolean	$pos	Description
 * @param	Boolean	$width	Description
 * @return	object			Description
 */
function set_msg($msg,$dsc=false,$class=false,$time=false,$pos=false,$width=false)
{
	$amsg=array();

	$amsg['msg']=$msg;
	$amsg['dsc']=$dsc;
	$amsg['cls']=$class;
	$amsg['tim']=$time;
	$amsg['pos']=$pos;
	$amsg['wdt']=$width;

	set_json_cookie( 'glumsg', $amsg );
}
