=== SexyBookmarks ===
Contributors: [Josh Jones](http://eight7teen.com)
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3415856
Tags: sexy,social bookmarking,bookmarks menu,digg,delicious,furl,myspace,twitter,facebook,technorati,reddit,yahoo 
Requires at least: 2.7
Tested up to: 2.7.1
Stable tag: 2.0.1

Adds a social bookmarking menu to your posts and/or pages

== Description ==

= 2.0 Update =
This is a major overhaul, and it actually came a bit early and unintended. If you were one of the unfortunate ones who downloaded v1.4, I am truly sorry for all of the bugs. I had tried a completely different approach to v1.4, and that approach failed miserably. So, I skipped ahead and developed v2.0 as quickly as possible to try and revive interest in the plugin for those who had such problems with v1.4



SexyBookmarks is based on [WP-Social-Bookmark-Menu](http://wordpress.org/extend/plugins/wp-social-bookmark-menu) by [Giovambattista Fazioli](http://undolog.com). Where WP-Social-Bookmark-Menu allows you to choose which sites to display and whether to display the menu above or below the post, SexyBookmarks extends that capability and adds several new functions for you to choose from. SexyBookmarks allows you to choose the sites you wish to display, choose your "target" attribute, set the "rel" attribute, and choose whether to display above or below the post. The plugin also allows you to enter your own custom CSS into a textarea to style the DIV that contains the menu, but that is purely optional.



== Credits ==

* Credit goes to [Saidmade Labs](http://labs.saidmade.com/ "Saidmade labs") for the original plugin core [WP-Social-Bookmark-Menu](http://wordpress.org/extend/plugins/wp-social-bookmark-menu)
* Credit goes to [Liam McKay](http://wefunction.com/2008/07/function-free-icon-set/ "Function Web Design Studio") for the original "Function Icon Set"
* Credit goes to [Kieran Smith](http://www.kieransmith.net/) for finding/fixing the ever elusive "elseif" bug...

= Thanks =

* Thanks to [Kieran Smith](http://www.kieransmith.net/) for additional development help.
* Thanks to [Nile](http://unlinkthis.net/) for his continued help optimizing the code.

== Screenshots ==

1. A quick preview of the final outcome

== Installation ==

1. Upload the extracted archive to 'wp-content/plugins/'
2. Activate the plugin through the 'Plugins' menu
3. Open the plugin settings page Settings -> SexyBookmarks
4. Adjust settings to your liking
4. Enjoy!

= Manual Usage =

If you would like to insert the menu manually, simply choose "Manually insert" from the options page, then place the following code into your theme files where you want the menu to appear:

`<?php if(function_exists('selfserv_sexy')) { selfserv_sexy(); } ?>`

You can still configure the other options available when inserting manually and they will be passed to the function. This is for those of you who have requested to be able to place the menu anywhere you choose... Enjoy!


== Frequently Asked Questions ==

= I've uploaded the plugin and activated, but it's not showing up or it's broken… =

This is normally due to styles in your Wordpress theme overriding the styles of the plugin. Check your theme's stylesheet for rules like !important; as these may be overriding the styles defined by the plugin.

= My favorite bookmarking site isn't listed! =

You can contact me with the name of the site and the URL, and I will work on releasing it with a future update.

= I'm a Wordpress theme developer, and I'd like to bundle your plugin with my themes. Is this okay? =

Absolutely! Please just let me know where the themes will be released so that I can post about it on my site as well!

= I've found a bug not covered here, where do I report it? =

Please report all bugs via the comment form below for quickest response and notation time. Otherwise, you can choose to email me via the [contact form](http://eight7teen.com/contact "Contact Form") located on my site


== Changelog ==

* 1.0		Initial release
* 1.1		Added Twitter to the list, also added more admin options
* 1.1.1	Added a custom CSS section for styling the container DIV
* 1.1.2	Fixed issue with custom css section overlapping icons in options page, also added custom background styles to the container DIV
* 1.1.3	Fixed bug that caused pages to disappear, also now plugin only displays on single posts
* 1.1.4	Resolved issue that caused the menu to be placed at top of post even if "below post" was chosen
* 1.2		Critical namespace update, also added function to allow you to choose page, post, or both
* 1.2.1	Fixed issue people have been having with an additional overlay of the menu where it shouldn't be (other plugin conflicts)
* 1.3		Corrected a css bug causing the DIV's background image to show
* 1.3.1	Fixed my goof from last night that caused images to disappear. Also added extra functionality for Twitter link (auto @reply with your Twitter id) and runs URLs through the API at [IS.GD](http://is.gd) to automatically shorten URLs for the Twitter link.
* 1.3.2	Added a custom function so that you can now insert the menu into your theme anywhere you choose
* 1.3.3	Fixed Twitter links (http://is.gd has a new api with tighter restrictions, so now the plugin uses http://ri.ms to shorten links)
* 1.3.4	Done away with all third party URL shortening services. Now using my own service so that you will not receive errors when the max API limit has been reached.
* 1.4		FAIL - abandoned development and skipped ahead
* 2.0		Added newsvine, devmarks, linkedin, "Email to friend", and "Subscribe to comments". Also fixed a security issue regarding file_get_contents, it now uses cURL instead. Got rid of the table based layout for the admin options area, and replaced it with DIVs. Also restructured the options area and added another option for choosing the background image of the DIV that contains the menu.
* 2.0.1	Fixed the problem with your blogname showing up in each post. Also fixed the encoding of : and ? characters.