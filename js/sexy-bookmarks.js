jQuery(document).ready(function() {
	if (jQuery('#iconator')) jQuery('#sexy-networks').sortable({ 
	delay:        250,
	cursor:      'move',
	scroll:       true,
	revert:       true, 
	opacity:      0.7
});
	if (jQuery('#sexy-bookmarks')) { jQuery('#sexy-sortables').sortable({ 
	handle:      '.box-mid-head',
	delay:        250,
	cursor:      'move',
	scroll:       true,
	revert:       true, 
	opacity:      0.7
});

// Check for Tumblr and alert of changes
// then remove completely after accepted
if (jQuery('#sexy-tumblr').is(':checked')) {
	jQuery('label.sexy-tumblr').css('background-color', '#df6f6f');
	jQuery('#sexy-tumblr').removeAttr('checked');
}
else if (jQuery('#sexy-tumblr').is(':not(:checked)')) {
	jQuery('label.sexy-tumblr').css('display', 'none');
}


jQuery('#info-manual').css({ display: 'none' });
jQuery('#clear-warning').css({ display:'none' });
jQuery('#custom-warning').css({ display:'none' });
jQuery('#custom-warning-a').css({ display:'none' });
jQuery('#mobile-warn').css({ display:'none' });


if (jQuery('#autocenter-no').is(':not(:checked)')) {
	this.checked=jQuery('#xtrastyle').attr('disabled', true);
	this.checked=jQuery('#xtrastyle').val('Custom CSS has been disabled because you are using either the "Auto Space" or "Auto Center" option above.');
}

jQuery('#autocenter-yes').click(function() {
	this.checked=jQuery('#custom-warning').fadeIn('fast');
	this.checked=jQuery(this).is(':not(:checked)');
});
jQuery('#autospace-yes').click(function() {
	this.checked=jQuery('#custom-warning-a').fadeIn('fast');
	this.checked=jQuery(this).is(':not(:checked)');
});

jQuery('#custom-warn-yes').click(function() {
	this.checked=jQuery('#custom-warning').fadeOut();
	this.checked=jQuery('#autocenter-yes').attr('checked', 'checked');
	this.checked=jQuery('#xtrastyle').attr('disabled', true);
	this.checked=jQuery('#xtrastyle').val('Custom CSS has been disabled because you are using either the "Auto Space" or "Auto Center" option above.');
	this.checked=jQuery(this).is(':not(:checked)');
});
jQuery('#custom-warn-yes-a').click(function() {
	this.checked=jQuery('#custom-warning-a').fadeOut();
	this.checked=jQuery('#autospace-yes').attr('checked', 'checked');
	this.checked=jQuery('#xtrastyle').attr('disabled', true);
	this.checked=jQuery('#xtrastyle').val('Custom CSS has been disabled because you are using either the "Auto Space" or "Auto Center" option above.');
	this.checked=jQuery(this).is(':not(:checked)');
});



jQuery('#autocenter-no').click(function() {
	this.checked=jQuery('#xtrastyle').removeAttr('disabled');
	this.checked=jQuery('#xtrastyle').val('margin:20px 0 0 0 !important;\npadding:25px 0 0 10px !important;\nheight:29px;/*the height of the icons (29px)*/\ndisplay:block !important;\nclear:both !important;');
});



jQuery('.toggle').click(function(){
	var id = jQuery(this).attr('id');
	jQuery('#tog'+ id).slideToggle('slow');

	if (jQuery('#'+ id + ' img.close').is(':hidden')){
		jQuery('#'+ id +' img.close').show();
		jQuery('#'+ id +' img.open').fadeOut();
	} else {
		jQuery('#'+ id + ' img.open').show();
		jQuery('#'+ id + ' img.close').fadeOut();
	}
});



// Apply "smart options" to BG image
jQuery('#bgimg-yes').click(function() {
	jQuery('#bgimgs').toggleClass('hidden').toggleClass('');
});


// Apply "smart options" to Yahoo! Buzz
if (jQuery('#sexy-yahoobuzz').is(':checked')) {
	jQuery('#ybuzz-defaults').is(':visible');
}
else if (jQuery('#sexy-yahoobuzz').is(':not(:checked)')) {
	jQuery('#ybuzz-defaults').is(':hidden');
}
jQuery('#sexy-yahoobuzz').click(function() {
	if (this.checked) {
		this.checked=jQuery('#ybuzz-defaults').fadeIn('fast');
	}
	else {
		jQuery('#ybuzz-defaults').fadeOut();
	}
});

// Apply "smart options" to Twittley
if (jQuery('#sexy-twittley').is(':checked')) {
	jQuery('#twittley-defaults').is(':visible');
}
else if (jQuery('#sexy-twittley').is(':not(:checked)')) {
	jQuery('#twittley-defaults').is(':hidden');
}
jQuery('#sexy-twittley').click(function() {
	if (this.checked) {
		this.checked=jQuery('#twittley-defaults').fadeIn('fast');
	}
	else {
		jQuery('#twittley-defaults').fadeOut();
	}
});

// Apply "smart options" to Twitter
if (jQuery('#sexy-twitter').is(':checked')) {
	jQuery('#twitter-defaults').is(':visible');
}
else if (jQuery('#sexy-twitter').is(':not(:checked)')) {
	jQuery('#twitter-defaults').is(':hidden');
}
jQuery('#sexy-twitter').click(function() {
	if (this.checked) {
		this.checked=jQuery('#twitter-defaults').fadeIn('fast');
	}
	else {
		jQuery('#twitter-defaults').fadeOut();
	}
});


// Apply "smart options" to bit.ly DIV
jQuery('#shorty').click(function() {
	if (jQuery("#shorty option[value='bitly']").is(':selected')) {
		jQuery('#shortyapimdiv-bitly').fadeIn('fast');
	}
	else {
		jQuery('#shortyapimdiv-bitly').fadeOut('fast');
	}
});


// Fade in/out mobile feature warning
jQuery('#mobile-hide').click(function() {
	if (this.checked) {
		this.checked=jQuery('#mobile-warn').fadeIn('fast');
	}
	else {
		jQuery('#mobile-warn').fadeOut();
	}
});


jQuery('#position-above').click(function() {
	if (jQuery('#info-manual').is(':visible')) {
		this.checked=jQuery('#info-manual').fadeOut();
	}
});

jQuery('#position-below').click(function() {
	if (jQuery('#info-manual').is(':visible')) {
		this.checked=jQuery('#info-manual').fadeOut();
	}
});

jQuery('#position-manual').click(function() {
	if (jQuery('#info-manual').is(':not(:visible)')) {
		this.checked=jQuery('#info-manual').fadeIn('slow');
	}
});

jQuery('.dtags-info').click(function() {
	jQuery('#tag-info').fadeIn('fast');
});

jQuery('.dtags-close').click(function() {
	jQuery('#tag-info').fadeOut();
});

jQuery('.shebang-info').click(function() {
	jQuery('#info-manual').fadeIn('fast');
});

jQuery('.boxcloser').click(function() {
	jQuery('.sexy-donation-box').slideUp('slow');
});

jQuery('#yourversion .del-x').click(function() {
	jQuery('#yourversion').fadeOut();
});

jQuery('div#errmessage img.del-x').click(function() {
	jQuery('div#errmessage').fadeOut();
});

jQuery('div#warnmessage img.del-x').click(function() {
	jQuery('div#warnmessage').fadeOut();
});

jQuery('div#statmessage img.del-x').click(function() {
	jQuery('div#statmessage').fadeOut();
});

jQuery('div#clearurl img.del-x').click(function() {
	jQuery('div#clearurl').fadeOut();
});

jQuery('#info-manual img.del-x').click(function() {
	jQuery('#info-manual').fadeOut();
});

jQuery('#mobile-warn img.del-x').click(function() {
	jQuery('#mobile-warn').fadeOut();
});




jQuery('#clearShortUrls').click(function() {
    if (jQuery('#clearShortUrls').is(':checked')) {
        this.checked=jQuery('#clear-warning').fadeIn('fast');
    }else{
        this.checked=jQuery(this).is(':not(:checked)');
    }
    this.checked=jQuery(this).is(':not(:checked)');
});



jQuery('#warn-cancel').click(function() {
	this.checked=jQuery('#clear-warning').fadeOut();
	this.checked=jQuery(this).is(':not(:checked)');
});

jQuery('#warn-yes').click(function() {
	this.checked=jQuery('#clear-warning').fadeOut();
	this.checked=jQuery('#clearShortUrls').attr('checked', 'checked');
	this.checked=!this.checked;
});

}});