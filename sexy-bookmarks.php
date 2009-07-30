<?php
/*
Plugin Name: SexyBookmarks
Plugin URI: http://eight7teen.com/sexy-bookmarks
Description: SexyBookmarks adds a (X)HTML compliant list of social bookmarking icons to each of your posts. See <a href="options-general.php?page=sexy-bookmarks.php">configuration panel</a> for more settings.
Version: 2.5.3b
Author: Josh Jones, Norman Yung
Author URI: http://eight7teen.com

	Original WP-Social-Bookmark-Plugin Copyright 2009 Saidmade srl (email : g.fazioli@saidmade.com)
	Original Social Bookmarking Menu & SexyBookmarks Plugin Copyright 2009 Eight7Teen (email : josh@eight7teen.com)
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

define('SEXY_OPTIONS','SexyBookmarks');
define('SEXY_vNum','2.5.3b');
define('SEXY_WPINC',get_option('siteurl').'/wp-includes');
define('SEXY_PLUGPATH',get_option('siteurl').'/wp-content/plugins/'.plugin_basename(dirname(__FILE__)).'/');
define('SEXY_WPADMIN',get_option('siteurl').'/wp-admin');

require_once('bookmarks-data.php');


//add defaults to an array
$sexy_plugopts = array(
	'position' => '', // below, above, or manual
	'reloption' => 'nofollow', // 'nofollow', or ''
	'targetopt' => 'blank', // 'blank' or 'self'
	'bgimg-yes' => '', // 'yes' or blank
	'bgimg' => '', // 'sexy', 'caring', 'wealth'
	'shorty' => 'e7t', // default is http://e7t.us
	'pageorpost' => '',
	'bookmark' => array_keys($sexy_bookmarks_data),
	'xtrastyle' => '',
	'feed' => '1', // 1 or 0
	'expand' => '1',
	'autocenter' => '0',
	'ybuzzcat' => 'science',
	'ybuzzmed' => 'text',
	'twittcat' => '',
	'default_tags' => '',
	'warn-choice' => '',
);


//add 2 db
add_option(SEXY_OPTIONS, $sexy_plugopts);

//reload
$sexy_plugopts = get_option(SEXY_OPTIONS);

//add sidebar link to settings page
function sexy_menu_link() {
	if (function_exists('add_options_page')) {
		add_options_page('SexyBookmarks', 'SexyBookmarks', 9, basename(__FILE__), 'sexy_settings_page');
	}
	
}


function sexy_network_input_select($name, $hint) {
	global $sexy_plugopts;
	return sprintf('<label class="%s" title="%s"><input %sname="bookmark[]" type="checkbox" value="%s"  id="%s" /></label>',
		$name,
		$hint,
		@in_array($name, $sexy_plugopts['bookmark'])?'checked="checked" ':"",
		$name,
		$name
	);
}

//write settings page
function sexy_settings_page() {

	echo '<h2 class="sexylogo">SexyBookmarks</h2>';

	global $sexy_plugopts, $sexy_bookmarks_data, $wpdb;

	// Rotate through both authors' donation links so that donations will be fully unbiased as the user won't know which link belongs to who...
	$donations = array(
		"https://www.paypal.com/cgi-bin/webscr?cmd=_donations&amp;business=8HGMUBNDCZ88A",
		"https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=3415856"
	);
	$donate_link = $donations[rand(0, count($donations) - 1)];

	// processing form submission
	$status_message = "";
	$error_message = "";
	if(isset($_POST['save_changes'])) {
		$status_message = 'Your changes have been saved successfully! | Maybe you would consider <a href="'.$donate_link.'">donating</a>?';
		
		//was there an error?
		if($_POST['position'] == '') {		
			$error_message = 'Please choose where you would like the menu to be displayed.';
		}
		elseif($_POST['bookmark'] == '') {
			$error_message = 'You can\'t display the menu if you don\'t choose a few sites to add to it!';
		}
		elseif($_POST['pageorpost'] == '') {
			$error_message = 'Please choose where you want the menu displayed.';
		}
		elseif($_POST['twittcat'] == '' && in_array('sexy-twittley', $sexy_plugopts['bookmark'])) {
			$error_message = 'You need to select the primary category for any articles submitted to Twittley.';
		}
		elseif($_POST['defaulttags'] == '' && in_array('sexy-twittley', $sexy_plugopts['bookmark'])) {
			$error_message = 'You need to set at least 1 default tag for any articles submitted to Twittley.';
		}
		elseif($_POST['shorty'] == 'tflp' && !function_exists('permalink_to_twitter_link')) { // check to see if they have the plugin activated
			$error_message = "You must first download and activate <a href=\"http://wordpress.org/extend/plugins/twitter-friendly-links/\">Twitter Friendly Links Plugin</a> before hosting your own short URLs...";
		}
		else {
			$sexy_plugopts['position'] = $_POST['position'];
			$sexy_plugopts['xtrastyle'] = $_POST['xtrastyle'];
			$sexy_plugopts['reloption'] = $_POST['reloption'];
			$sexy_plugopts['targetopt'] = $_POST['targetopt'];
			$sexy_plugopts['bookmark'] = $_POST['bookmark'];
			$sexy_plugopts['shorty'] = $_POST['shorty'];
			$sexy_plugopts['pageorpost'] = $_POST['pageorpost'];
			$sexy_plugopts['twittid'] = $_POST['twittid'];
			$sexy_plugopts['ybuzzcat'] = $_POST['ybuzzcat'];
			$sexy_plugopts['ybuzzmed'] = $_POST['ybuzzmed'];
			$sexy_plugopts['twittcat'] = $_POST['twittcat'];
			$sexy_plugopts['defaulttags'] = $_POST['defaulttags'];
			$sexy_plugopts['bgimg-yes'] = $_POST['bgimg-yes'];
			$sexy_plugopts['bgimg'] = $_POST['bgimg'];
			$sexy_plugopts['feed'] = $_POST['feed'];
			$sexy_plugopts['expand'] = $_POST['expand'];
			$sexy_plugopts['autocenter'] = $_POST['autocenter'];
			update_option(SEXY_OPTIONS, $sexy_plugopts);
		}
		
		// Check for Tumblr and display error, will use jQuery to remove if exists
		if(in_array('sexy-tumblr', $sexy_plugopts['bookmark'])) {
			$error_message = "Due to recent API changes by Tumblr, I can no longer offer them as a supported network in the plugin.";
		}


		if ($_POST['clearShortUrls']) {
			$dump=$wpdb->query(" DELETE FROM $wpdb->postmeta WHERE meta_key='_sexybookmarks_shortUrl' OR meta_key='_sexybookmarks_permaHash' ");
			echo  '<div id="message" class="sexy-warning"><div class="dialog-left"><img src="'.SEXY_PLUGPATH.'images/icons/warning.png" class="dialog-ico" alt=""/>'.$dump.' Short URLs have been reset.</div><div class="dialog-right"><img src="'.SEXY_PLUGPATH.'images/icons/warning-delete.jpg" class="del-x" alt=""/></div></div><div style="clear:both;"></div>';
		}
	}

	//if there was an error,
	//display it in my new fancy schmancy divs
	if ($error_message != '') {
		echo '
		<div id="message" class="sexy-error">
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
		<div id="message" class="sexy-success">
			<div class="dialog-left">
				<img src="'.SEXY_PLUGPATH.'images/icons/success.png" class="dialog-ico" alt=""/>
				'.$status_message.'
			</div>
			<div class="dialog-right">
				<img src="'.SEXY_PLUGPATH.'images/icons/success-delete.jpg" class="del-x" alt=""/>
			</div>
		</div>';
	}

require_once(ABSPATH.'/wp-admin/includes/plugin-install.php');
$plugin = 'SexyBookmarks';
$plug_api = plugins_api('plugin_information', array('slug' => sanitize_title($plugin) ));
	if ( is_wp_error($plug_api) ) {
		wp_die($plug_api);
	}
$latest_version = $plug_api->version;
$your_version = SEXY_vNum;

if (empty($status_message) && version_compare($latest_version, $your_version, '>')) {

	echo '
	<div class="sexy-warning" id="yourversion">
		<div class="dialog-left">
			<img src="'.SEXY_PLUGPATH.'images/icons/warning.png" class="dialog-ico" alt=""/>
			You are using an outdated version of the plugin ('.SEXY_vNum.'), please update if you wish to enjoy all available features!
		</div>
		<div class="dialog-right">
			<img src="'.SEXY_PLUGPATH.'images/icons/warning-delete.jpg" class="del-x" alt=""/>
		</div>
	</div>'; 	
}
elseif (empty($status_message) && version_compare($latest_version, $your_version, '<')) {
	echo '
	<div class="sexy-information" id="yourversion">
		<div class="dialog-left">
			<img src="'.SEXY_PLUGPATH.'images/icons/information.png" class="dialog-ico" alt=""/>
			You are using the development version of the plugin ('.SEXY_vNum.' beta), please <a href="http://sexybookmarks.net/contact-forms/bug-form" target="_blank">let us know of any bugs</a> you may encounter!
		</div>
		<div class="dialog-right">
			<img src="'.SEXY_PLUGPATH.'images/icons/information-delete.jpg" class="del-x" alt=""/>
		</div>
	</div>'; 
}
else { 
	## No action taken since they are obviously the same version 
}
?>

<form name="sexy-bookmarks" id="sexy-bookmarks" action="" method="post">
	<div id="sexy-col-left">
		<ul id="sexy-sortables">
			<li>
				<div class="box-mid-head" id="iconator">
					<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/globe-plus.png" alt="" class="box-icons" />
					<h2>Enabled Networks</h2>
						<div class="bnav">
							<a href="javascript:void(null);" class="toggle" id="gle1">
							<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/toggle-plus.png" class="close" alt=""/>
							<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/toggle-min.png" class="open" style="display:none;" alt=""/>
							</a>
						</div>
				</div>
				<div class="box-mid-body iconator" id="toggle1">
					<div class="padding">
						<p>Select the Networks to display. Drag to reorder.</p>
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
					<h2>Functionality Settings</h2>
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
								This will clear <u>ALL</u> short URLs. - Are you sure?
							</div>
							<div class="dialog-right">
								<label><input name="warn-choice" id="warn-yes" type="radio" value="yes" />Yes</label> &nbsp;<label><input name="warn-choice" id="warn-cancel" type="radio" value="cancel" />Cancel</label>
							</div>
						</div>  
						<div id="twitter-defaults">
							<h3>Twitter Options:</h3>
							<label for="twittid">Twitter ID:</label>
							<input type="text" id="twittid" name="twittid" value="<?php echo $sexy_plugopts['twittid']; ?>" />
							<div class="clearbig"></div>
							<label for="shorty">Which URL Shortener?</label>
							<select name="shorty" id="shorty">
								<option <?php echo (($socialit_plugopts['shorty'] == "e7t")? 'selected="selected"' : ""); ?> value="e7t">http://e7t.us</option>
								<option <?php echo (($socialit_plugopts['shorty'] == "trim")? 'selected="selected"' : ""); ?> value="trim">http://tr.im</option>
								<option <?php echo (($socialit_plugopts['shorty'] == "rims")? 'selected="selected"' : ""); ?> value="rims">http://ri.ms</option>
								<option <?php echo (($socialit_plugopts['shorty'] == "tinyarrow")? 'selected="selected"' : ""); ?> value="tinyarrow">http://tinyarro.ws</option>
								<option <?php echo (($socialit_plugopts['shorty'] == "tiny")? 'selected="selected"' : ""); ?> value="tiny">http://tinyurl.com</option>
								<option <?php echo (($socialit_plugopts['shorty'] == "snip")? 'selected="selected"' : ""); ?> value="snip">http://snipr.com</option>
								<option <?php echo (($socialit_plugopts['shorty'] == "supr")? 'selected="selected"' : ""); ?> value="supr">http://su.pr</option>
								<option <?php echo (($socialit_plugopts['shorty'] == "shortto")? 'selected="selected"' : ""); ?> value="shortto">http://short.to</option>
								<option <?php echo (($socialit_plugopts['shorty'] == "cligs")? 'selected="selected"' : ""); ?> value="cligs">http://cli.gs</option>
							</select>
							<label for="clearShortUrls" id="clearShortUrlsLabel"><input name="clearShortUrls" id="clearShortUrls" type="checkbox"/>Reset all Short URLs</label>
						<div class="clearbig"></div>
						</div>
						<div id="ybuzz-defaults">
							<h3>Yahoo! Buzz Defaults:</h3>
							<label for="ybuzzcat">Default Content Category: </label>
							<select name="ybuzzcat" id="ybuzzcat">
								<option <?php echo (($sexy_plugopts['ybuzzcat'] == "entertainment")? 'selected="selected"' : ""); ?> value="entertainment">Entertainment</option>
								<option <?php echo (($sexy_plugopts['ybuzzcat'] == "lifestyle")? 'selected="selected"' : ""); ?> value="lifestyle">Lifestyle</option>
								<option <?php echo (($sexy_plugopts['ybuzzcat'] == "health")? 'selected="selected"' : ""); ?> value="health">Health</option>
								<option <?php echo (($sexy_plugopts['ybuzzcat'] == "usnews")? 'selected="selected"' : ""); ?> value="usnews">U.S. News</option>
								<option <?php echo (($sexy_plugopts['ybuzzcat'] == "business")? 'selected="selected"' : ""); ?> value="business">Business</option>
								<option <?php echo (($sexy_plugopts['ybuzzcat'] == "politics")? 'selected="selected"' : ""); ?> value="politics">Politics</option>
								<option <?php echo (($sexy_plugopts['ybuzzcat'] == "science")? 'selected="selected"' : ""); ?> value="science">Sci/Tech</option>
								<option <?php echo (($sexy_plugopts['ybuzzcat'] == "world_news")? 'selected="selected"' : ""); ?> value="world_news">World</option>
								<option <?php echo (($sexy_plugopts['ybuzzcat'] == "sports")? 'selected="selected"' : ""); ?> value="sports">Sports</option>
								<option <?php echo (($sexy_plugopts['ybuzzcat'] == "travel")? 'selected="selected"' : ""); ?> value="travel">Travel</option>
							</select>
							<div class="clearbig"></div>
							<label for="ybuzzmed">Default Media Type: </label>
							<select name="ybuzzmed" id="ybuzzmed">
								<option <?php echo (($sexy_plugopts['ybuzzmed'] == "text")? 'selected="selected"' : ""); ?> value="text">Text</option>
								<option <?php echo (($sexy_plugopts['ybuzzmed'] == "image")? 'selected="selected"' : ""); ?> value="image">Image</option>
								<option <?php echo (($sexy_plugopts['ybuzzmed'] == "audio")? 'selected="selected"' : ""); ?> value="audio">Audio</option>
								<option <?php echo (($sexy_plugopts['ybuzzmed'] == "video")? 'selected="selected"' : ""); ?> value="video">Video</option>
							</select>
						<div class="clearbig"></div>
						</div>
						<div id="twittley-defaults">
							<h3>Twittley Defaults:</h3>
							<label for="twittcat">Primary Content Category: </label>
							<select name="twittcat" id="twittcat">
								<option <?php echo (($sexy_plugopts['twittcat'] == "Technology")? 'selected="selected"' : ""); ?> value="Technology">Technology</option>
								<option <?php echo (($sexy_plugopts['twittcat'] == "World &amp; Business")? 'selected="selected"' : ""); ?> value="World &amp; Business">World &amp; Business</option>
								<option <?php echo (($sexy_plugopts['twittcat'] == "Science")? 'selected="selected"' : ""); ?> value="Science">Science</option>
								<option <?php echo (($sexy_plugopts['twittcat'] == "Gaming")? 'selected="selected"' : ""); ?> value="Gaming">Gaming</option>
								<option <?php echo (($sexy_plugopts['twittcat'] == "Lifestyle")? 'selected="selected"' : ""); ?> value="Lifestyle">Lifestyle</option>
								<option <?php echo (($sexy_plugopts['twittcat'] == "Entertainment")? 'selected="selected"' : ""); ?> value="Entertainment">Entertainment</option>
								<option <?php echo (($sexy_plugopts['twittcat'] == "Sports")? 'selected="selected"' : ""); ?> value="Sports">Sports</option>
								<option <?php echo (($sexy_plugopts['twittcat'] == "Offbeat")? 'selected="selected"' : ""); ?> value="Offbeat">Offbeat</option>
								<option <?php echo (($sexy_plugopts['twittcat'] == "Internet")? 'selected="selected"' : ""); ?> value="Internet">Internet</option>
							</select>
							<div class="clearbig"></div>
							<p id="tag-info" class="hidden">
								Enter a comma separated list of general tags which describe your site's posts as a whole. Try not to be too specific, as one post may fall into different "tag categories" than other posts.<br />								
								This list is primarily used as a failsafe in case you forget to enter WordPress tags for a particular post, in which case this list of tags would be used so as to bring at least *somewhat* relevant search queries based on the general tags that you enter here.<br /><span title="Click here to close this message" class="dtags-close">[close]</span>
							</p>
							<label for="defaulttags">Default Tags: </label>
							<input type="text" name="defaulttags" id="defaulttags" value="<?php echo $sexy_plugopts['defaulttags']; ?>" /><img src="<?php echo SEXY_PLUGPATH; ?>images/icons/question-frame.png" class="dtags-info" title="Click here for help with this option" alt="Click here for help with this option" />
							<div class="clearbig"></div>
						</div>
						<div id="genopts">
							<h3>General Functionality Options:</h3>
							<span class="sexy_option">Add nofollow to the links?</span>
							<label><input <?php echo (($sexy_plugopts['reloption'] == "nofollow")? 'checked="checked"' : ""); ?> name="reloption" id="reloption-yes" type="radio" value="nofollow" /> Yes</label>
							<label><input <?php echo (($sexy_plugopts['reloption'] == "")? 'checked="checked"' : ""); ?> name="reloption" id="reloption-no" type="radio" value="" /> No</label>
							<span class="sexy_option">Open links in new window?</span>
							<label><input <?php echo (($sexy_plugopts['targetopt'] == "_blank")? 'checked="checked"' : ""); ?> name="targetopt" id="targetopt-blank" type="radio" value="_blank" /> Yes</label>
							<label><input <?php echo (($sexy_plugopts['targetopt'] == "_self")? 'checked="checked"' : ""); ?> name="targetopt" id="targetopt-self" type="radio" value="_self" /> No</label>
						</div>
					</div>
				</div>
			</li>
			<li>
				<div class="box-mid-head">
					<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/palette.png" alt="" class="box-icons" />
					<h2>General Look &amp; Feel</h2>
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
								This will void any custom CSS applied below.
							</div>
							<div class="dialog-right">
								<label><input name="warn-choice" id="custom-warn-yes" type="checkbox" value="ok" />Ok</label> 
							</div>
						</div>
						<span class="sexy_option">Animate-expand multi-lined bookmarks?</span>
						<label><input <?php echo (($sexy_plugopts['expand'] == "1")? 'checked="checked"' : ""); ?> name="expand" id="expand-yes" type="radio" value="1" />Yes</label>
						<label><input <?php echo (($sexy_plugopts['expand'] != "1")? 'checked="checked"' : ""); ?> name="expand" id="expand-no" type="radio" value="0" />No</label>
						<span class="sexy_option">Auto-center the bookmarks?</span>
						<label><input <?php echo (($sexy_plugopts['autocenter'] == "1")? 'checked="checked"' : ""); ?> name="autocenter" id="autocenter-yes" type="radio" value="1" />Yes</label>
						<label><input <?php echo (($sexy_plugopts['autocenter'] != "1")? 'checked="checked"' : ""); ?> name="autocenter" id="autocenter-no" type="radio" value="0" />No</label>
						<br />
						<br />
						<label for="xtrastyle">You can style the DIV that holds the menu here:</label><br/>
						<textarea id="xtrastyle" name="xtrastyle"><?php 
								$default_sexy = "margin:20px 0 0 0 !important;\npadding:25px 0 0 10px !important;\nheight:29px;/*the height of the icons (29px)*/\ndisplay:block !important;\nclear:both !important;";	
								if (!empty($sexy_plugopts['xtrastyle'])) {		
									echo $sexy_plugopts['xtrastyle']; 	
								} 	
								elseif (empty($sexy_plugopts['xtrastyle'])) {
									echo $default_sexy; 
								}
								else { 
									echo "If you see this message, please delete the contents of this textarea and click \"Save Changes\".";	
								} ?>
						</textarea>
					</div>
				</div>
			</li>
			<li>
				<div class="box-mid-head">
					<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/image.png" alt="" class="box-icons" />
					<h2>Background Image</h2>
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
							Use a background image? <input <?php echo (($sexy_plugopts['bgimg-yes'] == "yes")? 'checked' : ""); ?> name="bgimg-yes" id="bgimg-yes" type="checkbox" value="yes" />
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
						</div>
					</div>
				</div>
			</li>
			<li>
				<div class="box-mid-head">
					<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/layout-select-footer.png" alt="" class="box-icons" />
					<h2>Menu Placement</h2>
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
								Need help with this? Find it in the <a href="http://sexybookmarks.net/documentation/usage-installation"> official install guide</a>.
							</div>
							<div class="dialog-right">
								<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/information-delete.jpg" class="del-x" alt=""/>
							</div>
						</div> 
						<span class="sexy_option">Menu Location (in relevance to content):</span>
						<label><input <?php echo (($sexy_plugopts['position'] == "above")? 'checked="checked"' : ""); ?> name="position" id="position-above" type="radio" value="above" /> Above Content</label>
						<label><input <?php echo (($sexy_plugopts['position'] == "below")? 'checked="checked"' : ""); ?> name="position" id="position-below" type="radio" value="below" /> Below Content</label>
						<label><input <?php echo (($sexy_plugopts['position'] == "manual")? 'checked="checked"' : ""); ?> name="position" id="position-manual" type="radio" value="manual" /> Manual Mode</label>
						<span class="sexy_option">Posts, pages, or the whole shebang?</span>
						<select name="pageorpost" id="pageorpost">
							<option <?php echo (($sexy_plugopts['pageorpost'] == "post")? 'selected="selected"' : ""); ?> value="post">Posts Only</option>
							<option <?php echo (($sexy_plugopts['pageorpost'] == "page")? 'selected="selected"' : ""); ?> value="page">Pages Only</option>
							<option <?php echo (($sexy_plugopts['pageorpost'] == "index")? 'selected="selected"' : ""); ?> value="index">Index Only</option>
							<option <?php echo (($sexy_plugopts['pageorpost'] == "pagepost")? 'selected="selected"' : ""); ?> value="pagepost">Posts &amp; Pages</option>
							<option <?php echo (($sexy_plugopts['pageorpost'] == "postindex")? 'selected="selected"' : ""); ?> value="postindex">Posts &amp; Index</option>
							<option <?php echo (($sexy_plugopts['pageorpost'] == "pageindex")? 'selected="selected"' : ""); ?> value="pageindex">Pages &amp; Index</option>
							<option <?php echo (($sexy_plugopts['pageorpost'] == "postpageindex")? 'selected="selected"' : ""); ?> value="postpageindex" title="THE WHOLE SHEBANG!">Posts, Pages, &amp; Index</option>
						</select><img src="<?php echo SEXY_PLUGPATH; ?>images/icons/question-frame.png" class="shebang-info" title="Click here for help with this option" alt="Click here for help with this option" />
						<span class="sexy_option">Show in RSS feed?</span>
						<label><input <?php echo (($sexy_plugopts['feed'] == "1")? 'checked="checked"' : ""); ?> name="feed" id="feed-show" type="radio" value="1" /> Yes</label>
						<label><input <?php echo (($sexy_plugopts['feed'] == "0" || empty($sexy_plugopts['feed']))? 'checked="checked"' : ""); ?> name="feed" id="feed-hide" type="radio" value="0" /> No</label>
					</div>
				</div>
			</li>
		</ul>
		<input type="hidden" name="save_changes" value="1" />
		<div class="submit"><input type="submit" value="Save Changes" /></div>
	</form>
</div>

<div id="sexy-col-right">
	<div class="box-right">
		<div class="box-right-head">
			<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/plug.png" alt="" class="box-icons" />
			<h3>Plugin Info</h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<h4>Helpful Plugin Links:</h4>
				<ul>
					<li><a href="http://sexybookmarks.net/documentation/usage-installation" target="_blank">Installation &amp; Usage Guide</a></li>
					<li><a href="http://sexybookmarks.net/documentation/faq" target="_blank">Frequently Asked Questions</a></li>
					<li><a href="http://sexybookmarks.net/contact-forms/bug-form" target="_blank">Bug Submission Form</a></li>
					<li><a href="http://sexybookmarks.net/contact-forms/feature-request" target="_blank">Feature Request Form</a></li>
					<li><a href="http://sexybookmarks.net/platforms" target="_blank">Other SexyBookmarks Platforms</a></li>
					<li><a href="http://sexybookmarks.net/downloads/sexyfox" target="_blank">SexyFox Firefox Toolbar</a></li>
				</ul>
				<div class="clearbig"></div>
				<h4>Current Plugin Stats:</h4>
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
					}
					elseif ($sexy_plug_rating == "1") {
						$sexy_plug_rating_class = "sexy-rating-1";
					}
					elseif ($sexy_plug_rating == "2") {
						$sexy_plug_rating_class = "sexy-rating-2";
					}
					elseif ($sexy_plug_rating == "3") {
						$sexy_plug_rating_class = "sexy-rating-3";
					}
					elseif ($sexy_plug_rating == "4") {
						$sexy_plug_rating_class = "sexy-rating-4";
					}
					elseif ($sexy_plug_rating == "5") {
						$sexy_plug_rating_class = "sexy-rating-5";
					}
				?>
				<ul>
					<li><strong>Stable Version:</strong> <span><?php echo $sexy_latest_version; ?></span></li>
					<li><strong>Last Updated:</strong> <span><?php echo $sexy_updated_ago; ?></span></li>
					<li><strong>Downloaded:</strong> <span><?php echo $sexy_downloaded_times; ?> times</span></li>
					<li><strong>User Rating:</strong> <span class="<?php echo $sexy_plug_rating_class; ?>" title="<?php echo $sexy_plug_rating; ?> stars - Based on <?php echo $sexy_num_ratings; ?> votes"> </span></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="box-right">
		<div class="box-right-head">
			<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/thumb-up.png" alt="" class="box-icons" />
			<h3>Plugin Sponsors</h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<ul class="sexy-adslots">
					<li class="sexy-medium-banner">
						<script type="text/javascript">
							Vertical1240126 = true;
							ShowAdHereBanner1240126 = true;
							RepeatAll1240126 = true;
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
			<h3>Support by Donating</h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<p>So we've got big plans for SexyBookmarks, but we can't implement any of them without the proper funding!</p>
				<p>I'm sure you're aware that the development of and continued support for this plugin is a <i>non-paying</i> <b>job</b>, and as such, all donations or contributions are greatly appreciated!</p>
				<div class="sexy-donate-button">
					<a href="<?php echo $donate_link; ?>" title="Help support the development of this plugin by donating!" class="sexy-buttons">
						Make Donation
					</a>
					<a href="#" title="Close this box and leave me alone!" class="sexy-buttons boxcloser">
						Close This Box
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="box-right">
		<div class="box-right-head">
			<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/currency.png" alt="" class="box-icons" />
			<h3>Top Supporters</h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<ol>
					<li><a href="http://webhostingsearch.com">Web Hosting Search</a><span>$55<sup><u>00</u></sup></span></li>
					<li><a href="http://twittley.com">Joel Vaillancourt</a><span>$25<sup><u>00</u></sup></span></li>
					<li><a href="http://stephenbaugh.com">Stephen Baugh</a><span>$15<sup><u>00</u></sup></span></li>
					<li><a href="http://www.blissportraiture.com/">Kimberly Hill</a><span>$10<sup><u>00</u></sup></span></li>
					<li><a href="http://go-adventuresports.com">GO-AdventureSports</a><span>$10<sup><u>00</u></sup></span></li>
				</ol>
			</div>
		</div>
	</div>
	<div class="box-right">
		<div class="box-right-head">
			<img src="<?php echo SEXY_PLUGPATH; ?>images/icons/megaphone.png" alt="" class="box-icons" />
			<h3>Shout-Outs</h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<ul class="credits">
					<li><a href="http://www.pinvoke.com/">GUI Icons by Pinvoke</a></li>
					<li><a href="http://wefunction.com/2008/07/function-free-icon-set/">Original Skin Icons by Function</a></li>
					<li><a href="http://beerpla.net">Bug Patch by Artem Russakovskii</a></li>
					<li><a href="http://gaut.am/">Twitter encoding fix by Gautam Gupta</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php

}//closing brace for function "sexy_settings_page"


function sexy_get_fetch_url() {
	global $post, $sexy_plugopts;
	if($sexy_plugopts['position'] == 'manual') { $perms= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']; }
	else { $perms = get_permalink(); }
	
	// which short url service should be used?
	if($socialit_plugopts['shorty'] == "e7t") {
		$first_url = "http://e7t.us/create.php?url=".$perms;
	} elseif($socialit_plugopts['shorty'] == "rims") {
		$first_url = "http://ri.ms/api-create.php?url=".$perms;
	} elseif($socialit_plugopts['shorty'] == "tinyarrow") {
		$first_url = "http://tinyarro.ws/api-create.php?url=".$perms;
	} elseif($socialit_plugopts['shorty'] == "tiny") {
		$first_url = "http://tinyurl.com/api-create.php?url=".$perms;
	} elseif($socialit_plugopts['shorty'] == "snip") {
		$first_url = "http://snipr.com/site/snip?&r=simple&link=".$perms;
	} elseif($socialit_plugopts['shorty'] == "shortto") {
		$first_url = "http://short.to/s.txt?url=".$perms;
	} elseif($socialit_plugopts['shorty'] == "cligs") {
		$first_url = "http://cli.gs/api/v1/cligs/create?url=".urlencode($perms);
	} elseif($socialit_plugopts['shorty'] == "supr") {
		$first_url = "http://su.pr/api?url=".$perms;
	} elseif($socialit_plugopts['shorty'] == "trim") {
		$first_url = "http://api.tr.im/api/trim_simple?url=".$perms;
	}
	
	$fetch_url=get_post_meta($post->ID, '_sexybookmarks_shortUrl', true);
	// if neccessary, fetch and store
	if (empty($fetch_url) || md5($perms)!=get_post_meta($post->ID, '_sexybookmarks_permaHash', true)) {
		// retrieve the shortened URL
		if (function_exists('curl_init')) {
			// Use cURL
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $first_url);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
			curl_setopt($ch, CURLOPT_TIMEOUT, 3);
			$fetch_url = curl_exec($ch);
			curl_close($ch);
			
		} elseif (function_exists('file_get_contents')) { // use file_get_contents()
			$fetch_url = file_get_contents($first_url);
		} else {
			$fetch_url='';
		}

		if ($fetch_url) { // remote call made and was successful
			$fetch_url=trim($fetch_url);
			// add/update values
			// tries updates first, then add if field does not already exist
			if (!update_post_meta($post->ID, '_sexybookmarks_shortUrl', $fetch_url)) {
				add_post_meta($post->ID, '_sexybookmarks_shortUrl', $fetch_url);
			}
			if (!update_post_meta($post->ID, '_sexybookmarks_permaHash', md5($perms))) {
				add_post_meta($post->ID, '_sexybookmarks_permaHash', md5($perms));
			}
		} else { # check to see if they want to host their own short URLs
				    # notice that this is done outside of the cURL command as well as the post_meta section
				     # since it is a self-hosted solution there is no need to fetch the URL or store it because it's already stored in the database
				if($sexy_plugopts['shorty'] == "tflp" && function_exists('permalink_to_twitter_link')) {
					$fetch_url = permalink_to_twitter_link($perms);
				} else {  // failed. use permalink.
					$fetch_url=$perms;
				  }
		}
	}
	return $fetch_url;
}


//create an auto-insertion function
function sexy_position_menu($post_content) {
	global $sexy_plugopts;
	
	// if user selected manual positioning, get out.
	if ($sexy_plugopts['position']=='manual') return $post_content;
	
	// decide whether or not to generate the bookmarks.
	if ((is_single() && false!==strpos($sexy_plugopts['pageorpost'],"post")) ||
		(is_page() && false!==strpos($sexy_plugopts['pageorpost'],"page")) ||
		(is_home() && false!==strpos($sexy_plugopts['pageorpost'],"index")) ||
		(is_feed() && !empty($sexy_plugopts['feed']))
	) { // socials should be generated and added
		$socials=get_sexy();
	}
	
	// place of bookmarks and return w/ post content.
	if (empty($socials)) {
		return $post_content;
	} elseif ($sexy_plugopts['position']=='above') {
		return $socials.$post_content;
	} elseif ($sexy_plugopts['position']=='below') {
		return $post_content.$socials;
	} else { // some other unexpected error, don't do anything. return.
		error_log("an error occurred in SexyBookmarks");
		return $post_content;
	}
}
//end sexy_position_menu...




function bookmark_list_item($name, $opts=array()) {
	global $sexy_plugopts, $sexy_bookmarks_data;

	$url=$sexy_bookmarks_data[$name]['baseUrl'];
	foreach ($opts as $key=>$value) {
		$url=str_replace(strtoupper($key), $value, $url);
	}
	
	return sprintf(
		'<li class="%s"><a href="%s" rel="%s"%s title="%s">%s</a></li>',
		$name,
		$url,
		$sexy_plugopts['reloption'],
		$sexy_plugopts['targetopt']=="_blank"?' class="external"':'',
		$sexy_bookmarks_data[$name]['share'],
		$sexy_bookmarks_data[$name]['share']
	);
}






function get_sexy() {
	global $sexy_plugopts, $wp_query, $post;

	$post = $wp_query->post;

	if($sexy_plugopts['position'] == 'manual') { 
		$perms= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']; 
		$title = urlencode(get_bloginfo('name') . wp_title('-', false));
		$feedperms = strtolower('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']);
#		$mail_subject = urlencode(get_bloginfo('name') . wp_title('-', false));
	}
	elseif(is_home() && false!==strpos($sexy_plugopts['pageorpost'],"index")) {
		$perms= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']; 
		$title = urlencode(get_bloginfo('name') . wp_title('-', false));
		$feedperms = strtolower('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']);
#		$mail_subject = urlencode(get_bloginfo('name') . wp_title('-', false));
	}
	else { 
		$perms = urlencode(get_permalink($post->ID));
		$title = urlencode($post->post_title);
		$feedperms = strtolower($perms);
#		$mail_subject = urlencode($post->post_title);
	}

	
	//determine how to handle post titles for Twitter
	if (strlen($title) >= 80) {
		$short_title = substr($title, 0, 80)."[..]";
	}
	else {
		$short_title = $title;
	}

	$sexy_content = urlencode(substr(strip_tags(strip_shortcodes(get_the_content())),0,300));
	$sexy_content = str_replace('+','%20',$sexy_content);
	$sexy_content = str_replace("&#8217;","'",$sexy_content);
	$post_summary = stripslashes($sexy_content);
	$site_name = get_bloginfo('name');
#	$mail_subject = str_replace('+','%20',$mail_subject);
#	$mail_subject = str_replace("&#8217;","'",$mail_subject);
	$y_cat = $sexy_plugopts['ybuzzcat'];
	$y_med = $sexy_plugopts['ybuzzmed'];
	$t_cat = $sexy_plugopts['twittcat'];

	// Grab post tags for Twittley tags. If there aren't any, use default tags set in plugin options page
	$getkeywords = get_the_tags(); if ($getkeywords) { foreach($getkeywords as $tag) { $keywords=$keywords.$tag->name.','; } }

	if (!empty($getkeywords)) {
		$d_tags=substr($d_tags, 0, count($d_tags)-2);
	}
	else {
		$d_tags = $sexy_plugopts['defaulttags'];
	}



	

	// Check permalink setup for proper feed link
	if (false !== strpos($feedperms,'?') || false !== strpos($feedperms,'.php',strlen($feedperms) - 4)) {
		$feedstructure = '&feed=comments-rss2';
	} else {
		if ('/' == $feedperms[strlen($feedperms) - 1]) {
			$feedstructure = 'feed';
		} 
		else {
			$feedstructure = '/feed';
		}
	}


	// Temporary fix for bug that breaks layout when using NextGen Gallery plugin
	if( (strpos($post_summary, '[') || strpos($post_summary, ']')) ) {
		$post_summary = "";
	}
	if( (strpos($sexy_content, '[') || strpos($sexy_content,']')) ) {
		$sexy_content = "";
	}

	// select the background
	if(!isset($sexy_plugopts['bgimg-yes'])) {
		$bgchosen = '';
	} elseif($sexy_plugopts['bgimg'] == 'sexy') {
		$bgchosen = ' sexy-bookmarks-bg-sexy';
	} elseif($sexy_plugopts['bgimg'] == 'caring') {
		$bgchosen = ' sexy-bookmarks-bg-caring';
	} elseif($sexy_plugopts['bgimg'] == 'care-old') {
		$bgchosen = ' sexy-bookmarks-bg-caring-old';
	} elseif($sexy_plugopts['bgimg'] == 'love') {
		$bgchosen = ' sexy-bookmarks-bg-love';
	}  elseif($sexy_plugopts['bgimg'] == 'wealth') {
		$bgchosen = ' sexy-bookmarks-bg-wealth';
	}
	
	// do not add inline styles to the feed.
	$style=($sexy_plugopts['autocenter'])?'':' style="'.__($sexy_plugopts['xtrastyle']).'"';
	if (is_feed()) $style='';
	$expand=$sexy_plugopts['expand']?' sexy-bookmarks-expand':'';
	$autocenter=$sexy_plugopts['autocenter']?' sexy-bookmarks-center':'';
	//write the menu
	$socials = '<div class="sexy-bookmarks'.$expand.$autocenter.$bgchosen.'"'.$style.'><ul class="socials">';
	foreach ($sexy_plugopts['bookmark'] as $name) {
		if ($name=='sexy-twitter') {
			$socials.=bookmark_list_item($name, array(
				'post_by'=>(!empty($sexy_plugopts['twittid']))?"RT+@".$sexy_plugopts['twittid'].":+":'',
				'short_title'=>urldecode($short_title),
				'fetch_url'=>sexy_get_fetch_url(),
			));
	    }# elseif ($name=='sexy-mail') {
		 #		$socials.=bookmark_list_item($name, array(
		 #			'sexy_plugpath'=>SEXY_PLUGPATH,
		 #			'strip_teaser'=>$post_summary,
		 #			'permalink'=>$perms,
		 #		));
		 # }
		elseif ($name=='sexy-diigo') {
			$socials.=bookmark_list_item($name, array(
				'sexy_teaser'=>$sexy_content,
				'permalink'=>$perms,
				'title'=>$title,
			));
		}elseif ($name=='sexy-linkedin') {
			$socials.=bookmark_list_item($name, array(
				'post_summary'=>$post_summary,
				'site_name'=>$site_name,
				'permalink'=>$perms,
				'title'=>$title,
			));
		} elseif ($name=='sexy-devmarks') {
			$socials.=bookmark_list_item($name, array(
				'post_summary'=>$post_summary,
				'permalink'=>$perms,
				'title'=>$title,
			));
		} elseif ($name=='sexy-comfeed') {
			$socials.=bookmark_list_item($name, array(
				'permalink'=>$feedperms.$feedstructure,
			));
		} elseif ($name=='sexy-yahoobuzz') {
			$socials.=bookmark_list_item($name, array(
				'permalink'=>$perms,
				'title'=>$title,
				'yahooteaser'=>$sexy_content,
				'yahoocategory'=>$y_cat,
				'yahoomediatype'=>$y_med,
			));
		} elseif ($name=='sexy-twittley') {
			$socials.=bookmark_list_item($name, array(
				'permalink'=>urlencode($perms),
				'title'=>$title,
				'post_summary'=>$post_summary,
				'twitt_cat'=>$t_cat,
				'default_tags'=>$d_tags,
			));
		} else {
			$socials.=bookmark_list_item($name, array(
				'permalink'=>$perms,
				'title'=>$title,
			));
		}
	}
	$socials.='</ul><div style="clear:both;"></div></div>';

	return $socials;
}






// This function is what allows people to insert the menu wherever they please rather than above/below a post...
function selfserv_sexy() {
	echo get_sexy();
}

//write the <head> code
add_action('wp_head', 'sexy_public');
function sexy_public() {
	global $sexy_plugopts;
	
	echo "\n\n".'<!-- Start Of Code Generated By SexyBookmarks '.SEXY_vNum.' -->'."\n";
	wp_register_style('sexy-bookmarks', SEXY_PLUGPATH.'css/style.css', false, SEXY_vNum, 'all');
	wp_print_styles('sexy-bookmarks');
	if ($sexy_plugopts['expand'] || $sexy_plugopts['autocenter'] || $sexy_plugopts['targetopt']=='_blank') {

		wp_register_script('sexy-bookmarks-public-js', SEXY_PLUGPATH.'js/sexy-bookmarks-public.js', array('jquery'), true);
		wp_print_scripts('sexy-bookmarks-public-js', SEXY_PLUGPATH.'js/sexy-bookmarks-public.js', array('jquery'), true); 
	}
	echo "\n".'<!-- End Of Code Generated By SexyBookmarks '.SEXY_vNum.' -->'."\n\n";
}

//styles for admin area
add_action( "admin_print_scripts", 'sexy_admin_scripts' );
add_action( "admin_print_styles", 'sexy_admin_styles' );
function sexy_admin_scripts() {
	wp_register_script('sexy-bookmarks-js', SEXY_PLUGPATH.'js/sexy-bookmarks.js', array('jquery-ui-sortable'), SEXY_vNum);
	wp_print_scripts('sexy-bookmarks-js');
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
		if (isset($_SERVER['HTTP_USER_AGENT']) && 
		(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8') !== false))
			return true;
		else
			return false;
	}

	if (detect7()) {
		wp_register_style('sexy-bookmarks', SEXY_PLUGPATH.'css/admin-style.css', false, SEXY_vNum, 'all');
		wp_print_styles('sexy-bookmarks');
		wp_register_style('ie-sexy-bookmarks', SEXY_PLUGPATH.'css/ie7-admin-style.css', false, SEXY_vNum, 'all');
		wp_print_styles('ie-sexy-bookmarks');
	}
	elseif (detect8()) {
		wp_register_style('sexy-bookmarks', SEXY_PLUGPATH.'css/admin-style.css', false, SEXY_vNum, 'all');
		wp_print_styles('sexy-bookmarks');
		wp_register_style('sexy-bookmarks', SEXY_PLUGPATH.'css/ie8-admin-style.css', false, SEXY_vNum, 'all');
		wp_print_styles('sexy-bookmarks');
	}
	else {
		wp_register_style('sexy-bookmarks', SEXY_PLUGPATH.'css/admin-style.css', false, SEXY_vNum, 'all');
		wp_print_styles('sexy-bookmarks');
	}
}


//add a sidebar menu link
//hook the menu to "the_content"
add_action('admin_menu', 'sexy_menu_link');
add_filter('the_content', 'sexy_position_menu');
?>