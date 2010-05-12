<?php

function shr_preFlight_Checks() {
	global $sexy_plugopts;
	if( ((function_exists('curl_init') && function_exists('curl_exec')) || function_exists('file_get_contents')) && (is_dir(SEXY_PLUGDIR.'spritegen') && is_writable(SEXY_PLUGDIR.'spritegen')) && ((isset($_POST['bookmark']) && is_array($_POST['bookmark']) && sizeof($_POST['bookmark']) > 0 ) || (isset($sexy_plugopts['bookmark']) && is_array($sexy_plugopts['bookmark']) && sizeof($sexy_plugopts['bookmark']) > 0 )) && !$sexy_plugopts['custom-mods'] ) {
		return true;
	}
	else {
		return false;
	}
}

function get_sprite_file($opts, $type)
{
	$spritegen = 'http://www.shareaholic.com/api/sprite/?v=1&apikey=8afa39428933be41f8afdb8ea21a495c&imageset=60'.$opts.'&apitype='.$type;
  $filename = SEXY_PLUGDIR.'/spritegen/shr-custom-sprite.'.$type;
  $content = FALSE;

  if ( $type == 'png' )
    $fp_opt = 'rb';
  else
    $fp_opt = 'r';

  if ( function_exists('fopen') )
  {
    if ( function_exists('phpversion') )
    {
      $php_ver = @substr(phpversion(),0,1);
    }

    if ( $php_ver !== FALSE && $php_ver >= 5)
    {
      $http_opts = array(
              'http'=>array(
                'method'=>"GET",
                'header'=>"User-Agent: shr-wpspritebot-fopen/v" . SEXY_vNum . "\r\n"
              )
      );

      $fp_context = stream_context_create($http_opts);
    }
    else
      $fp_context = FALSE;

    if ( $fp_context )
      $fp = @fopen($spritegen, $fp_opt, false, $fp_context);
    else
      $fp = @fopen($spritegen, $fp_opt);

    if ( $fp !== FALSE )
    {
      $content = '';

      while ( !feof($fp) )
      {
        $content .= fread($fp, 8192);
      }

      @fclose($fp);
    }
  }

  if ( $content === FALSE && function_exists('curl_init') && function_exists('curl_exec') )
  {
	  $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $spritegen);
    curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($ch, CURLOPT_TIMEOUT, 6);
    curl_setopt($ch, CURLOPT_USERAGENT, "shr-wpspritebot-cURL/v" . SEXY_vNum);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);

    $content = curl_exec($ch);

    if ( curl_errno($ch) != 0 )
      $content = FALSE;

    curl_close($ch);
  }

  if ( $content !== FALSE )
  {
    if ( $type == 'png' )
      $fp_opt = 'w+b';
    else
      $fp_opt = 'w+';
    
    $fp = @fopen($filename, $fp_opt);

    if ( $fp !== FALSE )
    {
      $ret = @fwrite($fp, $content);
      @fclose($fp);
    }
    else
    {
      $ret = @file_put_contents($filename, $content);
    }

    if ( $ret !== FALSE )
    {
      @chmod($filename, 0666);
      return 0;
    }
    else
    {
      return 1;
    }
  }
  else
    return 2;
}

