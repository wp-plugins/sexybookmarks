<?php
/*
Plugin Name: SexyBookmarks
Plugin URI: http://sexybookmarks.net
Description: SexyBookmarks adds a (X)HTML compliant list of social bookmarking icons to each of your posts. See <a href="options-general.php?page=sexy-bookmarks.php">configuration panel</a> for more settings.
Version: 3.1
Author: Shareaholic
Author URI: http://shareaholic.com

	Original WP-Social-Bookmark-Plugin Copyright 2010 Saidmade srl (email : g.fazioli@saidmade.com)
	Original Social Bookmarking Menu & SexyBookmarks Plugin Copyright 2009 Josh Jones (email : josh.jones.mail@gmail.com)
	Continue Development Help: Josh Jones (www.blog2life.net)
	Previous Development Help: Gautam Gupta (www.gaut.am)
	Additional Special Thanks Goes To Kerem Erkan (www.keremerkan.net) 
	Additional Special Thanks Goes To Yuri Gribov (www.wp-ru.ru)
	Additional Special Thanks Goes To Kieran Smith (www.shuttlebox.net)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

// Create Text Domain For Translations
load_plugin_textdomain('sexybookmarks', '/wp-content/plugins/sexybookmarks/languages/');

// Define a couple of constants
define('SEXY_OPTIONS','SexyBookmarks');
define('SEXY_vNum','3.1');
define('SEXY_RELPATH', str_replace($_SERVER['DOCUMENT_ROOT'], '', WP_PLUGIN_DIR).'/'.plugin_basename(dirname(__FILE__)));



// Check for location modifications in wp-config
// Then define accordingly
if ( !defined('WP_CONTENT_URL') ) {
	define('SEXY_PLUGPATH',get_option('siteurl').'/wp-content/plugins/'.plugin_basename(dirname(__FILE__)).'/');
	define('SEXY_PLUGDIR', ABSPATH.'/wp-content/plugins/'.plugin_basename(dirname(__FILE__)).'/');
} else {
	define('SEXY_PLUGPATH',WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/');
	define('SEXY_PLUGDIR',WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__)).'/');
}


/*
 * Newer versions of WordPress include this class already
 * However, we've kept this here for people who are using older versions
 * This will mimick JSON support for PHP4 and below
*/
if ( !class_exists('SERVICES_JSON') ) {
	if ( !function_exists('json_decode') ){
		function json_decode($content, $assoc=false){
			require_once 'includes/JSON.php';
			if ( $assoc ){
				$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
			} else {
				$json = new Services_JSON;
			}
			return $json->decode($content);
		}
	}
	if ( !function_exists('json_encode') ){
		function json_encode($content){
			require_once 'includes/JSON.php';
			$json = new Services_JSON;
			return $json->encode($content);
		}
	}
}

// gets current URL to return to after donating
function get_sexy_current_location() {
	$sexy_current_location = "http";
	$sexy_current_location .= ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? "s" : "")."://";
	$sexy_current_location .= $_SERVER['SERVER_NAME'];
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {
		if($_SERVER['SERVER_PORT']!='443') {
			$sexy_current_location .= ":".$_SERVER['SERVER_PORT'];
		}
	}
	else {
		if($_SERVER['SERVER_PORT']!='80') {
			$sexy_current_location .= ":".$_SERVER['SERVER_PORT'];
		}
	}
	$sexy_current_location .= $_SERVER['REQUEST_URI'];
	echo $sexy_current_location;
}

// contains all bookmark templates.
require_once 'includes/bookmarks-data.php';

// helper functions for html output.
require_once 'includes/html-helpers.php';

//populate the array with default values
$sexy_plugopts = array(
	'position' => 'below', // below, above, or manual
	'reloption' => 'nofollow', // 'nofollow', or ''
	'targetopt' => 'blank', // 'blank' or 'self'
	'bgimg-yes' => 'yes', // 'yes' or blank
	'mobile-hide' => '', // 'yes' or blank
	'bgimg' => 'sexy', // 'sexy', 'caring', 'wealth'
	'shorty' => 'b2l', // default is http://b2l.me
	'pageorpost' => '',
	'bookmark' => array_keys($sexy_bookmarks_data),
	'feed' => '1', // 1 or 0
	'expand' => '1',
	'autocenter' => '0',
	'ybuzzcat' => 'science',
	'ybuzzmed' => 'text',
	'twittcat' => '',
	'defaulttags' => 'blog', // Random word to prevent the Twittley default tag warning
	'warn-choice' => '',
	'doNotIncludeJQuery' => '',
	'custom-mods' => '',
	'hide-sponsors' => '',
	'scriptInFooter' => '1',
);

add_option(SEXY_OPTIONS, $sexy_plugopts); //add to database
$sexy_plugopts = get_option(SEXY_OPTIONS); //reload

// give the custom sprite it's own option to prevent complications with previously saved data
if(!get_option('SexyCustomSprite')) {
	add_option('SexyCustomSprite', '');
	$sexy_custom_sprite = '';
}
else {
	$sexy_custom_sprite = get_option('SexyCustomSprite');
}


//explicitly define globals so they're available in the activation hook
global $sexy_plugopts, $sexy_custom_sprite;

//reload them one more time for good measure
$sexy_plugopts = get_option(SEXY_OPTIONS);
$sexy_custom_sprite = get_option('SexyCustomSprite');


function sexy_preFlight_Checks() {
	global $sexy_plugopts;
	if(phpversion() >= '5' && extension_loaded('gd') && function_exists('gd_info') && !$sexy_plugopts['custom-mods'] && is_writable(SEXY_PLUGDIR.'css') && is_writable(SEXY_PLUGDIR.'images') && ((isset($_POST['bookmark']) && is_array($_POST['bookmark']) && sizeof($_POST['bookmark']) > 0 ) || (isset($sexy_plugopts['bookmark']) && is_array($sexy_plugopts['bookmark']) && sizeof($sexy_plugopts['bookmark']) > 0 ))) {
		return true;
	}
	else {
		return false;
	}
}

// add activation function to generate new sprite
function sexy_activation_hook() {
	global $sexy_plugopts, $sexy_custom_sprite;
	//generate a new sprite, to reduce the size of the image, only for PHP 5 with GD
	if(sexy_preFlight_Checks()) {
		require_once('includes/sexy-sprite.php');

		$sexy_sprite = new SexySprite(sizeof($sexy_plugopts['bookmark']), $sexy_plugopts['bgimg'], $sexy_plugopts['expand']);

		foreach($sexy_plugopts['bookmark'] as $bookmark){
			$sexy_sprite->append_image($bookmark);
		}
		$sexy_sprite->save_image();
		$sexy_custom_sprite = SEXY_PLUGPATH.'css/sexy-custom-sprite.css';
	}	
	else{
		$sexy_custom_sprite = null;
	}
	update_option('SexyCustomSprite', $sexy_custom_sprite);
}
// generate sprite after activation
register_activation_hook(__FILE__, 'sexy_activation_hook' );



//write settings page
function sexy_settings_page() {
	global $sexy_plugopts, $sexy_bookmarks_data, $wpdb, $sexy_custom_sprite;
	
	if($_POST['sponsor-form-save'] == "1"){ //hide sponsor check
		$sexy_plugopts['hide-sponsors'] = $_POST['sexy-hide-sponsors'];
		update_option(SEXY_OPTIONS, $sexy_plugopts);
	}
	
	echo '<h2 class="sexylogo">SexyBookmarks</h2>';

	// create folders for custom mods
	// then copy original files into new folders
	if($_POST['custom-mods'] == 'yes' || $sexy_plugopts['custom-mods'] == 'yes') {
		if(is_admin() === true && !is_dir(WP_CONTENT_DIR.'/sexy-mods')) {
			$sexy_oldloc = SEXY_PLUGDIR;
			$sexy_newloc = WP_CONTENT_DIR.'/sexy-mods/';

			wp_mkdir_p(WP_CONTENT_DIR.'/sexy-mods');
			wp_mkdir_p(WP_CONTENT_DIR.'/sexy-mods/css');
			wp_mkdir_p(WP_CONTENT_DIR.'/sexy-mods/images');
			wp_mkdir_p(WP_CONTENT_DIR.'/sexy-mods/js');

			copy($sexy_oldloc.'css/style.css', $sexy_newloc.'css/style.css');
			copy($sexy_oldloc.'js/sexy-bookmarks-public.js', $sexy_newloc.'js/sexy-bookmarks-public.js');
			copy($sexy_oldloc.'images/sexy-sprite.png', $sexy_newloc.'images/sexy-sprite.png');
			
			copy($sexy_oldloc.'images/share-enjoy.png', $sexy_newloc.'images/share-enjoy.png');
			copy($sexy_oldloc.'images/share-german.png', $sexy_newloc.'images/share-german.png');
			copy($sexy_oldloc.'images/share-love-hearts.png', $sexy_newloc.'images/share-love-hearts.png');
			copy($sexy_oldloc.'images/share-wealth.png', $sexy_newloc.'images/share-wealth.png');
			copy($sexy_oldloc.'images/sharing-caring-hearts.png', $sexy_newloc.'images/sharing-caring-hearts.png');
			copy($sexy_oldloc.'images/sharing-caring.png', $sexy_newloc.'images/sharing-caring.png');
			copy($sexy_oldloc.'images/sharing-sexy.png', $sexy_newloc.'images/sharing-sexy.png');
		}
	}

	// processing form submission
	$status_message = "";
	$error_message = "";
	if(isset($_POST['save_changes'])) {
		$status_message = __('Your changes have been saved successfully!', 'sexybookmarks').' | '.sprintf(__('Maybe you would consider <a href="%s">donating</a>?', 'sexybookmarks'), '#sexydonationsbox');

		$errmsgmap = array(
			'position'=>__('Please choose where you would like the menu to be displayed.', 'sexybookmarks'),
			'bookmark'=>__("You can't display the menu if you don't choose a few sites to add to it!", 'sexybookmarks'),
			'pageorpost'=>__('Please choose where you want the menu displayed.', 'sexybookmarks'),
		);
		// adding to err msg map if twittley is enabled.
		if (in_array('sexy-twittley', $_POST['bookmark'])) {
			$errmsgmap['twittcat']=__('You need to select the primary category for any articles submitted to Twittley.', 'sexybookmarks');
			$errmsgmap['defaulttags']=__('You need to set at least 1 default tag for any articles submitted to Twittley.', 'sexybookmarks');
		}
		foreach ($errmsgmap as $field=>$msg) {
			if ($_POST[$field] == '') {
				$error_message = $msg;
				break;
			}
		}
		// Twitter friendly links: check to see if they have the plugin activated
		if ($_POST['shorty'] == 'tflp' && !function_exists('permalink_to_twitter_link')) {
			$error_message = sprintf(__('You must first download and activate the <a href="%s">Twitter Friendly Links Plugin</a> before hosting your own short URLs...', 'sexybookmarks'), 'http://wordpress.org/extend/plugins/twitter-friendly-links/');
		} elseif ($_POST['shorty'] == 'yourls' && !function_exists('wp_ozh_yourls_raw_url')) {
			$error_message = sprintf(__('You must first download and activate the <a href="%s">YOURLS Plugin</a> before hosting your own short URLs...', 'sexybookmarks'), 'http://wordpress.org/extend/plugins/yourls-wordpress-to-twitter/');
		}

		if (!$error_message) {
			//generate a new sprite, to reduce the size of the image, only for PHP 5 with GD
			if(sexy_preFlight_Checks()) {
				require_once('includes/sexy-sprite.php'); //main file, which includes other classes
				if ( isset($_POST['bookmark']) && is_array($_POST['bookmark']) and sizeof($_POST['bookmark']) > 0 )
				{
					$sexy_sprite = new SexySprite(sizeof($_POST['bookmark']), $_POST['bgimg'], $_POST['expand']);

					foreach ( $_POST['bookmark'] as $bookmark )
					{
						$sexy_sprite->append_image($bookmark);
					}
					$sexy_sprite->save_image();
				}
				$sexy_custom_sprite = SEXY_PLUGPATH.'css/sexy-custom-sprite.css'; //cssfilename
			}else{
				$sexy_custom_sprite = null;
				if(phpversion() >= '5' && extension_loaded('gd')) {
					if (!is_writable(SEXY_PLUGDIR.'css') || !is_writeable(SEXY_PLUGDIR.'images')) {
						echo '<div id="warnmessage" class="sexy-warning"><div class="dialog-left fugue f-warn">'.sprintf(__('WARNING: Your css and/or images folders are not writeable! <a href="%s" target="_blank">Need Help?</a>', 'sexybookmarks'), 'http://sexybookmarks.net/documentation/usage-installation#chmodinfo').'</div><div class="dialog-right"><img src="'.SEXY_PLUGPATH.'images/warning-delete.jpg" class="del-x" alt=""/></div></div><div style="clear:both;"></div>';
					}
				}
			}
			foreach (array(
				'position', 'xtrastyle', 'reloption', 'targetopt', 'bookmark',
				'shorty', 'pageorpost', 'twittid', 'ybuzzcat', 'ybuzzmed',
				'twittcat', 'defaulttags', 'bgimg-yes', 'mobile-hide', 'bgimg',
				'feed', 'expand', 'doNotIncludeJQuery', 'autocenter', 'custom-mods', 'scriptInFooter'
			) as $field) $sexy_plugopts[$field]=$_POST[$field];
			
			/* Short URLs */
			//trim also at the same time as at times while copying, some whitespace also gets copied
			//check fields dont need trim function
			$sexy_plugopts['shortyapi']['snip']['user'] = trim($_POST['shortyapiuser-snip']);
			$sexy_plugopts['shortyapi']['snip']['key'] = trim($_POST['shortyapikey-snip']);
			$sexy_plugopts['shortyapi']['bitly']['user'] = trim($_POST['shortyapiuser-bitly']);
			$sexy_plugopts['shortyapi']['bitly']['key'] = trim($_POST['shortyapikey-bitly']);
			$sexy_plugopts['shortyapi']['supr']['chk'] = $_POST['shortyapichk-supr'];
			$sexy_plugopts['shortyapi']['supr']['user'] = trim($_POST['shortyapiuser-supr']);
			$sexy_plugopts['shortyapi']['supr']['key'] = trim($_POST['shortyapikey-supr']);
			$sexy_plugopts['shortyapi']['trim']['chk'] = $_POST['shortyapichk-trim'];
			$sexy_plugopts['shortyapi']['trim']['user'] = trim($_POST['shortyapiuser-trim']);
			$sexy_plugopts['shortyapi']['trim']['pass'] = trim($_POST['shortyapipass-trim']);
			$sexy_plugopts['shortyapi']['tinyarrow']['chk'] = $_POST['shortyapichk-tinyarrow'];
			$sexy_plugopts['shortyapi']['tinyarrow']['user'] = trim($_POST['shortyapiuser-tinyarrow']);
			$sexy_plugopts['shortyapi']['cligs']['chk'] = $_POST['shortyapichk-cligs'];
			$sexy_plugopts['shortyapi']['cligs']['key'] = trim($_POST['shortyapikey-cligs']);
			/* Short URLs End */
			
			update_option(SEXY_OPTIONS, $sexy_plugopts);
			update_option('SexyCustomSprite', $sexy_custom_sprite);
		}


		if ($_POST['clearShortUrls']) {
			$dump = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key='_sexybookmarks_shortUrl' OR meta_key='_sexybookmarks_permaHash'");
			echo '<div id="warnmessage" class="sexy-warning"><div class="dialog-left fugue f-warn">'.($dump/2).' '.__('Short URL(s) have been reset.', 'sexybookmarks').'</div><div class="dialog-right"><img src="'.SEXY_PLUGPATH.'images/warning-delete.jpg" class="del-x" alt=""/></div></div><div style="clear:both;"></div>';
		}
	}

	//if there was an error, construct error messages 
	if ($error_message != '') {
		echo '
		<div id="errmessage" class="sexy-error">
			<div class="dialog-left fugue f-error">
				'.$error_message.'
			</div>
			<div class="dialog-right">
				<img src="'.SEXY_PLUGPATH.'images/error-delete.jpg" class="del-x" alt=""/>
			</div>
		</div>';
	} elseif ($status_message != '') {
		echo '
		<div id="statmessage" class="sexy-success">
			<div class="dialog-left fugue f-success">
				'.$status_message.'
			</div>
			<div class="dialog-right">
				<img src="'.SEXY_PLUGPATH.'images/success-delete.jpg" class="del-x" alt=""/>
			</div>
		</div>';
	}

// If sponsor messages aren't set to be hidden, insert the script 
if($sexy_plugopts['hide-sponsors'] != "yes") {
?>
<script type="text/javascript">
	var psHost = (("https:" == document.location.protocol) ? "https://" : "http://");
	document.write(unescape("%3Cscript src='" + psHost + "pluginsponsors.com/direct/spsn/display.php?client=sexy&spot=' type='text/javascript'%3E%3C/script%3E"));
</script>
<?php } ?>


<form name="sexy-bookmarks" id="sexy-bookmarks" action="" method="post">
	<div id="sexy-col-left">
		<ul id="sexy-sortables">
			<li>
				<div class="box-mid-head" id="iconator">
					<h2 class="fugue f-globe-plus"><?php _e('Enabled Networks', 'sexybookmarks'); ?></h2>
				</div>
				<div class="box-mid-body iconator" id="toggle1">
					<div class="padding">
						<p><?php _e('Select the Networks to display. Drag to reorder.', 'sexybookmarks'); ?></p>
						<ul class="multi-selection"> 
							<li><?php _e('Select', 'sexybookmarks'); ?>:&nbsp;</li> 
							<li><a id="sel-all" href="javascript:void(0);"><?php _e('All', 'sexybookmarks'); ?></a>&nbsp;|&nbsp;</li> 
							<li><a id="sel-none" href="javascript:void(0);"><?php _e('None', 'sexybookmarks'); ?></a>&nbsp;|&nbsp;</li> 
							<li><a id="sel-pop" href="javascript:void(0);"><?php _e('Most Popular', 'sexybookmarks'); ?></a>&nbsp;</li> 
		                </ul>
						<div id="sexy-networks">
							<?php
								foreach ($sexy_plugopts['bookmark'] as $name) print sexy_network_input_select($name, $sexy_bookmarks_data[$name]['check']);
								$unused_networks=array_diff(array_keys($sexy_bookmarks_data), $sexy_plugopts['bookmark']);
								foreach ($unused_networks as $name) print sexy_network_input_select($name, $sexy_bookmarks_data[$name]['check']);
							?>
						</div>
					</div>
				</div>
			</li>
			<li>
				<div class="box-mid-head">
					<h2 class="fugue f-wrench"><?php _e('Functionality Settings', 'sexybookmarks'); ?></h2>
				</div>
				<div class="box-mid-body" id="toggle2">
					<div class="padding">
						<div class="dialog-box-warning" id="clear-warning">
							<div class="dialog-left fugue f-warn">
								<?php _e('This will clear <u>ALL</u> short URLs. - Are you sure?', 'sexybookmarks'); ?>
							</div>
							<div class="dialog-right">
								<label><input name="warn-choice" id="warn-yes" type="radio" value="yes" /><?php _e('Yes', 'sexybookmarks'); ?></label> &nbsp;<label><input name="warn-choice" id="warn-cancel" type="radio" value="cancel" /><?php _e('Cancel', 'sexybookmarks'); ?></label>
							</div>
						</div>
						<div id="twitter-defaults"<?php if(!in_array('sexy-twitter', $sexy_plugopts['bookmark'])) { ?> class="hide"<?php } ?>>
							<h3><?php _e('Twitter Options:', 'sexybookmarks'); ?></h3>
							<label for="twittid"><?php _e('Twitter ID:', 'sexybookmarks'); ?></label>
							<input type="text" id="twittid" name="twittid" value="<?php echo $sexy_plugopts['twittid']; ?>" />
							<div class="clearbig"></div>
							<label for="shorty"><?php _e('Which URL Shortener?', 'sexybookmarks'); ?></label>
							<select name="shorty" id="shorty">
								<?php
									// output shorty select options
									print sexy_select_option_group('shorty', array(
										'none'=>__("Don't use a shortener", 'sexybookmarks'),
										'tflp'=>'Twitter Friendly Links Plugin',
										'yourls'=>'YOURLS Plugin',
										'b2l'=>'b2l.me',
										'bitly' => 'bit.ly',
										'trim'=>'tr.im',
										'tinyarrow'=>'tinyarro.ws',
										'tiny'=>'tinyurl.com',
										'snip'=>'snipr.com',
										'supr'=>'su.pr',
										'cligs'=>'cli.gs',
										'slly'=>'SexyURL (sl.ly)',
									));
								?>
							</select>
							<label for="clearShortUrls" id="clearShortUrlsLabel"><input name="clearShortUrls" id="clearShortUrls" type="checkbox"/><?php _e('Reset all Short URLs', 'sexybookmarks'); ?></label>
							<div id="shortyapimdiv-bitly"<?php if($sexy_plugopts['shorty'] != "bitly") { ?> class="hidden"<?php } ?>>
								<div id="shortyapidiv-bitly">
									<label for="shortyapiuser-bitly"><?php _e('User ID:', 'sexybookmarks'); ?></label>
									<input type="text" id="shortyapiuser-bitly" name="shortyapiuser-bitly" value="<?php echo $sexy_plugopts['shortyapi']['bitly']['user']; ?>" />
									<label for="shortyapikey-bitly"><?php _e('API Key:', 'sexybookmarks'); ?></label>
									<input type="text" id="shortyapikey-bitly" name="shortyapikey-bitly" value="<?php echo $sexy_plugopts['shortyapi']['bitly']['key']; ?>" />
								</div>
							</div>
							<div id="shortyapimdiv-trim" <?php if($sexy_plugopts['shorty'] != 'trim') { ?>class="hidden"<?php } ?>>
								<span class="sexy_option" id="shortyapidivchk-trim">
									<input <?php echo (($sexy_plugopts['shortyapi']['trim']['chk'] == "1")? 'checked=""' : ""); ?> name="shortyapichk-trim" id="shortyapichk-trim" type="checkbox" value="1" /> <?php _e('Track Generated Links?', 'sexybookmarks'); ?>
								</span>
								<div class="clearbig"></div>
								<div id="shortyapidiv-trim" <?php if(!isset($sexy_plugopts['shortyapi']['trim']['chk'])) { ?>class="hidden"<?php } ?>>
									<label for="shortyapiuser-trim"><?php _e('User ID:', 'sexybookmarks'); ?></label>
									<input type="text" id="shortyapiuser-trim" name="shortyapiuser-trim" value="<?php echo $sexy_plugopts['shortyapi']['trim']['user']; ?>" />
									<label for="shortyapikey-trim"><?php _e('Password:', 'sexybookmarks'); ?></label>
									<input type="text" id="shortyapipass-trim" name="shortyapipass-trim" value="<?php echo $sexy_plugopts['shortyapi']['trim']['pass']; ?>" />
								</div>
							</div>
							<div id="shortyapimdiv-snip" <?php if($sexy_plugopts['shorty'] != 'snip') { ?>class="hidden"<?php } ?>>
								<div class="clearbig"></div>
								<div id="shortyapidiv-snip">
									<label for="shortyapiuser-snip"><?php _e('User ID:', 'sexybookmarks'); ?></label>
									<input type="text" id="shortyapiuser-snip" name="shortyapiuser-snip" value="<?php echo $sexy_plugopts['shortyapi']['snip']['user']; ?>" />
									<label for="shortyapikey-snip"><?php _e('API Key:', 'sexybookmarks'); ?></label>
									<input type="text" id="shortyapikey-snip" name="shortyapikey-snip" value="<?php echo $sexy_plugopts['shortyapi']['snip']['key']; ?>" />
								</div>
							</div>
							<div id="shortyapimdiv-tinyarrow" <?php if($sexy_plugopts['shorty'] != 'tinyarrow') { ?>class="hidden"<?php } ?>>
								<span class="sexy_option" id="shortyapidivchk-tinyarrow">
									<input <?php echo (($sexy_plugopts['shortyapi']['tinyarrow']['chk'] == "1")? 'checked=""' : ""); ?> name="shortyapichk-tinyarrow" id="shortyapichk-tinyarrow" type="checkbox" value="1" /> <?php _e('Track Generated Links?', 'sexybookmarks'); ?>
								</span>
								<div class="clearbig"></div>
								<div id="shortyapidiv-tinyarrow" <?php if(!isset($sexy_plugopts['shortyapi']['tinyarrow']['chk'])) { ?>class="hidden"<?php } ?>>
									<label for="shortyapiuser-tinyarrow"><?php _e('User ID:', 'sexybookmarks'); ?></label>
									<input type="text" id="shortyapiuser-tinyarrow" name="shortyapiuser-tinyarrow" value="<?php echo $sexy_plugopts['shortyapi']['tinyarrow']['user']; ?>" />
								</div>
							</div>
							<div id="shortyapimdiv-cligs" <?php if($sexy_plugopts['shorty'] != 'cligs') { ?>class="hidden"<?php } ?>>
								<span class="sexy_option" id="shortyapidivchk-cligs">
									<input <?php echo (($sexy_plugopts['shortyapi']['cligs']['chk'] == "1")? 'checked=""' : ""); ?> name="shortyapichk-cligs" id="shortyapichk-cligs" type="checkbox" value="1" /> <?php _e('Track Generated Links?', 'sexybookmarks'); ?>
								</span>
								<div class="clearbig"></div>
								<div id="shortyapidiv-cligs" <?php if(!isset($sexy_plugopts['shortyapi']['cligs']['chk'])) { ?>class="hidden"<?php } ?>>
									<label for="shortyapikey-cligs"><?php _e('API Key:', 'sexybookmarks'); ?></label>
									<input type="text" id="shortyapikey-cligs" name="shortyapikey-cligs" value="<?php echo $sexy_plugopts['shortyapi']['cligs']['key']; ?>" />
								</div>
							</div>
							<div id="shortyapimdiv-supr" <?php if($sexy_plugopts['shorty'] != 'supr') { ?>class="hidden"<?php } ?>>
								<span class="sexy_option" id="shortyapidivchk-supr">
									<input <?php echo (($sexy_plugopts['shortyapi']['supr']['chk'] == "1")? 'checked=""' : ""); ?> name="shortyapichk-supr" id="shortyapichk-supr" type="checkbox" value="1" /> <?php _e('Track Generated Links?', 'sexybookmarks'); ?>
								</span>
								<div class="clearbig"></div>
								<div id="shortyapidiv-supr" <?php if(!isset($sexy_plugopts['shortyapi']['supr']['chk'])) { ?>class="hidden"<?php } ?>>
									<label for="shortyapiuser-supr"><?php _e('User ID:', 'sexybookmarks'); ?></label>
									<input type="text" id="shortyapiuser-supr" name="shortyapiuser-supr" value="<?php echo $sexy_plugopts['shortyapi']['supr']['user']; ?>" />
									<label for="shortyapikey-supr"><?php _e('API Key:', 'sexybookmarks'); ?></label>
									<input type="text" id="shortyapikey-supr" name="shortyapikey-supr" value="<?php echo $sexy_plugopts['shortyapi']['supr']['key']; ?>" />
								</div>
							</div>
							<div class="clearbig"></div>
						</div>
						<div id="ybuzz-defaults"<?php if(!in_array('sexy-yahoobuzz', $sexy_plugopts['bookmark'])) { ?> class="hide"<?php } ?>>
							<h3><?php _e('Yahoo! Buzz Defaults:', 'sexybookmarks'); ?></h3>
							<label for="ybuzzcat"><?php _e('Default Content Category:', 'sexybookmarks'); ?> </label>
							<select name="ybuzzcat" id="ybuzzcat">
								<?php
									// output shorty select options
									print sexy_select_option_group('ybuzzcat', array(
										'entertainment'=>'Entertainment',
										'lifestyle'=>'Lifestyle',
										'health'=>'Health',
										'usnews'=>'U.S. News',
										'business'=>'Business',
										'politics'=>'Politics',
										'science'=>'Sci/Tech',
										'world_news'=>'World',
										'sports'=>'Sports',
										'travel'=>'Travel',
									));
								?>
							</select>
							<div class="clearbig"></div>
							<label for="ybuzzmed"><?php _e('Default Media Type:', 'sexybookmarks'); ?></label>
							<select name="ybuzzmed" id="ybuzzmed">
								<?php
									print sexy_select_option_group('ybuzzmed', array(
										'text'=>'Text',
										'image'=>'Image',
										'audio'=>'Audio',
										'video'=>'Video',
									));
								?>
							</select>
						<div class="clearbig"></div>
						</div>
						<div id="twittley-defaults"<?php if(!in_array('sexy-twittley', $sexy_plugopts['bookmark'])) { ?> class="hide"<?php } ?>>
							<h3><?php _e('Twittley Defaults:', 'sexybookmarks'); ?></h3>
							<label for="twittcat"><?php _e('Primary Content Category:', 'sexybookmarks'); ?> </label>
							<select name="twittcat" id="twittcat">
								<?php
									print sexy_select_option_group('twittcat', array(
										'Technology'=>__('Technology', 'sexybookmarks'),
										'World &amp; Business'=>__('World &amp; Business', 'sexybookmarks'),
										'Science'=>__('Science', 'sexybookmarks'),
										'Gaming'=>__('Gaming', 'sexybookmarks'),
										'Lifestyle'=>__('Lifestyle', 'sexybookmarks'),
										'Entertainment'=>__('Entertainment', 'sexybookmarks'),
										'Sports'=>__('Sports', 'sexybookmarks'),
										'Offbeat'=>__('Offbeat', 'sexybookmarks'),
										'Internet'=>__('Internet', 'sexybookmarks'),
									));
								?>
							</select>
							<div class="clearbig"></div>
							<p id="tag-info" class="hidden">
								<?php _e("Enter a comma separated list of general tags which describe your site's posts as a whole. Try not to be too specific, as one post may fall into different *tag categories* than other posts.", 'sexybookmarks'); ?><br />
								<?php _e('This list is primarily used as a failsafe in case you forget to enter WordPress tags for a particular post, in which case this list of tags would be used so as to bring at least *somewhat* relevant search queries based on the general tags that you enter here.', 'sexybookmarks'); ?><br /><span title="<?php _e('Click here to close this message', 'sexybookmarks'); ?>" class="dtags-close">[<?php _e('close', 'sexybookmarks'); ?>]</span>
							</p>
							<label for="defaulttags"><?php _e('Default Tags:', 'sexybookmarks'); ?> </label>
							<input type="text" name="defaulttags" id="defaulttags" onblur="if ( this.value == '' ) { this.value = 'enter,default,tags,here'; }" onfocus="if ( this.value == 'enter,default,tags,here' ) { this.value = ''; }" value="<?php echo $sexy_plugopts['defaulttags']; ?>" /><span class="dtags-info fugue f-question" title="<?php _e('Click here for help with this option', 'sexybookmarks'); ?>"> </span>
							<div class="clearbig"></div>
						</div>
						<div id="genopts">
							<h3><?php _e('General Functionality Options:', 'sexybookmarks'); ?></h3>
							<span class="sexy_option"><?php _e('Add nofollow to the links?', 'sexybookmarks'); ?></span>
							<label><input <?php echo (($sexy_plugopts['reloption'] == "nofollow")? 'checked="checked"' : ""); ?> name="reloption" id="reloption-yes" type="radio" value="nofollow" /> <?php _e('Yes', 'sexybookmarks'); ?></label>
							<label><input <?php echo (($sexy_plugopts['reloption'] == "")? 'checked="checked"' : ""); ?> name="reloption" id="reloption-no" type="radio" value="" /> <?php _e('No', 'sexybookmarks'); ?></label>
							<span class="sexy_option"><?php _e('Open links in new window?', 'sexybookmarks'); ?></span>
							<label><input <?php echo (($sexy_plugopts['targetopt'] == "_blank")? 'checked="checked"' : ""); ?> name="targetopt" id="targetopt-blank" type="radio" value="_blank" /> <?php _e('Yes', 'sexybookmarks'); ?></label>
							<label><input <?php echo (($sexy_plugopts['targetopt'] == "_self")? 'checked="checked"' : ""); ?> name="targetopt" id="targetopt-self" type="radio" value="_self" /> <?php _e('No', 'sexybookmarks'); ?></label>
						</div>
					</div>
				</div>
			</li>
			<li>
				<div class="box-mid-head">
					<h2 class="fugue f-pallette"><?php _e('Plugin Aesthetics', 'sexybookmarks'); ?></h2>
				</div>
				<div class="box-mid-body" id="toggle3">
					<div class="padding">
						<div id="custom-mods-notice">
							<h1><?php _e('Warning!', 'sexybookmarks'); ?></h1>
							<p><?php echo __('This option in intended ', 'sexybookmarks ').'<strong>'.__('STRICTLY', 'sexybookmarks').'</strong>'.__(' for users who understand how to edit CSS/JS and intend to change/edit the associated images themselves. Unfortunately, no support will be offered for this feature, as I cannot be held accountable for your coding/image-editing mistakes.', 'sexybookmarks'); ?></p>
							<h3><?php _e('How it works...', 'sexybookmarks'); ?></h3>
							<p><?php _e('Since you have chosen for the plugin to override the style settings with your own custom mods, it will now pull the files from the new folders it is going to create on your server as soon as you save your changes. The file/folder locations should be as follows:', 'sexybookmarks'); ?></p>
							<ul>
								<li class="custom-mods-folder"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods'; ?></a></li>
								<li class="custom-mods-folder"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods/css'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods/css'; ?></a></li>
								<li class="custom-mods-folder"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods/js'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods/js'; ?></a></li>
								<li class="custom-mods-folder"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods/images'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods/images'; ?></a></li>
								<li class="custom-mods-code"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods/js/sexy-bookmarks-public.js'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods/js/sexy-bookmarks-public.js'; ?></a></li>
								<li class="custom-mods-code"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods/css/style.css'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods/css/style.css'; ?></a></li>
								<li class="custom-mods-image"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods/images/sexy-sprite.png'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods/images/sexy-sprite.png'; ?></a></li>
								<li class="custom-mods-image"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods/images/share-enjoy.png'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods/images/share-enjoy.png'; ?></a></li>
								<li class="custom-mods-image"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods/images/share-german.png'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods/images/share-german.png'; ?></a></li>
								<li class="custom-mods-image"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods/images/share-love-hearts.png'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods/images/share-love-hearts.png'; ?></a></li>
								<li class="custom-mods-image"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods/images/share-wealth.png'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods/images/share-wealth.png'; ?></a></li>
								<li class="custom-mods-image"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods/images/sharing-caring-hearts.png'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods/images/sharing-caring-hearts.png'; ?></a></li>
								<li class="custom-mods-image"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods/images/sharing-caring.png'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods/images/sharing-caring.png'; ?></a></li>
								<li class="custom-mods-image"><a href="<?php echo WP_CONTENT_URL.'/sexy-mods/images/sharing-sexy.png'; ?>"><?php echo WP_CONTENT_URL.'/sexy-mods/images/sharing-sexy.png'; ?></a></li>
							</ul>
							<p><?php _e('Once you have saved your changes, you will be able to edit the image sprite that holds all of the icons for SexyBookmarks as well as the CSS which accompanies it. Just be sure that you do in fact edit the CSS if you edit the images, as it is unlikely the heights, widths, and background positions of the images will stay the same after you are done.', 'sexybookmarks'); ?></p>
							<p><?php _e('Just a quick note... When you edit the styles and images to include your own custom backgrounds, icons, and CSS styles, be aware that those changes will not be reflected on the plugin options page. In other words: when you select your networks to be displayed, or when you select the background image to use, it will still be displaying the images from the original plugin directory.', 'sexybookmarks'); ?></p>
							<h3><?php _e('In Case of Emergency', 'sexybookmarks'); ?></h3>
							<p><?php _e('If you happen to mess things up, you can follow these directions to reset the plugin back to normal and try again if you wish:', 'sexybookmarks'); ?></p>
							<ol>
								<li><?php _e('Login to your server via FTP or SSH. (whichever you are more comfortable with)', 'sexybookmarks'); ?></li>
								<li><?php _e('Navigate to your wp-content directory.', 'sexybookmarks'); ?></li>
								<li><?php _e('Delete the directory named "sexy-mods".', 'sexybookmarks'); ?></li>
								<li><?php _e('Login to your WordPress dashboard.', 'sexybookmarks'); ?></li>
								<li><?php _e('Go to the SexyBookmarks plugin options page. (Settings->SexyBookmarks)', 'sexybookmarks'); ?></li>
								<li><?php _e('Deselect the "Use custom mods" option.', 'sexybookmarks'); ?></li>
								<li><?php _e('Save your changes.', 'sexybookmarks'); ?></li>
							</ol>
							<span class="fugue f-delete custom-mods-notice-close"><?php _e('Close Message', 'sexybookmarks'); ?></span>
						</div>
						<div class="custom-mod-check fugue f-plugin">
							<label for="custom-mods" class="sexy_option" style="display:inline;">
								<?php _e('Override Styles With Custom Mods Instead?', 'sexybookmarks'); ?>
							</label>
							<input <?php echo (($sexy_plugopts['custom-mods'] == "yes")? 'checked' : ""); ?> name="custom-mods" id="custom-mods" type="checkbox" value="yes" />
						</div>

						<h2><?php _e('jQuery Related Options', 'sexybookmarks'); ?></h2>
						<span class="sexy_option"><?php _e('Animate-expand multi-lined bookmarks?', 'sexybookmarks'); ?></span>
						<label><input <?php echo (($sexy_plugopts['expand'] == "1")? 'checked="checked"' : ""); ?> name="expand" id="expand-yes" type="radio" value="1" /><?php _e('Yes', 'sexybookmarks'); ?></label>
						<label><input <?php echo (($sexy_plugopts['expand'] != "1")? 'checked="checked"' : ""); ?> name="expand" id="expand-no" type="radio" value="0" /><?php _e('No', 'sexybookmarks'); ?></label>
						<span class="sexy_option"><?php _e('Auto-space/center the bookmarks?', 'sexybookmarks'); ?></span>
						<label><input <?php echo (($sexy_plugopts['autocenter'] == "2")? 'checked="checked"' : ""); ?> name="autocenter" id="autospace-yes" type="radio" value="2" /><?php _e('Space', 'sexybookmarks'); ?></label>
						<label><input <?php echo (($sexy_plugopts['autocenter'] == "1")? 'checked="checked"' : ""); ?> name="autocenter" id="autocenter-yes" type="radio" value="1" /><?php _e('Center', 'sexybookmarks'); ?></label>
						<label><input <?php echo (($sexy_plugopts['autocenter'] == "0")? 'checked="checked"' : ""); ?> name="autocenter" id="autocenter-no" type="radio" value="0" /><?php _e('No', 'sexybookmarks'); ?></label>
						<span class="sexy_option"><?php _e('jQuery Compatibility Fix', 'sexybookmarks'); ?></span>
						<label for="doNotIncludeJQuery"><?php _e("Check this box ONLY if you notice jQuery being loaded twice in your source code!", "sexybookmarks"); ?></label>
						<input type="checkbox" id="doNotIncludeJQuery" name="doNotIncludeJQuery" <?php echo (($sexy_plugopts['doNotIncludeJQuery'] == "1")? 'checked' : ""); ?> value="1" />
						<span class="sexy_option"><?php _e('Load scripts in Footer', 'sexybookmarks'); ?> <input type="checkbox" id="scriptInFooter" name="scriptInFooter" <?php echo (($sexy_plugopts['scriptInFooter'] == "1")? 'checked' : ""); ?> value="1" /></span>
						<label for="scriptInFooter"><?php _e("Check this box if you want the SexyBookmarks javascript to be loaded in your blog's footer.", 'sexybookmarks'); ?> (<a href="http://developer.yahoo.com/performance/rules.html#js_bottom" target="_blank">?</a>)</label>

						<h2><?php _e('Background Image Options', 'sexybookmarks'); ?></h2>
						<span class="sexy_option">
							<?php _e('Use a background image?', 'sexybookmarks'); ?> <input <?php echo (($sexy_plugopts['bgimg-yes'] == "yes")? 'checked' : ""); ?> name="bgimg-yes" id="bgimg-yes" type="checkbox" value="yes" />
						</span>
						<div id="bgimgs" class="<?php if(!isset($sexy_plugopts['bgimg-yes'])) { ?>hidden<?php } else { echo ''; }?>">
							<label class="share-sexy">
								<input <?php echo (($sexy_plugopts['bgimg'] == "sexy")? 'checked="checked"' : ""); ?> id="bgimg-sexy" name="bgimg" type="radio" value="sexy" />
							</label>
							<label class="share-care">
								<input <?php echo (($sexy_plugopts['bgimg'] == "caring")? 'checked="checked"' : ""); ?> id="bgimg-caring" name="bgimg" type="radio" value="caring" />
							</label>
							<label class="share-care-old">
								<input <?php echo (($sexy_plugopts['bgimg'] == "care-old")? 'checked="checked"' : ""); ?> id="bgimg-care-old" name="bgimg" type="radio" value="care-old" />
							</label>
							<label class="share-love">
								<input <?php echo (($sexy_plugopts['bgimg'] == "love")? 'checked="checked"' : ""); ?> id="bgimg-love" name="bgimg" type="radio" value="love" />
							</label>
							<label class="share-wealth">
								<input <?php echo (($sexy_plugopts['bgimg'] == "wealth")? 'checked="checked"' : ""); ?> id="bgimg-wealth" name="bgimg" type="radio" value="wealth" />
							</label>
							<label class="share-enjoy">
								<input <?php echo (($sexy_plugopts['bgimg'] == "enjoy")? 'checked="checked"' : ""); ?> id="bgimg-enjoy" name="bgimg" type="radio" value="enjoy" />
							</label>
							<label class="share-german">
								<input <?php echo (($sexy_plugopts['bgimg'] == "german")? 'checked="checked"' : ""); ?> id="bgimg-german" name="bgimg" type="radio" value="german" />
							</label>
							<label class="share-knowledge">
								<input <?php echo (($sexy_plugopts['bgimg'] == "knowledge")? 'checked="checked"' : ""); ?> id="bgimg-knowledge" name="bgimg" type="radio" value="knowledge" />
							</label>
						</div>
					</div>
				</div>
			</li>
			<li>
				<div class="box-mid-head">
					<h2 class="fugue f-footer"><?php _e('Menu Placement', 'sexybookmarks'); ?></h2>
				</div>
				<div class="box-mid-body" id="toggle5">
					<div class="padding">
						<div class="dialog-box-information" id="info-manual">
							<div class="dialog-left fugue f-info">
								<?php printf(__('Need help with this? Find it in the <a href="%s">official install guide.', 'sexybookmarks'), 'http://sexybookmarks.net/documentation/usage-installation'); ?></a>
							</div>
							<div class="dialog-right">
								<img src="<?php echo SEXY_PLUGPATH; ?>images/information-delete.jpg" class="del-x" alt=""/>
							</div>
						</div>
						<span class="sexy_option"><?php _e('Menu Location (in relation to content):', 'sexybookmarks'); ?></span>
						<label><input <?php echo (($sexy_plugopts['position'] == "above")? 'checked="checked"' : ""); ?> name="position" id="position-above" type="radio" value="above" /> <?php _e('Above Content', 'sexybookmarks'); ?></label>
						<label><input <?php echo (($sexy_plugopts['position'] == "below")? 'checked="checked"' : ""); ?> name="position" id="position-below" type="radio" value="below" /> <?php _e('Below Content', 'sexybookmarks'); ?></label>
						<label><input <?php echo (($sexy_plugopts['position'] == "manual")? 'checked="checked"' : ""); ?> name="position" id="position-manual" type="radio" value="manual" /> <?php _e('Manual Mode', 'sexybookmarks'); ?></label>
						<span class="sexy_option"><?php _e('Posts, pages, or the whole shebang?', 'sexybookmarks'); ?></span>
						<select name="pageorpost" id="pageorpost">
							<?php
								print sexy_select_option_group('pageorpost', array(
									'post'=>__('Posts Only', 'sexybookmarks'),
									'page'=>__('Pages Only', 'sexybookmarks'),
									'index'=>__('Index Only', 'sexybookmarks'),
									'pagepost'=>__('Posts &amp; Pages', 'sexybookmarks'),
									'postindex'=>__('Posts &amp; Index', 'sexybookmarks'),
									'pageindex'=>__('Pages &amp; Index', 'sexybookmarks'),
									'postpageindex'=>__('Posts, Pages, &amp; Index', 'sexybookmarks'),
								));
							?>
						</select><span class="shebang-info fugue f-question" title="<?php _e('Click here for help with this option', 'sexybookmarks'); ?>"> </span>
						<span class="sexy_option"><?php _e('Show in RSS feed?', 'sexybookmarks'); ?></span>
						<label><input <?php echo (($sexy_plugopts['feed'] == "1")? 'checked="checked"' : ""); ?> name="feed" id="feed-show" type="radio" value="1" /> <?php _e('Yes', 'sexybookmarks'); ?></label>
						<label><input <?php echo (($sexy_plugopts['feed'] == "0" || empty($sexy_plugopts['feed']))? 'checked="checked"' : ""); ?> name="feed" id="feed-hide" type="radio" value="0" /> <?php _e('No', 'sexybookmarks'); ?></label>
						<label class="sexy_option" style="margin-top:12px;">
							<?php _e('Hide menu from mobile browsers?', 'sexybookmarks'); ?> <input <?php echo (($sexy_plugopts['mobile-hide'] == "yes")? 'checked' : ""); ?> name="mobile-hide" id="mobile-hide" type="checkbox" value="yes" />
						</label>
						<br />
					</div>
				</div>
			</li>
		</ul>
		<input type="hidden" name="save_changes" value="1" />
		<div class="submit"><input type="submit" value="<?php _e('Save Changes', 'sexybookmarks'); ?>" /></div>
	</form>
</div>
<div id="sexy-col-right">
	<div class="box-right">
		<div class="box-right-head">
			<h3 class="fugue f-info-frame"><?php _e('Helpful Plugin Links', 'sexybookmarks'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<ul class="infolinks">
					<li><a href="http://sexybookmarks.net/documentation/usage-installation" target="_blank"><?php _e('Installation &amp; Usage Guide', 'sexybookmarks'); ?></a></li>
					<li><a href="http://sexybookmarks.net/documentation/faq" target="_blank"><?php _e('Frequently Asked Questions', 'sexybookmarks'); ?></a></li>
					<li><a href="http://sexybookmarks.net/contact-forms/bug-form" target="_blank"><?php _e('Bug Submission Form', 'sexybookmarks'); ?></a></li>
					<li><a href="http://sexybookmarks.net/contact-forms/feature-request" target="_blank"><?php _e('Feature Request Form', 'sexybookmarks'); ?></a></li>
					<li><a href="http://sexybookmarks.net/contact-forms/translation-submission-form" target="_blank"><?php _e('Submit a Translation', 'sexybookmarks'); ?></a></li>
					<li><a href="http://sexybookmarks.net/platforms" target="_blank"><?php _e('Other SexyBookmarks Platforms', 'sexybookmarks'); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="box-right sexy-donation-box" id="sexydonationsbox">
		<div class="box-right-head">
			<h3 class="fugue f-money"><?php _e('Support by Donating', 'sexybookmarks'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<p><?php _e("If you like SexyBookmarks and wish to contribute towards it's continued development, you can use the form below to do so.", "sexybookmarks"); ?></p>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_donations" />
					<input type="hidden" name="business" value="B7A62V9HWUA7N" />
					<input type="hidden" name="item_name" value="<?php _e('SexyBookmarks Development Support' , 'sexybookmarks'); ?>" />
					<input type="hidden" name="no_shipping" value="0">
					<input type="hidden" name="no_note" value="0">
					<input type="hidden" name="cn" value="<?php _e("Please enter the URL you'd like me to link to if you are a top contributor.", "sexyboomarks"); ?>" />
					<input type="hidden" name="return" value="<?php get_sexy_current_location(); ?>" />
					<input type="hidden" name="cbt" value="<?php _e('Return to Your Dashboard' , 'sexybookmarks'); ?>" />
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="lc" value="US">
					<input type="hidden" name="bn" value="PP-BuyNowBF">
					<label><?php _e('Select Preset Amount? ', 'sexybookmarks'); ?>
					<span>$</span> <select name="amount" id="preset-amounts">
						<option value="10">10</option>
						<option value="20" selected>20</option>
						<option value="30">30</option>
						<option value="40">40</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="200">200</option>
						<option value="300">300</option>
						<option value="400">400</option>
						<option value="500">500</option>
					</select> <span>USD</span></label><br /><br />
					<label><?php _e('Enter Custom Amount?', 'sexybookmarks'); ?> <span>$</span> <input type="text" name="amount" size="4" id="custom-amounts"> <span>USD</span></label>
					<br /><br />
					<input type="submit" value="<?php _e('Pay with PayPal!', 'sexybookmarks'); ?>" class="payment">
				</form>
				<form name="sexy-bookmarks" id="no-sponsors" action="" method="post">
					<label id="no-sponsors-label">
						<?php _e('Disable sponsor messages?', 'sexybookmarks'); ?>
						<input <?php if($sexy_plugopts['hide-sponsors'] == "yes") { echo 'checked="checked"'; } ?> name="sexy-hide-sponsors" id="hide-sponsors" type="checkbox" value="yes" />
						<input type="hidden" name="sponsor-form-save" value="1" />
					</label>
				</form>
			</div>
		</div>
	</div>
	<div class="box-right">
		<div class="box-right-head">
			<h3 class="fugue f-medal"><?php _e('Top Supporters', 'sexybookmarks'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<?php
					$sexyContributors = wp_remote_retrieve_body( wp_remote_get('http://sexybookmarks.net/apps/top-contributors.php') );
					echo $sexyContributors;
				?>
			</div>
		</div>
	</div>
	<div class="box-right">
		<div class="box-right-head">
			<h3 class="fugue f-megaphone"><?php _e('Shout-Outs', 'sexybookmarks'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<ul class="credits">
					<li><a href="http://www.pinvoke.com/"><?php _e('Fugue Icons: Pinvoke', 'sexybookmarks'); ?></a></li>
					<li><a href="http://wp-ru.ru/"><?php _e('Original i18n Support: Yuri Gribov', 'sexybookmarks'); ?></a></li>
					<li><a href="http://alisothegeek.com/2009/10/fugue-sprite-css/"><?php _e('Fugue Icon Sprite: Alison Barrett', 'sexybookmarks'); ?></a></li>
					<li><a href="http://wefunction.com/2008/07/function-free-icon-set/"><?php _e('Original Skin Icons: Function', 'sexybookmarks'); ?></a></li>
					<li><a href="http://beerpla.net"><?php _e('Bug Patch: Artem Russakovskii', 'sexybookmarks'); ?></a></li>
					<li><a href="http://kovshenin.com/"><?php _e('bit.ly bug fix: Konstantin Kovshenin', 'sexybookmarks'); ?></a></li>
					<li><a href="http://keremerkan.net/"><?php _e('Custom Sprite Generator: Kerem Erkan', 'sexybookmarks'); ?></a></li>
					<li><a href="http://gaut.am/"><?php _e('Previous Developer: Gautam Gupta', 'sexybookmarks'); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="box-right">
		<div class="box-right-head">
			<h3 class="fugue f-flags"><?php _e('Translation Contributors', 'sexybookmarks'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<ul class="langs">
					<li><a href="http://www.keege.com">CN <?php _e('Translation', 'sexybookmarks'); ?>: Joojen</a></li>
					<li><a href="http://hardwareblog.dk">da-DK <?php _e('Translation', 'sexybookmarks'); ?>: Mads Floe</a></li>
					<li><a href="http://gwegner.de">DE <?php _e('Translation', 'sexybookmarks'); ?>: Gunther Wegner</a></li>
					<li><a href="http://cpcdisseny.net">ES <?php _e('Translation', 'sexybookmarks'); ?>: Javier Pimienta</a></li>
					<li><a href="http://maitremo.fr">FR <?php _e('Translation', 'sexybookmarks'); ?>: Maitre Mo</a></li>
					<li><a href="http://chepelle.altervista.org/wordpress">IT <?php _e('Translation', 'sexybookmarks'); ?>: Carlo Veltri</a></li>
					<li><a href="http://www.giovannizuccaro.it">IT <?php _e('Translation', 'sexybookmarks'); ?>: Giovanni Zuccaro</a></li>
					<li><a href="http://www.gouwefoto.nl">NL <?php _e('Translation', 'sexybookmarks'); ?>: Martin van der Grond</a></li>
					<li><a href="http://www.mediaprod.no">NO <?php _e('Translation', 'sexybookmarks'); ?>: Svend Olaf Olsen</a></li>
					<li><a href="http://www.winnext.com.br">pt-BR <?php _e('Translation', 'sexybookmarks'); ?>: Cadu Silva</a></li>
					<li><a href="http://www.osn.ro">RO <?php _e('Translation', 'sexybookmarks'); ?>: Ghenciu Ciprian</a></li>
					<li><a href="http://wp-ru.ru">RU <?php _e('Translation', 'sexybookmarks'); ?>: Yuri Gribov</a></li>
					<li><a href="http://www.tuguts.com">TR <?php _e('Translation', 'sexybookmarks'); ?>: &#214;mer Taylan Tu&#287;ut</a></li>
					<li><a href="http://www.freegroup.org">zh-TW <?php _e('Translation', 'sexybookmarks'); ?>: Pseric Lin</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php

}//closing brace for function "sexy_settings_page"


//add sidebar link to settings page
add_action('admin_menu', 'sexy_menu_link');
function sexy_menu_link() {
	if (function_exists('add_options_page')) {
		$sexy_admin_page = add_options_page(__('SexyBookmarks', 'sexybookmarks'), 'SexyBookmarks', 'administrator', basename(__FILE__), 'sexy_settings_page');
		add_action( "admin_print_scripts-$sexy_admin_page", 'sexy_admin_scripts' );
		add_action( "admin_print_styles-$sexy_admin_page", 'sexy_admin_styles' );
	}
}

//styles and scripts for admin area
function sexy_admin_scripts() {
	wp_enqueue_script('sexy-bookmarks-js', SEXY_PLUGPATH.'js/sexy-bookmarks.js', array('jquery','jquery-ui-sortable'), SEXY_vNum, true);
}

function sexy_admin_styles() {
	global $sexy_plugopts;

	if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7') !== false)) {
		wp_enqueue_style('ie-old-sexy-bookmarks', SEXY_PLUGPATH.'css/ie7-admin-style.css', false, SEXY_vNum, 'all');
	}
	wp_enqueue_style('sexy-bookmarks', SEXY_PLUGPATH.'css/admin-style.css', false, SEXY_vNum, 'all');
}

// Add the 'Settings' link to the plugin page, taken from yourls plugin by ozh
function sexy_admin_plugin_actions($links) {
	$links[] = '<a href="options-general.php?page=sexy-bookmarks.php"><b>'.__('Settings', 'sexybookmarks').'</b></a>';
	return $links;
}
add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'sexy_admin_plugin_actions', -10);

require_once "includes/public.php";

?>
