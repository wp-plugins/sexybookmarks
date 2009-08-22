<?php
// array of bookmarks
$sexy_bookmarks_data=array(
	'sexy-scriptstyle'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Script &amp; Style', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').__('Script &amp; Style', 'sexybookmarks'),
		'baseUrl'=>'http://scriptandstyle.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-blinklist'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Blinklist', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('Blinklist', 'sexybookmarks'),
		'baseUrl'=>'http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=PERMALINK&amp;Title=TITLE',
	),
	'sexy-delicious'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Delicious', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('del.icio.us', 'sexybookmarks'),
		'baseUrl'=>'http://del.icio.us/post?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-digg'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Digg', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Digg this!', 'sexybookmarks'),
		'baseUrl'=>'http://digg.com/submit?phase=2&amp;url=PERMALINK&amp;title=TITLE',
	),
	'sexy-diigo'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Diigo', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Post this on ', 'sexybookmarks').__('Diigo', 'sexybookmarks'),
		'baseUrl'=>'http://www.diigo.com/post?url=PERMALINK&amp;title=TITLE&amp;desc=SEXY_TEASER',
	),
	'sexy-reddit'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Reddit', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('Reddit', 'sexybookmarks'),
		'baseUrl'=>'http://reddit.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-yahoobuzz'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Yahoo! Buzz', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Buzz up!', 'sexybookmarks'),
		'baseUrl'=>'http://buzz.yahoo.com/submit/?submitUrl=PERMALINK&amp;submitHeadline=TITLE&amp;submitSummary=YAHOOTEASER&amp;submitCategory=YAHOOCATEGORY&amp;submitAssetType=YAHOOMEDIATYPE',
	),
	'sexy-stumbleupon'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Stumbleupon', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Stumble upon something good? Share it on StumbleUpon', 'sexybookmarks'),
		'baseUrl'=>'http://www.stumbleupon.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-technorati'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Technorati', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('Technorati', 'sexybookmarks'),
		'baseUrl'=>'http://technorati.com/faves?add=PERMALINK',
	),
	'sexy-mixx'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Mixx', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('Mixx', 'sexybookmarks'),
		'baseUrl'=>'http://www.mixx.com/submit?page_url=PERMALINK&amp;title=TITLE',
	),
	'sexy-myspace'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('MySpace', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Post this to ', 'sexybookmarks').__('MySpace', 'sexybookmarks'),
		'baseUrl'=>'http://www.myspace.com/Modules/PostTo/Pages/?u=PERMALINK&amp;t=TITLE',
	),
	'sexy-designfloat'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('DesignFloat', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').__('DesignFloat', 'sexybookmarks'),
		'baseUrl'=>'http://www.designfloat.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-facebook'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Facebook', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('Facebook', 'sexybookmarks'),
		'baseUrl'=>'http://www.facebook.com/share.php?u=PERMALINK&amp;t=TITLE',
	),
	'sexy-twitter'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Twitter', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Tweet This!', 'sexybookmarks'),
		'baseUrl'=>'http://twitter.com/home?status=POST_BYSHORT_TITLE+-+FETCH_URL',
	),
	/*'sexy-mail'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('\'Email to a Friend\' link', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Email this to a friend?', 'sexybookmarks'),
		'baseUrl'=>'SEXY_PLUGPATHmail/friendmail.php',
	),*/
	'sexy-comfeed'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('a \'Subscribe to Comments\' link', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Subscribe to the comments for this post?', 'sexybookmarks'),
		'baseUrl'=>'PERMALINK',
	),
	'sexy-linkedin'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Linkedin', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('Linkedin', 'sexybookmarks'),
		'baseUrl'=>'http://www.linkedin.com/shareArticle?mini=true&amp;url=PERMALINK&amp;title=TITLE&amp;summary=POST_SUMMARY&amp;source=SITE_NAME',
	),
	'sexy-newsvine'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Newsvine', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Seed this on ', 'sexybookmarks').__('Newsvine', 'sexybookmarks'),
		'baseUrl'=>'http://www.newsvine.com/_tools/seed&amp;save?u=PERMALINK&amp;h=TITLE',
	),
	'sexy-devmarks'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Devmarks', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('Devmarks', 'sexybookmarks'),
		'baseUrl'=>'http://devmarks.com/index.php?posttext=POST_SUMMARY&amp;posturl=PERMALINK&amp;posttitle=TITLE',
	),
	'sexy-google'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Google Bookmarks', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').__('Google Bookmarks', 'sexybookmarks'),
		'baseUrl'=>'http://www.google.com/bookmarks/mark?op=add&amp;bkmk=PERMALINK&amp;title=TITLE',
	),
	'sexy-misterwong'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Mister Wong', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').__('Mister Wong', 'sexybookmarks'),
		'baseUrl'=>'http://'.__('www.mister-wong.com', 'sexybookmarks').'/addurl/?bm_url=PERMALINK&amp;bm_description=TITLE&amp;plugin=sexybookmarks',
	),
	'sexy-izeby'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Izeby', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').__('Izeby', 'sexybookmarks'),
		'baseUrl'=>'http://izeby.com/submit.php?url=PERMALINK',
	),
	'sexy-tipd'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Tipd', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('Tipd', 'sexybookmarks'),
		'baseUrl'=>'http://tipd.com/submit.php?url=PERMALINK',
	),
	'sexy-pfbuzz'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('PFBuzz', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('PFBuzz', 'sexybookmarks'),
		'baseUrl'=>'http://pfbuzz.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-friendfeed'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('FriendFeed', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('FriendFeed', 'sexybookmarks'),
		'baseUrl'=>'http://www.friendfeed.com/share?title=TITLE&amp;link=PERMALINK',
	),
	'sexy-blogmarks'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('BlogMarks', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Mark this on ', 'sexybookmarks').__('BlogMarks', 'sexybookmarks'),
		'baseUrl'=>'http://blogmarks.net/my/new.php?mini=1&amp;simple=1&amp;url=PERMALINK&amp;title=TITLE',
	),
	'sexy-twittley'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Twittley', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').__('Twittley', 'sexybookmarks'),
		'baseUrl'=>'http://twittley.com/submit/?title=TITLE&amp;url=PERMALINK&amp;desc=POST_SUMMARY&amp;pcat=TWITT_CAT&amp;tags=DEFAULT_TAGS',
	),
	'sexy-fwisp'=>array(
		'check'=>__('Check this box to include ', 'sexybookmarks').__('Fwisp', 'sexybookmarks').__(' in your bookmarking menu', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('Fwisp', 'sexybookmarks'),
		'baseUrl'=>'http://fwisp.com/submit?url=PERMALINK',
	),
);
?>
