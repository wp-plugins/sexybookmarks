<?php
// dynamic mister wong link generator
$wong_tld = '.com';

if(WPLANG == 'de_DE')
	$wong_tld = '.de';

elseif(WPLANG == 'zh_CN' || WPLANG == 'zh_HK' || WPLANG == 'zh_TW')
	$wong_tld = '.cn';

elseif(WPLANG == 'es_CL'  || WPLANG == 'es_ES' || WPLANG == 'es_PE' || WPLANG == 'es_VE')
	$wong_tld = '.es';

elseif(WPLANG == 'fr_FR' || WPLANG == 'fr_BE')
	$wong_tld = '.fr';

elseif(WPLANG =='ru_RU' || WPLANG == 'ru_MA')
	$wong_tld = '.ru';


// array of bookmarks
$sexy_bookmarks_data=array(
	'sexy-scriptstyle'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), 'Script &amp; Style'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Script &amp; Style',
		'baseUrl'=>'http://scriptandstyle.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-blinklist'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), 'Blinklist'),
		'share'=>__('Share this on ', 'sexybookmarks').'Blinklist',
		'baseUrl'=>'http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=PERMALINK&amp;Title=TITLE',
	),
	'sexy-delicious'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Delicious'),
		'share'=>__('Share this on ', 'sexybookmarks').'del.icio.us',
		'baseUrl'=>'http://delicious.com/post?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-digg'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Digg'),
		'share'=>__('Digg this!', 'sexybookmarks'),
		'baseUrl'=>'http://digg.com/submit?phase=2&amp;url=PERMALINK&amp;title=TITLE',
	),
	'sexy-diigo'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Diigo'),
		'share'=>__('Post this on ', 'sexybookmarks').'Diigo',
		'baseUrl'=>'http://www.diigo.com/post?url=PERMALINK&amp;title=TITLE&amp;desc=SEXY_TEASER',
	),
	'sexy-reddit'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Reddit'),
		'share'=>__('Share this on ', 'sexybookmarks').'Reddit',
		'baseUrl'=>'http://reddit.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-yahoobuzz'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Yahoo! Buzz'),
		'share'=>__('Buzz up!', 'sexybookmarks'),
		'baseUrl'=>'http://buzz.yahoo.com/submit/?submitUrl=PERMALINK&amp;submitHeadline=TITLE&amp;submitSummary=YAHOOTEASER&amp;submitCategory=YAHOOCATEGORY&amp;submitAssetType=YAHOOMEDIATYPE',
	),
	'sexy-stumbleupon'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Stumbleupon'),
		'share'=>__('Stumble upon something good? Share it on StumbleUpon', 'sexybookmarks'),
		'baseUrl'=>'http://www.stumbleupon.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-technorati'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Technorati'),
		'share'=>__('Share this on ', 'sexybookmarks').'Technorati',
		'baseUrl'=>'http://technorati.com/faves?add=PERMALINK',
	),
	'sexy-mixx'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Mixx'),
		'share'=>__('Share this on ', 'sexybookmarks').'Mixx',
		'baseUrl'=>'http://www.mixx.com/submit?page_url=PERMALINK&amp;title=TITLE',
	),
	'sexy-myspace'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'MySpace'),
		'share'=>__('Post this to ', 'sexybookmarks').'MySpace',
		'baseUrl'=>'http://www.myspace.com/Modules/PostTo/Pages/?u=PERMALINK&amp;t=TITLE',
	),
	'sexy-designfloat'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'DesignFloat'),
		'share'=>__('Submit this to ', 'sexybookmarks').'DesignFloat',
		'baseUrl'=>'http://www.designfloat.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-facebook'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Facebook'),
		'share'=>__('Share this on ', 'sexybookmarks').'Facebook',
		'baseUrl'=>'http://www.facebook.com/share.php?v=4&amp;src=bm&amp;u=PERMALINK&amp;t=TITLE',
	),
	'sexy-twitter'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Twitter'),
		'share'=>__('Tweet This!', 'sexybookmarks'),
		'baseUrl'=>'http://twitter.com/home?status=SHORT_TITLE+-+FETCH_URL+POST_BY&amp;source=shareaholic',
	),
	'sexy-mail'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __("an 'Email to a Friend' link", 'sexybookmarks')),
		'share'=>__('Email this to a friend?', 'sexybookmarks'),
                'baseUrl'=>'mailto:?subject=%22TITLE%22&amp;body='.urlencode( __('I thought this article might interest you.', 'sexybookmarks') ).'%0A%0A%22POST_SUMMARY%22%0A%0A'.urlencode( __('You can read the full article here', 'sexybookmarks') ).'%3A%20PERMALINK',
	),
	'sexy-tomuse'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'ToMuse'),
		'share'=>__('Suggest this article to ', 'sexybookmarks').'ToMuse',
                'baseUrl'=>'mailto:tips@tomuse.com?subject='.urlencode( __('New tip submitted via the SexyBookmarks Plugin!', 'sexybookmarks') ).'&amp;body='.urlencode( __('I would like to submit this article', 'sexybookmarks') ).'%3A%20%22TITLE%22%20'.urlencode( __('for possible inclusion on ToMuse.', 'sexybookmarks') ).'%0A%0A%22POST_SUMMARY%22%0A%0A'.urlencode( __('You can read the full article here', 'sexybookmarks') ).'%3A%20PERMALINK',
	),
	'sexy-comfeed'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'), __("a 'Subscribe to Comments' link", 'sexybookmarks')),
		'share'=>__('Subscribe to the comments for this post?', 'sexybookmarks'),
		'baseUrl'=>'PERMALINK',
	),
	'sexy-linkedin'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'LinkedIn'),
		'share'=>__('Share this on ', 'sexybookmarks').'LinkedIn',
		'baseUrl'=>'http://www.linkedin.com/shareArticle?mini=true&amp;url=PERMALINK&amp;title=TITLE&amp;summary=POST_SUMMARY&amp;source=SITE_NAME',
	),
	'sexy-newsvine'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Newsvine'),
		'share'=>__('Seed this on ', 'sexybookmarks').'Newsvine',
		'baseUrl'=>'http://www.newsvine.com/_tools/seed&amp;save?u=PERMALINK&amp;h=TITLE',
	),
	'sexy-google'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Google Bookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').'Google Bookmarks',
		'baseUrl'=>'http://www.google.com/bookmarks/mark?op=add&amp;bkmk=PERMALINK&amp;title=TITLE',
	),
	'sexy-googlereader'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Google Reader'),
		'share'=>__('Add this to ', 'sexybookmarks').'Google Reader',
		'baseUrl'=>'http://www.google.com/reader/link?url=PERMALINK&title=TITLE&srcUrl=PERMALINK&srcTitle=TITLE&snippet=POST_SUMMARY',
	),
	'sexy-googlebuzz'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Google Buzz'),
		'share'=>__('Post on Google Buzz', 'sexybookmarks'),
		'baseUrl'=>'http://www.google.com/buzz/post?url=PERMALINK&imageurl=',
	),
	'sexy-misterwong'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Mister Wong'),
		'share'=>__('Add this to ', 'sexybookmarks').'Mister Wong',
		'baseUrl'=>'http://www.mister-wong'.$wong_tld.'/addurl/?bm_url=PERMALINK&amp;bm_description=TITLE&amp;plugin=sexybookmarks',
	),
	'sexy-izeby'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Izeby'),
		'share'=>__('Add this to ', 'sexybookmarks').'Izeby',
		'baseUrl'=>'http://izeby.com/submit.php?url=PERMALINK',
	),
	'sexy-tipd'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Tipd'),
		'share'=>__('Share this on ', 'sexybookmarks').'Tipd',
		'baseUrl'=>'http://tipd.com/submit.php?url=PERMALINK',
	),
	'sexy-pfbuzz'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'PFBuzz'),
		'share'=>__('Share this on ', 'sexybookmarks').'PFBuzz',
		'baseUrl'=>'http://pfbuzz.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-friendfeed'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'FriendFeed'),
		'share'=>__('Share this on ', 'sexybookmarks').'FriendFeed',
		'baseUrl'=>'http://www.friendfeed.com/share?title=TITLE&amp;link=PERMALINK',
	),
	'sexy-blogmarks'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'BlogMarks'),
		'share'=>__('Mark this on ', 'sexybookmarks').'BlogMarks',
		'baseUrl'=>'http://blogmarks.net/my/new.php?mini=1&amp;simple=1&amp;url=PERMALINK&amp;title=TITLE',
	),
	'sexy-twittley'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Twittley'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Twittley',
		'baseUrl'=>'http://twittley.com/submit/?title=TITLE&amp;url=PERMALINK&amp;desc=POST_SUMMARY&amp;pcat=TWITT_CAT&amp;tags=DEFAULT_TAGS',
	),
	'sexy-fwisp'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Fwisp'),
		'share'=>__('Share this on ', 'sexybookmarks').'Fwisp',
		'baseUrl'=>'http://fwisp.com/submit?url=PERMALINK',
	),
	'sexy-bobrdobr'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'BobrDobr').__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').'BobrDobr',
		'baseUrl'=>'http://bobrdobr.ru/addext.html?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-yandex'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Yandex.Bookmarks').__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').'Yandex.Bookmarks',
		'baseUrl'=>'http://zakladki.yandex.ru/userarea/links/addfromfav.asp?bAddLink_x=1&amp;lurl=PERMALINK&amp;lname=TITLE',
	),
	'sexy-memoryru'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Memory.ru').__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').'Memory.ru',
		'baseUrl'=>'http://memori.ru/link/?sm=1&amp;u_data[url]=PERMALINK&amp;u_data[name]=TITLE',
	),
	'sexy-100zakladok'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'100 bookmarks').__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').'100 bookmarks',
		'baseUrl'=>'http://www.100zakladok.ru/save/?bmurl=PERMALINK&amp;bmtitle=TITLE',
	),
	'sexy-moemesto'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'MyPlace').__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').'MyPlace',
		'baseUrl'=>'http://moemesto.ru/post.php?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-hackernews'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Hacker News'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Hacker News',
		'baseUrl'=>'http://news.ycombinator.com/submitlink?u=PERMALINK&amp;t=TITLE',
	),
	'sexy-printfriendly'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Print Friendly'),
		'share'=>__('Send this page to ', 'sexybookmarks').'Print Friendly',
		'baseUrl'=>'http://www.printfriendly.com/print?url=PERMALINK',
	),
	'sexy-designbump'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Design Bump'),
		'share'=>__('Bump this on ', 'sexybookmarks').'DesignBump',
		'baseUrl'=>'http://designbump.com/submit?url=PERMALINK&amp;title=TITLE&amp;body=POST_SUMMARY',
	),
	'sexy-ning'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Ning'),
		'share'=>__('Add this to ', 'sexybookmarks').'Ning',
		'baseUrl'=>'http://bookmarks.ning.com/addItem.php?url=PERMALINK&amp;T=TITLE',
	),
	'sexy-identica'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Identica'),
		'share'=>__('Post this to ', 'sexybookmarks').'Identica',
		'baseUrl'=>'http://identi.ca//index.php?action=newnotice&amp;status_textarea=Reading:+&quot;SHORT_TITLE&quot;+-+from+FETCH_URL',
	),
	'sexy-xerpi'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Xerpi'),
		'share'=>__('Save this to ', 'sexybookmarks').'Xerpi',
		'baseUrl'=>'http://www.xerpi.com/block/add_link_from_extension?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-wikio'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Wikio'),
		'share'=>__('Share this on ', 'sexybookmarks').'Wikio',
		'baseUrl'=>'http://www.wikio.com/sharethis?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-techmeme'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'TechMeme'),
		'share'=>__('Tip this to ', 'sexybookmarks').'TechMeme',
		'baseUrl'=>'http://twitter.com/home/?status=Tip+@Techmeme+PERMALINK+&quot;TITLE&quot;',
	),
	'sexy-sphinn'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Sphinn'),
		'share'=>__('Sphinn this on ', 'sexybookmarks').'Sphinn',
		'baseUrl'=>'http://sphinn.com/index.php?c=post&amp;m=submit&amp;link=PERMALINK',
	),
	'sexy-posterous'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Posterous'),
		'share'=>__('Post this to ', 'sexybookmarks').'Posterous',
		'baseUrl'=>'http://posterous.com/share?linkto=PERMALINK&amp;title=TITLE&amp;selection=POST_SUMMARY',
	),
	'sexy-globalgrind'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Global Grind'),
		'share'=>__('Grind this! on ', 'sexybookmarks').'Global Grind',
		'baseUrl'=>'http://globalgrind.com/submission/submit.aspx?url=PERMALINK&amp;type=Article&amp;title=TITLE',
	),
	'sexy-pingfm'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Ping.fm'),
		'share'=>__('Ping this on ', 'sexybookmarks').'Ping.fm',
		'baseUrl'=>'http://ping.fm/ref/?link=PERMALINK&amp;title=TITLE&amp;body=POST_SUMMARY',
	),
	'sexy-nujij'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'NUjij').__(' (Dutch)', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').'NUjij',
		'baseUrl'=>'http://nujij.nl/jij.lynkx?t=TITLE&amp;u=PERMALINK&amp;b=POST_SUMMARY',
	),
	'sexy-ekudos'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'eKudos').__(' (Dutch)', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').'eKudos',
		'baseUrl'=>'http://www.ekudos.nl/artikel/nieuw?url=PERMALINK&amp;title=TITLE&amp;desc=POST_SUMMARY',
	),
	'sexy-netvouz'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Netvouz'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Netvouz',
		'baseUrl'=>'http://www.netvouz.com/action/submitBookmark?url=PERMALINK&amp;title=TITLE&amp;popup=no',
	),
	'sexy-netvibes'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Netvibes'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Netvibes',
		'baseUrl'=>'http://www.netvibes.com/share?title=TITLE&amp;url=PERMALINK',
	),
	'sexy-fleck'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Fleck'),
		'share'=>__('Share this on ', 'sexybookmarks').'Fleck',
		'baseUrl'=>'http://beta3.fleck.com/bookmarklet.php?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-webblend'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Web Blend'),
		'share'=>__('Blend this!', 'sexybookmarks'),
		'baseUrl'=>'http://thewebblend.com/submit?url=PERMALINK&amp;title=TITLE&amp;body=POST_SUMMARY',
	),
	'sexy-wykop'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Wykop').__(' (Polish)', 'sexybookmarks'),
		'share'=>__('Add this to Wykop!', 'sexybookmarks'),
		'baseUrl'=>'http://www.wykop.pl/dodaj?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-blogengage'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'BlogEngage'),
		'share'=>__('Engage with this article!', 'sexybookmarks'),
		'baseUrl'=>'http://www.blogengage.com/submit.php?url=PERMALINK',
	),
	'sexy-hyves'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Hyves'),
		'share'=>__('Share this on ', 'sexybookmarks').'Hyves',
		'baseUrl'=>'http://www.hyves.nl/profilemanage/add/tips/?name=TITLE&amp;text=POST_SUMMARY+-+PERMALINK&amp;rating=5',
	),
	'sexy-pusha'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Pusha').__(' (Swedish)', 'sexybookmarks'),
		'share'=>__('Push this on ', 'sexybookmarks').'Pusha',
		'baseUrl'=>'http://www.pusha.se/posta?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-hatena'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Hatena Bookmarks').__(' (Japanese)', 'sexybookmarks'),
		'share'=>__('Bookmarks this on ', 'sexybookmarks').'Hatena Bookmarks',
		'baseUrl'=>'http://b.hatena.ne.jp/add?mode=confirm&amp;url=PERMALINK&amp;title=TITLE',
	),
	'sexy-mylinkvault'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'MyLinkVault'),
		'share'=>__('Store this link on ', 'sexybookmarks').'MyLinkVault',
		'baseUrl'=>'http://www.mylinkvault.com/link-page.php?u=PERMALINK&amp;n=TITLE',
	),
	'sexy-slashdot'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'SlashDot'),
		'share'=>__('Submit this to ', 'sexybookmarks').'SlashDot',
		'baseUrl'=>'http://slashdot.org/bookmark.pl?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-squidoo'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Squidoo'),
		'share'=>__('Add to a lense on ', 'sexybookmarks').'Squidoo',
		'baseUrl'=>'http://www.squidoo.com/lensmaster/bookmark?PERMALINK',
	),
	'sexy-propeller'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Propeller'),
		'share'=>__('Submit this story to ', 'sexybookmarks').'Propeller',
		'baseUrl'=>'http://www.propeller.com/submit/?url=PERMALINK',
	),
	'sexy-faqpal'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'FAQpal'),
		'share'=>__('Submit this to ', 'sexybookmarks').'FAQpal',
		'baseUrl'=>'http://www.faqpal.com/submit?url=PERMALINK',
	),
	'sexy-evernote'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Evernote'),
		'share'=>__('Clip this to ', 'sexybookmarks').'Evernote',
		'baseUrl'=>'http://www.evernote.com/clip.action?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-meneame'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Meneame').__(' (Spanish)', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Meneame',
		'baseUrl'=>'http://meneame.net/submit.php?url=PERMALINK',
	),
	'sexy-bitacoras'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Bitacoras').__(' (Spanish)', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Bitacoras',
		'baseUrl'=>'http://bitacoras.com/anotaciones/PERMALINK',
	),
	'sexy-jumptags'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'JumpTags'),
		'share'=>__('Submit this link to ', 'sexybookmarks').'JumpTags',
		'baseUrl'=>'http://www.jumptags.com/add/?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-bebo'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Bebo'),
		'share'=>__('Share this on ', 'sexybookmarks').'Bebo',
		'baseUrl'=>'http://www.bebo.com/c/share?Url=PERMALINK&amp;Title=TITLE',
	),
	'sexy-n4g'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'N4G'),
		'share'=>__('Submit tip to ', 'sexybookmarks').'N4G',
		'baseUrl'=>'http://www.n4g.com/tips.aspx?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-strands'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Strands'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Strands',
		'baseUrl'=>'http://www.strands.com/tools/share/webpage?title=TITLE&amp;url=PERMALINK',
	),
	'sexy-orkut'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Orkut'),
		'share'=>__('Promote this on ', 'sexybookmarks').'Orkut',
		'baseUrl'=>'http://promote.orkut.com/preview?nt=orkut.com&amp;tt=TITLE&amp;du=PERMALINK&amp;cn=POST_SUMMARY',
	),
	'sexy-tumblr'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Tumblr'),
		'share'=>__('Share this on ', 'sexybookmarks').'Tumblr',
		'baseUrl'=>'http://www.tumblr.com/share?v=3&amp;u=PERMALINK&amp;t=TITLE',
	),
	'sexy-stumpedia'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Stumpedia'),
		'share'=>__('Add this to ', 'sexybookmarks').'Stumpedia',
		'baseUrl'=>'http://www.stumpedia.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-current'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Current'),
		'share'=>__('Post this to ', 'sexybookmarks').'Current',
		'baseUrl'=>'http://current.com/clipper.htm?url=PERMALINK&amp;title=TITLE',
	),
	'sexy-blogger'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Blogger'),
		'share'=>__('Blog this on ', 'sexybookmarks').'Blogger',
		'baseUrl'=>'http://www.blogger.com/blog_this.pyra?t&amp;u=PERMALINK&amp;n=TITLE&amp;pli=1',
	),
	'sexy-plurk'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Plurk'),
		'share'=>__('Share this on ', 'sexybookmarks').'Plurk',
		'baseUrl'=>'http://www.plurk.com/m?content=TITLE+-+PERMALINK&amp;qualifier=shares',
	),
	'sexy-dzone'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'DZone'),
		'share'=>__('Add this to ', 'sexybookmarks').'DZone',
		'baseUrl'=>'http://www.dzone.com/links/add.html?url=PERMALINK&title=TITLE&description=POST_SUMMARY',
	),	
	'sexy-kaevur'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Kaevur').__(' (Estonian)', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').'Kaevur',
		'baseUrl'=>'http://kaevur.com/submit.php?url=PERMALINK',
	),
	'sexy-virb'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Virb'),
		'share'=>__('Share this on ', 'sexybookmarks').'Virb',
		'baseUrl'=>'http://virb.com/share?external&v=2&url=PERMALINK&title=TITLE',
	),	
	'sexy-boxnet'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Box.net'),
		'share'=>__('Add this link to ', 'sexybookmarks').'Box.net',
		'baseUrl'=>'https://www.box.net/api/1.0/import?url=PERMALINK&name=TITLE&description=POST_SUMMARY&import_as=link',
	),
	'sexy-oknotizie'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'OkNotizie').__('(Italian)', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').'OkNotizie',
		'baseUrl'=>'http://oknotizie.virgilio.it/post?url=PERMALINK&title=TITLE',
	),
	'sexy-bonzobox'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'BonzoBox'),
		'share'=>__('Add this to ', 'sexybookmarks').'BonzoBox',
		'baseUrl'=>'http://bonzobox.com/toolbar/add?pop=1&u=PERMALINK&t=TITLE&d=POST_SUMMARY',
	),
	'sexy-plaxo'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Plaxo'),
		'share'=>__('Share this on ', 'sexybookmarks').'Plaxo',
		'baseUrl'=>'http://www.plaxo.com/?share_link=PERMALINK',
	),
	'sexy-springpad'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'SpringPad'),
		'share'=>__('Spring this on ', 'sexybookmarks').'SpringPad',
		'baseUrl'=>'http://springpadit.com/clip.action?body=POST_SUMMARY&url=PERMALINK&format=microclip&title=TITLE&isSelected=true',
	),
	'sexy-zabox'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Zabox'),
		'share'=>__('Box this on ', 'sexybookmarks').'Zabox',
		'baseUrl'=>'http://www.zabox.net/submit.php?url=PERMALINK',
	),
	'sexy-viadeo'=>array(
		'check'=>sprintf(__('Check this box to include %s in your bookmarking menu', 'sexybookmarks'),'Viadeo'),
		'share'=>__('Share this on ', 'sexybookmarks').'Viadeo',
		'baseUrl'=>'http://www.viadeo.com/shareit/share/?url=PERMALINK&title=TITLE&urlaffiliate=31138',
	),
);
?>