jQuery(document).ready(function() {
		var sexyBaseHeight=jQuery('.sexy-bookmarks').height();
		var sexyFullHeight=jQuery('.sexy-bookmarks ul.socials').height();
		jQuery('.sexy-bookmarks-expand').hover(
			function() {
				jQuery(this).animate({
					height: sexyFullHeight+'px'
				}, {duration: 400, queue: false});
			},
			function() {
				jQuery(this).animate({
					height: sexyBaseHeight+'px'
				}, {duration: 400, queue: false});
			}
		);
	});
