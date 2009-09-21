=== SexyBookmarks ===
Contributors: eight7teen, normanyung
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3415856
Tags: sexybookmarks,sexy bookmarks,sexy,social bookmarking,bookmarks menu,digg,delicious,diigo,myspace,twitter,facebook,technorati,reddit,yahoo,twittley
Requires at least: 2.7
Tested up to: 2.8.4
Stable tag: 2.5.3.3

Adds an attractive social bookmarking menu to your posts, pages, index, or any combination of the three.

== Description ==

= Recent Updates =
* Added French translation
* Added ability to disable on post by post basis


= Latest News =



== Credits ==
* Credit goes to [Maître Mô](http://maitremo.fr) for translating to French
* Credit goes to [Yuri Gribov](http://wp-ru.ru) for translating to Russian



= Thanks =
* Thanks to [Saidmade Labs](http://labs.saidmade.com/ "Saidmade labs") for the original plugin core [WP-Social-Bookmark-Menu](http://wordpress.org/extend/plugins/wp-social-bookmark-menu)
* Thanks to [Liam McKay](http://wefunction.com/2008/07/function-free-icon-set/ "Function Web Design Studio") for the original "Function Icon Set"
* Thanks to [Kieran Smith](http://www.kieransmith.net/) for additional development help.
* Thanks to [Crey Design](http://creydesign.com) for the new background image.
* Thanks to [Sascha Carlin](http://itst.net/) for the patch to make the plugin work sitewide with a single instance of the menu
* Thanks to [Artem Russakovskii](http://beerpla.net) for figuring out the solution to restrict the loading of scripts and styles to the plugin's admin page only
* Thanks to [Gautam Gupta](http://gaut.am/) for figuring out the extremely annoying Twitter encoding bug!




== Screenshots ==

1. A quick preview of the final outcome


== Installation ==

1. Upload the extracted archive to 'wp-content/plugins/'
2. Activate the plugin through the 'Plugins' menu
3. Open the plugin settings page Settings -> SexyBookmarks
4. Adjust settings to your liking
4. Enjoy!

= Manual Usage =
**As of v2.5 the menu can be inserted once anywhere within your site (even outside the loop) and it will still pull the appropriate data for the dynamic links**

If you would like to insert the menu manually, simply choose "Manually insert" from the options page, then place the following code into your theme files where you want the menu to appear:

`<?php if(function_exists('selfserv_sexy')) { selfserv_sexy(); } ?>`

You can still configure the other options available when inserting manually and they will be passed to the function. This is for those of you who have requested to be able to place the menu anywhere you choose... Enjoy!


== Frequently Asked Questions ==
= The menu shows up as a regular list with no styling and no images! =
Unfortunately, this is becoming a more prevalent problem recently and it's due to your WordPress theme not having the function reference `wp_head()` in the **header.php** file as it should. SexyBookmarks uses this function to hook the associated stylesheet and javascript files into the `<head>` of your document. So if it doesn't exist, then the stylesheet and/or javascript files won't be included on your site.

= I see blank spaces where icons used to be! =
This means that whatever service was previously in that space has been removed from the plugin either permanently or temporarily as we work out bugs or incorporate upgraded functionality. To remove the blank space, simply follow the detailed instructions found on the actual [FAQ Page](http://sexybookmarks.net/documentation/faq#17).

= My jQuery slider/fader doesn't work anymore! =
Please disable both of the jQuery dependent options (auto-center and animate-expand) in the plugin options area. We are working on a solution to make the plugin FULLY compatible with ALL themes, but have not reached that point yet... Sorry.

= Your plugin broke my site and there's a ton of stuff from another site being displayed!!! =
This isn't as critical as it may look... Simply choose another URL shortening service and select the "Clear all short URLs" option. Now save the changes and [report which URL shortening service you were using](http://sexybookmarks.net/contact-forms/bug-form/) that broke your site so I can look into it.

= I've uploaded the plugin and activated, but it's not showing up or it's broken… =

This is normally due to styles in your Wordpress theme overriding the styles of the plugin. Check your theme's stylesheet for rules like `!important;` as these may be overriding the styles defined by the plugin.

= My favorite bookmarking site isn't listed! =

You can contact me with the name of the site and the URL, and I will work on releasing it with a future update.

= I'm a Wordpress theme developer, and I'd like to bundle your plugin with my themes. Is this okay? =

Absolutely! Please just [let me know](http://sexybookmarks.net/contact-forms/contact-us/) where the themes will be released so that I can post about it on my site as well!

= I've found a bug not covered here, where do I report it? =

Please report all bugs via the [Bug Report Form](http://sexybookmarks.net/contact-forms/bug-form/) for quickest response and notation time.


== Changelog ==
= 2.6.0 =
* Added French translation
* Added ability to disable on a post by post basis

= 2.5.3.3 =
* snuck in fixing issues introduced w/ some css changes.
* also just made another release for those who may have gotten the improper release from last night so you won't have to jump thru hoops to get a fixed version.

= 2.5.3.2 =
* No changes, just fixing SVN hiccup from earlier tonight

= 2.5.3.1 =
* Fixed issue from **v2.5.3** where CSS was not being applied properly
* Fixed issue with bit.ly being stubborn when selected

= 2.5.3 =
* Added i18n / l10n support
* Added Russian translation and several popular Russian bookmarking sites
* Added DesignMoo
* Added bit.ly support and integration
* Fixed plugin conflicts due to jQuery incompatibility


= 2.5.2.3 =
* Added mobile browser check & ability to hide menu from mobile
* Fixed issue with titles & URLs on index pointing to site and not individual articles
* Fixed persistent Twittley error message when saving settings
* Resolved issue with Google Bookmarks link
* Fixed Subscribe to comments link
* Fixed issue with some themes forcing borders and background colors for menu items
* Minor dashboard adjustments

= 2.5.2.2 =
* Changed icon of Fwisp by request of site owner
* Fixed status message problem when trying to dismiss more than one
* Re-added Twitter Friendly Links support after accidental removal
* Added an automatic check/removal of email link for those who previously had it set

= 2.5.2.1 =
* Fixed URL shortening bug from 2.5.2
* Fixed persistent Twitter bug
* Fixed readme problem

= 2.5.2 =
* Added cligs, Supr, Short-to, and Trim as supported URL shortening services
* Added Fwisp as a supported site
* FIXED TWITTER ENCODING BUG!!!
* Updated/Optimized readme file
* Updated screenshot
* Completely redesigned the entire plugin options page
* Refactored some JS code.
* Limited the jQuery selector for "external" links within the .sexy-bookmarks div.
* Do not apply JS when links are set **not** to open in a new window in the case that some other plugin is handling such links.
* Added a few more BG images to choose from.
* Removed email link until further notice.
* Fixed the issue with scripts and styles loading throughout the entire dashboard.
* Fixed small issue with manual mode returning wrong post titles.
* Added Twittley to the list of sites

= 2.5.1 =
* Fixed problem with auto-centering and animation slide effect not working.

= 2.5 =
* Added a permalink structure check so that ALL subscribe to comments links will work no matter how your permalinks are configured.
* Fixed my CSS goof for people who's theme was applying a background color rather than the desired image.
* Added the ability to host your own short URLs by using the [Twitter Friendly Links Plugin](http://wordpress.org/extend/plugins/twitter-friendly-links/).
* You can now choose to place the menu on your site anywhere **once** and it will work throughout the entire site rather than having it displayed on every page/article.
* Added new "smart options" in the admin area (dependent options).
* Added new background image "Share the wealth!".
* Updated the "Sharing is sexy!" and "Sharing is caring!" images.

= 2.4.3 =
* Replaced the deceased Yahoo! MyWeb with Yahoo! Buzz and a few custom features for that particular service.
* Fixed error with images not showing up for Tipd, Tumblr, and PFBuzz.

= 2.4.2 =
* Fixed typo with one of the URL shortening services.
* Fixed the subscribe to comments feed error I created.

= 2.4.1 =
* Small CSS fix for anyone having CSS generated content placed in the menu by their theme's stylesheet.
* Fixed validation error for PFBuzz link.

= 2.4 =
* Added Tipd, Tumblr, and PFBuzz to the list of available sites.

= 2.3.4 =
* Small CSS fix for those of you who don't get the "hover" effect on mouseover.

= 2.3.3 =
* Fixed Snipr URL shortener.
* Minor CSS fixes

= 2.3.2 =
* Added option to reset/refresh all stored short URLs.

= 2.3.1 =
* Fixed auto-centering js not being included when it should be.
* Fixed minor bug causing apostrophes to not be encoded properly for email subject/body.

= 2.3.0 =
* Restyled the admin panel and logically grouped the options/settings.
* Removed use of inline styles (most of them anyway).
* Minor bug fix for servers that don't support short tags (i.e. you're getting all the Array Array Array messages).

= 2.2.4 =
* Added iZeby and Mister Wong to the list of available sites.

= 2.2.3 =
* Fixed minor CSS issue introduced in v2.2.2
* Added option to auto-center the bookmarks menu (via jQuery).

= 2.2.2 =
* Added option to vertically expand multi-rowed bookmark lines on mouseover using jQuery.

= 2.2.1 =
* Fixed problem with short tags that caused an array to print at top of your pages.
* Fixed urlencode of subject and body of email link.
* Fixed code's "validity".
* Title text shows up correctly now rather than displaying the word "Array" when hovering over links.

= 2.2 =
* Icons are now rearrangeable.
* You can now pick your own URL shortening service.
* Code is more efficient and puts less strain on the server.

= 2.1.5 =
* Fixed bug causing email link to break layouts in some cases (minor update, only critical to those using NextGen plugin).

= 2.1.4 =
* Fixed small bug that was messing up the "Quick Edit" styles in the dashboard (minor update, not critical).

= 2.1.3 =
* Replaced cURL command with custom function that stores short URLs in the database to reduce server load.
* Replaced Furl with Diigo since Furl no longer exists.
* Now only fetching short URL if Twitter is selected to be displayed in the menu.

= 2.1.2 =
* Added ability to choose which URL shortening service to use.
* Also added a fallback to file_get_contents() if cURL is not enabled on your server.
* Added another fallback so that if file_get_contents() isn't enabled either, the URL won't be shortened and will simply print the permalink of the post.

= 2.1.1 =
* Fixed the bug causing your sites to crash right and left due to timeouts with the URL shortening service.

= 2.1 =
* Added ability to display menu on main page.
* Fixed 2 minor bugs with email link
* Shortened URLs are now static and do not change with each page refresh.

= 2.0.3 =
* Fixed error causing RSS and Email icons not to show up when using manual method.

= 2.0.2 =
* Fixed the display error for Yahoo and Stumbleupon when using manual method.

= 2.0.1 =
* Fixed the problem with your blogname showing up in each post.
* Also fixed the encoding of **:** and **?** characters.

= 2.0 =
* Added newsvine, devmarks, linkedin, "Email to friend", and "Subscribe to comments".
* Got rid of the table based layout for the admin options area, and replaced it with DIVs.
* Added another option for choosing the background image of the DIV that contains the menu.

= 1.4 =
* FAIL - abandoned development and skipped ahead

= 1.3.4 =
* Done away with all third party URL shortening services. Now using my own service so that you will not receive errors when the max API limit has been reached.

= 1.3.3 =
* Fixed Twitter links (http://is.gd has a new api with tighter restrictions, so now the plugin uses http://ri.ms to shorten links).

= 1.3.2 =
* Added a custom function so that you can now insert the menu into your theme anywhere you choose.

= 1.3.1 =
* Fixed my goof from last night that caused images to disappear.
* Added extra functionality for Twitter link (auto @reply with your Twitter id).
* Twitter link automatically shortens the URL to each post via the API at [IS.GD](http://is.gd).

= 1.3 =
* Corrected a css bug causing the DIV's background image to show.

= 1.2.1 =
* Fixed issue people have been having with an additional overlay of the menu where it shouldn't be (other plugin conflicts).

= 1.2 =
* Critical namespace update, no longer "WP-Social-Bookmarks".
* Added function to allow you to choose page, post, or both.

= 1.1.4 =
* Resolved issue that caused the menu to be placed at top of post even if "below post" was chosen.

= 1.1.3 =
* Fixed bug that caused pages to disappear, 
* Now plugin only displays on single posts

= 1.1.2 =
* Fixed issue with custom css section overlapping icons in options page.
* Added custom background styles to the container DIV.

= 1.1.1 =
* Added a custom CSS section for styling the container DIV.

= 1.1 =
* Added Twitter to the list.
* Added a few more options.

= 1.0 =
* Initial release!
