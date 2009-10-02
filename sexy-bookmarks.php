<?php
/*
Plugin Name: SexyBookmarks
Plugin URI: http://sexybookmarks.net
Description: SexyBookmarks adds a (X)HTML compliant list of social bookmarking icons to each of your posts. See <a href="options-general.php?page=sexy-bookmarks.php">configuration panel</a> for more settings.
Version: 2.5.4.1
Author: Josh Jones, Norman Yung
Author URI: http://blog2life.net

	Original WP-Social-Bookmark-Plugin Copyright 2009 Saidmade srl (email : g.fazioli@saidmade.com)
	Original Social Bookmarking Menu & SexyBookmarks Plugin Copyright 2009 Josh Jones (email : josh@sexybookmarks.net)
	Additional Developer: Norman Yung (www.robotwithaheart.com), now a full-time part of further development.
	Additional Special Thanks Goes To Kieran Smith (email : undisclosed)

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


define('SEXY_OPTIONS','SexyBookmarks');
define('SEXY_vNum','2.5.4.1');
define('SEXY_WPINC',get_option('siteurl').'/wp-includes');
define('SEXY_WPADMIN',get_option('siteurl').'/wp-admin');


// Check for location modifications in wp-config
if ( !defined('WP_CONTENT_URL') ) {
	define('SEXY_PLUGPATH',get_option('siteurl').'/wp-content/plugins/'.plugin_basename(dirname(__FILE__)).'/');
} else {
	define('SEXY_PLUGPATH',WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/');
} 


// contains all bookmark templates.
require_once 'bookmarks-data.php';

// helper functions for html output.
require_once 'html-helpers.php';

//add defaults to an array
$sexy_plugopts = array(
	'position' => '', // below, above, or manual
	'reloption' => 'nofollow', // 'nofollow', or ''
	'targetopt' => 'blank', // 'blank' or 'self'
	'bgimg-yes' => '', // 'yes' or blank
	'mobile-hide' => '', // 'yes' or blank
	'bgimg' => '', // 'sexy', 'caring', 'wealth'
	'shorty' => 'b2l', // default is http://b2l.me
	'pageorpost' => '',
	'bookmark' => array_keys($sexy_bookmarks_data),
	'xtrastyle' => '',
	'feed' => '1', // 1 or 0
	'expand' => '1',
	'autocenter' => '0',
	'ybuzzcat' => 'science',
	'ybuzzmed' => 'text',
	'twittcat' => '',
	'default_tags' => 'blog', // Random word to prevent the Twittley default tag warning
	'warn-choice' => '',
);

//add to database
add_option(SEXY_OPTIONS, $sexy_plugopts);

//reload
$sexy_plugopts = get_option(SEXY_OPTIONS);


//write settings page
function sexy_settings_page() {
	echo '<h2 class="sexylogo">SexyBookmarks</h2>';
	global $sexy_plugopts, $sexy_bookmarks_data, $wpdb;

	// processing form submission
	$status_message = "";
	$error_message = "";
	if(isset($_POST['save_changes'])) {
		$status_message = __('Your changes have been saved successfully!', 'sexybookmarks').' | '.__('Maybe you would consider ', 'sexybookmarks').'<a href="#sexydonationsbox">'.__('donating', 'sexybookmarks').'</a>?';
		
		$errmsgmap = array(
			'position'=>__('Please choose where you would like the menu to be displayed.', 'sexybookmarks'),
			'bookmark'=>__('You can\'t display the menu if you don\'t choose a few sites to add to it!', 'sexybookmarks'),
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
			$error_message = __('You must first download and activate the', 'sexybookmarks').' <a href="http://wordpress.org/extend/plugins/twitter-friendly-links/">'.__('Twitter Friendly Links Plugin', 'sexybookmarks').'</a> '.__('before hosting your own short URLs...', 'sexybookmarks');
		}
		if (!$error_message) {
			foreach (array(
				'position', 'xtrastyle', 'reloption', 'targetopt', 'bookmark', 
				'shorty', 'pageorpost', 'twittid', 'ybuzzcat', 'ybuzzmed', 
				'twittcat', 'defaulttags', 'bgimg-yes', 'mobile-hide', 'bgimg',
				'feed', 'expand', 'expand', 'autocenter',
			) as $field) $sexy_plugopts[$field]=$_POST[$field];
			/* Short URLs */
				$sexy_plugopts['shortyapi']['bitly']['user'] = $_POST['shortyapiuser-bitly'];
				$sexy_plugopts['shortyapi']['bitly']['key'] = $_POST['shortyapikey-bitly'];
			/* Short URLs End */
			update_option(SEXY_OPTIONS, $sexy_plugopts);
		}
		
		// Check for Tumblr and display error, will use jQuery to remove if exists
		if(in_array('sexy-tumblr', $sexy_plugopts['bookmark'])) {
			$error_message = __('Due to recent API changes by Tumblr, I can no longer offer them as a supported network in the plugin.', 'sexybookmarks');

		}
		// Check for Email link and display error, will use jQuery to remove if exists
		if(in_array('sexy-mail', $sexy_plugopts['bookmark'])) {
			$error_message = __('We\'re currently working on a more sophisticated solution for the email link and will re-enable it when finished.', 'sexybookmarks');
		}

		if ($_POST['clearShortUrls']) {
			$dump=$wpdb->query(" DELETE FROM $wpdb->postmeta WHERE meta_key='_sexybookmarks_shortUrl' OR meta_key='_sexybookmarks_permaHash' ");
			echo  '<div id="warnmessage" class="sexy-warning"><div class="dialog-left"><img src="'.SEXY_PLUGPATH.'images/icons/warning.png" class="dialog-ico" alt=""/>'.$dump.__(' Short URLs have been reset.', 'sexybookmarks').'</div><div class="dialog-right"><img src="'.SEXY_PLUGPATH.'images/icons/warning-delete.jpg" class="del-x" alt=""/></div></div><div style="clear:both;"></div>';
		}
	}

	//if there was an error,
	//display it in my new fancy schmancy divs
	if ($error_message != '') {
		echo '
		<div id="errmessage" class="sexy-error">
			<div class="dialog-left">
				<img src="'.SEXY_PLUGPATH.'images/icons/error.png" class="dialog-ico" alt=""/>
				'.$error_message.'
			</div>
			<div class="dialog-right">
				<img src="'.SEXY_PLUGPATH.'images/icons/error-delete.jpg" class="del-x" alt=""/>
			</div>
		</div>';
	} elseif ($status_message != '') {
		echo '
		<div id="statmessage" class="sexy-success">
			<div class="dialog-left">
				<img src="'.SEXY_PLUGPATH.'images/icons/success.png" class="dialog-ico" alt=""/>
				'.$status_message.'
			</div>
			<div class="dialog-right">
				<img src="'.SEXY_PLUGPATH.'images/icons/success-delete.jpg" class="del-x" alt=""/>
			</div>
		</div>';
	}
	
	// displaying plugin version info
	require_once(ABSPATH.'/wp-admin/includes/plugin-install.php');
	$plug_api = plugins_api('plugin_information', array('slug' => sanitize_title('SexyBookmarks') ));
		if ( is_wp_error($plug_api) ) {
			wp_die($plug_api);
		}
	$latest_version = $plug_api->version;
	$your_version = SEXY_vNum;
	if (empty($status_message) && version_compare($latest_version, $your_version, '>')) {
		echo '
		<div class="sexy-warning" id="yourversion">
			<div class="dialog-left">
				<img src="'.SEXY_PLUGPATH.'images/icons/warning.png" class="dialog-ico" alt=""/>'.
				__('You are using an outdated version of the plugin', 'sexybookmarks').' ('.SEXY_vNum.'), '.__('please update if you wish to enjoy all available features!', 'sexybookmarks').'
			</div>
			<div class="dialog-right">
				<img src="'.SEXY_PLUGPATH.'images/icons/warning-delete.jpg" class="del-x" alt=""/>
			</div>
		</div>'; 	
	} elseif (empty($status_message) && version_compare($latest_version, $your_version, '<')) {
		echo '
		<div class="sexy-information" id="yourversion">
			<div class="dialog-left">
				<img src="'.SEXY_PLUGPATH.'images/icons/information.png" class="dialog-ico" alt=""/>'.
				__('You are using the development version of the plugin', 'sexybookmarks').' ('.SEXY_vNum.__(' beta', 'sexybookmarks').'), '.__('please ', 'sexybookmarks').'<a href="http://sexybookmarks.net/contact-forms/bug-form" target="_blank">'.__('let us know of any bugs', 'sexybookmarks').'</a> '.__('you may encounter!', 'sexybookmarks').
			'</div>
			<div class="dialog-right">
				<img src="'.SEXY_PLUGPATH.'images/icons/information-delete.jpg" class="del-x" alt=""/>
			</div>
		</div>';
	} else { 
		## No action taken since they are obviously the same version 
	}
?>

<form name="sexy-bookmarks" id="sexy-bookmarks" action="" method="post">
	<div id="sexy-col-left">
		<ul id="sexy-sortables">
			<li>
				<div class="box-mid-head" id="iconator">
					<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/globe-plus.png" alt="" class="box-icons" />
					<h2><?php _e('Enabled Networks', 'sexybookmarks'); ?></h2>
						<div class="bnav">
							<a href="javascript:void(null);" class="toggle" id="gle1">
							<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/toggle-plus.png" class="close" alt=""/>
							<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/toggle-min.png" class="open" style="display:none;" alt=""/>
							</a>
						</div>
				</div>
				<div class="box-mid-body iconator" id="toggle1">
					<div class="padding">
						<p><?php _e('Select the Networks to display. Drag to reorder.', 'sexybookmarks'); ?></p>
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
					<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/wrench-screwdriver.png" alt="" class="box-icons" />
					<h2><?php _e('Functionality Settings', 'sexybookmarks'); ?></h2>
						<div class="bnav">
							<a href="javascript:void(null);" class="toggle" id="gle2">
							<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/toggle-plus.png" class="close" alt=""/>
							<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/toggle-min.png" class="open" style="display:none;" alt=""/>
							</a>
						</div>
				</div>
				<div class="box-mid-body" id="toggle2">
					<div class="padding">
						<div class="dialog-box-warning" id="clear-warning">
							<div class="dialog-left">
								<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/warning.png" class="dialog-ico" alt=""/>
								<?php _e('This will clear <u>ALL</u> short URLs. - Are you sure?', 'sexybookmarks'); ?>
							</div>
							<div class="dialog-right">
								<label><input name="warn-choice" id="warn-yes" type="radio" value="yes" /><?php _e('Yes', 'sexybookmarks'); ?></label> &nbsp;<label><input name="warn-choice" id="warn-cancel" type="radio" value="cancel" /><?php _e('Cancel', 'sexybookmarks'); ?></label>
							</div>
						</div>  
						<div id="twitter-defaults">
							<h3><?php _e('Twitter Options:', 'sexybookmarks'); ?></h3>
							<label for="twittid"><?php _e('Twitter ID:', 'sexybookmarks'); ?></label>
							<input type="text" id="twittid" name="twittid" value="<?php echo $sexy_plugopts['twittid']; ?>" />
							<div class="clearbig"></div>
							<label for="shorty"><?php _e('Which URL Shortener?', 'sexybookmarks'); ?></label>
							<select name="shorty" id="shorty">
								<?php
									// output shorty select options
									print sexy_select_option_group('shorty', array(
										'tflp'=>'Twitter Friendly Links Plugin',
										'b2l'=>'http://b2l.me',
										'bitly' => 'http://bit.ly',
										'trim'=>'http://tr.im',
										'rims'=>'http://ri.ms',
										'tinyarrow'=>'http://tinyarro.ws',
										'tiny'=>'http://tinyurl.com',
										'snip'=>'http://snipr.com',
										'supr'=>'http://su.pr',
										'shortto'=>'http://short.to',
										'cligs'=>'http://cli.gs',
									));
								?>
							</select>
							<label for="clearShortUrls" id="clearShortUrlsLabel"><input name="clearShortUrls" id="clearShortUrls" type="checkbox"/><?php _e('Reset all Short URLs', 'sexybookmarks'); ?></label>
							<div id="shortyapimdiv-bitly"<?php if($sexy_plugopts['shorty'] != "bitly") { ?> class="hidden"<?php } ?>>
								<div id="shortyapidiv-bitly">
								    <label for="shortyapiuser-bitly">User ID:</label>
								    <input type="text" id="shortyapiuser-bitly" name="shortyapiuser-bitly" value="<?php echo $sexy_plugopts['shortyapi']['bitly']['user']; ?>" />
								    <label for="shortyapikey-bitly">API Key:</label>
								    <input type="text" id="shortyapikey-bitly" name="shortyapikey-bitly" value="<?php echo $sexy_plugopts['shortyapi']['bitly']['key']; ?>" />
								</div>
							</div>
						<div class="clearbig"></div>
						</div>
						<div id="ybuzz-defaults">
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
							<label for="ybuzzmed">Default Media Type: </label>
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
						<div id="twittley-defaults">
							<h3><?php _e('Twittley Defaults:', 'sexybookmarks'); ?></h3>
							<label for="twittcat"><?php _e('Primary Content Category:', 'sexybookmarks'); ?> </label>
							<select name="twittcat" id="twittcat">
								<?php
									print sexy_select_option_group('twittcat', array(
										'Technology'=>'Technology',
										'World &amp; Business'=>'World &amp; Business',
										'Science'=>'Science',
										'Gaming'=>'Gaming',
										'Lifestyle'=>'Lifestyle',
										'Entertainment'=>'Entertainment',
										'Sports'=>'Sports',
										'Offbeat'=>'Offbeat',
										'Internet'=>'Internet',
									));
								?>
							</select>
							<div class="clearbig"></div>
							<p id="tag-info" class="hidden">
								<?php _e('Enter a comma separated list of general tags which describe your site\'s posts as a whole. Try not to be too specific, as one post may fall into different "tag categories" than other posts.', 'sexybookmarks'); ?><br />
								<?php _e('This list is primarily used as a failsafe in case you forget to enter WordPress tags for a particular post, in which case this list of tags would be used so as to bring at least *somewhat* relevant search queries based on the general tags that you enter here.', 'sexybookmarks'); ?><br /><span title="<?php _e('Click here to close this message', 'sexybookmarks'); ?>" class="dtags-close">[<?php _e('close', 'sexybookmarks'); ?>]</span>
							</p>
							<label for="defaulttags"><?php _e('Default Tags:', 'sexybookmarks'); ?> </label>
							<input type="text" name="defaulttags" id="defaulttags" onblur="if ( this.value == '' ) { this.value = 'enter,default,tags,here'; }" onfocus="if ( this.value == 'enter,default,tags,here' ) { this.value = ''; }" value="<?php echo $sexy_plugopts['defaulttags']; ?>" /><img src="<?php echo SEXY_PLUGPATH; ?>images/icons/question-frame.png" class="dtags-info" title="<?php _e('Click here for help with this option', 'sexybookmarks'); ?>" alt="<?php _e('Click here for help with this option', 'sexybookmarks'); ?>" />
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
					<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/palette.png" alt="" class="box-icons" />
					<h2><?php _e('General Look &amp; Feel', 'sexybookmarks'); ?></h2>
						<div class="bnav">
							<a href="javascript:void(null);" class="toggle" id="gle3">
							<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/toggle-plus.png" class="close" alt=""/>
							<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/toggle-min.png" class="open" style="display:none;" alt=""/>
							</a>
						</div>
				</div>
				<div class="box-mid-body" id="toggle3">
					<div class="padding">
						<div class="dialog-box-warning" id="custom-warning">
							<div class="dialog-left">
								<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/warning.png" class="dialog-ico" alt=""/>
								<?php _e('This will void any custom CSS applied below.', 'sexybookmarks'); ?>
							</div>
							<div class="dialog-right">
								<label><input name="warn-choice" id="custom-warn-yes" type="checkbox" value="ok" /><?php _e('Ok', 'sexybookmarks'); ?></label> 
							</div>
						</div>
						<div class="dialog-box-warning" id="custom-warning-a">
							<div class="dialog-left">
								<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/warning.png" class="dialog-ico" alt=""/>
								<?php _e('This will void any custom CSS applied below.', 'sexybookmarks'); ?>
							</div>
							<div class="dialog-right">
								<label><input name="warn-choice" id="custom-warn-yes-a" type="checkbox" value="ok" /><?php _e('Ok', 'sexybookmarks'); ?></label> 
							</div>
						</div>
						<span class="sexy_option"><?php _e('Animate-expand multi-lined bookmarks?', 'sexybookmarks'); ?></span>
						<label><input <?php echo (($sexy_plugopts['expand'] == "1")? 'checked="checked"' : ""); ?> name="expand" id="expand-yes" type="radio" value="1" /><?php _e('Yes', 'sexybookmarks'); ?></label>
						<label><input <?php echo (($sexy_plugopts['expand'] != "1")? 'checked="checked"' : ""); ?> name="expand" id="expand-no" type="radio" value="0" /><?php _e('No', 'sexybookmarks'); ?></label>
						<span class="sexy_option"><?php _e('Auto-space/center the bookmarks?', 'sexybookmarks'); ?></span>
						<label><input <?php echo (($sexy_plugopts['autocenter'] == "2")? 'checked="checked"' : ""); ?> name="autocenter" id="autospace-yes" type="radio" value="2" /><?php _e('Space', 'sexybookmarks'); ?></label>
						<label><input <?php echo (($sexy_plugopts['autocenter'] == "1")? 'checked="checked"' : ""); ?> name="autocenter" id="autocenter-yes" type="radio" value="1" /><?php _e('Center', 'sexybookmarks'); ?></label>
						<label><input <?php echo (($sexy_plugopts['autocenter'] == "0")? 'checked="checked"' : ""); ?> name="autocenter" id="autocenter-no" type="radio" value="0" /><?php _e('No', 'sexybookmarks'); ?></label>
						<br />
						<br />
						<label for="xtrastyle"><?php _e('You can style the DIV that holds the menu here:', 'sexybookmarks'); ?></label><br/>
						<textarea id="xtrastyle" name="xtrastyle"><?php 
								$default_sexy = "margin:20px 0 0 0 !important;\npadding:25px 0 0 10px !important;\nheight:29px;/*the height of the icons (29px)*/\ndisplay:block !important;\nclear:both !important;";	
								if (!empty($sexy_plugopts['xtrastyle'])) {		
									echo $sexy_plugopts['xtrastyle']; 	
								} 	
								elseif (empty($sexy_plugopts['xtrastyle'])) {
									echo $default_sexy; 
								}
								else { 
									echo __('If you see this message, please delete the contents of this textarea and click \"Save Changes\".', 'sexybookmarks');	
								} ?>
						</textarea>
					</div>
				</div>
			</li>
			<li>
				<div class="box-mid-head">
					<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/image.png" alt="" class="box-icons" />
					<h2><?php _e('Background Image', 'sexybookmarks'); ?></h2>
					<div class="bnav">
						<a href="javascript:void(null);" class="toggle" id="gle4">
							<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/toggle-plus.png" class="close" alt=""/>
							<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/toggle-min.png" class="open" style="display:none;" alt=""/>
						</a>
					</div>
				</div>
				<div class="box-mid-body" id="toggle4">
					<div class="padding">
						<span class="sexy_option">
							<?php _e('Use a background image?', 'sexybookmarks'); ?> <input <?php echo (($sexy_plugopts['bgimg-yes'] == "yes")? 'checked' : ""); ?> name="bgimg-yes" id="bgimg-yes" type="checkbox" value="yes" />
						</span>
						<div id="bgimgs" class="<?php if(!isset($sexy_plugopts['bgimg-yes'])) { ?>hidden<?php } else { echo ''; }?>">
							<label class="bgimg share-sexy">
								<input <?php echo (($sexy_plugopts['bgimg'] == "sexy")? 'checked="checked"' : ""); ?> id="bgimg-sexy" name="bgimg" type="radio" value="sexy" />
							</label>
							<label class="bgimg share-care">
								<input <?php echo (($sexy_plugopts['bgimg'] == "caring")? 'checked="checked"' : ""); ?> id="bgimg-caring" name="bgimg" type="radio" value="caring" />
							</label>
							<label class="bgimg share-care-old">
								<input <?php echo (($sexy_plugopts['bgimg'] == "care-old")? 'checked="checked"' : ""); ?> id="bgimg-care-old" name="bgimg" type="radio" value="care-old" />
							</label>
							<label class="bgimg share-love">
								<input <?php echo (($sexy_plugopts['bgimg'] == "love")? 'checked="checked"' : ""); ?> id="bgimg-love" name="bgimg" type="radio" value="love" />
							</label>
							<label class="bgimg share-wealth">
								<input <?php echo (($sexy_plugopts['bgimg'] == "wealth")? 'checked="checked"' : ""); ?> id="bgimg-wealth" name="bgimg" type="radio" value="wealth" />
							</label>
							<label class="bgimg share-enjoy">
								<input <?php echo (($sexy_plugopts['bgimg'] == "enjoy")? 'checked="checked"' : ""); ?> id="bgimg-enjoy" name="bgimg" type="radio" value="enjoy" />
							</label>
						</div>
					</div>
				</div>
			</li>
			<li>
				<div class="box-mid-head">
					<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/layout-select-footer.png" alt="" class="box-icons" />
					<h2><?php _e('Menu Placement', 'sexybookmarks'); ?></h2>
					<div class="bnav">
						<a href="javascript:void(null);" class="toggle" id="gle5">
							<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/toggle-plus.png" class="close" alt=""/>
							<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/toggle-min.png" class="open" style="display:none;" alt=""/>
						</a>
					</div>
				</div>
				<div class="box-mid-body" id="toggle5">
					<div class="padding">
						<div class="dialog-box-information" id="info-manual">
							<div class="dialog-left">
								<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/information.png" class="dialog-ico" alt=""/>
								<?php _e('Need help with this? Find it in the ', 'sexybookmarks'); ?><a href="http://sexybookmarks.net/documentation/usage-installation"> <?php _e('official install guide', 'sexybookmarks'); ?></a>.
							</div>
							<div class="dialog-right">
								<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/information-delete.jpg" class="del-x" alt=""/>
							</div>
						</div>
						<div class="dialog-box-warning" id="mobile-warn">
							<div class="dialog-left">
								<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/warning.png" class="dialog-ico" alt=""/>
								<?php _e('This feature is still in the experimental phase, so please ', 'sexybookmarks'); ?><a href="http://sexybookmarks.net/contact-forms/bug-form"><?php _e('report any bugs', 'sexybookmarks'); ?></a> <?php _e('you may find', 'sexybookmarks'); ?>.
							</div>
							<div class="dialog-right">
								<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/warning-delete.jpg" class="del-x" alt=""/>
							</div>
						</div> 
						<span class="sexy_option"><?php _e('Menu Location (in relevance to content):', 'sexybookmarks'); ?></span>
						<label><input <?php echo (($sexy_plugopts['position'] == "above")? 'checked="checked"' : ""); ?> name="position" id="position-above" type="radio" value="above" /> <?php _e('Above Content', 'sexybookmarks'); ?></label>
						<label><input <?php echo (($sexy_plugopts['position'] == "below")? 'checked="checked"' : ""); ?> name="position" id="position-below" type="radio" value="below" /> <?php _e('Below Content', 'sexybookmarks'); ?></label>
						<label><input <?php echo (($sexy_plugopts['position'] == "manual")? 'checked="checked"' : ""); ?> name="position" id="position-manual" type="radio" value="manual" /> <?php _e('Manual Mode', 'sexybookmarks'); ?></label>
						<span class="sexy_option"><?php _e('Posts, pages, or the whole shebang?', 'sexybookmarks'); ?></span>
						<select name="pageorpost" id="pageorpost">
							<?php
								print sexy_select_option_group('pageorpost', array(
									'post'=>'Posts Only',
									'page'=>'Pages Only',
									'index'=>'Index Only',
									'pagepost'=>'Posts &amp; Pages',
									'postindex'=>'Posts &amp; Index',
									'pageindex'=>'Pages &amp; Index',
									'postpageindex'=>'Posts, Pages, &amp; Index',
								));
							?>
						</select><img src="<?php echo SEXY_PLUGPATH; ?>images/icons/question-frame.png" class="shebang-info" title="<?php _e('Click here for help with this option', 'sexybookmarks'); ?>" alt="<?php _e('Click here for help with this option', 'sexybookmarks'); ?>" />
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
			<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/plug.png" alt="" class="box-icons" />
			<h3><?php _e('Plugin Info', 'sexybookmarks'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<h4><?php _e('Helpful Plugin Links:', 'sexybookmarks'); ?></h4>
				<ul>
					<li><a href="http://sexybookmarks.net/documentation/usage-installation" target="_blank"><?php _e('Installation &amp; Usage Guide', 'sexybookmarks'); ?></a></li>
					<li><a href="http://sexybookmarks.net/documentation/faq" target="_blank"><?php _e('Frequently Asked Questions', 'sexybookmarks'); ?></a></li>
					<li><a href="http://sexybookmarks.net/contact-forms/bug-form" target="_blank"><?php _e('Bug Submission Form', 'sexybookmarks'); ?></a></li>
					<li><a href="http://sexybookmarks.net/contact-forms/feature-request" target="_blank"><?php _e('Feature Request Form', 'sexybookmarks'); ?></a></li>
					<li><a href="http://sexybookmarks.net/platforms" target="_blank"><?php _e('Other SexyBookmarks Platforms', 'sexybookmarks'); ?></a></li>
					<li><a href="http://sexybookmarks.net/downloads/sexyfox" target="_blank"><?php _e('SexyFox Firefox Toolbar', 'sexybookmarks'); ?></a></li>
				</ul>
				<div class="clearbig"></div>
				<h4><?php _e('Current Plugin Stats:', 'sexybookmarks'); ?></h4>
				<?php
					// getting the plugin stats
					require_once(ABSPATH.'/wp-admin/includes/plugin-install.php');
					$sexy_plugin = 'sexybookmarks';
					$sexy_api = plugins_api('plugin_information', array('slug' => stripslashes( 'sexybookmarks' ) ));
						if ( is_wp_error($sexy_api) )
							wp_die($sexy_api);
					$sexy_latest_version = $sexy_api->version;
					$sexy_updated_ago = sprintf( __('%s ago'), human_time_diff( strtotime( $sexy_api->last_updated ) ) );
					$sexy_downloaded_times = number_format( $sexy_api->downloaded );
					$sexy_plug_rating = ceil( 0.05 * $sexy_api->rating );
					$sexy_num_ratings = number_format( $sexy_api->num_ratings );

					if ($sexy_plug_rating == "0") {
						$sexy_plug_rating_class = "sexy-rating";
					} elseif (1<=$sexy_plug_rating && 5>=$sexy_plug_rating) {
						$sexy_plug_rating_class = "sexy-rating-".$sexy_plug_rating;
					}
				?>
				<ul>
					<li><strong><?php _e('Stable Version:', 'sexybookmarks'); ?></strong> <span><?php echo $sexy_latest_version; ?></span></li>
					<li><strong><?php _e('Last Updated:', 'sexybookmarks'); ?></strong> <span><?php echo $sexy_updated_ago; ?></span></li>
					<li><strong><?php _e('Downloaded:', 'sexybookmarks'); ?></strong> <span><?php echo $sexy_downloaded_times; ?> <?php _e('times', 'sexybookmarks'); ?></span></li>
					<li><strong><?php _e('User Rating:', 'sexybookmarks'); ?></strong> <span class="<?php echo $sexy_plug_rating_class; ?>" title="<?php echo $sexy_plug_rating; ?> <?php _e('stars - Based on', 'sexybookmarks'); ?> <?php echo $sexy_num_ratings; ?> <?php _e('votes', 'sexybookmarks'); ?>"> </span></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="box-right">
		<div class="box-right-head">
			<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/thumb-up.png" alt="" class="box-icons" />
			<h3><?php _e('Plugin Sponsors', 'sexybookmarks'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<ul class="sexy-adslots">
					<li class="sexy-medium-banner">
						<a href="http://blog2life.net/" title="It's coming... Are you ready?" target="_blank" rel="dofollow">
							<img src="http://blog2life.net/images/234x60.png" alt="Free themes and resources to bring your blog to life | Blog2Life" height="60" width="234" />
						</a>
						<a href="http://bingseoguide.com/" title="The definitive guide to the world's first decision engine." target="_blank" rel="dofollow">
							<img src="http://bingseoguide.com/ads/bing-seo-guide-234x60.gif" alt="The definitive guide to the world's first decision engine." height="60" width="234" />
						</a>
						<script type="text/javascript">
							Vertical1240126 = true;
							ShowAdHereBanner1240126 = true;
							RepeatAll1240126 = false;
							NoFollowAll1240126 = false;
							BannerStyles1240126 = new Array(
								"a{display:block;font-size:11px;color:#79939F;font-family:verdana,sans-serif;margin:0 0 10px 1px;text-align:center;text-decoration:none;overflow:hidden;}",
								"img{border:0;clear:right;}",
								"a.adhere{color:#79939F;font-weight:bold;font-size:12px;outline:1px solid #79939F;background:#F2F2F2;text-align:center;height:60px !important;width:234px !important;}",
								"a.adhere:hover{outline:1px solid #68828e;background:#f0f0f0;color:#68828e;}"
							);
							document.write(unescape("%3Cscript src='"+document.location.protocol+"//s3.buysellads.com/1240126/1240126.js?v="+Date.parse(new Date())+"' type='text/javascript'%3E%3C/script%3E"));
						</script>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="box-right sexy-donation-box">
		<div class="box-right-head">
			<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/money-coin.png" alt="" class="box-icons" />
			<h3><?php _e('Support by Donating', 'sexybookmarks'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<p><?php _e('Surely the fact that we\'re making the web a sexier place one blog at a time is worth a drink or three, right?', 'sexybookmarks'); ?></p>
				<div class="sexy-donate-button">
					<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=3415856" title="<?php _e('Help support the development of this plugin by donating!', 'sexybookmarks'); ?>" class="sexy-dew">
						<img src="<?php echo SEXY_PLUGPATH; ?>images/buyjoshdew.png" alt="" />
					</a>
					<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&amp;business=8HGMUBNDCZ88A" title="<?php _e('Help support the development of this plugin by donating!', 'sexybookmarks'); ?>" class="sexy-beer">
						<img src="<?php echo SEXY_PLUGPATH; ?>images/buynormbeer.png" alt="" />
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="box-right">
		<div class="box-right-head">
			<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/currency.png" alt="" class="box-icons" />
			<h3><?php _e('Top Supporters', 'sexybookmarks'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<script language="JavaScript" type="text/javascript">
				<!--
					// Customize the widget by editing the fields below
					// All fields are required

					// Your Feedity RSS feed URL
					feedity_widget_feed = "http://feedity.com/rss.aspx/sexybookmarks-net/UlZXV1RX";

					// Number of items to display in the widget
					feedity_widget_numberofitems = "5";

					// Show feed item published date (values: yes or no)
					feedity_widget_showdate = "no";

					// Widget box width (in px, pt, em, or %)
					feedity_widget_width = "236px";

					// Widget background color in hex or by name (eg: #ffffff or white)
					feedity_widget_backcolor = "#f8f8f8";

					// Widget font/link color in hex or by name (eg: #000000 or black)
					feedity_widget_fontcolor = "#000000";
				//-->
				</script>
				<script language="JavaScript" type="text/javascript" src="http://feedity.com/js/widget.js"></script>
			</div>
		</div>
	</div>
	<div class="box-right">
		<div class="box-right-head">
			<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/megaphone.png" alt="" class="box-icons" />
			<h3><?php _e('Shout-Outs', 'sexybookmarks'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<ul class="credits">
					<li><a href="http://www.pinvoke.com/"><?php _e('GUI Icons by Pinvoke', 'sexybookmarks'); ?></a></li>
					<li><a href="http://wefunction.com/2008/07/function-free-icon-set/"><?php _e('Original Skin Icons by Function', 'sexybookmarks'); ?></a></li>
					<li><a href="http://beerpla.net"><?php _e('Bug Patch by Artem Russakovskii', 'sexybookmarks'); ?></a></li>
					<li><a href="http://gaut.am/"><?php _e('Twitter encoding fix by Gautam Gupta', 'sexybookmarks'); ?></a></li>
					<li><a href="http://wp-ru.ru"><?php _e('Russian translation by Yuri Gribov', 'sexybookmarks'); ?></a></li>
					<li><a href="http://maitremo.fr"><?php _e('French translation by Maitre Mo', 'sexybookmarks'); ?></a></li>
					<li><a href="http://kovshenin.com/"><?php _e('bit.ly bug fix by Konstantin Kovshenin', 'sexybookmarks'); ?></a></li>
					<li><a href="http://mirarifilms.com/"><?php _e('Romanian translation by Ghenciu Ciprian', 'sexybookmarks'); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php

}//closing brace for function "sexy_settings_page"





// Grab required plugin info and format notice
	function sexy_upgrade_notice(){
		require_once(ABSPATH.'/wp-admin/includes/plugin-install.php');
		$plug_api = plugins_api('plugin_information', array('slug' => sanitize_title('SexyBookmarks') ));
		if ( is_wp_error($plug_api) ) {
			wp_die($plug_api);
		}
		$latest_version = $plug_api->version;
		$your_version = SEXY_vNum;
		if (version_compare($latest_version, $your_version, '>')) {
			echo '<div class="error fade below-h2 update-message" style="background:#FFEBE8 !important;margin-top:30px !important;"><p><img src="'.SEXY_PLUGPATH.'images/icons/error.png" style="border:0;padding:0;margin:0 5px -3px 0 !important;" />You\'re using an outdated version of SexyBookmarks! (<strong>v'.SEXY_vNum.'</strong>) Please update to the latest version <a href="http://wordpress.org/extend/plugins/sexybookmarks/download/"><strong>v'.$latest_version.'</strong></a> to help reduce support requests.</p></div>';
		}
	}

// Display notice if versions don't match
add_action( 'admin_notices', 'sexy_upgrade_notice');


//add sidebar link to settings page
add_action('admin_menu', 'sexy_menu_link');
function sexy_menu_link() {
	if (function_exists('add_options_page')) {
		$sexy_admin_page = add_options_page('SexyBookmarks', 'SexyBookmarks', 9, basename(__FILE__), 'sexy_settings_page');
		add_action( "admin_print_scripts-$sexy_admin_page", 'sexy_admin_scripts' );
		add_action( "admin_print_styles-$sexy_admin_page", 'sexy_admin_styles' );
	}	
}

//styles and scripts for admin area
function sexy_admin_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('sexy-bookmarks-js', SEXY_PLUGPATH.'js/sexy-bookmarks.js', array('jquery-ui-sortable'), SEXY_vNum);
}
function sexy_admin_styles() {
	function detect7() {
		if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7') !== false))
			return true;
			else
				return false;
	}
	function detect8()
		{
			if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8') !== false))
				return true;
				else
					return false;
		}

	if (detect7()) {
		wp_enqueue_style('sexy-bookmarks', SEXY_PLUGPATH.'css/admin-style.css', false, SEXY_vNum, 'all');
		wp_print_styles('sexy-bookmarks');
		wp_enqueue_style('ie-sexy-bookmarks', SEXY_PLUGPATH.'css/ie7-admin-style.css', false, SEXY_vNum, 'all');
		wp_print_styles('ie-sexy-bookmarks');
	}
	elseif (detect8()) {
		wp_enqueue_style('sexy-bookmarks', SEXY_PLUGPATH.'css/admin-style.css', false, SEXY_vNum, 'all');
		wp_print_styles('sexy-bookmarks');
		wp_enqueue_style('sexy-bookmarks', SEXY_PLUGPATH.'css/ie8-admin-style.css', false, SEXY_vNum, 'all');
		wp_print_styles('sexy-bookmarks');
	}
	else {
		wp_enqueue_style('sexy-bookmarks', SEXY_PLUGPATH.'css/admin-style.css', false, SEXY_vNum, 'all');
		wp_print_styles('sexy-bookmarks');
	}
}


require_once "public.php";

?>