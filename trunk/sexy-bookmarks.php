<?php
/*
Plugin Name: SexyBookmarks
Plugin URI: http://eight7teen.com/sexy-bookmarks
Description: SexyBookmarks adds a (X)HTML compliant list of social bookmarking icons to each of your posts that allows visitors to easily submit them to some of the most popular social bookmarking sites. See <a href="options-general.php?page=sexy-bookmarks.php">configuration panel</a> for more settings. This plugin is based on the original <a href="http://wordpress.org/extend/plugins/wp-social-bookmark-menu">WP-Social-Bookmark-Menu</a> plugin by <a href="http://undolog.com">Giovambattista Fazioli</a>.
Version: 1.2.1
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
define('vNum','1.2.1');
define('PLUGPATH',get_option('siteurl').'/wp-content/plugins/'.plugin_basename(dirname(__FILE__)).'/');




//add defaults to an array
$plugopts = array(
'position' => 'below','bookmark','reloption','targetopt','xtrastyle'=> array('sexy-scriptstyle','sexy-blinklist','sexy-delicious','sexy-digg','sexy-furl','sexy-reddit','sexy-yahoomyweb','sexy-stumbleupon','sexy-technorati','sexy-mixx','sexy-myspace','sexy-designfloat','sexy-facebook','sexy-twitter')
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
	if(isset($_POST['save_changes'])) {
		$status_message = 'Changes saved successfully.';
		
	//was there an error?
	if($_POST['position'] == '') {		
		$status_message = 'A required option was not selected. Please check your settings and try again.';
		} 
		else {
		$plugopts['position'] = $_POST['position'];
		$plugopts['xtrastyle'] = $_POST['xtrastyle'];
		$plugopts['reloption'] = $_POST['reloption'];
		$plugopts['targetopt'] = $_POST['targetopt'];
		$plugopts['bookmark'] = $_POST['bookmark'];
		$plugopts['pageorpost'] = $_POST['pageorpost'];
		update_option(OPTIONS, $plugopts);
  }
}

//if there was an error,
//display it in that fancy fading div
if($status_message != '') 
	echo '<div id="message" class="updated fade"><p>'.$status_message.'</p></div>';
?>

<div class="wrap">
 <h2 class="sexy">SexyBookmarks</h2>
 <form name="sexy-bookmarks" id="sexy-bookmarks" action="" method="post">
 <div style="position:relative;top:0;left:0;margin:18px 0 10px 0;">
  <strong><label for="xtrastyle">You can style the DIV that holds the menu here:</label></strong><br />
  <textarea name="xtrastyle" id="xtrastyle" cols="65" rows="8" style="text-indent:0;"><?php if ( $plugopts['xtrastyle'] != '' ) { echo $plugopts['xtrastyle']; } else { echo 'background:url('.plugins_url('sexy-bookmarks/sexy-trans.png').') no-repeat left bottom;'."\n".'margin:0 !important;'."\n".'padding:25px 0 0 10px !important;'."\n".'width:100% !important;'."\n".'height:29px;/*the height of the icons (29px)*/'."\n".'display:block !important;'."\n".'clear:both !important;';} ?></textarea>
 </div>
 <input type="hidden" name="save_changes" value="1" />
 <table width="440px" cellpadding="4" cellspacing="0">
  <tr>
   <td><br /><br /></td>
  </tr>
  <tr>
   <td align="left" valign="top" nowrap><strong><label for="position">Menu Location:</label></strong> </td>
   <td>
    <input <?php echo (($plugopts['position'] == "above")? 'checked="checked"' : ""); ?> name="position" id="position" type="radio" value="above" /> Above each post<br />
    <input <?php echo (($plugopts['position'] == "below")? 'checked="checked"' : ""); ?> name="position" id="position" type="radio" value="below" /> Below each post
   </td>
  </tr>
  <tr>
   <td><br /><br /></td>
  </tr>
  <tr>
   <td align="left" valign="top" nowrap>
    <strong><label for="position">Add nofollow to the links? </label></strong>
   </td>
   <td>
    &nbsp;<input <?php echo (($plugopts['reloption'] == "nofollow")? 'checked="checked"' : ""); ?> name="reloption" id="reloption" type="radio" value="nofollow" /> Yes 
    &nbsp;<input <?php echo (($plugopts['reloption'] == "")? 'checked="checked"' : ""); ?> name="reloption" id="reloption" type="radio" value="" /> No 
   </td>
  </tr>
  <tr><td><br /><br /></td></tr>
  <tr>
   <td align="left" valign="top" nowrap>
    <strong><label for="position">Pages, Posts, or Both? </label></strong>
   </td>
   <td>
	&nbsp;<input <?php echo (($plugopts['pageorpost'] == "post")? 'checked="checked"' : ""); ?> name="pageorpost" id="pageorpost-post" type="radio" value="post" /> Posts 
	&nbsp;<input <?php echo (($plugopts['pageorpost'] == "page")? 'checked="checked"' : ""); ?> name="pageorpost" id="pageorpost-page" type="radio" value="page" /> Pages 
	&nbsp;<input <?php echo (( $plugopts['pageorpost'] == "pagepost")? 'checked="checked"' : ""); ?> name="pageorpost" id="pageorpost-pagepost" type="radio" value="pagepost" /> Both 
   </td>
  </tr>
  <tr><td><br /><br /></td></tr>
  <tr>
   <td align="left" valign="top" nowrap>
    <strong><label for="position">Open links in new window? </label></strong>
   </td>
   <td>
    &nbsp;<input <?php echo (($plugopts['targetopt'] == "_blank")? 'checked="checked"' : ""); ?> name="targetopt" id="targetopt" type="radio" value="_blank" /> Yes 
    &nbsp;<input <?php echo (($plugopts['targetopt'] == "_self")? 'checked="checked"' : ""); ?> name="targetopt" id="targetopt" type="radio" value="_self" /> No 
   </td>
  </tr>
  <tr>
   <td><br /><br /></td>
  </tr>
  <tr>
   <td align="left" valign="top" nowrap><strong><label for="position">Preferred Networks:</label></strong> </td>
   <td>
    <span class="sexy-scriptstyle"></span> <input <?php echo (@in_array("scriptstyle", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="scriptstyle" /> Script & Style <br />
    <span class="sexy-blinklist"></span> <input <?php echo (@in_array("blinklist", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="blinklist" /> Blinklist <br />
    <span class="sexy-delicious"></span> <input <?php echo (@in_array("delicious", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="delicious" /> del.icio.us <br />
    <span class="sexy-digg"></span> <input <?php echo (@in_array("digg", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="digg" /> Digg <br />
    <span class="sexy-furl"></span> <input <?php echo (@in_array("furl", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="furl" /> Furl <br />
    <span class="sexy-reddit"></span> <input <?php echo (@in_array("reddit", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="reddit" /> Reddit <br />
    <span class="sexy-yahoomyweb"></span> <input <?php echo (@in_array("yahoomyweb", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="yahoomyweb" /> Yahoo MyWeb <br />
    <span class="sexy-stumbleupon"></span> <input <?php echo (@in_array("stumbleupon", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="stumbleupon" /> StumbleUpon <br />
    <span class="sexy-technorati"></span> <input <?php echo (@in_array("technorati", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="technorati" /> Technorati <br />
    <span class="sexy-mixx"></span> <input <?php echo (@in_array("mixx", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="mixx" /> Mixx <br />
    <span class="sexy-myspace"></span> <input <?php echo (@in_array("myspace", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="myspace" /> MySpace <br />
    <span class="sexy-designfloat"></span> <input <?php echo (@in_array("designfloat", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="designfloat" /> DesignFloat <br />
    <span class="sexy-facebook"></span> <input <?php echo (@in_array("facebook", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="facebook" /> Facebook <br />
	<span class="sexy-twitter"></span> <input <?php echo (@in_array("twitter", $plugopts['bookmark'])? 'checked="checked"' : ""); ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="twitter" /> Twitter <br />
   </td>
  <tr>
   <td><br /><br /></td>
  </tr>
  <tr>  
   <td colspan="2"><div class="submit"><input type="submit" value="Save Changes" /></div></td>
  </tr>
</table>
</form>
<p>Please visit <a href="http://eight7teen.com/" target="_blank">Eight7Teen</a> for more development resources. Alternatively, you could help support my sanity by <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3415856" target="_blank">donating a Mt. Dew</a>!</p>
</div>

<?php

}//closing brace for function "settings_page"


//define a few variables
function position_menu($post_content) {


	global $plugopts;
	$relopt = $plugopts['reloption'];
	$tarwin = $plugopts['targetopt'];
	$title = urlencode(get_the_title());
	$perms = get_permalink();

	//write the menu
	$socials = '<div class="sexy-bookmarks" style="'.__($plugopts['xtrastyle']).'"><ul class="socials">'.
	(in_array("scriptstyle", $plugopts['bookmark'])?
	'<li class="sexy-script-style"><a href="http://scriptandstyle.com/submit?url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Submit this to Script &amp; Style"> </a></li>' : '').
	
	(in_array("blinklist", $plugopts['bookmark'])?
	'<li class="sexy-blinklist"><a href="http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url='.$perms.'&amp;Title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Blinklist"> </a></li>' : '').
	
	(in_array("delicious", $plugopts['bookmark'])?
	'<li class="sexy-delicious"><a href="http://del.icio.us/post?url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on del.icio.us"> </a></li>' : '').
	
	(in_array("digg", $plugopts['bookmark'])?
	'<li class="sexy-digg"><a href="http://digg.com/submit?phase=2&amp;url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Digg this!"> </a></li>' : '').
	
	(in_array("furl", $plugopts['bookmark'])?
	'<li class="sexy-furl"><a href="http://www.furl.net/storeIt.jsp?t='.$title.'&amp;u='.$perms.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Furl"> </a></li>' : '').
	
	(in_array("reddit", $plugopts['bookmark'])?
	'<li class="sexy-reddit"><a href="http://reddit.com/submit?url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Reddit"> </a></li>' : '').
	
	(in_array("yahoomyweb", $plugopts['bookmark'])?
	'<li class="sexy-yahoo"><a href="http://myweb2.search.yahoo.com/myresults/bookmarklet?t='.$title.'&amp;u='.$perms.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Save this to Yahoo MyWeb"> </a></li>' : '').
	
	(in_array("stumbleupon", $plugopts['bookmark'])?
	'<li class="sexy-stumble"><a href="http://www.stumbleupon.com/submit?url='.$perms.'&amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Stumble upon something good? Share it on StumbleUpon"> </a></li>' : '').

	(in_array("technorati", $plugopts['bookmark'])?
	'<li class="sexy-technorati"><a href="http://technorati.com/faves?add='.$perms.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Technorati"> </a></li>' : '').
	
	(in_array("mixx", $plugopts['bookmark'])?
	'<li class="sexy-mixx"><a href="http://www.mixx.com/submit?page_url='.$perms.'&amp;amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Mixx"> </a></li>' : '').
	
	(in_array("myspace", $plugopts['bookmark'])?
	'<li class="sexy-myspace"><a href="http://www.myspace.com/Modules/PostTo/Pages/?u='.$perms.'&amp;amp;t='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Post this to MySpace"> </a></li>' : '').
	
	(in_array("designfloat", $plugopts['bookmark'])?
	'<li class="sexy-designfloat"><a href="http://www.designfloat.com/submit.php?url='.$perms.'&amp;amp;title='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Submit this to DesignFloat"> </a></li>' : '').
	
	(in_array("facebook", $plugopts['bookmark'])?
	'<li class="sexy-facebook"><a href="http://www.facebook.com/share.php?u='.$perms.'&amp;amp;t='.$title.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Share this on Facebook"> </a></li>' : '').

	(in_array("twitter", $plugopts['bookmark'])?
	'<li class="sexy-twitter"><a href="http://www.twitter.com/home?status=Currently+Reading:+'.$perms.'" target="'.$tarwin.'" rel="'.$relopt.'" title="Tweet This!"> </a></li>' : '').
	
	'</ul></div>';

	if(is_single() && $plugopts['position'] == "above" && $plugopts['pageorpost'] == "post") return $socials.$post_content;
	elseif(is_single() && $plugopts['position'] == "below" && $plugopts['pageorpost'] == "post") return $post_content.$socials;
	elseif(is_page() && $plugopts['position'] == "above" && $plugopts['pageorpost'] == "page") return $socials.$post_content;
	elseif(is_page() && $plugopts['position'] == "below" && $plugopts['pageorpost'] == "page") return $post_content.$socials;
	elseif( ( is_page() || is_single() ) && $plugopts['position'] == "above" && $plugopts['pageorpost'] == "pagepost") return $socials.$post_content;
	elseif( ( is_page() || is_single() ) && $plugopts['position'] == "below" && $plugopts['pageorpost'] == "pagepost") return $post_content.$socials;
	else return $post_content;
}


//write the <head> code
add_action('wp_head', 'add_styles');
function add_styles() {
 echo "\n".'<!-- Start Of Code Generated By SexyBookmarks '.vNum.' -->'."\n".
 '<!--[if lt IE 7]>'."\n".
 '<script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE7.js" type="text/javascript"></script>'."\n".
 '<![endif]-->'."\n";
 if(@file_exists(PLUGPATH.'/style.css')) {
  wp_register_style('sexy-bookmarks', get_stylesheet_directory_uri().'/style.css', false, vNum, 'all');
} else {
  wp_register_style('sexy-bookmarks', plugins_url('sexybookmarks/style.css'), false, vNum, 'all');
}
  wp_print_styles('sexy-bookmarks');
 echo '<!-- End Of Code Generated By SexyBookmarks '.vNum.' -->'."\n";
}

//styles for admin area
function sexy_admin() {
echo "<style type='text/css'>
h2.sexy {
display:inline;
width:auto;
padding-left:15px;
background:url(".PLUGPATH."icon.png) no-repeat left 15px;
}
form#sexy-bookmarks span {
background:url(".PLUGPATH."sprite-trans.png) no-repeat;
display:inline-block;
height:29px;
width:50px;
}	
span.sexy-scriptstyle { background-position:-400px bottom !important; }
span.sexy-mixx { background-position:-250px bottom !important; }
span.sexy-facebook { background-position:-450px bottom !important; }
span.sexy-myspace { background-position:-200px bottom !important; }
span.sexy-blinklist { background-position:-600px bottom !important; }
span.sexy-yahoomyweb { background-position:-650px bottom !important; }
span.sexy-delicious { background-position:left bottom !important; }
span.sexy-stumbleupon { background-position:-50px bottom !important; }
span.sexy-reddit { background-position:-100px bottom !important; }
span.sexy-digg { background-position:-500px bottom !important; }
span.sexy-furl { background-position:-300px bottom !important; }
span.sexy-twitter { background-position:-350px bottom !important; }
span.sexy-technorati { background-position:-700px bottom !important; }
span.sexy-designfloat { background-position:-550px bottom !important; }
</style>";
}

add_action('admin_head', 'sexy_admin');
add_action('admin_menu', 'menu_link');
add_filter('the_content', 'position_menu');
?>