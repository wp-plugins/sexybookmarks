<?php
/*
Plugin Name: SexyBookmarks
Plugin URI: http://sexybookmarks.net
Description: SexyBookmarks adds a (X)HTML compliant list of social bookmarking icons to each of your posts. See <a href="options-general.php?page=sexy-bookmarks.php">configuration panel</a> for more settings.
Version: 2.6.0
Author: Josh Jones, Norman Yung
Author URI: http://eight7teen.com

	Original WP-Social-Bookmark-Plugin Copyright 2009 Saidmade srl (email : g.fazioli@saidmade.com)
	Original Social Bookmarking Menu & SexyBookmarks Plugin Copyright 2009 Josh Jones (email : josh@eight7teen.com)
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
define('SEXY_vNum','2.6.0');
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
	'default_tags' => 'blog', // Random word to prevent the Twittley default tag warning
	'warn-choice' => '',
);

//add to database and reload
add_option(SEXY_OPTIONS, $sexy_plugopts);
$sexy_plugopts = get_option(SEXY_OPTIONS);

require_once "admin.php";
require_once "public.php";
?>
