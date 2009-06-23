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


jQuery('#info-manual').css({ display: 'none' });
jQuery('#clear-warning').css({ display:'none' });
jQuery('#custom-warning').css({ display:'none' });

if (jQuery('#autocenter-yes').is(':checked')) {
	this.checked=jQuery('#xtrastyle').attr('disabled', true);
}
else {
	jQuery('#xtrastyle').removeAttr('disabled');
}

jQuery('#autocenter-yes').click(function() {
	this.checked=jQuery('#custom-warning').fadeIn('fast');
	this.checked=jQuery(this).is(':not(:checked)');
});

jQuery('#custom-warn-yes').click(function() {
	this.checked=jQuery('#custom-warning').fadeOut();
	this.checked=jQuery('#autocenter-yes').attr('checked', 'checked');
	this.checked=jQuery('#xtrastyle').attr('disabled', true);
	this.checked=jQuery(this).is(':not(:checked)');
});

jQuery('#autocenter-no').click(function() {
	this.checked=jQuery('#xtrastyle').removeAttr('disabled');
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


if (jQuery('#bgimg-yes').is(':checked')) {
	jQuery('#bgimgs').is(':visible');
}
else if (jQuery('#bgimg-yes').is(':not(:checked)')) {
	jQuery('#bgimgs').is(':hidden');
}
jQuery('#bgimg-yes').click(function() {
	if (this.checked) {
		this.checked=jQuery('#bgimgs').removeClass('hidden');
	}
	else {
		jQuery('#bgimgs').fadeOut();
	}
});


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


// Check for Tumblr and warn then remove
if (jQuery('#sexy-tumblr').is(':checked')) {
	jQuery('label.sexy-tumblr').css('background-color', '#df6f6f');
	jQuery('#sexy-tumblr').removeAttr('checked');
}
else if (jQuery('#sexy-tumblr').is(':not(:checked)')) {
	jQuery('label.sexy-tumblr').css('display', 'none');
}



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

jQuery('.shebang-info').click(function() {
	jQuery('#info-manual').fadeIn('fast');
});

jQuery('.boxcloser').click(function() {
	jQuery('.sexy-donation-box').slideUp('slow');
});

jQuery('#yourversion .del-x').click(function() {
	jQuery('#yourversion').fadeOut();
});

jQuery('#message .del-x').click(function() {
	jQuery('#message').fadeOut();
});

jQuery('#info-manual img.del-x').click(function() {
	jQuery('#info-manual').fadeOut();
});




jQuery('#clearShortUrls').click(function() {
	this.checked=jQuery('#clear-warning').fadeIn('fast');
	this.checked=jQuery(this).is(':not(:checked)');
});

jQuery('#warn-cancel').click(function() {
	this.checked=jQuery('#clear-warning').fadeOut();
	this.checked=jQuery(this).is(':not(:checked)');
});

jQuery('#warn-yes').click(function() {
	this.checked=jQuery('#clear-warning').fadeOut();
	this.checked=jQuery('#clearShortUrls').attr('checked', 'checked');
});

}});