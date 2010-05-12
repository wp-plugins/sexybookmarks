jQuery(document).ready(function($) {
	if ($('#iconator')) $('#sexy-networks').sortable({ 
		delay:        250,
		cursor:      'move',
		scroll:       true,
		revert:       true, 
		opacity:      0.7
	});
	if ($('.sexy-bookmarks')) { $('#sexy-sortables').sortable({ 
		handle:      '.box-mid-head',
		delay:        250,
		cursor:      'move',
		scroll:       true,
		revert:       true, 
		opacity:      0.7
	});

	//Select all icons upon clicking
	$('#sel-all').click(function() {
		$('#sexy-networks').each(function() {
			$('#sexy-networks input').attr('checked', 'checked');
		});
	});

	//Deselect all icons upon clicking
	$('#sel-none').click(function() {
		$('#sexy-networks').each(function() {
			$('#sexy-networks input').removeAttr('checked');
		});
	});

	//Select most popular icons upon clicking
	$('#sel-pop').click(function() {
		$('#sexy-networks').each(function() {
			$('#sexy-networks input').removeAttr('checked');
		});
		$('#sexy-networks').each(function() {
			$('#shr-digg').attr('checked', 'checked');
			$('#shr-reddit').attr('checked', 'checked');
			$('#shr-delicious').attr('checked', 'checked');
			$('#shr-stumbleupon').attr('checked', 'checked');
			$('#shr-mixx').attr('checked', 'checked');
			$('#shr-comfeed').attr('checked', 'checked');
			$('#shr-twitter').attr('checked', 'checked');
			$('#shr-technorati').attr('checked', 'checked');
			$('#shr-misterwong').attr('checked', 'checked');
			$('#shr-diigo').attr('checked', 'checked');
			$('#shr-googlebuzz').attr('checked', 'checked');
		});
	});

	/* Select recommended icons upon clicking
	$('#sel-pop').click(function() {
		$('#sexy-networks').each(function() {
			$('#shr-digg').attr('checked', 'checked');
			$('#shr-reddit').attr('checked', 'checked');
			$('#shr-delicious').attr('checked', 'checked');
			$('#shr-stumbleupon').attr('checked', 'checked');
			$('#shr-mixx').attr('checked', 'checked');
			$('#shr-comfeed').attr('checked', 'checked');
			$('#shr-twitter').attr('checked', 'checked');
			$('#shr-technorati').attr('checked', 'checked');
			$('#shr-misterwong').attr('checked', 'checked');
			$('#shr-???').attr('checked', 'checked');
			$('#shr-???').attr('checked', 'checked');
			$('#shr-???').attr('checked', 'checked');
			$('#shr-???').attr('checked', 'checked');
			$('#shr-???').attr('checked', 'checked');			
		});
	}); */

	//Swap enabled/disabled between donation options onclick
	$('#preset-amounts').parent('label').click(function() {
		$('#custom-amounts').attr('disabled', 'disabled').css({'cursor':'none'});
		$('#preset-amounts').removeAttr('disabled');
	});

	//Swap enabled/disabled between donation options onclick
	$('#custom-amounts').parent('label').click(function() {
		$('#preset-amounts').attr('disabled', 'disabled').css({'cursor':'none'});
		$('#custom-amounts').removeAttr('disabled');
	});

	// Handle tiny form submission upon selecting option to hide sponsor messages
	$('#hide-sponsors').click(function() {
		$('#no-sponsors').submit();
	});

	// Create a universal click function to close status messages...
	$('.del-x').click(function() {
		$(this).parent('div').parent('div').fadeOut();
	});

	// if checkbox isn't already checked, open warning message...
	$("#custom-mods").click(function() {
		if($(this).is(":not(:checked)")) {
			$("#custom-mods-notice").css("display", "none");
		}
		else {
			$("#custom-mods-notice").fadeIn("fast");
			$("#custom-mods-notice").css("display", "table");
		}
	});

	// close custom mods warning when they click the X
	$(".custom-mods-notice-close").click(function() {
		$("#custom-mods-notice").fadeOut('fast');
	});

	// Apply "smart options" to BG image
	$('#bgimg-yes').click(function() {
		if($(this).is(':checked')) {
			$('#bgimgs').fadeIn('slow');
		}
		else {
			$('#bgimgs').css('display', 'none');
		}
	});

	// Apply "smart options" to Yahoo! Buzz
	$('#shr-yahoobuzz').click(function() {
		if ($(this).attr('checked')) {
			$('#ybuzz-defaults').fadeIn('fast');
		}
		else {
			$('#ybuzz-defaults').fadeOut();
		}
	});

	// Apply "smart options" to Twittley
	$('#shr-twittley').click(function() {
		if ($(this).attr('checked')) {
			$('#twittley-defaults').fadeIn('fast');
		}
		else {
			$('#twittley-defaults').fadeOut();
		}
	});

	// Apply "smart options" to Twitter
	$('#shr-twitter').click(function() {
		if ($(this).attr('checked')) {
			$('#twitter-defaults').fadeIn('fast');
		}
		else {
			$('#twitter-defaults').fadeOut();
		}
	});

	$('#shorty').change(function() {
		$('#shortyapimdiv-bitly').fadeOut('fast');
		$('#shortyapimdiv-trim').fadeOut('fast');
		$('#shortyapimdiv-snip').fadeOut('fast');
		$('#shortyapimdiv-tinyarrow').fadeOut('fast');
		$('#shortyapimdiv-cligs').fadeOut('fast');
		$('#shortyapimdiv-supr').fadeOut('fast');
		if(this.value=='trim'){
			$('#shortyapimdiv-trim').fadeIn('fast');
		}
		else if(this.value=='bitly'){
			$('#shortyapimdiv-bitly').fadeIn('fast');
		}
		else if(this.value=='snip'){
			$('#shortyapimdiv-snip').fadeIn('fast');
		}
		else if(this.value=='tinyarrow'){
			$('#shortyapimdiv-tinyarrow').fadeIn('fast');
		}
		else if(this.value=='cligs'){
			$('#shortyapimdiv-cligs').fadeIn('fast');
		}
		else if(this.value=='supr'){
			$('#shortyapimdiv-supr').fadeIn('fast');
		}
	});

	$('#shortyapichk-trim').click(function() {
		if (this.checked) {
			$('#shortyapidiv-trim').fadeIn('fast');
		}
		else {
			$('#shortyapidiv-trim').fadeOut('fast');
		}
	});

	$('#shortyapichk-tinyarrow').click(function() {
		if (this.checked) {
			$('#shortyapidiv-tinyarrow').fadeIn('fast');
		}
		else {
			$('#shortyapidiv-tinyarrow').fadeOut('fast');
		}
	});

	$('#shortyapichk-cligs').click(function() {
		if (this.checked) {
			$('#shortyapidiv-cligs').fadeIn('fast');
		}
		else {
			$('#shortyapidiv-cligs').fadeOut('fast');
		}
	});

	$('#shortyapichk-supr').click(function() {
		if (this.checked) {
			$('#shortyapidiv-supr').fadeIn('fast');
		}
		else {
			$('#shortyapidiv-supr').fadeOut('fast');
		}
	});

	$('#position-above').click(function() {
		if ($('#info-manual').is(':visible')) {
			$('#info-manual').fadeOut();
		}
	});

	$('#position-below').click(function() {
		if ($('#info-manual').is(':visible')) {
			$('#info-manual').fadeOut();
		}
	});

	$('#position-manual').click(function() {
		if ($('#info-manual').is(':not(:visible)')) {
			$('#info-manual').fadeIn('slow');
		}
	});

	$('.dtags-info').click(function() {
		$('#tag-info').fadeIn('fast');
	});

	$('.dtags-close').click(function() {
		$('#tag-info').fadeOut();
	});

	$('.shebang-info').click(function() {
		$('#info-manual').fadeIn('fast');
	});

	$('.boxcloser').click(function() {
		$('.sexy-donation-box').slideUp('slow');
	});

	$('#clearShortUrls').click(function() {
		if ($('#clearShortUrls').is(':checked')) {
			this.checked=$('#clear-warning').fadeIn('fast');
		}else{
			this.checked=$(this).is(':not(:checked)');
		}
		this.checked=$(this).is(':not(:checked)');
	});

	$('#warn-cancel').click(function() {
		this.checked=$('#clear-warning').fadeOut();
		this.checked=$(this).is(':not(:checked)');
	});

	$('#warn-yes').click(function() {
		this.checked=$('#clear-warning').fadeOut();
		this.checked=$('#clearShortUrls').attr('checked', 'checked');
		this.checked=!this.checked;
	});



	$('#sexyresetallwarn-cancel').click(function() {
		$('#sexyresetallwarn').fadeOut();
	});

	$('#sexyresetallwarn-yes').click(function() {
		this.checked=$('#sexyresetallwarn').fadeOut();
		this.checked=$('#resetalloptionsaccept').submit();
		this.checked=!this.checked;
	});


	


// Load character count and tweet output demo onload
	var dfaultload = 0;
	var dfaulttitle = 8;
	var dfaulturl = 13;
	if($("#tweetconfig").val().indexOf('${title}')!=-1) {
		dfaultload = Math.floor(dfaultload + dfaulttitle);
	}
	if($("#tweetconfig").val().indexOf('${short_link}')!=-1) {
		dfaultload = Math.floor(dfaultload + dfaulturl);
	}
	var mathdoneload = Math.floor($('#tweetconfig').val().length - dfaultload);
	if(mathdoneload >= 50) {
		$('#tweetcounter span').addClass('error');
	}
	else {
		$('#tweetcounter span').removeClass();
	}
	$('#tweetcounter span').html(mathdoneload);
	var endvalueload = $('#tweetconfig').val();
	endvalueload = endvalueload.replace('${title}', 'Some fancy post title');
	endvalueload = endvalueload.replace('${short_link}', 'http://b2l.me/a4Dc1');
	var endtweetload = endvalueload;
	$('#tweetoutput span').html(endtweetload);



	$('#tweetconfig').keyup(function() {
		var dfaults = 0;
		var title = 8;
		var url = 13;

		if($("#tweetconfig").val().indexOf('${title}')!=-1) {
			dfaults = Math.floor(dfaults + title);
		}
		if($("#tweetconfig").val().indexOf('${short_link}')!=-1) {
			dfaults = Math.floor(dfaults + url);
		}

		var mathdone = Math.floor($(this).val().length - dfaults);

		if(mathdone >= 50) {
			$('#tweetcounter span').addClass('error');
			alert("You need to leave room for the short URL and/or post title...");
			return false;
		}
		else {
			$('#tweetcounter span').removeClass();
		}
		$('#tweetcounter span').html(mathdone);
		
		var endvalue = $(this).val();

		endvalue = endvalue.replace('${title}', 'Some fancy post title');
		endvalue = endvalue.replace('${short_link}', 'http://b2l.me/a4Dc1');

		var endtweet = endvalue;

		$('#tweetoutput span').html(endtweet);

	});




}});