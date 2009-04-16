<?php
/*
Plugin Name: SexyBookmarks
Plugin URI: http://eight7teen.com/sexy-bookmarks
Description: SexyBookmarks adds a (X)HTML compliant list of social bookmarking icons to each of your posts that allows visitors to easily submit them to some of the most popular social bookmarking sites. See <a href="options-general.php?page=sexy-bookmarks.php">configuration panel</a> for more settings.
Version: 2.1.2
Author: Josh Jones
Author URI: http://eight7teen.com

 
	Original WP-Social-Bookmark-Plugin Copyright 2009 Saidmade srl (email : g.fazioli@saidmade.com)
	Original Social Bookmarking Menu & SexyBookmarks Plugin Copyright 2009 Eight7Teen (email : josh@eight7teen.com)
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
define('vNum','2.1.2');
define('PLUGPATH',get_option('siteurl').'/wp-content/plugins/'.plugin_basename(dirname(__FILE__)).'/');




//add defaults to an array
$plugopts = array(
  'position' => 'below', // below, above, or manual
  'reloption' => 'nofollow', // 'nofollow', or ''
  'targetopt' => 'blank', // 'blank' or 'self'
  'bgimg' => 'top', // 'sexy' or 'caring'
  'shorty' => 'rims',
  'pageorpost' => '',
  'bookmark' => 
    array(
      'sexy-scriptstyle',
      'sexy-blinklist',
      'sexy-delicious',
      'sexy-digg',
      'sexy-furl',
      'sexy-reddit',
      'sexy-yahoomyweb',
      'sexy-stumbleupon',
      'sexy-technorati',
      'sexy-mixx',
      'sexy-myspace',
      'sexy-designfloat',
      'sexy-facebook',
      'sexy-twitter',
      'sexy-mail',
      'sexy-comfeed',
      'sexy-linkedin',
      'sexy-newsvine',
      'sexy-devmarks',
      'sexy-google'
	),
  'xtrastyle' => ''
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

//write settings page
function settings_page() {
	global $plugopts, $_POST;
	$status_message = "";
	$error_message = "";
	if(isset($_POST['save_changes'])) {
		$status_message = 'Krykie mate, it worked! Maybe you would consider <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3415856">donating</a> to this plugin?';
		
	//was there an error?
	if($_POST['position'] == '') {		
		$error_message = 'Please choose where you would like the menu to be displayed. | I need more Mt. Dew... <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3415856">Donate?</a>';
	}
	elseif($_POST['bookmark'] == '') {
		$error_message = 'You can\'t display the menu if you don\'t choose a few sites to add to it! | Holy smokes Batman! I think this one wants to <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3415856">donate</a> to help keep Gotham crime free!';
	}
	elseif($_POST['pageorpost'] == '') {
		$error_message = 'Please choose whether you want the menu displayed on pages, posts, or both. | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3415856">Donate</a>, it\'s good karma...';
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
		update_option(OPTIONS, $plugopts);
  }
}

//if there was an error,
//display it in that fancy fading div
if($error_message != '') {
	echo '<div id="message" class="error" style="margin-top:25px;"><p>'.$error_message.'</p></div>';
}
elseif($status_message != '') {
	echo '<div id="message" class="updated fade" style="margin-top:25px;"><p>'.$status_message.'</p></div>';
}
?>




<div class="donations">
	<h4 align='center'>Fuel the sexiness...</h4>
	<p><a href="http://eight7teen.com/sexy-bookmarks">SexyBookmarks</a> is fueled by Mt. Dew... You wouldn't want it running out of fuel, would you? Please donate.</p>
	<p>Thanks!<br /><span style="font-style:italic;font-family:georgia;font-weight:normal;">Josh Jones</span><br /></p>
	<div align='center'>
	<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3415856">
	<img src="https://www.paypal.com/en_GB/i/btn/btn_donate_SM.gif" border="0"  alt="Donate to help make this plugin better"/></a>
</div></div>

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
				 <option <?php echo (($plugopts['shorty'] == "cligs")? 'selected="selected"' : ""); ?> value="cligs">http://cli.gs</option>
				 <option <?php echo (($plugopts['shorty'] == "tiny")? 'selected="selected"' : ""); ?> value="tiny">http://tinyurl.com</option>
				 <option <?php echo (($plugopts['shorty'] == "snip")? 'selected="selected"' : ""); ?> value="snip">http://snipr.com</option>
				</select>
			</div>
		</div>
		<div class="in1" title="Now the plugin supports insertion on your site's main page for those of you who use themes that post the entire content of posts on the homepage."><span class="title">Posts, pages, or the whole shebang?</span>
			<div class="in2">

				<label><input <?php echo (($plugopts['pageorpost'] == "post")? 'checked="checked"' : ""); ?> name="pageorpost" id="pageorpost-post" type="radio" value="post" /> Posts</label><br />
				<label><input <?php echo (($plugopts['pageorpost'] == "page")? 'checked="checked"' : ""); ?> name="pageorpost" id="pageorpost-page" type="radio" value="page" /> Pages</label><br />
				<label><input <?php echo (($plugopts['pageorpost'] == "index")? 'checked="checked"' : ""); ?> name="pageorpost" id="pageorpost-index" type="radio" value="index" /> Index</label><br />
				<label><input <?php echo (( $plugopts['pageorpost'] == "pagepost")? 'checked="checked"' : ""); ?> name="pageorpost" id="pageorpost-pagepost" type="radio" value="pagepost" /> Posts & Pages</label><br />
				<label><input <?php echo (( $plugopts['pageorpost'] == "postindex")? 'checked="checked"' : ""); ?> name="pageorpost" id="pageorpost-postindex" type="radio" value="postindex" /> Posts & Index</label><br />
				<label><input <?php echo (( $plugopts['pageorpost'] == "pageindex")? 'checked="checked"' : ""); ?> name="pageorpost" id="pageorpost-pageindex" type="radio" value="pageindex" /> Pages & Index</label><br />
				<label><input <?php echo (( $plugopts['pageorpost'] == "all")? 'checked="checked"' : ""); ?> name="pageorpost" id="pageorpost-all" type="radio" value="all" /> All</label>
			</div>
		</div>

		<div class="in1"><span class="title">Open links in new window?</span>
			<div class="in2">
				<label><input <?php echo (($plugopts['targetopt'] == "_blank")? 'checked="checked"' : ""); ?> name="targetopt" id="targetopt-blank" type="radio" value="_blank" /> Yes</label>
				<label><input <?php echo (($plugopts['targetopt'] == "_self")? 'checked="checked"' : ""); ?> name="targetopt" id="targetopt-self" type="radio" value="_self" /> No</label>
			</div>
		</div>

		<div class="iconator">
			<h2>Preferred Networks:</h2>
			<label class="sexy-newsvine" title="Check this box to include Newsvine in your bookmarking menu">
			<input <?php echo (@in_array("sexy-newsvine", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-newsvine" />
			</label>
			<label class="sexy-linkedin" title="Check this box to include Linkedin in your bookmarking menu">
			<input <?php echo (@in_array("sexy-linkedin", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-linkedin" />
			</label>
			<label class="sexy-devmarks" title="Check this box to include Devmarks in your bookmarking menu">
			<input <?php echo (@in_array("sexy-devmarks", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-devmarks" />
			</label>
			<label class="sexy-google" title="Check this box to include Google Bookmarks in your bookmarking menu">
			<input <?php echo (@in_array("sexy-google", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-google" />
			</label>
			<label class="sexy-scriptstyle" title="Check this box to include Script &amp; Style in your bookmarking menu">
			<input <?php echo (@in_array("sexy-scriptstyle", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-scriptstyle" />
			</label>
			<label class="sexy-mail" title="Check this box to include 'Email to a Friend' link in your bookmarking menu">
			<input <?php echo (@in_array("sexy-mail", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-mail" />
			</label>
			<label class="sexy-comfeed" title="Check this box to include a 'Subscribe to Comments' link in your bookmarking menu">
			<input <?php echo (@in_array("sexy-comfeed", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-comfeed" />
			</label>
			<label class="sexy-twitter" title="Check this box to include Twitter in your bookmarking menu">
			<input <?php echo (@in_array("sexy-twitter", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-twitter" />
			</label>
			<label class="sexy-technorati" title="Check this box to include Technorati in your bookmarking menu">
			<input <?php echo (@in_array("sexy-technorati", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-technorati" />
			</label>
			<label class="sexy-stumbleupon" title="Check this box to include Stumbleupon in your bookmarking menu">
			<input <?php echo (@in_array("sexy-stumbleupon", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-stumbleupon" />
			</label>
			<label class="sexy-reddit" title="Check this box to include Reddit in your bookmarking menu">
			<input <?php echo (@in_array("sexy-reddit", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-reddit" />
			</label>
			<label class="sexy-myspace" title="Check this box to include MySpace in your bookmarking menu">
			<input <?php echo (@in_array("sexy-myspace", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-myspace" />
			</label>
			<label class="sexy-mixx" title="Check this box to include Mixx in your bookmarking menu">
			<input <?php echo (@in_array("sexy-mixx", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-mixx" />
			</label>
			<label class="sexy-furl" title="Check this box to include Furl in your bookmarking menu">
			<input <?php echo (@in_array("sexy-furl", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-furl" />
			</label>
			<label class="sexy-digg" title="Check this box to include Digg in your bookmarking menu">
			<input <?php echo (@in_array("sexy-digg", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-digg" />
			</label>
			<label class="sexy-designfloat" title="Check this box to include DesignFloat in your bookmarking menu">
			<input <?php echo (@in_array("sexy-designfloat", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-designfloat" />
			</label>
			<label class="sexy-yahoomyweb" title="Check this box to include Yahoo! MyWeb in your bookmarking menu">
			<input <?php echo (@in_array("sexy-yahoomyweb", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-yahoomyweb" />
			</label>
			<label class="sexy-delicious" title="Check this box to include Delicious in your bookmarking menu">
			<input <?php echo (@in_array("sexy-delicious", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-delicious" />
			</label>
			<label class="sexy-blinklist" title="Check this box to include Blinklist in your bookmarking menu">
			<input <?php echo (@in_array("sexy-blinklist", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-blinklist" />
			</label>
			<label class="sexy-facebook" title="Check this box to include Facebook in your bookmarking menu">
			<input <?php echo (@in_array("sexy-facebook", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="sexy-facebook" />
			</label>
		</div>
<div class="clear"></div>
		<div class="in1"><span class="title">Which background image would you like to use?</span>
			<div class="in2">
				<label class="bgimg"><input <?php echo (($plugopts['bgimg'] == "bottom")? 'checked="checked"' : ""); ?> id="bgimg-sexy" name="bgimg" type="radio" value="bottom" />
				<span class="share-sexy"> </span></label>
				<br />
				<label class="bgimg"><input <?php echo (($plugopts['bgimg'] == "top")? 'checked="checked"' : ""); ?> id="bgimg-caring" name="bgimg" type="radio" value="top" />
				<span class="share-care"> </span></label>
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






//create an auto-insertion function
function position_menu($post_content) {


	global $plugopts;
	$relopt = $plugopts['reloption'];
	$tarwin = $plugopts['targetopt'];
	$title = urlencode(get_the_title());
	$title = str_replace('%3A',':',$title);
	$title = str_replace('%3F','?',$title);
	$perms = get_permalink();
    $short_title = substr($title, 0, 60)."...";
	$sexy_content = urlencode(strip_tags(substr(get_the_content(), 0, 220)."[..]"));
	$post_summary = stripslashes($sexy_content);
	$site_name = get_bloginfo('name');
	$sexy_teaser = strip_tags(substr(get_the_content(), 0, 250)."[..]");
	$strip_teaser = stripslashes($sexy_teaser);
	$mail_subject = urldecode(substr($title, 0, 60)."...");


//Use cURL to retrieve the shortened URL
if($plugopts['shorty'] == "rims") {
	$first_url = "http://ri.ms/api-create.php?url=".$perms;
}
elseif($plugopts['shorty'] == "tinyarrow") {
	$first_url = "http://tinyarro.ws/api-create.php?url=".$perms;
}
elseif($plugopts['shorty'] == "cligs") {
	$first_url = "http://cli.gs/api/v1/cligs/create?url=".$perms;
}
elseif($plugopts['shorty'] == "tiny") {
	$first_url = "http://tinyurl.com/api-create.php?url=".$perms;
}
elseif($plugopts['shorty'] == "snip") {
	$first_url = "http://snipr.com/site/snip?&r=simple&link=".$perms;
}
else {
	$first_url = "http://e7t.us/create.php?url=".$perms;
}

if(function_exists('curl_init')) {
if(in_array("sexy-twitter", $plugopts['bookmark'])) {
	$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $first_url);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($ch, CURLOPT_TIMEOUT, 3);

$fetch_url = curl_exec($ch);
curl_close($ch);
}}
elseif(!function_exists('curl_init') && function_exists('file_get_contents')) {
	if(in_array("sexy-twitter", $plugopts['bookmark'])) {
	$fetch_url = file_get_contents($first_url);
}}
else {
	$fetch_url = $perms;
}


if($plugopts['bgimg'] == 'top') {
	$bgchosen = "background:url('".PLUGPATH."images/sexy-trans.png') no-repeat left top;";
}
elseif($plugopts['bgimg'] == 'bottom') {
	$bgchosen = "background:url('".PLUGPATH."images/sexy-trans.png') no-repeat left -149px;";
}
elseif($plugopts['bgimg'] == 'none') {
	$bgchosen = "background:none;";
}

if(!empty($plugopts['twittid'])) {
	$post_by = "RT+@".$plugopts['twittid'].":+";
}
else {
	$post_by ="";
}

	//write the menu
	$socials = '<div class="sexy-bookmarks" style="'.__($bgchosen).__($plugopts['xtrastyle']).'"><ul class="socials">'.
	(in_array("sexy-scriptstyle", $plugopts['bookmark'])?
	'<li class="sexy-scriptstyle"><a href="http://scriptandstyle.com/submit?url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Submit this to Script &amp; Style"> </a></li>' : '').
	
	(in_array("sexy-blinklist", $plugopts['bookmark'])?
	'<li class="sexy-blinklist"><a href="http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url='.$perms.'&amp;Title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Blinklist"> </a></li>' : '').
	
	(in_array("sexy-delicious", $plugopts['bookmark'])?
	'<li class="sexy-delicious"><a href="http://del.icio.us/post?url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on del.icio.us"> </a></li>' : '').
	
	(in_array("sexy-digg", $plugopts['bookmark'])?
	'<li class="sexy-digg"><a href="http://digg.com/submit?phase=2&amp;url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Digg this!"> </a></li>' : '').
	
	(in_array("sexy-furl", $plugopts['bookmark'])?
	'<li class="sexy-furl"><a href="http://www.furl.net/storeIt.jsp?t='.$title.'&amp;u='.$perms.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Furl"> </a></li>' : '').
	
	(in_array("sexy-reddit", $plugopts['bookmark'])?
	'<li class="sexy-reddit"><a href="http://reddit.com/submit?url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Reddit"> </a></li>' : '').
	
	(in_array("sexy-yahoomyweb", $plugopts['bookmark'])?
	'<li class="sexy-yahoomyweb"><a href="http://myweb2.search.yahoo.com/myresults/bookmarklet?t='.$title.'&amp;u='.$perms.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Save this to Yahoo MyWeb"> </a></li>' : '').
	
	(in_array("sexy-stumbleupon", $plugopts['bookmark'])?
	'<li class="sexy-stumbleupon"><a href="http://www.stumbleupon.com/submit?url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Stumble upon something good? Share it on StumbleUpon"> </a></li>' : '').

	(in_array("sexy-technorati", $plugopts['bookmark'])?
	'<li class="sexy-technorati"><a href="http://technorati.com/faves?add='.$perms.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Technorati"> </a></li>' : '').
	
	(in_array("sexy-mixx", $plugopts['bookmark'])?
	'<li class="sexy-mixx"><a href="http://www.mixx.com/submit?page_url='.$perms.'&amp;amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Mixx"> </a></li>' : '').
	
	(in_array("sexy-myspace", $plugopts['bookmark'])?
	'<li class="sexy-myspace"><a href="http://www.myspace.com/Modules/PostTo/Pages/?u='.$perms.'&amp;amp;t='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Post this to MySpace"> </a></li>' : '').
	
	(in_array("sexy-designfloat", $plugopts['bookmark'])?
	'<li class="sexy-designfloat"><a href="http://www.designfloat.com/submit.php?url='.$perms.'&amp;amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Submit this to DesignFloat"> </a></li>' : '').
	
	(in_array("sexy-facebook", $plugopts['bookmark'])?
	'<li class="sexy-facebook"><a href="http://www.facebook.com/share.php?u='.$perms.'&amp;amp;t='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Facebook"> </a></li>' : '').

	(in_array("sexy-twitter", $plugopts['bookmark'])?
	'<li class="sexy-twitter"><a href="http://www.twitter.com/home?status='.$post_by.'+'.$short_title.'+-+'.$fetch_url.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Tweet This!"> </a></li>' : '').

	(in_array("sexy-devmarks", $plugopts['bookmark'])?
	'<li class="sexy-devmarks"><a href="http://devmarks.com/index.php?posttext='.$post_summary.'&posturl='.$perms.'&posttitle='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Devmarks"> </a></li>' : '').


	(in_array("sexy-newsvine", $plugopts['bookmark'])?
	'<li class="sexy-newsvine"><a href="http://www.newsvine.com/_tools/seed&save?u='.$perms.'&h='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Seed this on Newsvine"> </a></li>' : '').


	(in_array("sexy-linkedin", $plugopts['bookmark'])?
	'<li class="sexy-linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&url='.$perms.'&title='.$title.'&summary='.$post_summary.'&source='.$site_name.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Linkedin"> </a></li>' : '').

	(in_array("sexy-google", $plugopts['bookmark'])?
	'<li class="sexy-google"><a href="http://www.google.com/bookmarks/mark?op=add&bkmk='.$perms.'title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Add this to Google Bookmarks"> </a></li>' : '').

	(in_array("sexy-comfeed", $plugopts['bookmark'])?
	'<li class="sexy-comfeed"><a href="'.$perms.'feed'.'" title="Subscribe to the comments for this post?"> </a></li>' : '').


	(in_array("sexy-mail", $plugopts['bookmark'])?
	'<li class="sexy-mail"><a href="mailto:?&subject='.$mail_subject.'&body='.strip_tags($strip_teaser).' - '.$perms.'" title="Email this to a friend?"> </a></li>' : '').

	'</ul></div>';

	if(is_single() && $plugopts['position'] == "above" && $plugopts['pageorpost'] == "post") return $socials.$post_content;
	elseif(is_single() && $plugopts['position'] == "below" && $plugopts['pageorpost'] == "post") return $post_content.$socials;
	elseif(is_page() && $plugopts['position'] == "above" && $plugopts['pageorpost'] == "page") return $socials.$post_content;
	elseif(is_page() && $plugopts['position'] == "below" && $plugopts['pageorpost'] == "page") return $post_content.$socials;
	elseif(is_home() && $plugopts['position'] == "above" && $plugopts['pageorpost'] == "index") return $socials.$post_content;
	elseif(is_home() && $plugopts['position'] == "below" && $plugopts['pageorpost'] == "index") return $post_content.$socials;

	elseif( ( is_page() || is_single() ) && $plugopts['position'] == "above" && $plugopts['pageorpost'] == "pagepost") return $socials.$post_content;
	elseif( ( is_page() || is_single() ) && $plugopts['position'] == "below" && $plugopts['pageorpost'] == "pagepost") return $post_content.$socials;
	elseif( ( is_single() || is_home() ) && $plugopts['position'] == "above" && $plugopts['pageorpost'] == "postindex") return $socials.$post_content;
	elseif( ( is_single() || is_home() ) && $plugopts['position'] == "below" && $plugopts['pageorpost'] == "postindex") return $post_content.$socials;
	elseif( ( is_page() || is_home() ) && $plugopts['position'] == "above" && $plugopts['pageorpost'] == "pageindex") return $socials.$post_content;
	elseif( ( is_page() || is_home() ) && $plugopts['position'] == "below" && $plugopts['pageorpost'] == "pageindex") return $post_content.$socials;
	
	elseif( ( is_single() || is_home() || is_page ) && $plugopts['position'] == "above" && $plugopts['pageorpost'] == "all") return $socials.$post_content;
	elseif( ( is_single() || is_home() || is_page ) && $plugopts['position'] == "below" && $plugopts['pageorpost'] == "all") return $post_content.$socials;

	elseif( $plugopts['position'] == "manual" )  return $post_content;
	else { return $post_content; }
}
//end position_menu...











// This function is what allows people to insert the menu wherever they please rather than above/below a post...
function selfserv_sexy() {

	global $plugopts;
	$relopt = $plugopts['reloption'];
	$tarwin = $plugopts['targetopt'];
	$title = urlencode(get_the_title());
	$title = str_replace('%3A',':',$title);
	$title = str_replace('%3F','?',$title);
	$perms = get_permalink();
    $short_title = substr($title, 0, 60)."...";
	$sexy_content = urlencode(strip_tags(substr(get_the_content(), 0, 220)."[..]"));
	$post_summary = stripslashes($sexy_content);
	$site_name = get_bloginfo('name');
	$sexy_teaser = strip_tags(substr(get_the_content(), 0, 250)."[..]");
	$strip_teaser = stripslashes($sexy_teaser);
	$mail_subject = urldecode(substr($title, 0, 60)."...");


//Use cURL to retrieve the shortened URL
if($plugopts['shorty'] == "rims") {
	$first_url = "http://ri.ms/api-create.php?url=".$perms;
}
elseif($plugopts['shorty'] == "tinyarrow") {
	$first_url = "http://tinyarro.ws/api-create.php?url=".$perms;
}
elseif($plugopts['shorty'] == "cligs") {
	$first_url = "http://cli.gs/api/v1/cligs/create?url=".$perms;
}
elseif($plugopts['shorty'] == "tiny") {
	$first_url = "http://tinyurl.com/api-create.php?url=".$perms;
}
elseif($plugopts['shorty'] == "snip") {
	$first_url = "http://snipr.com/site/snip?&r=simple&link=".$perms;
}
else {
	$first_url = "http://e7t.us/create.php?url=".$perms;
}


if(function_exists('curl_init')) {
if(in_array("sexy-twitter", $plugopts['bookmark'])) {
	$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $first_url);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($ch, CURLOPT_TIMEOUT, 3);
$fetch_url = curl_exec($ch);
curl_close($ch);
}}
elseif(!function_exists('curl_init') && function_exists('file_get_contents')) {
	if(in_array("sexy-twitter", $plugopts['bookmark'])) {
	$fetch_url = file_get_contents($first_url);
}}
else {
	$fetch_url = $perms;
}

if($plugopts['bgimg'] == 'top') {
	$bgchosen = "background:url('".PLUGPATH."images/sexy-trans.png') no-repeat left top;";
}
else {
	$bgchosen = "background:url('".PLUGPATH."images/sexy-trans.png') no-repeat left -149px;";
}

if(!empty($plugopts['twittid'])) {
	$post_by = "RT+@".$plugopts['twittid'].":+";
}
else {
	$post_by ="";
}

	//write the menu
	$socials = '<div class="sexy-bookmarks" style="'.__($bgchosen).__($plugopts['xtrastyle']).'"><ul class="socials">'.
	(in_array("sexy-scriptstyle", $plugopts['bookmark'])?
	'<li class="sexy-scriptstyle"><a href="http://scriptandstyle.com/submit?url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Submit this to Script &amp; Style"> </a></li>' : '').
	
	(in_array("sexy-blinklist", $plugopts['bookmark'])?
	'<li class="sexy-blinklist"><a href="http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url='.$perms.'&amp;Title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Blinklist"> </a></li>' : '').
	
	(in_array("sexy-delicious", $plugopts['bookmark'])?
	'<li class="sexy-delicious"><a href="http://del.icio.us/post?url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on del.icio.us"> </a></li>' : '').
	
	(in_array("sexy-digg", $plugopts['bookmark'])?
	'<li class="sexy-digg"><a href="http://digg.com/submit?phase=2&amp;url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Digg this!"> </a></li>' : '').
	
	(in_array("sexy-furl", $plugopts['bookmark'])?
	'<li class="sexy-furl"><a href="http://www.furl.net/storeIt.jsp?t='.$title.'&amp;u='.$perms.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Furl"> </a></li>' : '').
	
	(in_array("sexy-reddit", $plugopts['bookmark'])?
	'<li class="sexy-reddit"><a href="http://reddit.com/submit?url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Reddit"> </a></li>' : '').
	
	(in_array("sexy-yahoomyweb", $plugopts['bookmark'])?
	'<li class="sexy-yahoomyweb"><a href="http://myweb2.search.yahoo.com/myresults/bookmarklet?t='.$title.'&amp;u='.$perms.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Save this to Yahoo MyWeb"> </a></li>' : '').
	
	(in_array("sexy-stumbleupon", $plugopts['bookmark'])?
	'<li class="sexy-stumbleupon"><a href="http://www.stumbleupon.com/submit?url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Stumble upon something good? Share it on StumbleUpon"> </a></li>' : '').

	(in_array("sexy-technorati", $plugopts['bookmark'])?
	'<li class="sexy-technorati"><a href="http://technorati.com/faves?add='.$perms.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Technorati"> </a></li>' : '').
	
	(in_array("sexy-mixx", $plugopts['bookmark'])?
	'<li class="sexy-mixx"><a href="http://www.mixx.com/submit?page_url='.$perms.'&amp;amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Mixx"> </a></li>' : '').
	
	(in_array("sexy-myspace", $plugopts['bookmark'])?
	'<li class="sexy-myspace"><a href="http://www.myspace.com/Modules/PostTo/Pages/?u='.$perms.'&amp;amp;t='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Post this to MySpace"> </a></li>' : '').
	
	(in_array("sexy-designfloat", $plugopts['bookmark'])?
	'<li class="sexy-designfloat"><a href="http://www.designfloat.com/submit.php?url='.$perms.'&amp;amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Submit this to DesignFloat"> </a></li>' : '').
	
	(in_array("sexy-facebook", $plugopts['bookmark'])?
	'<li class="sexy-facebook"><a href="http://www.facebook.com/share.php?u='.$perms.'&amp;amp;t='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Facebook"> </a></li>' : '').

	(in_array("sexy-twitter", $plugopts['bookmark'])?
	'<li class="sexy-twitter"><a href="http://www.twitter.com/home?status='.$post_by.'+'.$short_title.'+-+'.$fetch_url.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Tweet This!"> </a></li>' : '').

	(in_array("sexy-devmarks", $plugopts['bookmark'])?
	'<li class="sexy-devmarks"><a href="http://devmarks.com/index.php?posttext='.$post_summary.'&posturl='.$perms.'&posttitle='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Devmarks"> </a></li>' : '').


	(in_array("sexy-newsvine", $plugopts['bookmark'])?
	'<li class="sexy-newsvine"><a href="http://www.newsvine.com/_tools/seed&save?u='.$perms.'&h='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Seed this on Newsvine"> </a></li>' : '').


	(in_array("sexy-linkedin", $plugopts['bookmark'])?
	'<li class="sexy-linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&url='.$perms.'&title='.$title.'&summary='.$post_summary.'&source='.$site_name.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Linkedin"> </a></li>' : '').

	(in_array("sexy-google", $plugopts['bookmark'])?
	'<li class="sexy-google"><a href="http://www.google.com/bookmarks/mark?op=add&bkmk='.$perms.'title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Add this to Google Bookmarks"> </a></li>' : '').

	(in_array("sexy-comfeed", $plugopts['bookmark'])?
	'<li class="sexy-comfeed"><a href="'.$perms.'feed'.'" title="Subscribe to the comments for this post?"> </a></li>' : '').


	(in_array("sexy-mail", $plugopts['bookmark'])?
	'<li class="sexy-mail"><a href="mailto:?&subject='.$mail_subject.'&body='.strip_tags($strip_teaser).' - '.$perms.'" title="Email this to a friend?"> </a></li>' : '').

	'</ul></div>';

echo $socials;
}
// End self-serv sexy...









//write the <head> code
add_action('wp_head', 'add_styles');
function add_styles() {
 echo "\n\n".'<!-- Start Of Code Generated By SexyBookmarks '.vNum.' -->'."\n";
 if(@file_exists(PLUGPATH.'/css/style.css')) {
  wp_register_style('sexy-bookmarks', get_stylesheet_directory_uri().'/css/style.css', false, vNum, 'all');
} else {
  wp_register_style('sexy-bookmarks', plugins_url('sexybookmarks/css/style.css'), false, vNum, 'all');
}
  wp_print_styles('sexy-bookmarks');
 echo '<!-- End Of Code Generated By SexyBookmarks '.vNum.' -->'."\n\n";
}


//styles for admin area
add_action('admin_head', 'sexy_admin');
function sexy_admin() {
 if(@file_exists(PLUGPATH.'/css/admin-style.css')) {
  wp_register_style('sexy-bookmarks', get_stylesheet_directory_uri().'/css/admin-style.css', false, vNum, 'all');
} else {
  wp_register_style('sexy-bookmarks', plugins_url('sexybookmarks/css/admin-style.css'), false, vNum, 'all');
}
  wp_print_styles('sexy-bookmarks');
}



//add a sidebar menu link
//hook the menu to "the_content"
add_action('admin_menu', 'menu_link');
add_filter('the_content', 'position_menu');
?>