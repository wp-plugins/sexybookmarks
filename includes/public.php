<?php

// Functions related to mobile.
require_once 'mobile.php';
$sexy_is_mobile = sexy_is_mobile();
$sexy_is_bot = sexy_is_bot();

//cURL, file get contents or nothing, used for short url
function sexy_nav_browse($url, $method = 'GET', $data = array()){
	return wp_remote_retrieve_body( wp_remote_request( $url, array( 'method' => $method, 'body' => $data, 'user-agent' => 'SexyBookmarks WP Plugin - http://www.sexybookmarks.net/' ) ) );
}

function sexy_get_fetch_url() {
	global $post, $sexy_plugopts, $wp_query; //globals
	
	//get link but first check if inside or outside loop and what page it's on
	$post = $wp_query->post;

	if($sexy_plugopts['position'] == 'manual') {
		//Check if outside the loop
		if(empty($post->post_title)) {
			$perms= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];
		}
		//Otherwise, it must be inside the loop
		else {
			$perms = get_permalink($post->ID);
		}
	}
	//Check if index page...
	elseif(is_home() && false!==strpos($sexy_plugopts['pageorpost'],"index")) {
		//Check if outside the loop
		if(empty($post->post_title)) {
			$perms= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];
		}
		//Otherwise, it must be inside the loop
		else {
			$perms = get_permalink($post->ID);
		}
	}
	//Apparently isn't on index page...
	else {
		$perms = get_permalink($post->ID);
	}
	$perms = trim($perms);
	
	//if is post, and post is not published then return permalink and go back
	if($post && get_post_status($post->ID) != 'publish') {
		return $perms;
	}
	//if user chose not to use shortener, return permalink and go back
	if($sexy_plugopts['shorty'] == 'none') {
		return $perms;
	}
	
	if ($sexy_plugopts['shorty'] == 'tflp' && function_exists('permalink_to_twitter_link')) {
		$fetch_url = permalink_to_twitter_link($perms);
	} elseif ($sexy_plugopts['shorty'] == 'yourls' && function_exists('wp_ozh_yourls_raw_url')) {
		$fetch_url = wp_ozh_yourls_raw_url();
	}

	if( !empty( $fetch_url ) ) //if it is tflp or yourls and short url has been successfully recieved, then do not save it in db or try getting a stored short url
		return $fetch_url;

	//check if the link is already genereted or not, if yes, then return the link
	$fetch_url = trim(get_post_meta($post->ID, '_sexybookmarks_shortUrl', true));
	if(!is_null($fetch_url) && md5($perms) == trim(get_post_meta($post->ID, '_sexybookmarks_permaHash', true)))
		return $fetch_url;

	//some vars to be used later, so better set null values before
	$url_more = "";
	$method = 'GET';
	$POST_data = array();
	 
	// Which short url service should be used?
	switch ( $sexy_plugopts['shorty'] ) {
		case 'tiny':
			$first_url = "http://tinyurl.com/api-create.php?url=".$perms;
			break;
		case 'snip':
			$first_url = "http://snipr.com/site/getsnip";
			$method = 'POST';
			$POST_data = array( "snipformat" => "simple", "sniplink" => rawurlencode($perms), "snipuser" => $sexy_plugopts['shortyapi']['snip']['user'], "snipapi" => $sexy_plugopts['shortyapi']['snip']['key'] );
			break;
		case 'cligs':
			$first_url = "http://cli.gs/api/v1/cligs/create?url=".urlencode($perms)."&appid=sexy";
			if ($sexy_plugopts['shortyapi']['cligs']['chk'] == 1) //if user custom options are set
				$first_url .= "&key=".$sexy_plugopts['shortyapi']['cligs']['key'];
			break;
		case 'supr':
			$first_url = "http://su.pr/api/simpleshorten?url=".$perms;
			if($sexy_plugopts['shortyapi']['supr']['chk'] == 1) //if user custom options are set
				$first_url .= "&login=".$sexy_plugopts['shortyapi']['supr']['user']."&apiKey=".$sexy_plugopts['shortyapi']['supr']['key'];
			break;
		case 'bitly':
			$first_url = "http://api.bit.ly/shorten?version=2.0.1&longUrl=".$perms."&history=1&login=".$sexy_plugopts['shortyapi']['bitly']['user']."&apiKey=".$sexy_plugopts['shortyapi']['bitly']['key']."&format=json";
			break;
		case 'trim':
			if($sexy_plugopts['shortyapi']['trim']['chk'] == 1){ //if user custom options are set
				$first_url = "http://api.tr.im/api/trim_url.json?url=".$perms."&username=".$sexy_plugopts['shortyapi']['trim']['user']."&password=".$sexy_plugopts['shortyapi']['trim']['pass'];
			}else{
				$first_url = "http://api.tr.im/api/trim_simple?url=".$perms;
			}
			break;
		case 'tinyarrow':
			$first_url = "http://tinyarro.ws/api-create.php?";
			if($sexy_plugopts['shortyapi']['tinyarrow']['chk'] == 1) //if user custom options are set
				$first_url .= "&userid=".$sexy_plugopts['shortyapi']['tinyarrow']['user'];
			$first_url .= "&url=".$perms; //url has to be last param in tinyarrow
			break;
		case 'slly':
			$first_url = "http://sl.ly/?module=ShortURL&file=Add&mode=API&url=".$perms;
			break;
		case 'e7t': //e7t.us no longer exists, this only here for backwards compatibility
			$first_url = "http://b2l.me/api.php?alias=&url=".$perms;
			$sexy_plugopts['shorty'] = 'b2l';
			update_option(SEXY_OPTIONS, $sexy_plugopts);
			break;
		case 'b2l': //goto default
		default:
			$first_url = "http://b2l.me/api.php?alias=&url=".$perms;
			break;
	}
	
	$fetch_url = trim(sexy_nav_browse($first_url, $method, $POST_data));

	if ( !empty( $fetch_url ) ) {
		//if trim or bitly, then decode the json string
		if($sexy_plugopts['shorty'] == "trim" && $sexy_plugopts['shortyapi']['trim']['chk'] == 1){
			$fetch_array = json_decode($fetch_url, true);
			$fetch_url = $fetch_array['url'];
		}elseif($sexy_plugopts['shorty'] == "bitly"){
			$fetch_array = json_decode($fetch_url, true);
			$fetch_url = $fetch_array['results'][$perms]['shortUrl'];
		}
		// Remote call made and was successful
		// Add/update values
		// Tries to update first, then add if field does not already exist
		if (!update_post_meta($post->ID, '_sexybookmarks_shortUrl', $fetch_url)) {
			add_post_meta($post->ID, '_sexybookmarks_shortUrl', $fetch_url);
		}
		if (!update_post_meta($post->ID, '_sexybookmarks_permaHash', md5($perms))) {
			add_post_meta($post->ID, '_sexybookmarks_permaHash', md5($perms));
		}
	} else {
		$fetch_url = $perms;
	}
	return $fetch_url;
}


// Create an auto-insertion function
function sexy_position_menu($post_content) {
	global $post, $sexy_plugopts, $sexy_is_mobile, $sexy_is_bot;

	// If user selected manual positioning, get out.
	if ($sexy_plugopts['position']=='manual') {
		return $post_content;
	}

	// If user selected hide from mobile and is mobile, get out.
	elseif ($sexy_plugopts['mobile-hide']=='yes' && false!==$sexy_is_mobile || $sexy_plugopts['mobile-hide']=='yes' && false!==$sexy_is_bot) {
		return $post_content;
	}

	// Decide whether or not to generate the bookmarks.
	if ((is_single() && false!==strpos($sexy_plugopts['pageorpost'],"post")) ||
		(is_page() && false!==strpos($sexy_plugopts['pageorpost'],"page")) ||
		(is_home() && false!==strpos($sexy_plugopts['pageorpost'],"index")) ||
		(is_feed() && !empty($sexy_plugopts['feed']))
	) { // socials should be generated and added
		if(!get_post_meta($post->ID, 'Hide SexyBookmarks')) {
			$socials=get_sexy();
		}
	}

	// Place of bookmarks and return w/ post content.
	if (empty($socials)) {
		return $post_content;
	} elseif ($sexy_plugopts['position']=='above') {
		return $socials.$post_content;
	} elseif ($sexy_plugopts['position']=='below') {
		return $post_content.$socials;
	} else { // some other unexpected error, don't do anything. return.
		error_log(__('an error occurred in SexyBookmarks', 'sexybookmarks'));
		return $post_content;
	}
}
// End sexy_position_menu...

function get_sexy() {
	global $sexy_plugopts, $wp_query, $post;

	$post = $wp_query->post;

	if($sexy_plugopts['position'] == 'manual') {

		//Check if outside the loop
		if(empty($post->post_title)) {
			$perms= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];
			$title = get_bloginfo('name') . wp_title('-', false);
			$feedperms = strtolower('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']);
			$mail_subject = urlencode(get_bloginfo('name') . wp_title('-', false));
		}

		//Otherwise, it must be inside the loop
		else {
			$perms = get_permalink($post->ID);
			$title = $post->post_title;
			$feedperms = strtolower($perms);
			$mail_subject = urlencode($post->post_title);
		}
	}

	//Check if index page...
	elseif(is_home() && false!==strpos($sexy_plugopts['pageorpost'],"index")) {

		//Check if outside the loop
		if(empty($post->post_title)) {
			$perms= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];
			$title = get_bloginfo('name') . wp_title('-', false);
			$feedperms = strtolower('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']);
			$mail_subject = urlencode(get_bloginfo('name') . wp_title('-', false));
		}

		//Otherwise, it must be inside the loop
		else {
			$perms = get_permalink($post->ID);
			$title = $post->post_title;
			$feedperms = strtolower($perms);
			$mail_subject = urlencode($post->post_title);
		}
	}
	//Apparently isn't on index page...
	else {
		$perms = get_permalink($post->ID);
		$title = $post->post_title;
		$feedperms = strtolower($perms);
		$mail_subject = urlencode($post->post_title);
	}


	//Determine how to handle post titles for Twitter
	if (strlen($title) >= 80) {
		$short_title = urlencode(substr($title, 0, 80)."[..]");
	}
	else {
		$short_title = urlencode($title);
	}

	$title=urlencode($title);

	$sexy_content	= urlencode(strip_tags(strip_shortcodes($post->post_excerpt)));

	if ($sexy_content == "") {	$sexy_content = urlencode(substr(strip_tags(strip_shortcodes($post->post_content)),0,300)); }

	$sexy_content	= str_replace('+','%20',$sexy_content);
	$post_summary = stripslashes($sexy_content);
	$site_name = get_bloginfo('name');
	$mail_subject = str_replace('+','%20',$mail_subject);
	$mail_subject = str_replace("&#8217;","'",$mail_subject);
	$y_cat = $sexy_plugopts['ybuzzcat'];
	$y_med = $sexy_plugopts['ybuzzmed'];
	$t_cat = $sexy_plugopts['twittcat'];
	$fetch_url = sexy_get_fetch_url();


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
		$feedstructure = '&amp;feed=comments-rss2';
	} else {
		if ('/' == $feedperms[strlen($feedperms) - 1]) {
			$feedstructure = 'feed';
		}
		else {
			$feedstructure = '/feed';
		}
	}


	// Compatibility fix for NextGen Gallery Plugin...
	if( (strpos($post_summary, '[') || strpos($post_summary, ']')) ) {
		$post_summary = "";
	}
	if( (strpos($sexy_content, '[') || strpos($sexy_content,']')) ) {
		$sexy_content = "";
	}

	// Select the background image
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
	} elseif($sexy_plugopts['bgimg'] == 'wealth') {
		$bgchosen = ' sexy-bookmarks-bg-wealth';
	} elseif($sexy_plugopts['bgimg'] == 'enjoy') {
		$bgchosen = ' sexy-bookmarks-bg-enjoy';
	} elseif($sexy_plugopts['bgimg'] == 'german') {
		$bgchosen = ' sexy-bookmarks-bg-german';
	}

	// Do not add inline styles to the feed.
	$style=($sexy_plugopts['autocenter'])?'':' style="'.__($sexy_plugopts['xtrastyle']).'"';
	if (is_feed()) $style='';
	$expand=$sexy_plugopts['expand']?' sexy-bookmarks-expand':'';
	if ($sexy_plugopts['autocenter']==1) {
		$autocenter=' sexy-bookmarks-center';
	} elseif ($sexy_plugopts['autocenter']==2) {
		$autocenter=' sexy-bookmarks-spaced';
	} else {
		$autocenter='';
	}

	//Write the sexybookmarks menu
	$socials = "\n\n".'<!-- Begin SexyBookmarks Menu Code -->'."\n";
	$socials .= '<div class="sexy-bookmarks'.$expand.$autocenter.$bgchosen.'"'.$style.'>'."\n".'<ul class="socials">'."\n";
	foreach ($sexy_plugopts['bookmark'] as $name) {
		switch ($name) {
			case 'sexy-twitter':
				$socials.=bookmark_list_item($name, array(
					'post_by'=>(!empty($sexy_plugopts['twittid']))?"(via+@".$sexy_plugopts['twittid'].")":'',
					'short_title'=>$short_title,
					'fetch_url'=>$fetch_url,
				));
				break;
			case 'sexy-identica':
				$socials.=bookmark_list_item($name, array(
					'short_title'=>$short_title,
					'fetch_url'=>$fetch_url,
				));
				break;
			case 'sexy-mail':
				$socials.=bookmark_list_item($name, array(
					'title'=>$mail_subject,
					'post_summary'=>$post_summary,
					'permalink'=>$perms,
				));
				break;
			case 'sexy-tomuse':
				$socials.=bookmark_list_item($name, array(
					'title'=>$mail_subject,
					'post_summary'=>$post_summary,
					'permalink'=>$perms,
				));
				break;
			case 'sexy-diigo':
				$socials.=bookmark_list_item($name, array(
					'sexy_teaser'=>$sexy_content,
					'permalink'=>$perms,
					'title'=>$title,
				));
				break;
			case 'sexy-linkedin':
				$socials.=bookmark_list_item($name, array(
					'post_summary'=>$post_summary,
					'site_name'=>$site_name,
					'permalink'=>$perms,
					'title'=>$title,
				));
				break;
			case 'sexy-comfeed':
				$socials.=bookmark_list_item($name, array(
					'permalink'=>urldecode($feedperms).$feedstructure,
				));
				break;
			case 'sexy-yahoobuzz':
				$socials.=bookmark_list_item($name, array(
					'permalink'=>$perms,
					'title'=>$title,
					'yahooteaser'=>$sexy_content,
					'yahoocategory'=>$y_cat,
					'yahoomediatype'=>$y_med,
				));
				break;
			case 'sexy-twittley':
				$socials.=bookmark_list_item($name, array(
					'permalink'=>urlencode($perms),
					'title'=>$title,
					'post_summary'=>$post_summary,
					'twitt_cat'=>$t_cat,
					'default_tags'=>$d_tags,
				));
				break;
			case 'sexy-tumblr':
				$socials.=bookmark_list_item($name, array(
					'permalink'=>urlencode($perms),
					'title'=>$title,
				));
				break;
			default:
				$socials.=bookmark_list_item($name, array(
					'post_summary'=>$post_summary,
					'permalink'=>$perms,
					'title'=>$title,
				));
				break;
		}
	}
	$socials.='</ul>'."\n".'<div style="clear:both;"></div>'."\n".'</div>';
	$socials.="\n".'<!-- End SexyBookmarks Menu Code -->'."\n\n";

	return $socials;
}

// This function is what allows people to insert the menu wherever they please rather than above/below a post...
function selfserv_sexy() {
	global $post;
	if(!get_post_meta($post->ID, 'Hide SexyBookmarks'))
		echo get_sexy();
}

// Write the <head> code only on pages that the menu is set to display
function sexy_publicStyles() {
	global $sexy_plugopts, $post;

	// If custom field is set, do not display sexybookmarks
	if(get_post_meta($post->ID, 'Hide SexyBookmarks')) {
		echo "\n\n".'<!-- '.__('SexyBookmarks has been disabled on this page', 'sexybookmarks').' -->'."\n\n";
	} else {
		//custom mods rule over custom css
		$surl = (!is_null($sexy_plugopts['custom-css'])) ? $sexy_plugopts['custom-css'] : SEXY_PLUGPATH.'css/style.css'; // If custom css, generated by sprite
		$surl = ($sexy_plugopts['custom-mods'] == 'yes') ? WP_CONTENT_URL.'/sexy-mods/css/style.css' : $surl; // If custom mods option is selected, pull files from new location
		wp_enqueue_style('sexy-bookmarks', $surl, false, SEXY_vNum, 'all');
	}
}
function sexy_publicScripts() {
	global $sexy_plugopts, $post;
	
	if (($sexy_plugopts['expand'] || $sexy_plugopts['autocenter'] || $sexy_plugopts['targetopt']=='_blank') && !get_post_meta($post->ID, 'Hide SexyBookmarks')) { // If any javascript dependent options are selected, load the scripts
		$surl = ($sexy_plugopts['custom-mods'] == 'yes') ? WP_CONTENT_URL.'/sexy-mods/' : SEXY_PLUGPATH; // If custom mods option is selected, pull files from new location
		$jquery = ($sexy_plugopts['doNotIncludeJQuery'] != '1') ? array('jquery') : array(); // If jQuery compatibility fix is not selected, go ahead and load jQuery
		$infooter = ($sexy_plugopts['scriptInFooter'] == '1') ? true : false;
		wp_enqueue_script('sexy-bookmarks-public-js', $surl.'js/sexy-bookmarks-public.js', $jquery, SEXY_vNum, $infooter);
	}
}

add_action('wp_print_styles', 'sexy_publicStyles');
add_action('wp_print_scripts', 'sexy_publicScripts');
add_filter('the_content', 'sexy_position_menu');
?>