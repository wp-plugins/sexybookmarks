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

$checkthis_text = __('Check this box to include %s in your bookmarking menu', 'sexybookmarks');

// array of bookmarks
$sexy_bookmarks_data=array(
	'shr-scriptstyle'=>array(
		'check'=>sprintf($checkthis_text, 'Script &amp; Style'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Script &amp; Style',
		'baseUrl'=>'http://scriptandstyle.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'shr-blinklist'=>array(
		'check'=>sprintf($checkthis_text, 'Blinklist'),
		'share'=>__('Share this on ', 'sexybookmarks').'Blinklist',
		'baseUrl'=>'http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=PERMALINK&amp;Title=TITLE',
	),
	'shr-delicious'=>array(
		'check'=>sprintf($checkthis_text,'Delicious'),
		'share'=>__('Share this on ', 'sexybookmarks').'del.icio.us',
		'baseUrl'=>'http://delicious.com/post?url=PERMALINK&amp;title=TITLE',
	),
	'shr-digg'=>array(
		'check'=>sprintf($checkthis_text,'Digg'),
		'share'=>__('Digg this!', 'sexybookmarks'),
		'baseUrl'=>'http://digg.com/submit?phase=2&amp;url=PERMALINK&amp;title=TITLE',
	),
	'shr-diigo'=>array(
		'check'=>sprintf($checkthis_text,'Diigo'),
		'share'=>__('Post this on ', 'sexybookmarks').'Diigo',
		'baseUrl'=>'http://www.diigo.com/post?url=PERMALINK&amp;title=TITLE&amp;desc=SEXY_TEASER',
	),
	'shr-reddit'=>array(
		'check'=>sprintf($checkthis_text,'Reddit'),
		'share'=>__('Share this on ', 'sexybookmarks').'Reddit',
		'baseUrl'=>'http://reddit.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'shr-yahoobuzz'=>array(
		'check'=>sprintf($checkthis_text,'Yahoo! Buzz'),
		'share'=>__('Buzz up!', 'sexybookmarks'),
		'baseUrl'=>'http://buzz.yahoo.com/submit/?submitUrl=PERMALINK&amp;submitHeadline=TITLE&amp;submitSummary=YAHOOTEASER&amp;submitCategory=YAHOOCATEGORY&amp;submitAssetType=YAHOOMEDIATYPE',
	),
	'shr-stumbleupon'=>array(
		'check'=>sprintf($checkthis_text,'Stumbleupon'),
		'share'=>__('Stumble upon something good? Share it on StumbleUpon', 'sexybookmarks'),
		'baseUrl'=>'http://www.stumbleupon.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'shr-technorati'=>array(
		'check'=>sprintf($checkthis_text,'Technorati'),
		'share'=>__('Share this on ', 'sexybookmarks').'Technorati',
		'baseUrl'=>'http://technorati.com/faves?add=PERMALINK',
	),
	'shr-mixx'=>array(
		'check'=>sprintf($checkthis_text,'Mixx'),
		'share'=>__('Share this on ', 'sexybookmarks').'Mixx',
		'baseUrl'=>'http://www.mixx.com/submit?page_url=PERMALINK&amp;title=TITLE',
	),
	'shr-myspace'=>array(
		'check'=>sprintf($checkthis_text,'MySpace'),
		'share'=>__('Post this to ', 'sexybookmarks').'MySpace',
		'baseUrl'=>'http://www.myspace.com/Modules/PostTo/Pages/?u=PERMALINK&amp;t=TITLE',
	),
	'shr-designfloat'=>array(
		'check'=>sprintf($checkthis_text,'DesignFloat'),
		'share'=>__('Submit this to ', 'sexybookmarks').'DesignFloat',
		'baseUrl'=>'http://www.designfloat.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),
	'shr-facebook'=>array(
		'check'=>sprintf($checkthis_text,'Facebook'),
		'share'=>__('Share this on ', 'sexybookmarks').'Facebook',
		'baseUrl'=>'http://www.facebook.com/share.php?v=4&amp;src=bm&amp;u=PERMALINK&amp;t=TITLE',
	),
	'shr-twitter'=>array(
		'check'=>sprintf($checkthis_text,'Twitter'),
		'share'=>__('Tweet This!', 'sexybookmarks'),
		'baseUrl'=>'http://twitter.com/home?status=',
	),
	'shr-mail'=>array(
		'check'=>sprintf($checkthis_text, __("an 'Email to a Friend' link", 'sexybookmarks')),
		'share'=>__('Email this to a friend?', 'sexybookmarks'),
      'baseUrl'=>'mailto:?subject=%22TITLE%22&amp;body=Link: PERMALINK '.__('(sent via shareaholic)', 'sexybookmarks').'%0D%0A%0D%0A----%0D%0A POST_SUMMARY',
	),
	'shr-tomuse'=>array(
		'check'=>sprintf($checkthis_text,'ToMuse'),
		'share'=>__('Suggest this article to ', 'sexybookmarks').'ToMuse',
      'baseUrl'=>'mailto:tips@tomuse.com?subject='.urlencode( __('New tip submitted via the SexyBookmarks Plugin!', 'sexybookmarks') ).'&amp;body=Link: PERMALINK %0D%0A%0D%0A POST_SUMMARY',
	),
	'shr-comfeed'=>array(
		'check'=>sprintf($checkthis_text, __("a 'Subscribe to Comments' link", 'sexybookmarks')),
		'share'=>__('Subscribe to the comments for this post?', 'sexybookmarks'),
		'baseUrl'=>'PERMALINK',
	),
	'shr-linkedin'=>array(
		'check'=>sprintf($checkthis_text,'LinkedIn'),
		'share'=>__('Share this on ', 'sexybookmarks').'LinkedIn',
		'baseUrl'=>'http://www.linkedin.com/shareArticle?mini=true&amp;url=PERMALINK&amp;title=TITLE&amp;summary=POST_SUMMARY&amp;source=SITE_NAME',
	),
	'shr-newsvine'=>array(
		'check'=>sprintf($checkthis_text,'Newsvine'),
		'share'=>__('Seed this on ', 'sexybookmarks').'Newsvine',
		'baseUrl'=>'http://www.newsvine.com/_tools/seed&amp;save?u=PERMALINK&amp;h=TITLE',
	),
	'shr-googlebookmarks'=>array(
		'check'=>sprintf($checkthis_text,'Google Bookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').'Google Bookmarks',
		'baseUrl'=>'http://www.google.com/bookmarks/mark?op=add&amp;bkmk=PERMALINK&amp;title=TITLE',
	),
	'shr-googlereader'=>array(
		'check'=>sprintf($checkthis_text,'Google Reader'),
		'share'=>__('Add this to ', 'sexybookmarks').'Google Reader',
		'baseUrl'=>'http://www.google.com/reader/link?url=PERMALINK&amp;title=TITLE&amp;srcUrl=PERMALINK&amp;srcTitle=TITLE&amp;snippet=POST_SUMMARY',
	),
	'shr-googlebuzz'=>array(
		'check'=>sprintf($checkthis_text,'Google Buzz'),
		'share'=>__('Post on Google Buzz', 'sexybookmarks'),
		'baseUrl'=>'http://www.google.com/buzz/post?url=PERMALINK&amp;imageurl=',
	),
	'shr-misterwong'=>array(
		'check'=>sprintf($checkthis_text,'Mister Wong'),
		'share'=>__('Add this to ', 'sexybookmarks').'Mister Wong',
		'baseUrl'=>'http://www.mister-wong'.$wong_tld.'/addurl/?bm_url=PERMALINK&amp;bm_description=TITLE&amp;plugin=sexybookmarks',
	),
	'shr-izeby'=>array(
		'check'=>sprintf($checkthis_text,'Izeby'),
		'share'=>__('Add this to ', 'sexybookmarks').'Izeby',
		'baseUrl'=>'http://izeby.com/submit.php?url=PERMALINK',
	),
	'shr-tipd'=>array(
		'check'=>sprintf($checkthis_text,'Tipd'),
		'share'=>__('Share this on ', 'sexybookmarks').'Tipd',
		'baseUrl'=>'http://tipd.com/submit.php?url=PERMALINK',
	),
	'shr-pfbuzz'=>array(
		'check'=>sprintf($checkthis_text,'PFBuzz'),
		'share'=>__('Share this on ', 'sexybookmarks').'PFBuzz',
		'baseUrl'=>'http://pfbuzz.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'shr-friendfeed'=>array(
		'check'=>sprintf($checkthis_text,'FriendFeed'),
		'share'=>__('Share this on ', 'sexybookmarks').'FriendFeed',
		'baseUrl'=>'http://www.friendfeed.com/share?title=TITLE&amp;link=PERMALINK',
	),
	'shr-blogmarks'=>array(
		'check'=>sprintf($checkthis_text,'BlogMarks'),
		'share'=>__('Mark this on ', 'sexybookmarks').'BlogMarks',
		'baseUrl'=>'http://blogmarks.net/my/new.php?mini=1&amp;simple=1&amp;url=PERMALINK&amp;title=TITLE',
	),
	'shr-twittley'=>array(
		'check'=>sprintf($checkthis_text,'Twittley'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Twittley',
		'baseUrl'=>'http://twittley.com/submit/?title=TITLE&amp;url=PERMALINK&amp;desc=POST_SUMMARY&amp;pcat=TWITT_CAT&amp;tags=DEFAULT_TAGS',
	),
	'shr-fwisp'=>array(
		'check'=>sprintf($checkthis_text,'Fwisp'),
		'share'=>__('Share this on ', 'sexybookmarks').'Fwisp',
		'baseUrl'=>'http://fwisp.com/submit?url=PERMALINK',
	),
	'shr-bobrdobr'=>array(
		'check'=>sprintf($checkthis_text,'BobrDobr').__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').'BobrDobr',
		'baseUrl'=>'http://bobrdobr.ru/addext.html?url=PERMALINK&amp;title=TITLE',
	),
	'shr-yandex'=>array(
		'check'=>sprintf($checkthis_text,'Yandex.Bookmarks').__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').'Yandex.Bookmarks',
		'baseUrl'=>'http://zakladki.yandex.ru/userarea/links/addfromfav.asp?bAddLink_x=1&amp;lurl=PERMALINK&amp;lname=TITLE',
	),
	'shr-memoryru'=>array(
		'check'=>sprintf($checkthis_text,'Memory.ru').__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').'Memory.ru',
		'baseUrl'=>'http://memori.ru/link/?sm=1&amp;u_data[url]=PERMALINK&amp;u_data[name]=TITLE',
	),
	'shr-100zakladok'=>array(
		'check'=>sprintf($checkthis_text,'100 bookmarks').__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').'100 bookmarks',
		'baseUrl'=>'http://www.100zakladok.ru/save/?bmurl=PERMALINK&amp;bmtitle=TITLE',
	),
	'shr-moemesto'=>array(
		'check'=>sprintf($checkthis_text,'MyPlace').__(' (Russian)', 'sexybookmarks'),
		'share'=>__('Add this to ', 'sexybookmarks').'MyPlace',
		'baseUrl'=>'http://moemesto.ru/post.php?url=PERMALINK&amp;title=TITLE',
	),
	'shr-hackernews'=>array(
		'check'=>sprintf($checkthis_text,'Hacker News'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Hacker News',
		'baseUrl'=>'http://news.ycombinator.com/submitlink?u=PERMALINK&amp;t=TITLE',
	),
	'shr-printfriendly'=>array(
		'check'=>sprintf($checkthis_text,'Print Friendly'),
		'share'=>__('Send this page to ', 'sexybookmarks').'Print Friendly',
		'baseUrl'=>'http://www.printfriendly.com/print?url=PERMALINK',
	),
	'shr-designbump'=>array(
		'check'=>sprintf($checkthis_text,'Design Bump'),
		'share'=>__('Bump this on ', 'sexybookmarks').'DesignBump',
		'baseUrl'=>'http://designbump.com/submit?url=PERMALINK&amp;title=TITLE&amp;body=POST_SUMMARY',
	),
	'shr-ning'=>array(
		'check'=>sprintf($checkthis_text,'Ning'),
		'share'=>__('Add this to ', 'sexybookmarks').'Ning',
		'baseUrl'=>'http://bookmarks.ning.com/addItem.php?url=PERMALINK&amp;T=TITLE',
	),
	'shr-identica'=>array(
		'check'=>sprintf($checkthis_text,'Identica'),
		'share'=>__('Post this to ', 'sexybookmarks').'Identica',
		'baseUrl'=>'http://identi.ca//index.php?action=newnotice&amp;status_textarea=Reading:+&quot;SHORT_TITLE&quot;+-+from+FETCH_URL',
	),
	'shr-xerpi'=>array(
		'check'=>sprintf($checkthis_text,'Xerpi'),
		'share'=>__('Save this to ', 'sexybookmarks').'Xerpi',
		'baseUrl'=>'http://www.xerpi.com/block/add_link_from_extension?url=PERMALINK&amp;title=TITLE',
	),
	'shr-wikio'=>array(
		'check'=>sprintf($checkthis_text,'Wikio'),
		'share'=>__('Share this on ', 'sexybookmarks').'Wikio',
		'baseUrl'=>'http://www.wikio.com/sharethis?url=PERMALINK&amp;title=TITLE',
	),
	'shr-techmeme'=>array(
		'check'=>sprintf($checkthis_text,'TechMeme'),
		'share'=>__('Tip this to ', 'sexybookmarks').'TechMeme',
		'baseUrl'=>'http://twitter.com/home/?status=Tip+@Techmeme+PERMALINK+&quot;TITLE&quot;&amp;source=shareaholic',
	),
	'shr-sphinn'=>array(
		'check'=>sprintf($checkthis_text,'Sphinn'),
		'share'=>__('Sphinn this on ', 'sexybookmarks').'Sphinn',
		'baseUrl'=>'http://sphinn.com/index.php?c=post&amp;m=submit&amp;link=PERMALINK',
	),
	'shr-posterous'=>array(
		'check'=>sprintf($checkthis_text,'Posterous'),
		'share'=>__('Post this to ', 'sexybookmarks').'Posterous',
		'baseUrl'=>'http://posterous.com/share?linkto=PERMALINK&amp;title=TITLE&amp;selection=POST_SUMMARY',
	),
	'shr-globalgrind'=>array(
		'check'=>sprintf($checkthis_text,'Global Grind'),
		'share'=>__('Grind this! on ', 'sexybookmarks').'Global Grind',
		'baseUrl'=>'http://globalgrind.com/submission/submit.aspx?url=PERMALINK&amp;type=Article&amp;title=TITLE',
	),
	'shr-pingfm'=>array(
		'check'=>sprintf($checkthis_text,'Ping.fm'),
		'share'=>__('Ping this on ', 'sexybookmarks').'Ping.fm',
		'baseUrl'=>'http://ping.fm/ref/?link=PERMALINK&amp;title=TITLE&amp;body=POST_SUMMARY',
	),
	'shr-nujij'=>array(
		'check'=>sprintf($checkthis_text,'NUjij').__(' (Dutch)', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').'NUjij',
		'baseUrl'=>'http://nujij.nl/jij.lynkx?t=TITLE&amp;u=PERMALINK&amp;b=POST_SUMMARY',
	),
	'shr-ekudos'=>array(
		'check'=>sprintf($checkthis_text,'eKudos').__(' (Dutch)', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').'eKudos',
		'baseUrl'=>'http://www.ekudos.nl/artikel/nieuw?url=PERMALINK&amp;title=TITLE&amp;desc=POST_SUMMARY',
	),
	'shr-netvouz'=>array(
		'check'=>sprintf($checkthis_text,'Netvouz'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Netvouz',
		'baseUrl'=>'http://www.netvouz.com/action/submitBookmark?url=PERMALINK&amp;title=TITLE&amp;popup=no',
	),
	'shr-netvibes'=>array(
		'check'=>sprintf($checkthis_text,'Netvibes'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Netvibes',
		'baseUrl'=>'http://www.netvibes.com/share?title=TITLE&amp;url=PERMALINK',
	),
	'shr-fleck'=>array(
		'check'=>sprintf($checkthis_text,'Fleck'),
		'share'=>__('Share this on ', 'sexybookmarks').'Fleck',
		'baseUrl'=>'http://beta3.fleck.com/bookmarklet.php?url=PERMALINK&amp;title=TITLE',
	),
	'shr-webblend'=>array(
		'check'=>sprintf($checkthis_text,'Web Blend'),
		'share'=>__('Blend this!', 'sexybookmarks'),
		'baseUrl'=>'http://thewebblend.com/submit?url=PERMALINK&amp;title=TITLE&amp;body=POST_SUMMARY',
	),
	'shr-wykop'=>array(
		'check'=>sprintf($checkthis_text,'Wykop').__(' (Polish)', 'sexybookmarks'),
		'share'=>__('Add this to Wykop!', 'sexybookmarks'),
		'baseUrl'=>'http://www.wykop.pl/dodaj?url=PERMALINK&amp;title=TITLE',
	),
	'shr-blogengage'=>array(
		'check'=>sprintf($checkthis_text,'BlogEngage'),
		'share'=>__('Engage with this article!', 'sexybookmarks'),
		'baseUrl'=>'http://www.blogengage.com/submit.php?url=PERMALINK',
	),
	'shr-hyves'=>array(
		'check'=>sprintf($checkthis_text,'Hyves'),
		'share'=>__('Share this on ', 'sexybookmarks').'Hyves',
		'baseUrl'=>'http://www.hyves.nl/profilemanage/add/tips/?name=TITLE&amp;text=POST_SUMMARY+-+PERMALINK&amp;rating=5',
	),
	'shr-pusha'=>array(
		'check'=>sprintf($checkthis_text,'Pusha').__(' (Swedish)', 'sexybookmarks'),
		'share'=>__('Push this on ', 'sexybookmarks').'Pusha',
		'baseUrl'=>'http://www.pusha.se/posta?url=PERMALINK&amp;title=TITLE',
	),
	'shr-hatena'=>array(
		'check'=>sprintf($checkthis_text,'Hatena Bookmarks').__(' (Japanese)', 'sexybookmarks'),
		'share'=>__('Bookmarks this on ', 'sexybookmarks').'Hatena Bookmarks',
		'baseUrl'=>'http://b.hatena.ne.jp/add?mode=confirm&amp;url=PERMALINK&amp;title=TITLE',
	),
	'shr-mylinkvault'=>array(
		'check'=>sprintf($checkthis_text,'MyLinkVault'),
		'share'=>__('Store this link on ', 'sexybookmarks').'MyLinkVault',
		'baseUrl'=>'http://www.mylinkvault.com/link-page.php?u=PERMALINK&amp;n=TITLE',
	),
	'shr-slashdot'=>array(
		'check'=>sprintf($checkthis_text,'SlashDot'),
		'share'=>__('Submit this to ', 'sexybookmarks').'SlashDot',
		'baseUrl'=>'http://slashdot.org/bookmark.pl?url=PERMALINK&amp;title=TITLE',
	),
	'shr-squidoo'=>array(
		'check'=>sprintf($checkthis_text,'Squidoo'),
		'share'=>__('Add to a lense on ', 'sexybookmarks').'Squidoo',
		'baseUrl'=>'http://www.squidoo.com/lensmaster/bookmark?PERMALINK',
	),
	'shr-propeller'=>array(
		'check'=>sprintf($checkthis_text,'Propeller'),
		'share'=>__('Submit this story to ', 'sexybookmarks').'Propeller',
		'baseUrl'=>'http://www.propeller.com/submit/?url=PERMALINK',
	),
	'shr-faqpal'=>array(
		'check'=>sprintf($checkthis_text,'FAQpal'),
		'share'=>__('Submit this to ', 'sexybookmarks').'FAQpal',
		'baseUrl'=>'http://www.faqpal.com/submit?url=PERMALINK',
	),
	'shr-evernote'=>array(
		'check'=>sprintf($checkthis_text,'Evernote'),
		'share'=>__('Clip this to ', 'sexybookmarks').'Evernote',
		'baseUrl'=>'http://www.evernote.com/clip.action?url=PERMALINK&amp;title=TITLE',
	),
	'shr-meneame'=>array(
		'check'=>sprintf($checkthis_text,'Meneame').__(' (Spanish)', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Meneame',
		'baseUrl'=>'http://meneame.net/submit.php?url=PERMALINK',
	),
	'shr-bitacoras'=>array(
		'check'=>sprintf($checkthis_text,'Bitacoras').__(' (Spanish)', 'sexybookmarks'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Bitacoras',
		'baseUrl'=>'http://bitacoras.com/anotaciones/PERMALINK',
	),
	'shr-jumptags'=>array(
		'check'=>sprintf($checkthis_text,'JumpTags'),
		'share'=>__('Submit this link to ', 'sexybookmarks').'JumpTags',
		'baseUrl'=>'http://www.jumptags.com/add/?url=PERMALINK&amp;title=TITLE',
	),
	'shr-bebo'=>array(
		'check'=>sprintf($checkthis_text,'Bebo'),
		'share'=>__('Share this on ', 'sexybookmarks').'Bebo',
		'baseUrl'=>'http://www.bebo.com/c/share?Url=PERMALINK&amp;Title=TITLE',
	),
	'shr-n4g'=>array(
		'check'=>sprintf($checkthis_text,'N4G'),
		'share'=>__('Submit tip to ', 'sexybookmarks').'N4G',
		'baseUrl'=>'http://www.n4g.com/tips.aspx?url=PERMALINK&amp;title=TITLE',
	),
	'shr-strands'=>array(
		'check'=>sprintf($checkthis_text,'Strands'),
		'share'=>__('Submit this to ', 'sexybookmarks').'Strands',
		'baseUrl'=>'http://www.strands.com/tools/share/webpage?title=TITLE&amp;url=PERMALINK',
	),
	'shr-orkut'=>array(
		'check'=>sprintf($checkthis_text,'Orkut'),
		'share'=>__('Promote this on ', 'sexybookmarks').'Orkut',
		'baseUrl'=>'http://promote.orkut.com/preview?nt=orkut.com&amp;tt=TITLE&amp;du=PERMALINK&amp;cn=POST_SUMMARY',
	),
	'shr-tumblr'=>array(
		'check'=>sprintf($checkthis_text,'Tumblr'),
		'share'=>__('Share this on ', 'sexybookmarks').'Tumblr',
		'baseUrl'=>'http://www.tumblr.com/share?v=3&amp;u=PERMALINK&amp;t=TITLE',
	),
	'shr-stumpedia'=>array(
		'check'=>sprintf($checkthis_text,'Stumpedia'),
		'share'=>__('Add this to ', 'sexybookmarks').'Stumpedia',
		'baseUrl'=>'http://www.stumpedia.com/submit?url=PERMALINK&amp;title=TITLE',
	),
	'shr-current'=>array(
		'check'=>sprintf($checkthis_text,'Current'),
		'share'=>__('Post this to ', 'sexybookmarks').'Current',
		'baseUrl'=>'http://current.com/clipper.htm?url=PERMALINK&amp;title=TITLE',
	),
	'shr-blogger'=>array(
		'check'=>sprintf($checkthis_text,'Blogger'),
		'share'=>__('Blog this on ', 'sexybookmarks').'Blogger',
		'baseUrl'=>'http://www.blogger.com/blog_this.pyra?t&amp;u=PERMALINK&amp;n=TITLE&amp;pli=1',
	),
	'shr-plurk'=>array(
		'check'=>sprintf($checkthis_text,'Plurk'),
		'share'=>__('Share this on ', 'sexybookmarks').'Plurk',
		'baseUrl'=>'http://www.plurk.com/m?content=TITLE+-+PERMALINK&amp;qualifier=shares',
	),
	'shr-dzone'=>array(
		'check'=>sprintf($checkthis_text,'DZone'),
		'share'=>__('Add this to ', 'sexybookmarks').'DZone',
		'baseUrl'=>'http://www.dzone.com/links/add.html?url=PERMALINK&amp;title=TITLE&amp;description=POST_SUMMARY',
	),	
	'shr-kaevur'=>array(
		'check'=>sprintf($checkthis_text,'Kaevur').__(' (Estonian)', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').'Kaevur',
		'baseUrl'=>'http://kaevur.com/submit.php?url=PERMALINK',
	),
	'shr-virb'=>array(
		'check'=>sprintf($checkthis_text,'Virb'),
		'share'=>__('Share this on ', 'sexybookmarks').'Virb',
		'baseUrl'=>'http://virb.com/share?external&amp;v=2&amp;url=PERMALINK&amp;title=TITLE',
	),	
	'shr-boxnet'=>array(
		'check'=>sprintf($checkthis_text,'Box.net'),
		'share'=>__('Add this link to ', 'sexybookmarks').'Box.net',
		'baseUrl'=>'https://www.box.net/api/1.0/import?url=PERMALINK&amp;name=TITLE&amp;description=POST_SUMMARY&amp;import_as=link',
	),
	'shr-oknotizie'=>array(
		'check'=>sprintf($checkthis_text,'OkNotizie').__('(Italian)', 'sexybookmarks'),
		'share'=>__('Share this on ', 'sexybookmarks').'OkNotizie',
		'baseUrl'=>'http://oknotizie.virgilio.it/post?url=PERMALINK&amp;title=TITLE',
	),
	'shr-bonzobox'=>array(
		'check'=>sprintf($checkthis_text,'BonzoBox'),
		'share'=>__('Add this to ', 'sexybookmarks').'BonzoBox',
		'baseUrl'=>'http://bonzobox.com/toolbar/add?pop=1&amp;u=PERMALINK&amp;t=TITLE&amp;d=POST_SUMMARY',
	),
	'shr-plaxo'=>array(
		'check'=>sprintf($checkthis_text,'Plaxo'),
		'share'=>__('Share this on ', 'sexybookmarks').'Plaxo',
		'baseUrl'=>'http://www.plaxo.com/?share_link=PERMALINK',
	),
	'shr-springpad'=>array(
		'check'=>sprintf($checkthis_text,'SpringPad'),
		'share'=>__('Spring this on ', 'sexybookmarks').'SpringPad',
		'baseUrl'=>'http://springpadit.com/clip.action?body=POST_SUMMARY&amp;url=PERMALINK&amp;format=microclip&amp;title=TITLE&amp;isSelected=true',
	),
	'shr-zabox'=>array(
		'check'=>sprintf($checkthis_text,'Zabox'),
		'share'=>__('Box this on ', 'sexybookmarks').'Zabox',
		'baseUrl'=>'http://www.zabox.net/submit.php?url=PERMALINK',
	),
	'shr-viadeo'=>array(
		'check'=>sprintf($checkthis_text,'Viadeo'),
		'share'=>__('Share this on ', 'sexybookmarks').'Viadeo',
		'baseUrl'=>'http://www.viadeo.com/shareit/share/?url=PERMALINK&amp;title=TITLE&amp;urlaffiliate=31138',
	),
	'shr-gmail'=>array(
		'check'=>sprintf($checkthis_text,'Gmail'),
		'share'=>__('Email this via ', 'sexybookmarks').'Gmail',
		'baseUrl'=>'https://mail.google.com/mail/?ui=2&amp;view=cm&amp;fs=1&amp;tf=1&amp;su=TITLE&amp;body=Link: PERMALINK '.__('(sent via shareaholic)', 'sexybookmarks').'%0D%0A%0D%0A----%0D%0A POST_SUMMARY',
	),
	'shr-hotmail'=>array(
		'check'=>sprintf($checkthis_text,'Hotmail'),
		'share'=>__('Email this via ', 'sexybookmarks').'Hotmail',
		'baseUrl'=>'http://mail.live.com/?rru=compose?subject=TITLE&amp;body=Link: PERMALINK '.__('(sent via shareaholic)', 'sexybookmarks').'%0D%0A%0D%0A----%0D%0A POST_SUMMARY',
	),
	'shr-yahoomail'=>array(
		'check'=>sprintf($checkthis_text,'Yahoo! Mail'),
		'share'=>__('Email this via ', 'sexybookmarks').'Yahoo! Mail',
		'baseUrl'=>'http://compose.mail.yahoo.com/?Subject=TITLE&amp;body=Link: PERMALINK '.__('(sent via shareaholic)', 'sexybookmarks').'%0D%0A%0D%0A----%0D%0A POST_SUMMARY',
	),
	'shr-buzzster'=>array(
		'check'=>sprintf($checkthis_text,'Buzzster!'),
		'share'=>__('Share this via ', 'sexybookmarks').'Buzzster!',
		'baseUrl'=>"javascript:var%20s=document.createElement('script');s.src='http://www.buzzster.com/javascripts/bzz_adv.js';s.type='text/javascript';void(document.getElementsByTagName('head')[0].appendChild(s));",
	),
);
ksort($sexy_bookmarks_data, SORT_STRING); //sort array by keys
?>