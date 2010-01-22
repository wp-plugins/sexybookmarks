<?php
// dynamic mister wong link generator
$wong_tld = '.com';
if(WPLANG == 'de_DE') {
	$wong_tld = '.de';
} elseif(WPLANG == 'zh_CN' || WPLANG == 'zh_HK' || WPLANG == 'zh_TW') {
	$wong_tld = '.cn';
} elseif(WPLANG == 'es_CL'  || WPLANG == 'es_ES' || WPLANG == 'es_PE' || WPLANG == 'es_VE') {
	$wong_tld = '.es';
} elseif(WPLANG == 'fr_FR' || WPLANG == 'fr_BE') {
	$wong_tld = '.fr';
} elseif(WPLANG =='ru_RU' || WPLANG == 'ru_MA') {
	$wong_tld = '.ru';
}

// array of bookmarks
$sexy_bookmarks_data=array(
	'sexy-scriptstyle'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Script &amp; Style', 'sexybookmarks')),
		'share'=>__('Submit this to ', 'sexybookmarks').__('Script &amp; Style', 'sexybookmarks'),
		'baseUrl'=>'http://scriptandstyle.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-blinklist'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Blinklist', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Blinklist', 'sexybookmarks'),
		'baseUrl'=>'http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=PERMALINK&amp;Title=TITLE',
	),
	'sexy-delicious'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Delicious', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('del.icio.us', 'sexybookmarks'),
		'baseUrl'=>'http://del.icio.us/post?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-digg'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Digg', 'sexybookmarks')),
		'share'=>__('Digg this!', 'sexybookmarks'),
		'baseUrl'=>'http://digg.com/submit?phase=2&amp;url=PERMALINK&amp;title=TITLE',
	),
	'sexy-diigo'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Diigo', 'sexybookmarks')),
		'share'=>__('Post this on ', 'sexybookmarks').__('Diigo', 'sexybookmarks'),
		'baseUrl'=>'http://www.diigo.com/post?url=PERMALINK&amp;title=TITLE&amp;desc=SEXY_TEASER',
	),
	'sexy-reddit'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Reddit', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Reddit', 'sexybookmarks'),
		'baseUrl'=>'http://reddit.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-yahoobuzz'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Yahoo! Buzz', 'sexybookmarks')),
		'share'=>__('Buzz up!', 'sexybookmarks'),
		'baseUrl'=>'http://buzz.yahoo.com/submit/?submitUrl=PERMALINK&amp;submitHeadline=TITLE&amp;submitSummary=YAHOOTEASER&amp;submitCategory=YAHOOCATEGORY&amp;submitAssetType=YAHOOMEDIATYPE',
	),
	'sexy-stumbleupon'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Stumbleupon', 'sexybookmarks')),
		'share'=>__('Stumble upon something good? Share it on StumbleUpon', 'sexybookmarks'),
		'baseUrl'=>'http://www.stumbleupon.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-technorati'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Technorati', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Technorati', 'sexybookmarks'),
		'baseUrl'=>'http://technorati.com/faves?add=PERMALINK',
	),
	'sexy-mixx'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Mixx', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Mixx', 'sexybookmarks'),
		'baseUrl'=>'http://www.mixx.com/submit?page_url=PERMALINK&amp;title=TITLE',
	),
	'sexy-myspace'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('MySpace', 'sexybookmarks')),
		'share'=>__('Post this to ', 'sexybookmarks').__('MySpace', 'sexybookmarks'),
		'baseUrl'=>'http://www.myspace.com/Modules/PostTo/Pages/?u=PERMALINK&amp;t=TITLE',
	),
	'sexy-designfloat'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('DesignFloat', 'sexybookmarks')),
		'share'=>__('Submit this to ', 'sexybookmarks').__('DesignFloat', 'sexybookmarks'),
		'baseUrl'=>'http://www.designfloat.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-facebook'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Facebook', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Facebook', 'sexybookmarks'),
		'baseUrl'=>'http://www.facebook.com/share.php?v=4&amp;src=bm&amp;u=PERMALINK&amp;t=TITLE',
	),
	'sexy-twitter'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Twitter', 'sexybookmarks')),
		'share'=>__('Tweet This!', 'sexybookmarks'),
		'baseUrl'=>'http://twitter.com/home?status=SHORT_TITLE+-+FETCH_URL+POST_BY',
	),
	'sexy-mail'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('"Email to a Friend" link', 'sexybookmarks')),
		'share'=>__('Email this to a friend?', 'sexybookmarks'),
                'baseUrl'=>'mailto:?subject=%22TITLE%22&amp;body='.urlencode( __('I thought this article might interest you.', 'sexybookmarks') ).'%0A%0A%22POST_SUMMARY%22%0A%0A'.urlencode( __('You can read the full article here', 'sexybookmarks') ).'%3A%20PERMALINK',
	),
	'sexy-tomuse'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('ToMuse', 'sexybookmarks')),
		'share'=>__('Suggest this article to ', 'sexybookmarks').__('ToMuse', 'sexybookmarks'),
                'baseUrl'=>'mailto:tips@tomuse.com?subject='.urlencode( __('New tip submitted via the SexyBookmarks Plugin!', 'sexybookmarks') ).'&amp;body='.urlencode( __('I would like to submit this article', 'socialit') ).'%3A%20%22TITLE%22%20'.urlencode( __('for possible inclusion on ToMuse.', 'sexybookmarks') ).'%0A%0A%22POST_SUMMARY%22%0A%0A'.urlencode( __('You can read the full article here', 'sexybookmarks') ).'%3A%20PERMALINK',
	),
	'sexy-comfeed'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('a \'Subscribe to Comments\' link', 'sexybookmarks')),
		'share'=>__('Subscribe to the comments for this post?', 'sexybookmarks'),
		'baseUrl'=>'PERMALINK',
	),
	'sexy-linkedin'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Linkedin', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Linkedin', 'sexybookmarks'),
		'baseUrl'=>'http://www.linkedin.com/shareArticle?mini=true&amp;url=PERMALINK&amp;title=TITLE&amp;summary=POST_SUMMARY&amp;source=SITE_NAME',
	),
	'sexy-newsvine'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Newsvine', 'sexybookmarks')),
		'share'=>__('Seed this on ', 'sexybookmarks').__('Newsvine', 'sexybookmarks'),
		'baseUrl'=>'http://www.newsvine.com/_tools/seed&amp;save?u=PERMALINK&amp;h=TITLE',
	),
	'sexy-google'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Google Bookmarks', 'sexybookmarks')),
		'share'=>__('Add this to ', 'sexybookmarks').__('Google Bookmarks', 'sexybookmarks'),
		'baseUrl'=>'http://www.google.com/bookmarks/mark?op=add&amp;bkmk=PERMALINK&amp;title=TITLE',
	),
	'sexy-misterwong'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Mister Wong', 'sexybookmarks')),
		'share'=>__('Add this to ', 'sexybookmarks').__('Mister Wong', 'sexybookmarks'),
		'baseUrl'=>'http://www.mister-wong'.$wong_tld.'/addurl/?bm_url=PERMALINK&amp;bm_description=TITLE&amp;plugin=sexybookmarks',
	),
	'sexy-izeby'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Izeby', 'sexybookmarks')),
		'share'=>__('Add this to ', 'sexybookmarks').__('Izeby', 'sexybookmarks'),
		'baseUrl'=>'http://izeby.com/submit.php?url=PERMALINK',
	),
	'sexy-tipd'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Tipd', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Tipd', 'sexybookmarks'),
		'baseUrl'=>'http://tipd.com/submit.php?url=PERMALINK',
	),
	'sexy-pfbuzz'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('PFBuzz', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('PFBuzz', 'sexybookmarks'),
		'baseUrl'=>'http://pfbuzz.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-friendfeed'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('FriendFeed', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('FriendFeed', 'sexybookmarks'),
		'baseUrl'=>'http://www.friendfeed.com/share?title=TITLE&amp;link=PERMALINK',
	),
	'sexy-blogmarks'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('BlogMarks', 'sexybookmarks')),
		'share'=>__('Mark this on ', 'sexybookmarks').__('BlogMarks', 'sexybookmarks'),
		'baseUrl'=>'http://blogmarks.net/my/new.php?mini=1&amp;simple=1&amp;url=PERMALINK&amp;title=TITLE',
	),
	'sexy-twittley'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Twittley', 'sexybookmarks')),
		'share'=>__('Submit this to ', 'sexybookmarks').__('Twittley', 'sexybookmarks'),
		'baseUrl'=>'http://twittley.com/submit/?title=TITLE&amp;url=PERMALINK&amp;desc=POST_SUMMARY&amp;pcat=TWITT_CAT&amp;tags=DEFAULT_TAGS',
	),
	'sexy-fwisp'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Fwisp', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Fwisp', 'sexybookmarks'),
		'baseUrl'=>'http://fwisp.com/submit?url=PERMALINK',
	),
	'sexy-designmoo'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('DesignMoo', 'sexybookmarks')),
		'share'=>__('Moo this on ', 'sexybookmarks').__('DesignMoo', 'sexybookmarks').'!',
		'baseUrl'=>'http://designmoo.com/submit?url=PERMALINK&amp;title=TITLE&amp;body=POST_SUMMARY',
	),
	'sexy-bobrdobr'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('BobrDobr', 'sexybookmarks')).__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('BobrDobr', 'sexybookmarks'),
		'baseUrl'=>'http://bobrdobr.ru/addext.html?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-yandex'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Yandex.Bookmarks', 'sexybookmarks')).__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').__('Yandex.Bookmarks', 'sexybookmarks'),
		'baseUrl'=>'http://zakladki.yandex.ru/userarea/links/addfromfav.asp?bAddLink_x=1&amp;lurl=PERMALINK&amp;lname=TITLE',
	),
	'sexy-memoryru'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Memory.ru', 'sexybookmarks')).__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').__('Memory.ru', 'sexybookmarks'),
		'baseUrl'=>'http://memori.ru/link/?sm=1&amp;u_data[url]=PERMALINK&amp;u_data[name]=TITLE',
	),
	'sexy-100zakladok'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('100 bookmarks', 'sexybookmarks')).__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').__('100 bookmarks', 'sexybookmarks'),
		'baseUrl'=>'http://www.100zakladok.ru/save/?bmurl=PERMALINK&amp;bmtitle=TITLE',
	),
	'sexy-moemesto'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('MyPlace', 'sexybookmarks')).__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').__('MyPlace', 'sexybookmarks'),
		'baseUrl'=>'http://moemesto.ru/post.php?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-hackernews'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Hacker News', 'sexybookmarks')),
		'share'=>__('Submit this to ', 'sexybookmarks').__('Hacker News', 'sexybookmarks'),
		'baseUrl'=>'http://news.ycombinator.com/submitlink?u=PERMALINK&amp;t=TITLE',
	),
	'sexy-printfriendly'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Print Friendly', 'sexybookmarks')),
		'share'=>__('Send this page to ', 'sexybookmarks').__('Print Friendly', 'sexybookmarks'),
		'baseUrl'=>'http://www.printfriendly.com/print?url=PERMALINK',
	),
	'sexy-designbump'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Design Bump', 'sexybookmarks')),
		'share'=>__('Bump this on ', 'sexybookmarks').__('DesignBump', 'sexybookmarks'),
		'baseUrl'=>'http://designbump.com/submit?url=PERMALINK&amp;title=TITLE&amp;body=POST_SUMMARY',
	),
	'sexy-ning'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Ning', 'sexybookmarks')),
		'share'=>__('Add this to ', 'sexybookmarks').__('Ning', 'sexybookmarks'),
		'baseUrl'=>'http://bookmarks.ning.com/addItem.php?url=PERMALINK&amp;T=TITLE',
	),
	'sexy-identica'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Identica', 'sexybookmarks')),
		'share'=>__('Post this to ', 'sexybookmarks').__('Identica', 'sexybookmarks'),
		'baseUrl'=>'http://identi.ca//index.php?action=newnotice&amp;status_textarea=Reading:+&quot;SHORT_TITLE&quot;+-+from+FETCH_URL',
	),
	'sexy-xerpi'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Xerpi', 'sexybookmarks')),
		'share'=>__('Save this to ', 'sexybookmarks').__('Xerpi', 'sexybookmarks'),
		'baseUrl'=>'http://www.xerpi.com/block/add_link_from_extension?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-wikio'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Wikio', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Wikio', 'sexybookmarks'),
		'baseUrl'=>'http://www.wikio.com/sharethis?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-techmeme'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('TechMeme', 'sexybookmarks')),
		'share'=>__('Tip this to ', 'sexybookmarks').__('TechMeme', 'sexybookmarks'),
		'baseUrl'=>'http://twitter.com/home/?status=Tip+@Techmeme+PERMALINK+&quot;TITLE&quot;',
	),
	'sexy-sphinn'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Sphinn', 'sexybookmarks')),
		'share'=>__('Sphinn this on ', 'sexybookmarks').__('Sphinn', 'sexybookmarks'),
		'baseUrl'=>'http://sphinn.com/index.php?c=post&amp;m=submit&amp;link=PERMALINK',
	),
	'sexy-posterous'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Posterous', 'sexybookmarks')),
		'share'=>__('Post this to ', 'sexybookmarks').__('Posterous', 'sexybookmarks'),
		'baseUrl'=>'http://posterous.com/share?linkto=PERMALINK&amp;title=TITLE&amp;selection=POST_SUMMARY',
	),
	'sexy-globalgrind'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Global Grind', 'sexybookmarks')),
		'share'=>__('Grind this! on ', 'sexybookmarks').__('Global Grind', 'sexybookmarks'),
		'baseUrl'=>'http://globalgrind.com/submission/submit.aspx?url=PERMALINK&amp;type=Article&amp;title=TITLE',
	),
	'sexy-pingfm'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Ping.fm', 'sexybookmarks')),
		'share'=>__('Ping this on ', 'sexybookmarks').__('Ping.fm', 'sexybookmarks'),
		'baseUrl'=>'http://ping.fm/ref/?link=PERMALINK&amp;title=TITLE&amp;body=POST_SUMMARY',
	),
	'sexy-nujij'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('NUjij', 'sexybookmarks')).__(' (Dutch)', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').__('NUjij', 'sexybookmarks'),
		'baseUrl'=>'http://nujij.nl/jij.lynkx?t=TITLE&amp;u=PERMALINK&amp;b=POST_SUMMARY',
	),
	'sexy-ekudos'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('eKudos', 'sexybookmarks')).__(' (Dutch)', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').__('eKudos', 'sexybookmarks'),
		'baseUrl'=>'http://www.ekudos.nl/artikel/nieuw?url=PERMALINK&amp;title=TITLE&amp;desc=POST_SUMMARY',
	),
	'sexy-netvouz'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Netvouz', 'sexybookmarks')),
		'share'=>__('Submit this to ', 'sexybookmarks').__('Netvouz', 'sexybookmarks'),
		'baseUrl'=>'http://www.netvouz.com/action/submitBookmark?url=PERMALINK&amp;title=TITLE&amp;popup=no',
	),
	'sexy-netvibes'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Netvibes', 'sexybookmarks')),
		'share'=>__('Submit this to ', 'sexybookmarks').__('Netvibes', 'sexybookmarks'),
		'baseUrl'=>'http://www.netvibes.com/share?title=TITLE&amp;url=PERMALINK',
	),
	'sexy-fleck'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Fleck', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Fleck', 'sexybookmarks'),
		'baseUrl'=>'http://beta3.fleck.com/bookmarklet.php?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-blogospherenews'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Blogosphere News', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Blogosphere News', 'sexybookmarks'),
		'baseUrl'=>'http://www.blogospherenews.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-webblend'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Web Blend', 'sexybookmarks')),
		'share'=>__('Blend this!', 'sexybookmarks'),
		'baseUrl'=>'http://thewebblend.com/submit?url=PERMALINK&amp;title=TITLE&amp;body=POST_SUMMARY',
	),
	'sexy-wykop'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Wykop', 'sexybookmarks')).__(' (Polish)', 'sexybookmarks'),
		'share'=>__('Add this to Wykop!', 'sexybookmarks'),
		'baseUrl'=>'http://www.wykop.pl/dodaj?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-blogengage'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('BlogEngage', 'sexybookmarks')),
		'share'=>__('Engage with this article!', 'sexybookmarks'),
		'baseUrl'=>'http://www.blogengage.com/submit.php?url=PERMALINK',
	),
	'sexy-hyves'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Hyves', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Hyves', 'sexybookmarks'),
		'baseUrl'=>'http://www.hyves.nl/profilemanage/add/tips/?name=TITLE&amp;text=POST_SUMMARY+-+PERMALINK&amp;rating=5',
	),
	'sexy-pusha'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Pusha', 'sexybookmarks')).__(' (Swedish)', 'sexybookmarks'),
		'share'=>__('Push this on ', 'sexybookmarks').__('Pusha', 'sexybookmarks'),
		'baseUrl'=>'http://www.pusha.se/posta?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-hatena'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Hatena Bookmarks', 'sexybookmarks')).__(' (Japanese)', 'sexybookmarks'),
		'share'=>__('Bookmarks this on ', 'sexybookmarks').__('Hatena Bookmarks', 'sexybookmarks'),
		'baseUrl'=>'http://b.hatena.ne.jp/add?mode=confirm&amp;url=PERMALINK&amp;title=TITLE',
	),
	'sexy-mylinkvault'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('MyLinkVault', 'sexybookmarks')),
		'share'=>__('Store this link on ', 'sexybookmarks').__('MyLinkVault', 'sexybookmarks'),
		'baseUrl'=>'http://www.mylinkvault.com/link-page.php?u=PERMALINK&amp;n=TITLE',
	),
	'sexy-slashdot'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('SlashDot', 'sexybookmarks')),
		'share'=>__('Submit this to ', 'sexybookmarks').__('SlashDot', 'sexybookmarks'),
		'baseUrl'=>'http://slashdot.org/bookmark.pl?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-squidoo'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Squidoo', 'sexybookmarks')),
		'share'=>__('Add to a lense on ', 'sexybookmarks').__('Squidoo', 'sexybookmarks'),
		'baseUrl'=>'http://www.squidoo.com/lensmaster/bookmark?PERMALINK',
	),
	'sexy-propeller'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Propeller', 'sexybookmarks')),
		'share'=>__('Submit this story to ', 'sexybookmarks').__('Propeller', 'sexybookmarks'),
		'baseUrl'=>'http://www.propeller.com/submit/?url=PERMALINK',
	),
	'sexy-faqpal'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('FAQpal', 'sexybookmarks')),
		'share'=>__('Submit this to ', 'sexybookmarks').__('FAQpal', 'sexybookmarks'),
		'baseUrl'=>'http://www.faqpal.com/submit?url=PERMALINK',
	),
	'sexy-evernote'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Evernote', 'sexybookmarks')),
		'share'=>__('Clip this to ', 'sexybookmarks').__('Evernote', 'sexybookmarks'),
		'baseUrl'=>'http://www.evernote.com/clip.action?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-meneame'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Meneame', 'sexybookmarks')).__(' (Spanish)', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').__('Meneame', 'sexybookmarks'),
		'baseUrl'=>'http://meneame.net/submit.php?url=PERMALINK',
	),
	'sexy-bitacoras'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Bitacoras', 'sexybookmarks')).__(' (Spanish)', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').__('Bitacoras', 'sexybookmarks'),
		'baseUrl'=>'http://bitacoras.com/anotaciones/PERMALINK',
	),
	'sexy-jumptags'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('JumpTags', 'sexybookmarks')),
		'share'=>__('Submit this link to ', 'sexybookmarks').__('JumpTags', 'sexybookmarks'),
		'baseUrl'=>'http://www.jumptags.com/add/?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-bebo'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Bebo', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Bebo', 'sexybookmarks'),
		'baseUrl'=>'http://www.bebo.com/c/share?Url=PERMALINK&amp;Title=TITLE',
	),
	'sexy-n4g'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('N4G', 'sexybookmarks')),
		'share'=>__('Submit tip to ', 'sexybookmarks').__('N4G', 'sexybookmarks'),
		'baseUrl'=>'http://www.n4g.com/tips.aspx?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-strands'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Strands', 'sexybookmarks')),
		'share'=>__('Submit this to ', 'sexybookmarks').__('Strands', 'sexybookmarks'),
		'baseUrl'=>'http://www.strands.com/tools/share/webpage?title=TITLE&amp;url=PERMALINK',
	),
	'sexy-orkut'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Orkut', 'sexybookmarks')),
		'share'=>__('Promote this on ', 'sexybookmarks').__('Orkut', 'sexybookmarks'),
		'baseUrl'=>'http://promote.orkut.com/preview?nt=orkut.com&amp;tt=TITLE&amp;du=PERMALINK&amp;cn=POST_SUMMARY',
	),
	'sexy-tumblr'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Tumblr', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Tumblr', 'sexybookmarks'),
		'baseUrl'=>'http://www.tumblr.com/share?v=3&amp;u=PERMALINK&amp;t=TITLE',
	),
	'sexy-stumpedia'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Stumpedia', 'sexybookmarks')),
		'share'=>__('Add this to ', 'sexybookmarks').__('Stumpedia', 'sexybookmarks'),
		'baseUrl'=>'http://www.stumpedia.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-current'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Current', 'sexybookmarks')),
		'share'=>__('Post this to ', 'sexybookmarks').__('Current', 'sexybookmarks'),
		'baseUrl'=>'http://current.com/clipper.htm?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-blogger'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Blogger', 'sexybookmarks')),
		'share'=>__('Blog this on ', 'sexybookmarks').__('Blogger', 'sexybookmarks'),
		'baseUrl'=>'http://www.blogger.com/blog_this.pyra?t&amp;u=PERMALINK&amp;n=TITLE&amp;pli=1',
	),
	'sexy-plurk'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Plurk', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Plurk', 'sexybookmarks'),
		'baseUrl'=>'http://www.plurk.com/m?content=TITLE+-+PERMALINK&amp;qualifier=shares',
	),
	'sexy-dzone'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('DZone', 'sexybookmarks')),
		'share'=>__('Add this to ', 'sexybookmarks').__('DZone', 'sexybookmarks'),
		'baseUrl'=>'http://www.dzone.com/links/add.html?url=PERMALINK&title=TITLE&description=POST_SUMMARY',
	),	
	'sexy-kaevur'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Kaevur', 'sexybookmarks')).__(' (Estonian)', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').__('Kaevur', 'sexybookmarks'),
		'baseUrl'=>'http://kaevur.com/submit.php?url=PERMALINK',
	),
	'sexy-virb'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Virb', 'sexybookmarks')),
		'share'=>__('Share this on ', 'sexybookmarks').__('Virb', 'sexybookmarks'),
		'baseUrl'=>'http://virb.com/share?external&v=2&url=PERMALINK&title=TITLE',
	),	
	'sexy-boxnet'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __('Box.net', 'sexybookmarks')),
		'share'=>__('Add this link to ', 'sexybookmarks').__('Box.net', 'sexybookmarks'),
		'baseUrl'=>'https://www.box.net/api/1.0/import?url=PERMALINK&name=TITLE&description=POST_SUMMARY&import_as=link',
	),	
);
?>