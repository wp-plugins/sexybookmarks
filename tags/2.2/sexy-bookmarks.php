<?php
/*
Plugin Name: SexyBookmarks
Plugin URI: http://eight7teen.com/sexy-bookmarks
Description: SexyBookmarks adds a (X)HTML compliant list of social bookmarking icons to each of your posts. See <a href="options-general.php?page=sexy-bookmarks.php">configuration panel</a> for more settings.
Version: 2.2
Author: Josh Jones
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

define('PLUGINNAME','SexyBookmarks');
define('OPTIONS','SexyBookmarks');
define('vNum','2.2');
define('PLUGPATH',get_option('siteurl').'/wp-content/plugins/'.plugin_basename(dirname(__FILE__)).'/');

require_once('bookmarks-data.php');

//add defaults to an array
$plugopts = array(
	'position' => '', // below, above, or manual
	'reloption' => 'nofollow', // 'nofollow', or ''
	'targetopt' => 'blank', // 'blank' or 'self'
	'bgimg' => '', // 'sexy' or 'caring'
	'shorty' => '',
	'pageorpost' => '',
	'bookmark' => array_keys($bookmarks),
	'xtrastyle' => '',
	'feed' => '1', // 1 or 0
);


//add 2 db
add_option(OPTIONS, $plugopts);

//reload
$plugopts = get_option(OPTIONS);

//add sidebar link to settings page
function menu_link() {
	if (function_exists('add_options_page')) {
		add_options_page('SexyBookmarks', 'SexyBookmarks', 8, basename(__FILE__), 'settings_page');
	}
}

function network_input_select($name, $hint) {
	global $plugopts;
	return sprintf('<label class="%s" title="%s"><input %sname="bookmark[]" type="checkbox" value="%s" /></label>',
		$name,
		$hint,
		@in_array($name, $plugopts['bookmark'])?'checked="checked" ':"",
		$name
	);
}




//write settings page
function settings_page() {

// Rotate through both authors' donation links so that donations will be fully unbiased as the user won't know which link belongs to who...
$donations = array(
"https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=8HGMUBNDCZ88A",
"https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3415856"
);
$donate_link = $donations[rand(0, count($donations) - 1)];

	global $plugopts, $bookmarks, $_POST;
	$status_message = "";
	$error_message = "";
	if(isset($_POST['save_changes'])) {
		$status_message = 'Your changes have been saved successfully!&nbsp;--->> &nbsp;<a href="'.$donate_link.'">Donate?</a>';
		
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
		else {
			$plugopts['position'] = $_POST['position'];
			$plugopts['xtrastyle'] = $_POST['xtrastyle'];
			$plugopts['reloption'] = $_POST['reloption'];
			$plugopts['targetopt'] = $_POST['targetopt'];
			$plugopts['bookmark'] = $_POST['bookmark'];
			$plugopts['shorty'] = $_POST['shorty'];
			$plugopts['pageorpost'] = $_POST['pageorpost'];
			$plugopts['twittid'] = $_POST['twittid'];
			$plugopts['bgimg'] = $_POST['bgimg'];
			$plugopts['feed'] = $_POST['feed'];
			update_option(OPTIONS, $plugopts);
		}
	}

	//if there was an error,
	//display it in my new fancy schmancy divs
	if($error_message != '') {
		echo '<div id="message" class="sexy-errors"><p>'.$error_message.'</p></div><div style="clear:both;"></div>';
	}
	elseif($status_message != '') {
		echo '<div id="message" class="sexy-infos"><p>'.$status_message.'</p></div><div style="clear:both;"></div>';
	}
?>


<div class="sexy-donations">
<p>SexyBookmarks is fueld primarily by a spark of ingenuity 
that can only be attained while in a caffeine induced sleepless
daze sitting in front of a computer.</p>
<p>So if you think this plugin is worth a couple of bucks... Please help induce our
<strong>&quot;caffeine comas&quot;</strong> by donating.</p>
<div class="sexy-donate-button"><a href="<?php echo $donate_link; ?>" title="Help support the development of this plugin by donating!"><img src="<?php echo PLUGPATH.'/images/sexy-donational-button.png'; ?>" /></a></div>
</div>
<h2 class="sexy">SexyBookmarks</h2>
<div class="wrapit">

	 <form name="sexy-bookmarks" id="sexy-bookmarks" action="" method="post">
		<div class="in1">
			<label for="xtrastyle" class="title">You can style the DIV that holds the menu here:</label>
			<textarea id="xtrastyle" name="xtrastyle" cols="52" rows="8" style="font-family:monospace;font-weight:bold;font-size:15px;padding:5px;"><?php 
$default_sexy = "margin:20px 0 0 0 !important;\npadding:25px 0 0 10px !important;\nheight:29px;/*the height of the icons (29px)*/\ndisplay:block !important;\nclear:both !important;";
if (!empty($plugopts['xtrastyle'])) {
	echo $plugopts['xtrastyle']; 
} 
elseif ( empty($plugopts['xtrastyle']) || $plugopts['xtrastyle'] == 'Array' )
	echo $default_sexy;
else {
	echo "If you see this message, please delete the contents of this textarea and click \"Save Changes\".";
}
?></textarea>
		</div>
		<div class="in1"><span class="title"><label for="twittid">Twitter ID:</label></span>
			<div class="in2">
				<input type="text" id="twittid" name="twittid" value="<?php echo $plugopts['twittid']; ?>" />
			</div>

		</div>
		<div class="in1"><span class="title">Menu Location:</span>
			<div class="in2">			
				<label><input <?php echo (($plugopts['position'] == "above")? 'checked="checked"' : ""); ?> name="position" id="position-above" type="radio" value="above" />
				Above each post</label>
				<br />
				<label><input <?php echo (($plugopts['position'] == "below")? 'checked="checked"' : ""); ?> name="position" id="position-below" type="radio" value="below" />
				Below each post</label>
				<br />
			    <label><input <?php echo (($plugopts['position'] == "manual")? 'checked="checked"' : ""); ?> name="position" id="position-manual" type="radio" value="manual" />
				Manually insert</label>
			</div>
		</div>
		<div class="in1"><span class="title">Add nofollow to the links?</span>
			<div class="in2">
				<label><input <?php echo (($plugopts['reloption'] == "nofollow")? 'checked="checked"' : ""); ?> name="reloption" id="reloption" type="radio" value="nofollow" /> Yes</label>
				<label><input <?php echo (($plugopts['reloption'] == "")? 'checked="checked"' : ""); ?> name="reloption" id="reloption" type="radio" value="" /> No</label>
			</div>
		</div>
		<div class="in1"><span class="title">Which URL Shortening Service?</span>
			<div class="in2">
				<select name="shorty" id="shorty">
				 <option <?php echo (($plugopts['shorty'] == "rims")? 'selected="selected"' : ""); ?> value="rims">http://ri.ms</option>
				 <option <?php echo (($plugopts['shorty'] == "tinyarrow")? 'selected="selected"' : ""); ?> value="tinyarrow">http://tinyarro.ws</option>
				 <option <?php echo (($plugopts['shorty'] == "tiny")? 'selected="selected"' : ""); ?> value="tiny">http://tinyurl.com</option>
				 <option <?php echo (($plugopts['shorty'] == "snip")? 'selected="selected"' : ""); ?> value="snip">http://snipr.com</option>
				</select>
			</div>
		</div>
		<div class="in1" title="Now the plugin supports insertion on your site's main page for those of you who use themes that post the entire content of posts on the homepage."><span class="title">Posts, pages, or the whole shebang?</span>
			<div class="in2">
				<select name="pageorpost" id="pageorpost">
				 <option <?php echo (($plugopts['pageorpost'] == "post")? 'selected="selected"' : ""); ?> value="post">Posts Only</option>
				 <option <?php echo (($plugopts['pageorpost'] == "page")? 'selected="selected"' : ""); ?> value="page">Pages Only</option>
				 <option <?php echo (($plugopts['pageorpost'] == "index")? 'selected="selected"' : ""); ?> value="index">Index Only</option>
				 <option <?php echo (($plugopts['pageorpost'] == "pagepost")? 'selected="selected"' : ""); ?> value="pagepost">Posts &amp; Pages</option>
				 <option <?php echo (($plugopts['pageorpost'] == "postindex")? 'selected="selected"' : ""); ?> value="postindex">Posts &amp; Index</option>
				 <option <?php echo (($plugopts['pageorpost'] == "pageindex")? 'selected="selected"' : ""); ?> value="pageindex">Pages &amp; Index</option>
				 <option <?php echo (($plugopts['pageorpost'] == "postpageindex")? 'selected="selected"' : ""); ?> value="postpageindex" title="THE WHOLE SHEBANG!">Posts, Pages, &amp; Index</option>
				</select>
			</div>
		</div>

		<div class="in1"><span class="title">Open links in new window?</span>
			<div class="in2">
				<label><input <?php echo (($plugopts['targetopt'] == "_blank")? 'checked="checked"' : ""); ?> name="targetopt" id="targetopt-blank" type="radio" value="_blank" /> Yes</label>
				<label><input <?php echo (($plugopts['targetopt'] == "_self")? 'checked="checked"' : ""); ?> name="targetopt" id="targetopt-self" type="radio" value="_self" /> No</label>
			</div>
		</div>

		<div class="iconator" id="iconator">
			<h2>Preferred Networks: (drag to reorder)</h2><?
foreach ($plugopts['bookmark'] as $name) print network_input_select($name, $bookmarks[$name]['check']);
$unused_networks=array_diff(array_keys($bookmarks), $plugopts['bookmark']);
foreach ($unused_networks as $name) print network_input_select($name, $bookmarks[$name]['check']);
?>
		</div>
		<div class="clear"></div>
		<div class="in1"><span class="title">Which background image would you like to use?</span>
			<div class="in2">
				<label class="bgimg"><input <?php echo (($plugopts['bgimg'] == "bottom")? 'checked="checked"' : ""); ?> id="bgimg-sexy" name="bgimg" type="radio" value="bottom" />
				<span class="share-sexy"> </span></label>
				<br />
				<label class="bgimg"><input <?php echo (($plugopts['bgimg'] == "top")? 'checked="checked"' : ""); ?> id="bgimg-caring" name="bgimg" type="radio" value="top" />
				<span class="share-care"> </span></label>
				<br />
				<label class="bgimg"><input <?php echo (($plugopts['bgimg'] == "none")? 'checked="checked"' : ""); ?> id="bgimg-none" name="bgimg" type="radio" value="none" /> &nbsp;&nbsp;(none)
				</label>
			</div>
		</div>
		<div class="in1"><span class="title">Feed Settings</span>
			<div class="in2">			
				<label><input <?php echo (($plugopts['feed'] == "1")? 'checked="checked"' : ""); ?> name="feed" id="feed-show" type="radio" value="1" />
				Show in feed</label>
				<br />
				<label><input <?php echo (($plugopts['feed'] == "0" || empty($plugopts['feed']))? 'checked="checked"' : ""); ?> name="feed" id="feed-hide" type="radio" value="0" />
				Hide in feed</label>
			</div>
		</div>
		<div class="in1">
			<input type="hidden" name="save_changes" value="1" />
			<div class="submit"><input type="submit" value="Save Changes" /></div>
		</div>
	</form>
</div>

<?php

}//closing brace for function "settings_page"


function get_fetch_url() {
	global $post, $plugopts;
	$perms=get_permalink();
	
	// which short url service should be used?
	if($plugopts['shorty'] == "rims") {
		$first_url = "http://ri.ms/api-create.php?url=".$perms;
	} elseif($plugopts['shorty'] == "tinyarrow") {
		$first_url = "http://tinyarro.ws/api-create.php?url=".$perms;
	} elseif($plugopts['shorty'] == "tiny") {
		$first_url = "http://tinyurl.com/api-create.php?url=".$perms;
	} elseif($plugopts['shorty'] == "snip") {
		$first_url = "http://snipr.com/site/snip?&r=simple&link=".$perms;
	}
	
	$fetch_url=get_post_meta($post->ID, '_sexybookmarks_shortUrl', true);
	if (!empty($fetch_url) && md5($perms)==get_post_meta($post->ID, '_sexybookmarks_permaHash', true)) {
		// no curl fetch neccessary.
	} 
	
	else { //fetch and store
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
		} else { // failed. use permalink.
			$fetch_url=$perms;
		}
	}
	return $fetch_url;
}


//create an auto-insertion function
function position_menu($post_content) {
	global $plugopts;
	
	// if user selected manual positioning, get out.
	if ($plugopts['position']=='manual') return $post_content;
	
	// decide whether or not to generate the bookmarks.
	if ((is_single() && false!==strpos($plugopts['pageorpost'],"post")) ||
		(is_page() && false!==strpos($plugopts['pageorpost'],"page")) ||
		(is_home() && false!==strpos($plugopts['pageorpost'],"index")) ||
		(is_feed() && !empty($plugopts['feed']))
	) { // socials should be generated and added
		$socials=get_sexy();
	}
	
	// place of bookmarks and return w/ post content.
	if (empty($socials)) {
		return $post_content;
	} elseif ($plugopts['position']=='above') {
		return $socials.$post_content;
	} elseif ($plugopts['position']=='below') {
		return $post_content.$socials;
	} else { // some other unexpected error, don't do anything. return.
		error_log("an error occurred in SexyBookmarks");
		return $post_content;
	}
}
//end position_menu...

function bookmark_list_item($name, $opts=array()) {
	global $plugopts, $bookmarks;
	
	$url=$bookmarks[$name]['baseUrl'];
	foreach ($opts as $key=>$value) {
		$url=str_replace(strtoupper($key), $value, $url);
	}
	
	return sprintf(
		'<li class="%s"><a href="%s" target="%s" rel="%s" title="%s">%s</a></li>',
		$name,
		$url,
		$plugopts['targetopt'],
		$plugopts['reloption'],
		$bookmarks[$opt['name']]['share'],
		$bookmarks[$opt['name']]['share']
	);
}

function get_sexy() {
	global $plugopts;
	
	$title = urlencode(get_the_title());
	$title = str_replace('%3A',':',$title);
	$title = str_replace('%3F','?',$title);
	$perms = get_permalink();
    $short_title = substr($title, 0, 60)."...";
	$sexy_content = urlencode(strip_tags(substr(get_the_content(), 0, 220)."..."));
	$post_summary = stripslashes($sexy_content);
	$site_name = get_bloginfo('name');
	$sexy_teaser = strip_tags(substr(get_the_content(), 0, 250)."...");
	$strip_teaser = strip_tags(stripslashes($sexy_teaser));
	$mail_subject = urldecode(substr($title, 0, 60)."...");


// Temporary fix for bug that breaks layout when using NextGen Gallery plugin
if( (strpos($strip_teaser, '[') || strpos($strip_teaser, ']')) ) {
	$strip_teaser = "";
}
if( (strpos($sexy_teaser, '[') || strpos($sexy_teaser,']')) ) {
	$sexy_teaser = "";
}




	// select the background
	if($plugopts['bgimg'] == 'top') {
		$bgchosen = "background:url(".PLUGPATH."images/sexy-trans.png) no-repeat left top;";
	} elseif($plugopts['bgimg'] == 'bottom') {
		$bgchosen = "background:url(".PLUGPATH."images/sexy-trans.png) no-repeat left -149px;";
	} elseif($plugopts['bgimg'] == 'none') {
		$bgchosen = "background:none;";
	}
	
	// do not add inline styles to the feed.
	$style=is_feed()?'':' style="'.__($bgchosen).__($plugopts['xtrastyle']).'"';
	//write the menu
	$socials = '<div class="sexy-bookmarks"'.$style.'><ul class="socials">';
	foreach ($plugopts['bookmark'] as $name) {
		if ($name=='sexy-twitter') {
			$socials.=bookmark_list_item($name, array(
				'post_by'=>(!empty($plugopts['twittid']))?"RT+@".$plugopts['twittid'].":+":'',
				'short_title'=>$title,
				'fetch_url'=>get_fetch_url(),
			));
		} elseif ($name=='sexy-mail') {
			$socials.=bookmark_list_item($name, array(
				'mail_subject'=>$mail_subject,
				'strip_teaser'=>$strip_teaser,
				'permalink'=>$perms,
			));
		}elseif ($name=='sexy-diigo') {
			$socials.=bookmark_list_item($name, array(
				'sexy_teaser'=>$sexy_teaser,
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
		} else {
			$socials.=bookmark_list_item($name, array(
				'permalink'=>$perms,
				'title'=>$title,
			));
		}
	}
	$socials.='</ul></div>';

	return $socials;
}

// This function is what allows people to insert the menu wherever they please rather than above/below a post...
function selfserv_sexy() {
	echo get_sexy();
}

//write the <head> code
add_action('wp_head', 'add_sexy_public');
function add_sexy_public() {
	echo "\n\n".'<!- Start Of Code Generated By SexyBookmarks '.vNum.' ->'."\n";
	wp_register_style('sexy-bookmarks', PLUGPATH.'css/style.css', false, vNum, 'all');
	wp_print_styles('sexy-bookmarks');
	echo '<!- End Of Code Generated By SexyBookmarks '.vNum.' ->'."\n\n";
}


//styles for admin area
add_action('admin_head', 'sexy_admin');
function sexy_admin() {
	wp_register_style('sexy-bookmarks', PLUGPATH.'css/admin-style.css', false, vNum, 'all');
	wp_register_script('sexy-bookmarks-js', PLUGPATH.'sexy-bookmarks.js', array('jquery-ui-sortable'), vNum);
	wp_print_styles('sexy-bookmarks');
	wp_print_scripts('sexy-bookmarks-js');
}



//add a sidebar menu link
//hook the menu to "the_content"
add_action('admin_menu', 'menu_link');
add_filter('the_content', 'position_menu');
?>
