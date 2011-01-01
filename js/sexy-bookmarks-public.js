jQuery(document).ready(function () {
    jQuery(".shr-bookmarks a.external").attr("target", "_blank");
    var c = jQuery(".shr-bookmarks").height(),
        d = jQuery(".shr-bookmarks ul.socials").height();
    d > c && jQuery(".shr-bookmarks-expand").hover(function () {
        jQuery(this).animate({
            height: d + "px"
        }, {
            duration: 400,
            queue: false
        })
    }, function () {
        jQuery(this).animate({
            height: c + "px"
        }, {
            duration: 400,
            queue: false
        })
    });
    if (jQuery(".shr-bookmarks-center") || jQuery(".shr-bookmarks-spaced")) {
        var a = jQuery(".shr-bookmarks").width(),
            b = jQuery(".shr-bookmarks:first ul.socials li").width(),
            e = jQuery(".shr-bookmarks:first ul.socials li").length,
            f = Math.floor(a / b);
        b = Math.min(f, e) * b;
        if (jQuery(".shr-bookmarks-spaced").length > 0) {
            a = Math.floor((a - b) / (Math.min(f, e) + 1));
            jQuery(".shr-bookmarks ul.socials li").attr("style", 'margin-left:' + a + 'px !important')
        } else if (jQuery(true)) {
            a = (a - b) / 2;
            jQuery(".shr-bookmarks-center").attr("style", 'margin-left:' + a + 'px !important')
        }
    }
});