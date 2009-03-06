=== SexyBookmarks ===
Contributors: Josh Jones
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3415856
Tags: sexy,social bookmarking,bookmarks menu,digg,delicious,furl,myspace,twitter,facebook,technorati,reddit,yahoo 
Requires at least: 2.7
Tested up to: 2.7.1
Stable tag: 1.3.1

Adds a social bookmarking menu to your posts and/or pages

== Description ==
=v1.3.1 Notice=
If you downloaded version 1.3 and your plugin quit working, I'm sorry. I accidentally uploaded the wrong copy of the plugin to the svn. However, version 1.3.1 fixes my goof and also adds more features (see changelog)


SexyBookmarks is based on [WP-Social-Bookmark-Menu](http://wordpress.org/extend/plugins/wp-social-bookmark-menu) by [Giovambattista Fazioli](http://undolog.com). Where WP-Social-Bookmark-Menu allows you to choose which sites to display and whether to display the menu above or below the post, SexyBookmarks extends that capability and adds several new functions for you to choose from. SexyBookmarks allows you to choose the sites you wish to display, choose your "target" attribute, set the "rel" attribute, and choose whether to display above or below the post. The plugin also allows you to enter your own custom CSS into a textarea to style the DIV that contains the menu, but that is purely optional.

== Credits ==

* Credit goes to [Saidmade Labs](http://labs.saidmade.com/ "Saidmade labs") for the original plugin core [WP-Social-Bookmark-Menu](http://wordpress.org/extend/plugins/wp-social-bookmark-menu)
* Credit goes to [Liam McKay](http://wefunction.com/2008/07/function-free-icon-set/ "Function Web Design Studio") for the original "Function Icon Set"
* Credit goes to [Kieran Smith](http://www.kieransmith.net/) for finding/fixing the ever elusive "elseif" bug...

= Thanks =

* Thanks to [Kieran Smith](http://www.kieransmith.net/) for additional development help.
* Thanks to [Nile](http://unlinkthis.net/) for his continue help optimizing the code.


== Screenshots ==

1. A quick preview of the final outcome
2. A look at the plugin options

== Installation ==

1. Upload the extracted archive to 'wp-content/plugins/'
2. Activate the plugin through the 'Plugins' menu
3. Open the plugin settings page Settings -> SexyBookmarks
4. Adjust settings to your liking
4. Enjoy!



== Frequently Asked Questions ==

= I’ve uploaded the plugin and activated, but it’s not showing up or it’s broken… =

This is normally due to styles in your Wordpress theme overriding the styles of the plugin. Check your theme’s stylesheet for rules like !important; as these may be overriding the styles defined by the plugin.

= My favorite bookmarking site isn’t listed! =

You can contact me with the name of the site and the URL, and I will work on releasing it with a future update.

= I’m a Wordpress theme developer, and I’d like to bundle your plugin with my themes. Is this okay? =

Absolutely! Please just let me know where the themes will be released so that I can post about it on my site as well!

= The custom background for the container DIV is not showing up… =

I’ve found a small issues that happens occasionally where the script doesn’t communicate the way it’s supposed to and therefor the styles for the DIV aren’t sent automatically on the first try. If this is happening to you, for now you can fix it by clicking inside the textarea where the custom CSS “default” styles are written, make sure the cursor is at the very end of the styles, press the space bar and add a single space to the end, then save your changes.

= I’ve found a bug not covered here, where do I report it? =

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
