=== SexyBookmarks ===
Contributors: eight7teen, Norman Yung
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3415856
Tags: sexy,social bookmarking,bookmarks menu,digg,delicious,furl,myspace,twitter,facebook,technorati,reddit,yahoo 
Requires at least: 2.7
Tested up to: 2.7.1
Stable tag: 2.2

Adds a social bookmarking menu to your posts, pages, index, or any combination of the three.

== Description ==

= Recent Updates =
Bookmarks are now draggable so that you can display them in whatever order you wish. 
You can select your own URL shortening service. 
Efficiency has been nearly doubled thru code organization and optimization, so now there's less strain on your server.





SexyBookmarks is based on [WP-Social-Bookmark-Menu](http://wordpress.org/extend/plugins/wp-social-bookmark-menu) by [Giovambattista Fazioli](http://undolog.com). Where WP-Social-Bookmark-Menu allows you to choose which sites to display and whether to display the menu above or below the post, SexyBookmarks extends that capability and adds several new functions for you to choose from. SexyBookmarks allows you to choose the sites you wish to display, choose your "target" attribute, set the "rel" attribute, and choose whether to display above or below the post. The plugin also allows you to enter your own custom CSS into a textarea to style the DIV that contains the menu, but that is purely optional.


== Latest News ==
I would like to announce that I am now being assisted in the development of this plugin by [Norman Yung](http://www.robotwithaheart.com). He has offered up several great improvements, and furthermore, has offered to continue helping develop the plugin. 


Also, be looking for v3.0 to include a unique translation system for those who wish to use this plugin in their native language. Not only will the plugin text(s) be translated, but the plugin will offer certain languages with more bookmarking sites to include the sites which are most popular in that region! Coming soon!


== Credits ==

* Credit goes to [Kieran Smith](http://www.kieransmith.net/) for finding/fixing the ever elusive "elseif" bug...
* Credit goes to [Norman Yung](http://www.robotwithaheart.com/) for `just about` every improvement in v2.1.3

= Thanks =
* Thanks [Saidmade Labs](http://labs.saidmade.com/ "Saidmade labs") for the original plugin core [WP-Social-Bookmark-Menu](http://wordpress.org/extend/plugins/wp-social-bookmark-menu)
*Thanks to [Liam McKay](http://wefunction.com/2008/07/function-free-icon-set/ "Function Web Design Studio") for the original "Function Icon Set"
* Thanks to [Kieran Smith](http://www.kieransmith.net/) for additional development help.
* Thanks to [Nile](http://unlinkthis.net/) for his continued help optimizing the code.
* Thanks to [Norman Yung](http://www.robotwithaheart.com/) for the tremendous help in further developing this plugin

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
* 2.0.2	Fixed the display error for Yahoo and Stumbleupon when using manual method.
* 2.0.3	Fixed error causing RSS and Email icons not to show up when using manual method.
* 2.1		Added ability to display menu on main page, 2 minor bug fixes with email link, Shortened URLs are now static and do not change with each page refresh.
* 2.1.1	Fixed the bug causing your sites to crash right and left due to timeouts with the URL shortening service
* 2.1.2	Added ability to choose which URL shortening service to use. Also added a fallback to file_get_contents() if cURL is not enabled on your server. Then if all else fails and file_get_contents() isn't enabled either, the URL won't be shortened and will simply print the permalink of the post.
* 2.1.3	Replaced cURL command with custom function to reduce server load. Replaced Furl with Diigo since Furl no longer exists. Now only fetching short URL if Twitter is selected to be displayed in the menu.
* 2.1.4	Fixed small bug that was messing up the "Quick Edit" styles in the dashboard (minor update, not critical)
* 2.1.5	Fixed bug causing email link to break layouts in some cases (minor update, only critical to those using NextGen plugin)
* 2.2		Icons are now rearrangeable as well as you can now pick your own URL shortening service. Code is more efficient and puts less strain on the server.