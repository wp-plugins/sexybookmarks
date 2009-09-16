<?php
// functions related to mobile.
require_once 'mobile.php';
$sexy_is_mobile=sexy_is_mobile();
$sexy_is_bot=sexy_is_bot();

function sexy_get_fetch_url() {
	global $post, $sexy_plugopts;
	if($sexy_plugopts['position'] == 'manual') { $perms= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']; }
	else { $perms = get_permalink(); }
	
	// which short url service should be used?
	if($sexy_plugopts['shorty'] == "e7t") {
		$first_url = "http://e7t.us/create.php?url=".$perms;
	} elseif($sexy_plugopts['shorty'] == "bitly") {
		$first_url = "http://api.bit.ly/shorten?version=2.0.1&longUrl=".$perms."&history=1&login=".$sexy_plugopts['shortyapi']['bitly']['user']."&apiKey=".$sexy_plugopts['shortyapi']['bitly']['key']."&format=json";
	} elseif($sexy_plugopts['shorty'] == "rims") {
		$first_url = "http://ri.ms/api-create.php?url=".$perms;
	} elseif($sexy_plugopts['shorty'] == "tinyarrow") {
		$first_url = "http://tinyarro.ws/api-create.php?url=".$perms;
	} elseif($sexy_plugopts['shorty'] == "tiny") {
		$first_url = "http://tinyurl.com/api-create.php?url=".$perms;
	} elseif($sexy_plugopts['shorty'] == "snip") {
		$first_url = "http://snipr.com/site/snip?&r=simple&link=".$perms;
	} elseif($sexy_plugopts['shorty'] == "shortto") {
		$first_url = "http://short.to/s.txt?url=".$perms;
	} elseif($sexy_plugopts['shorty'] == "cligs") {
		$first_url = "http://cli.gs/api/v1/cligs/create?url=".urlencode($perms);
	} elseif($sexy_plugopts['shorty'] == "supr") {
		$first_url = "http://su.pr/api?url=".$perms;
	} elseif($sexy_plugopts['shorty'] == "trim") {
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
			if($sexy_plugopts['shorty'] == "bitly"){
				$fetch_array = json_decode($fetch_url, true);
				$fetch_url = $fetch_array['results'][$perms]['shortUrl'];
			}
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
	global $sexy_plugopts, $sexy_is_mobile, $sexy_is_bot;
	
	// if user selected manual positioning, get out.
	if ($sexy_plugopts['position']=='manual') {
		return $post_content;
	}

	// if user selected hide from mobile and is mobile, get out.
	elseif ($sexy_plugopts['mobile-hide']=='yes' && false!==$sexy_is_mobile || $sexy_plugopts['mobile-hide']=='yes' && false!==$sexy_is_bot) {
		return $post_content;
	}


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
		error_log(__('an error occurred in SexyBookmarks', 'sexybookmarks'));
		return $post_content;
	}
}
//end sexy_position_menu...

function get_sexy() {
	global $sexy_plugopts, $wp_query, $post;

	$post = $wp_query->post;

	if($sexy_plugopts['position'] == 'manual') { 
		$perms= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']; 
		$title = get_bloginfo('name') . wp_title('-', false);
		$feedperms = strtolower('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']);
#		$mail_subject = urlencode(get_bloginfo('name') . wp_title('-', false));
	}
	
	//Check if index page
	elseif(is_home() && false!==strpos($sexy_plugopts['pageorpost'],"index")) { 
		
		//Check if outside the loop
		if(empty($post->post_title)) { 
			$perms= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']; 
			$title = get_bloginfo('name') . wp_title('-', false);
			$feedperms = strtolower('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']);
#			$mail_subject = urlencode(get_bloginfo('name') . wp_title('-', false));
		} 

		//Otherwise, it must be inside the loop
		else { 
			$perms = get_permalink($post->ID);
			$title = $post->post_title;
			$feedperms = strtolower($perms);
#			$mail_subject = urlencode($post->post_title);
		}
	}
	else { 
		$perms = get_permalink($post->ID);
		$title = $post->post_title;
		$feedperms = strtolower($perms);
#		$mail_subject = urlencode($post->post_title);
	}

	
	//determine how to handle post titles for Twitter
	if (strlen($title) >= 80) {
		$short_title = urlencode(substr($title, 0, 80)."[..]");
	}
	else {
		$short_title = urlencode($title);
	}
	$title=urlencode($title);

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
	} elseif($sexy_plugopts['bgimg'] == 'wealth') {
		$bgchosen = ' sexy-bookmarks-bg-wealth';
	} elseif($sexy_plugopts['bgimg'] == 'enjoy') {
		$bgchosen = ' sexy-bookmarks-bg-enjoy';
	}
	
	// do not add inline styles to the feed.
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
	
	//write the menu
	$socials = '<div class="sexy-bookmarks'.$expand.$autocenter.$bgchosen.'"'.$style.'><ul class="socials">';
	foreach ($sexy_plugopts['bookmark'] as $name) {
		if ($name=='sexy-twitter') {
			$socials.=bookmark_list_item($name, array(
				'post_by'=>(!empty($sexy_plugopts['twittid']))?"RT+@".$sexy_plugopts['twittid'].":+":'',
				'short_title'=>$short_title,
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
				'permalink'=>urldecode($feedperms).$feedstructure,
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
		} elseif ($name=='sexy-designmoo') {
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


//hook the menu to "the_content"
add_filter('the_content', 'sexy_position_menu');
?>
