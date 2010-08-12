<?php

function shrsb_preFlight_Checks() {
	global $shrsb_plugopts;
	if( ((function_exists('curl_init') && function_exists('curl_exec')) || function_exists('file_get_contents')) && (is_dir(SHRSB_PLUGDIR.'spritegen') && is_writable(SHRSB_PLUGDIR.'spritegen')) && ((isset($_POST['bookmark']) && is_array($_POST['bookmark']) && sizeof($_POST['bookmark']) > 0 ) || (isset($shrsb_plugopts['bookmark']) && is_array($shrsb_plugopts['bookmark']) && sizeof($shrsb_plugopts['bookmark']) > 0 )) && !$shrsb_plugopts['custom-mods'] ) {
		return true;
	}
	else {
		return false;
	}
}

function get_sprite_file($opts, $type) {
  global $shrsb_plugopts;

  $shrbase = $shrsb_plugopts['shrbase']?$shrsb_plugopts['shrbase']:'http://www.shareaholic.com';
	$spritegen = $shrbase.'/api/sprite/?v=1&apikey=8afa39428933be41f8afdb8ea21a495c&imageset=60'.$opts.'&apitype='.$type;
  $filename = SHRSB_PLUGDIR.'spritegen/shr-custom-sprite.'.$type;
  $content = FALSE;

  if ( $type == 'png' ) {
    $fp_opt = 'rb';
  }
  else {
    $fp_opt = 'r';
  }

  if(function_exists('wp_remote_retrieve_body') && function_exists('wp_remote_get') && function_exists('wp_remote_retrieve_response_code')) {
    $request = wp_remote_get(
      $spritegen,
      array(
        'user-agent' => "shr-wpspritebot-fopen/v" . SHRSB_vNum,
        'headers' => array(
          'Referer' => get_bloginfo('url')
        )
      )
    );
    $response = wp_remote_retrieve_response_code($request);
    if($response == 200 || $response == '200') {
      $content = wp_remote_retrieve_body($request);
    }
    else {
      $content = FALSE;
    }
  }

  if ( $content === FALSE && function_exists('curl_init') && function_exists('curl_exec') ) {
	  $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $spritegen);
    curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($ch, CURLOPT_TIMEOUT, 6);
    curl_setopt($ch, CURLOPT_USERAGENT, "shr-wpspritebot-cURL/v" . SHRSB_vNum);
    curl_setopt($ch, CURLOPT_REFERER, get_bloginfo('url'));
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);

    $content = curl_exec($ch);

    if ( curl_errno($ch) != 0 ) {
      $content = FALSE;
    }
    curl_close($ch);
  }

  if ( $content !== FALSE ) {
    if ( $type == 'png' ) {
      $fp_opt = 'w+b';
    }
    else {
      $fp_opt = 'w+';
    }

    
    $fp = @fopen($filename, $fp_opt);

    if ( $fp !== FALSE ) {
      $ret = @fwrite($fp, $content);
      @fclose($fp);
    }
    else {
      $ret = @file_put_contents($filename, $content);
    }

    if ( $ret !== FALSE ) {
      @chmod($filename, 0666);
      return 0;
    }
    else {
      return 1;
    }
  }
  else {
    return 2;
  }
}

/**
 * Gets the contents of a url on www.shareaholic.com.  We use shrbase as the
 * URL base path.  The caller is responsible for keeping track of whether the
 * cache is up-to-date or not.  If the cache is stale (because some argument
 * has changed), then the caller should pass true as the second argument.
 *
 * @url        - the partial url without base.  ex. /publishers
 * @path       - path to cache result to, under spritegen.
 *               ex. /publishers.html
 *               pass null to use the path part of url
 * @clearcache - force call and overwrite cache.
 */
function _shrsb_fetch_content($url, $path, $clearcache=false) {
  global $shrsb_plugopts;

  $shrbase = $shrsb_plugopts['shrbase']?$shrsb_plugopts['shrbase']:'http://www.shareaholic.com';

  if (!preg_match('|^/|', $url)) {
    @error_log("url must start with '/' in _shrsb_fetch_content");
    return FALSE;
  }

  // default path
  if (null === $path) {
    $url_parts = explode('?', $url);
    $path = rtrim($url_parts[0], '/');
  }

  $base_path = path_join(SHRSB_PLUGDIR, 'spritegen');
  $abs_path = $base_path.$path;

  if ($clearcache || !($retval = _shrsb_read_file($abs_path))) {
    $response = wp_remote_get($shrbase.$url);
    if (is_wp_error($response)) {
      @error_log("Failed to fetch ".$shrbase.$url);
      $retval = FALSE;
    } else {
      $retval = $response['body'];
    }

    _shrsb_write_file($abs_path, $retval);
  }

  return $retval;
}

function _shrsb_write_file($path, $content) {
  $dir = dirname($path);
  if(!wp_mkdir_p(dirname($path))) {
    @error_log("Failed to create path ".dirname($path));
  }
  $fh = fopen($path, 'w+');
  if (!$fh) {
    @error_log("Failed to open ".$path);
  } 
  else {
    if (!fwrite($fh, $content)) {
      @error_log("Failed to write to ".$path);
    }
    @fclose($fh);
  }
}

function _shrsb_read_file($path) {
  $content = FALSE;

  $fh = @fopen($path, 'r');
  if (!$fh) {
    @error_log("Failed to open ".$path);
  } 
  else {
    if (!$content = fread($fh, filesize($path))) {
      @error_log("Failed to read from ".$path);
    }
    @fclose($fh);
  }

  return $content;
}



















/*
 * "Test Head Footer" plugin integration
 * Copyright (c) 2010 Matt Martz (http://sivel.net/)
 * Test Head Footer is released under the GNU General Public License (GPL)
 * http://www.gnu.org/licenses/gpl-2.0.txt
*/
// Lets not do anything until init
add_action( 'init', 'shrsb_shrsb_test_head_footer_init' );
function shrsb_shrsb_test_head_footer_init() {
  // Hook in at admin_init to perform the check for wp_head and wp_footer
  add_action( 'admin_init', 'shrsb_check_head_footer' );

  // If test-head query var exists hook into wp_head
  if (isset($_GET['test-head'])) {
    add_action( 'wp_head', 'shrsb_test_head', 99999 ); // Some obscene priority, make sure we run last
  }

  // If test-footer query var exists hook into wp_footer
  if (isset($_GET['test-footer'])) {
    add_action( 'wp_footer', 'shrsb_test_footer', 99999 ); // Some obscene priority, make sure we run last
  }
}

// Echo a string that we can search for later into the head of the document
// This should end up appearing directly before </head>
function shrsb_test_head() {
  echo '<!--wp_head-->';
}

// Echo a string that we can search for later into the footer of the document
// This should end up appearing directly before </body>
function shrsb_test_footer() {
  echo '<!--wp_footer-->';
}

// Check for the existence of the strings where wp_head and wp_footer should have been called from
function shrsb_check_head_footer() {

  if(function_exists('home_url')) {
    // Build the url to call, NOTE: uses home_url and thus requires WordPress 3.0
    $url = add_query_arg( array( 'test-head' => '', 'test-footer' => '' ), home_url() );
  }
  else {
    $url = add_query_arg( array( 'test-head' => '', 'test-footer' => '' ), get_bloginfo('siteurl') );
  }
  // Perform the HTTP GET ignoring SSL errors
  $response = wp_remote_get( $url, array( 'sslverify' => false ) );
  // Grab the response code and make sure the request was sucessful
  $code = (int) wp_remote_retrieve_response_code($response);
  if($code == 200) {
    global $head_footer_errors;
    $head_footer_errors = array();

    // Strip all tabs, line feeds, carriage returns and spaces
    $html = preg_replace('/[\t\r\n\s]/', '', wp_remote_retrieve_body($response));

    // Check to see if we found the existence of wp_head
    if(!strstr($html, '<!--wp_head-->')) {
      $head_footer_errors['nohead'] = sprintf(__('Your theme is missing the call to %s which should appear directly before %s in the file "header.php"', 'shrsb'), '&lt;?php wp_head(); ?&gt;', '&lt;/head&gt;');
    }
    // Check to see if we found the existence of wp_footer
    if(!strstr($html, '<!--wp_footer-->')) {
      $head_footer_errors['nofooter'] = sprintf(__('Your theme is missing the call to %s which should appear directly before %s in the file "footer.php"', 'shrsb'), '&lt;?php wp_footer(); ?&gt;', '&lt;/body&gt;');
    }

    // Check to see if we found wp_head and if was located in the proper spot
    if(!strstr($html, '<!--wp_head--></head>') && !isset($head_footer_errors['nohead'])) {
      $head_footer_errors[] = sprintf(__('Your theme has the call to %s but it is not called directly before %s in the file "header.php"', 'shrsb'), '&lt;?php wp_head(); ?&gt;', '&lt;/head&gt;');
    }
    // Check to see if we found wp_footer and if was located in the proper spot
    if(!strstr($html, '<!--wp_footer--></body>' ) && !isset($head_footer_errors['nofooter'])) {
      $head_footer_errors[] = sprintf(__('Your theme has the call to %s but it is not called directly before %s in the file "footer.php"', 'shrsb'), '&lt;?php wp_footer(); ?&gt;', '&lt;/body&gt;');
    }

    // If we found errors with the existence of wp_head or wp_footer hook into admin_notices to complain about it
    if(!empty( $head_footer_errors)) {
      add_action('admin_notices', 'shrsb_test_head_footer_notices');
    }
  }
}

// Output the notices
function shrsb_test_head_footer_notices() {
  global $head_footer_errors;
  // If we made it here it is because there were errors, lets loop through and state them all
  echo '<div class="error" style="margin-top:35px;"><p><strong>'.__('WARNING!', 'shrsb').'</strong></p><ul>';
  foreach($head_footer_errors as $error) {
    echo '<li>' . esc_html( $error ) . '</li>';
  }
  echo '</ul><p>'.sprintf(__('This is required to ensure that %sSexyBookmarks%s will work properly.', 'shrsb'), '<a href="options-general.php?page=sexy-bookmarks.php" style="color:#ca0c01">', '</a>').'</p></div>';
}