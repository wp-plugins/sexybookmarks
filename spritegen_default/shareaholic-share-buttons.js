if (typeof(SHR4P)=="undefined") SHR4P = {};
SHR4P['debug_enabled'] = 'true';

SHR4P.base_url = "http://www.shareaholic.com/";
SHR4P.shr_link =  SHR4P.base_url + "api/share/";

SHR4P.shr_css = SHR4P.base_url + "media/css/shareaholic-share-button.css";

SHR4P.debug = function(str) {
  if (SHR4P['debug_enabled']) {
    if (typeof(console) != 'undefined' && console) {
      console.log(str);
    } else {
      alert(str);
    }
  }
};

SHR4P.ready = false;
SHR4P.init = false;


var SHR4P_init = function() {
  SHR4P.debug('SHR4P_init called');
  // only one please!
  if (SHR4P.init) {
    SHR4P.debug('SHR4P_init returning because already loaded');
    return;
  }
  SHR4P.init = true;
  if(typeof(sb_dont_noConflict) != "undefined" && sb_dont_noConflict) {
    SHR4P.jQuery = jQuery; // We didn't insert any jquery so shouldnot no conflict
  } else {
    SHR4P.jQuery = jQuery.noConflict(true);
  }

  (function ($) {
        SHR4P.renderShareButtons = function () {   // Create a basic frame around the sharing anchors and attach the share url
            SHR4P.debug('SHR4P.renderShareButtons called');
            if(typeof(SHR_Settings) == "undefined" || !SHR_Settings) {
                    window['SHR_Settings'] = {};
            }

            $('.shr-toolbox').each(function() {
                var container = $(this);
                var form_factor = container.attr("data-shr_form_factor") || container.attr("shr_form_factor");

                container.addClass(form_factor + "-head");
                
                var link = container.attr('data-shr_link') || container.attr('shr_link');
                link = link || document.location.href;

                var title = container.attr('data-shr_title') || container.attr('shr_title');
                title = title || ((link == document.location.href) ? document.title : "");

                var short_link = container.attr('data-shr_short_link') || container.attr('shr_short_link');
                short_link = short_link || "";

                container.children("#shareaholic_services").wrapInner("<ul></ul>");

                container.find("ul>a").each(function() {
                    var jThis = $(this);
                    var service_name = jThis.attr('data-shr_service') || jThis.attr('shr_service');;
                    var service = -1;
                    $.each(SHR4P.tooltips_suffix, function(key, value) {
                      if(value == service_name) {
                          service = key;
                          return;
                      }
                    });

                    var browserLocale = SHR4P.utils.getBrowserLocale();

                    browserLocale = browserLocale.split("-")[0];
                    if(typeof(SHR4P.locales[browserLocale]) == "undefined" || !SHR4P.locales[browserLocale]) {
                        browserLocale = 'en';
                    }
                    var tipText = SHR4P.locales[browserLocale][SHR4P.tooltips_prefix_map[service]] + ' ' + SHR4P.tooltips_suffix[service]/*SHR4P.tooltips[v]*/;

                    var show_count = jThis.attr('data-shr_showCount') || jThis.attr('shr_showCount');
                    show_count = show_count || 'true';
                    
                    var sharingLi = "";
                    jThis.wrap('<li class="shr-'+service+' shareaholic '+form_factor+'"></li>');
                    
                    if ((service == '7' || service == '306' || service == '307') && !SHR4P.utils.isMobileBrowser()) {

                        var service_name = "";

                        switch(service) {
                            case '306':
                                service_name = "more";
                                break;
                            case '307':
                                service_name = "all";
                                break;
                            case '7':
                            default:
                                service_name = "twitter";
                        }
                        
                        var params = {};
                        params['shortener'] = SHR_Settings.shortener ? SHR_Settings.shortener : "google";
                        params['shortener_key'] = SHR_Settings.shortener_key ? SHR_Settings.shortener_key : "";
                        params['apikey'] = SHR_Settings.apikey ? SHR_Settings.apikey : "8afa39428933be41f8afdb8ea21a495c";
                        params['twitter_template'] = SHR_Settings.twitter_template ? SHR_Settings.twitter_template:'${title} - ${short_link}';
                        params["link"] = link;
                        params["title"] = title;
                        params["short_link"] = short_link;

                        jThis.attr({
                                href: url(SHR4P.shr_link, {
                                  title: title,
                                  link: link,
                                  short_link: short_link,
                                  shortener: SHR_Settings.shortener ? SHR_Settings.shortener : "google",
                                  shortener_key : SHR_Settings.shortener_key ? SHR_Settings.shortener_key : "",
                                  v: 1,
                                  apitype: 1,
                                  apikey: SHR_Settings.apikey ? SHR_Settings.apikey : "8afa39428933be41f8afdb8ea21a495c",
                                  template: SHR_Settings.twitter_template ? SHR_Settings.twitter_template:'${title} - ${short_link}',
                                  service: service
                                }),
                                //rel: config.rel,
                                target: "_blank",
                                'class': 'external',
                                title: tipText,
                                'shr_service_id': service
                              }).click(function(e) {
                                SHR4P.utils.showServiceLet(params,service_name);
                                e.preventDefault();
                            });

                            
                    } else {
                       jThis.attr({
                            href: url(SHR4P.shr_link, {
                              title: title,
                              link: link,
                              short_link: short_link,
                              shortener: SHR_Settings.shortener ? SHR_Settings.shortener : "google",
                              shortener_key : SHR_Settings.shortener_key ? SHR_Settings.shortener_key : "",
                              v: 1,
                              apitype: 1,
                              apikey: SHR_Settings.apikey ? SHR_Settings.apikey : "8afa39428933be41f8afdb8ea21a495c",
                              template: SHR_Settings.twitter_template ? SHR_Settings.twitter_template:'${title} - ${short_link}',
                              service: service
                            }),
                            //rel: config.rel,
                            target: "_blank",
                            'class': 'external',
                            title: tipText,
                            'shr_service_id': service
                          })
                        
                    }
                    
                });

                layoutFormFactor(form_factor,container);

            });
        };
        
        var layoutFormFactorCalled = false;
        var scrollOffset = 120;
        var shrTopBarHidden = false;

        var layoutFormFactor = function(form_factor,container) {
            SHR4P.debug('SHR4P.layoutFormFactor called');
            if(typeof(form_factor) == "undefined" || !form_factor || typeof(container) == "undefined" || !container) {
                return;
            }
            if(form_factor == "shareaholic-top-bar") {
                if(!layoutFormFactorCalled) {
                    layoutFormFactorCalled = true;
                } else {
                    return;
                }
                var bgColor = SHR_Settings.topBarBgColor;
                bgColor = bgColor || '#343434';
                $("<style type='text/css'>#shareToolBar,#showHideToolBar{ background-color: "+bgColor+" !important;}</style>").appendTo("head");
                var toolBar = $("<div id='shareaholic-bar' style='display:none'><div id='shareToolBar'></div></div>");
                container.wrap(toolBar);
                var topBar = container.parents('#shareaholic-bar');
                $("<div id='showHideToolBar'>Hide</div>").prependTo(topBar);

                topBar.find('#showHideToolBar').click(function () {
                    shrTopBarHidden = !shrTopBarHidden;
                    $('#shareToolBar').slideToggle(400);
                });

                $(window).scroll(function (data) {
                    var scrollTop = $(window).scrollTop();
                    var hidden = ($('#shareaholic-bar').css('display') == 'none');
                    if(scrollTop > scrollOffset) {
                        if(hidden) {
                            $('#shareaholic-bar').slideDown(400);
                        }
                    } else if(!shrTopBarHidden){
                        $('#shareaholic-bar').slideUp(400);
                    }
                });

            
                var link = container.attr("data-shr_link") || container.attr("shr_link");
                container.find("ul>li>a").each(function() {
                        var jThis = $(this);
                        SHR4P.debug(jThis);
                        var tipText = jThis.attr("data-title") || jThis.attr("title");
                        var show_count = jThis.attr("data-shr_showCount") || jThis.attr("shr_showCount");
                        var service = parseInt( jThis.attr("data-shr_service_id") || jThis.attr("shr_service_id"));
                        jThis.append("<div class='shr-icon'></div><div class='shr-text'>" + tipText + "</div>");
                        SHR4P.debug(jThis);
                        if(show_count == "true" && (service == 5
                            || service == 7)) { //facebook
                            var dispCount = function (obj) {
                                var count = obj.count;
                                if(parseInt(count) >0) {
                                    var cntDiv = $('<div/>').addClass('shr-count').appendTo(jThis.find('.shr-icon'));
                                    for(var i=0; i<9; i+=1) {
                                        if(i!=4) {
                                            cntDiv.append(
                                                $('<div>'+count+'</div>').addClass('shr-count-outline').css({
                                                                    right: (15 - (i%3)+1) + 'px',
                                                                    top: (14 - parseInt(i/3)) + 'px'
                                                                })
                                            );
                                        }
                                    }
                                    cntDiv.append(
                                        $('<div>'+count+'</div>').addClass('shr-count-center').css({
                                                                right: '15px',
                                                                top: '13px'
                                                            })
                                    );
                                }
                            };
                    }

                    if(show_count == "true" && service == 5) { //facebook
                        SHR4P.utils.getFbShrCnt(link, dispCount);
                    } else if(show_count == "true" && service == 7) { //twitter
                        SHR4P.utils.getTwitShrCnt(link, dispCount);
                    }


                });
            } else if(form_factor == "shareaholic-mini") {

                var link = container.attr("data-shr_link") || container.attr("shr_link");;
                container.find("ul>li>a").each(function() {
                        var jThis = $(this);
                        
                        var service = parseInt(jThis.attr('data-shr_service_id') || jThis.attr('shr_service_id'));
                        
                        var className = "shr-" + service;
                        var show_count = jThis.attr('data-shr_showCount') || jThis.attr('shr_showCount');
                        if(show_count == "true") {
                            className += "-count";
                        }
                        var is_compact = jThis.attr('data-shr_Compact') || jThis.attr('shr_Compact');
                        if(show_count == "true" && is_compact == "true") {
                            className += "-compact";
                        }
                        jThis.parent().removeClass('shr-' + service);
                        jThis.addClass(className);
                        
                        if(show_count  == "true") {
                            var countDiv = this;

                            if(is_compact == "true"){
                                this.style.marginRight = "0px";

                                var tickDiv = document.createElement("div");

                                countDiv = document.createElement("div");
                                var parNode = this.parentNode;
                                parNode.appendChild(countDiv);
                                countDiv.className = "shr_compact_div";
                                tickDiv.className = "shr_compact_tick";
                                tickDiv.appendChild(document.createElement("s"));
                                tickDiv.appendChild(document.createElement("i"));
                                parNode.insertBefore(tickDiv,countDiv);

                            }

                             var dispCount = function (obj) {
                                 countDiv.innerHTML = obj.count;
                             };


                            if(show_count == "true" && service == 5) { //facebook
                                SHR4P.utils.getFbShrCnt(link, dispCount);
                            } else if(show_count == "true" && service == 7) { //twitter
                                SHR4P.utils.getTwitShrCnt(link, dispCount);
                            }
                    
                        }
                    });
                }

        };


        var url = function(path, params) {
            return [path, $.param(params)].join('?');
         };

  })(SHR4P.jQuery);

  SHR4P.ready = true;
  if(typeof(SHR4P.onready) != 'undefined') {
    SHR4P.onready();
  }
};

SHR4P.load = function() {
    // Attach styling CSS
    var link = document.createElement('link');
	link.rel = "stylesheet";
	link.type = "text/css";
	link.href = SHR4P.shr_css;
	document.getElementsByTagName('head')[0].appendChild(link);

    // Always load jQuery to ensure we are working with the version we want to.
    
    if(typeof(jQuery)!="undefined" && jQuery) {
        // jQuery is already present in the page.. Check if version number requirements are met
        var pageVersion = jQuery().jquery;
        if(SHRSB_Globals.minJQueryVersion <= pageVersion) {
            window["sb_dont_noConflict"] = true;
            SHR4P_init();
            return;
        }
    }

    SHR4P.debug('loading jquery');
    var head = document.getElementsByTagName('head')[0];
    if (typeof(head) != 'undefined') {
      var jq_script = document.createElement('script');
      if (SHR4P['debug_enabled']) {
        jq_script.src = "//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.js";
      } else {
        jq_script.src = "//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js";
      }
      jq_script.type = "text/javascript";
      head.appendChild(jq_script);
      jq_script.onreadystatechange = function() {
        if (this.readyState == 'complete' || this.readyState == 'loaded') {
          SHR4P.debug('jQuery loaded with onreadystatechange, init\'ing');
          SHR4P_init();
        }
      };
      jq_script.onload = SHR4P_init;
    }

    

};

SHR4P.onready = function () {
  if(/(loaded|complete)/.test(document.readyState)) {
      SHR4P.readyHandler();
    } else {
      SHR4P.jQuery(document).ready(function(){
        SHR4P.readyHandler();
      });
    }
};

SHR4P.readyHandler = function() {
    SHR4P.renderLikeButtons();
    SHR4P.renderShareButtons();
};

SHR4P.utils = {
    getBrowserLocale : function () {
            var locale = "en-us";
            if ( navigator ) {
                if ( navigator.language ) {
                    locale = navigator.language;
                }
                else if ( navigator.browserLanguage ) {
                    locale = navigator.browserLanguage;
                }
                else if ( navigator.systemLanguage ) {
                    locale = navigator.systemLanguage;
                }
                else if ( navigator.userLanguage ) {
                    locale = navigator.userLanguage;
                }
            }
            return locale.toLowerCase();
        },
    showServiceLet : function(params,service) {
            if(typeof(service) == "undefined" || !service) {
                return;
            }

            if(typeof(SHR_config) == "undefined" || !SHR_config) {
                window["SHR_config"] = {};
            }

            window["__shr_service"] = service;
            window["__shr_log"] = 'true';
            window["__shr_center"] = true;


            SHR_config['shortener'] = params.shortener ? params.shortener : "google",
            SHR_config['shortener_key'] = params.shortener_key ? params.shortener_key : "",
            SHR_config['apikey'] = params.apikey ? params.apikey : "8afa39428933be41f8afdb8ea21a495c",
            SHR_config['twitter_template'] = params.twitter_template ? params.twitter_template:'${title} - ${short_link}',
            SHR_config["link"] = params.link ? params.link : document.location.href;
            SHR_config["title"] = params.title ? params.title : (params.link ? "" : document.title);
            SHR_config["short_link"] = params.short_link ? params.short_link : "" ;

            if(window.SHR && window.SHR.Servicelet) {
                SHR.Servicelet.show();
            } else{
                var d = document;
                var s=d.createElement('script');
                s.setAttribute('language','javascript');
                s.id='shr-servicelet';
                s.setAttribute('src', (params.share_src ? params.share_src : "http://www.shareaholic.com" ) + '/media/js/servicelet.min.js');
                d.body.appendChild(s);
            }
        },

    isMobileBrowser : function () {
            var searchStr = navigator.userAgent||navigator.vendor||window.opera;
            var isMobile = /android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(searchStr)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i.test(searchStr.substr(0,4));
            return isMobile;
        },

    getFbShrCnt : function (url,handler) {
		url = "http://api.ak.facebook.com/restserver.php?v=1.0&method=links.getStats&format=json&urls="
				+ encodeURIComponent(url);
		SHR4P.jQuery.getJSON(url+'&callback=?',function (obj) {
			var count = 0;
			if(obj.length > 0) {
				count = obj[0].total_count;
				if (count != 0) {
					if (count > 1000) {
						count = Math.floor(count/1000) + 'K';
					}
				}
			}

			handler({count:count});
		});
	},

	getTwitShrCnt : function (url,handler) {
		url = "http://urls.api.twitter.com/1/urls/count.json?url="
				+ encodeURIComponent(url);
		SHR4P.jQuery.getJSON(url+'&callback=?',function (obj) {
				var count = obj.count;
				if (count != 0) {
					if (count > 1000) {
						count = Math.floor(count/1000) + 'K';
					}
				}
				handler({count:count});
			});
	}
};


//Code Reused from Sexybookmark script -- Started
SHR4P.renderLikeButtons = function () {
    if(SHR4P.jQuery('.shareaholic-fblike,.shareaholic-fbsend','.shareaholic-like-buttonset').length > 0) {
        setTimeout("SHR4P.fbUtil.addFBConnect()",0);
    }
    if(SHR4P.jQuery('.shareaholic-googleplusone','.shareaholic-like-buttonset').length > 0) {
        setTimeout("SHR4P.googPlusOneUtil.addGoogScript()",0);
    }
};

SHR4P.googPlusOneUtil = {
    addGoogScript: function(){
        if(SHR4P.jQuery("#googplusonescript").length == 0) {
            var e = document.createElement('script');e.async = true;
            e.src = "https://apis.google.com/js/plusone.js";
            e.id = "googplusonescript";
            e.text = '{"parsetags": "explicit"}';

            document.getElementsByTagName("head")[0].appendChild(e);


            e.onreadystatechange = function() {
                if (this.readyState == 'complete' || this.readyState == 'loaded') {
                  SHR4P.googPlusOneUtil.renderPlusOnes();
                }
            };
            e.onload = SHR4P.googPlusOneUtil.renderPlusOnes;
        }
    },
    renderPlusOnes: function () {
        SHR4P.jQuery('.shareaholic-googleplusone','.shareaholic-like-buttonset').each(function() {
            var jThis = SHR4P.jQuery(this);

            //Get value from html
            var targ = jThis.attr('data-shr_href') || jThis.attr('shr_href');
            var title = jThis.attr('data-shr_title') || jThis.attr('shr_title');
            var size = jThis.attr('data-shr_size') || jThis.attr('shr_size');
			var count = jThis.attr('data-shr_count') || jThis.attr('shr_count');
            
            //New Api parameters
            var annotation = jThis.attr('data-shr_annotation');
            var width = jThis.attr('data-shr_width');
            var expandto = jThis.attr('data-shr_expandto');
            var onstartinteraction = jThis.attr('data-shr_onstartinteraction');
            var onendinteraction = jThis.attr('data-shr_onendinteraction');

            
            //Depriciated by google plusone api
            //For Count
            if(typeof(count) == "undefined" || !count) {
                count = "true";
            }
            
            //For Title and href
            if((typeof(targ) == "undefined" || !targ) && (typeof(title) == "undefined" || !title )){
                targ = encodeURIComponent(document.location.href);
                title = document.title;
            }else{
                if(typeof(targ) == "undefined" || !targ) {
                    targ = encodeURIComponent(document.location.href);
                }

                if(typeof(title) == "undefined" || !title) {
                    title = "";
                }
            }

            //For the size
            if(typeof(size) == "undefined" || !size) {
                size = "standard";
            }
            
            //For annotation - none, bubble, inline
            if(typeof(annotation) == "undefined" || !annotation) {
                annotation = "inline";
                if(typeof(count) !== "undefined" && (count &&  count !== "false")){
                    annotation = "inline";
                }else{
                    annotation = "none";
                }
            }
            
            //For width
            if((typeof(width) == "undefined" || !width)){
                 width = "450px";
            }

            //For expandto
            if((typeof(expandto) == "undefined" || !expandto)){
                 expandto = "";
            }

            //For onstartinteraction
            if((typeof(onstartinteraction) == "undefined" || !onstartinteraction)){
                 onstartinteraction = "";
            }

            //For onendinteraction
            if((typeof(onendinteraction) == "undefined" || !onendinteraction)){
                 onendinteraction = "";
            }
            
            //For padding - not related to googleplus api
            var padding = "";
            if(size == 'medium') {
                padding = 'padding-top:1px !important;';
            }

            //For container in which we render google plus
            var container = SHR4P.jQuery("<div style='float:left; "+ padding +" margin:0px 0px 0px 10px !important;'/>").get(0);
            jThis.replaceWith(container);
            SHR4P.jQuery(container).append("<div/>");
            container = SHR4P.jQuery(container).find(':first-child').get(0);

            //Calling plusone api
            gapi.plusone.render(container,{"size": size, "annotation": annotation, "width":width, "expandto": expandto, "onstartinteraction":onstartinteraction, "onendinteraction":onendinteraction, "href":decodeURIComponent(targ), "callback" :function(obj){
                SHR4P.googPlusOneUtil.trackPlusOneClick(obj,title)}});
            });
    },
    //tracking function, registered as a callback in plusone api
    trackPlusOneClick: function (obj, title) {
        if(obj.state == "on") {
            SHR4P.jQuery('<img/>').attr({
                    src : ("http://www.shareaholic.com/api/share/?v=1&apikey=172809fde4d12743cc4a1ec894142b97f&apitype=3&service=304&link=" + encodeURIComponent(obj.href) + (title !== "" ? "&title="+title :"" ) ),
                    width  : "1",
                    height : "1"
                }).appendTo("body");
        }
    }
};

SHR4P.fbUtil = {
    fbConnectAdd : 0,
    renderFBWidgetCalled: false,
    likeButtonsToRender : [],
    // An array containing like button tags to parse that were formed before FB script was inserted

    /*renderFBWidgetHandlerAttached: false,*/// This code should be inserted back once fb fixes parse bug

    hasFB : function () {
        return (typeof (window.FB) == "object" && FB.Event && typeof (FB.Event.subscribe) == "function");
    },

    addLikeButton : function (par, href) {
        if(SHR4P.fbUtil.hasFBNameSpace()) {
            var likeBtn = SHR4P.jQuery('<fb:like href="'+ href +'"layout="button_count" show_faces="true" width="60" font=""></fb:like>').appendTo(par);

            if(typeof(window.FB) != "undefined" && FB.XFBML && FB.XFBML.parse) {
                FB.XFBML.parse(likeBtn.get(0));
            } else {
                SHR4P.fbUtil.likeButtonsToRender.push(likeBtn.get(0));
            }
        } else {
          SHR4P.jQuery('<iframe src="http://www.facebook.com/plugins/like.php?app_id=207766518608&amp;'
            + 'href='+ href + '&amp;send=false&amp;layout=button_count&amp;'
            + 'width=90&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" '
            + 'style="border:none; overflow:hidden; width:90px; height:21px;" allowTransparency="true"></iframe>').appendTo(par);
        }


    },

/*    addSendButton : function (par, href) {
        var likeBtn = SHR4P.jQuery('<fb:send href="'+ href +'"layout="button_count" show_faces="true" width="60" font=""></fb:send>').appendTo(par);

        if(typeof(window.FB) != "undefined" && FB.XFBML && FB.XFBML.parse) {
            FB.XFBML.parse(likeBtn.get(0));
        }
    },
*/
    renderFBWidgets: function () {
        if(!SHR4P.fbUtil.renderFBWidgetCalled) {
            setTimeout('SHR4P.fbUtil.renderFBLikeButtons()',0);
            setTimeout('SHR4P.fbUtil.renderFBSendButtons()',0);

            for(var i=0; i<SHR4P.fbUtil.likeButtonsToRender.length; ++i){
                if(typeof(window.FB) != "undefined" && FB.XFBML && FB.XFBML.parse) {
                    FB.XFBML.parse(SHR4P.fbUtil.likeButtonsToRender[i]);
                }
            }
            SHR4P.fbUtil.renderFBWidgetCalled = true;
        }
    },

    renderFBSendButtons : function () {
        SHR4P.jQuery('.shareaholic-fbsend','.shareaholic-like-buttonset').each(function() {
            if(SHR4P.fbUtil.hasFBNameSpace()) {
                var jThis = SHR4P.jQuery(this);
                var targ = jThis.attr('data-shr_href');
                if(typeof(targ) == "undefined" || !targ) {
                    targ = encodeURIComponent(document.location.href);
                }

                var container = SHR4P.jQuery("<div style='float:left;padding-top:0px !important; margin:0px 5px !important;'/>").get(0);
                jThis.replaceWith(container);

                var sendBtn = SHR4P.jQuery('<fb:send href="'+ targ +'" width="60" font=""></fb:send>').appendTo(container);

                if(typeof(window.FB) != "undefined" && FB.XFBML && FB.XFBML.parse) {
                    FB.XFBML.parse(sendBtn.get(0));
                }
            }

        });
    },

    renderFBLikeButtons : function () {
        SHR4P.jQuery('.shareaholic-fblike','.shareaholic-like-buttonset').each(function() {
            var jThis = SHR4P.jQuery(this);
            var targ = jThis.attr('data-shr_href');
            if(typeof(targ) == "undefined" || !targ) {
                targ = encodeURIComponent(document.location.href);
            }
            var layout = jThis.attr('data-shr_layout');
            if(typeof(layout) == "undefined" || !layout) {
                layout = "button_count";
            }

            var show_faces = jThis.attr('data-shr_showfaces');
            if(typeof(show_faces) == "undefined" || !show_faces) {
                show_faces = "true";
            }

            var send = jThis.attr('data-shr_send');
            if(typeof(send) == "undefined" || !send) {
                send = "false";
            }

            var action = jThis.attr('data-shr_action');
            if(typeof(action) == "undefined" || !action
                        || (action.toLowerCase() != 'recommend' && action.toLowerCase() != 'like')
                        ) {
                action = "like";
            }

            var container = SHR4P.jQuery("<div style='float:left;padding-top:0px !important; margin:0px 5px !important;'/>").get(0);
            jThis.replaceWith(container);
            if(SHR4P.fbUtil.hasFBNameSpace()) {
                var likeBtn = SHR4P.jQuery('<fb:like action="'+ action +'" send = "' + send + '" href="'+ targ +'"layout="'+layout+'" show_faces="'+ show_faces +'" width="60" font=""></fb:like>').appendTo(container);

                if(typeof(window.FB) != "undefined" && FB.XFBML && FB.XFBML.parse) {
                    FB.XFBML.parse(likeBtn.get(0));
                }
            } else {
                var heightFB = "30";
                var widthFB = "60";
                switch(layout) {
                    case "button_count":
                        widthFB = "90";
                        heightFB = "21";
                        break;
                    case "box_count":
                        widthFB = "60";
                        heightFB = "90";
                        break;
                    default:
                        widthFB = "60";
                        heightFB = "80";
                }

                  SHR4P.jQuery('<iframe src="http://www.facebook.com/plugins/like.php?app_id=207766518608&amp;'
                    + 'href='+ targ + '&amp;send=false&amp;layout=' + layout + '&amp;width=' + widthFB + '&amp;show_faces='+ show_faces
                    +'&amp;action='+ action + '&amp;colorscheme=light&amp;font&amp;height='+ heightFB +
                    '" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:' + widthFB + 'px; height:' + heightFB +
                    'px;" allowTransparency="true"></iframe>').appendTo(container);
            }
        });

    },

    addFBConnect: function () {
        SHR4P.fbUtil.addFBNameSpace();
        if(/*!SHR4P.fbUtil.hasFB() && */ !SHR4P.fbUtil.fbConnectAdd) { // this readding of FB script should be removed once fb fixes parse bug
            SHR4P.jQuery('<div id="fb-root"></div>').appendTo('body');
            window.fbAsyncInit = function() {
                FB.init({appId: '207766518608', status: true, cookie: true,
                xfbml: true});
                SHR4P.fbUtil.tryAddFBSubscription();
                // start rendering the fb widgets as FB APIs have been initialized
            };
            SHR4P.fbUtil.renderFBWidgetHandlerAttached = true;
            (function() {
                var e = document.createElement('script');e.async = true;
                e.src = document.location.protocol +
                        '//connect.facebook.net/en_US/all.js';
                e.onload = SHR4P.fbUtil.renderFBWidgets;
                e.onreadystatechange = function() {
                    if (this.readyState == 'complete' || this.readyState == 'loaded') {
                      SHR4P.fbUtil.renderFBWidgets();
                    }
                };

                document.getElementById('fb-root').appendChild(e);

            }());
            SHR4P.fbUtil.fbConnectAdd = 1;
        }/* else if(!SHR4P.fbUtil.fbConnectAdd) {
            SHR4P.fbUtil.tryAddFBSubscription();
            SHR4P.fbUtil.fbConnectAdd = 1;
            if(!SHR4P.fbUtil.renderFBWidgetHandlerAttached) {
                SHR4P.fbUtil.renderFBWidgets();
            }

        } */ // This code should be inserted back once fb fixes parse bug
    },

    tryAddFBSubscription : function () {
        if(SHR4P.fbUtil.hasFB() && FB.XFBML && FB.XFBML.parse) {
            SHR4P.fbUtil.addFBSubscription();
        } else {
             setTimeout(SHR4P.fbUtil.tryAddFBSubscription,500);
        }

    },

    addFBSubscription : function() {
		FB.Event.subscribe('edge.create', function(href, widget) {
				SHR4P.jQuery('<img/>').attr({
                    src : ("http://www.shareaholic.com/api/share/?v=1&apikey=172809fde4d12743cc4a1ec894142b97f&apitype=3&service=303&link=" + encodeURIComponent(href)),
                    width  : "1",
                    height : "1"
                }).appendTo("body");
            }
		);
        FB.Event.subscribe('message.send', function(href, widget) {
            SHR4P.jQuery('<img/>').attr({
                    src : ("http://www.shareaholic.com/api/share/?v=1&apikey=172809fde4d12743cc4a1ec894142b97f&apitype=3&service=305&link=" + encodeURIComponent(href)),
                    width  : "1",
                    height : "1"
                }).appendTo("body");
        });
    },


    addFBNameSpace : function () {
        var htmlRoot = SHR4P.jQuery(SHR4P.jQuery("html").get(0));
	    if(typeof(htmlRoot.attr("xmlns:fb")) == "undefined"
             && (!SHR4P.jQuery.browser.msie || SHR4P.jQuery.browser.version >= '9.0' )) {
            htmlRoot.attr("xmlns:fb",'http://www.facebook.com/2008/fbml');
            htmlRoot.attr("xmlns:og",'http://opengraphprotocol.org/schema/');
	    }
    },

    hasFBNameSpace : function () {
        var htmlRoot = SHR4P.jQuery(SHR4P.jQuery("html").get(0));
	    return (typeof(htmlRoot.attr("xmlns:fb")) != "undefined");
    }

};

//Code Reused from Sexybookmark script -- Ended

SHR4P.tooltips_prefix_map = {1:10,2:0,3:0,4:0,5:0,6:1,7:0,8:1,9:1,10:1,11:1,12:1,13:1,14:0,15:1,16:1,17:1,18:1,19:1,20:1,21:1,22:1,23:1,24:1,25:1,26:1,27:0,28:1,29:1,30:1,31:1,32:1,33:1,34:1,35:1,36:1,37:1,38:0,39:1,40:1,41:1,42:1,43:1,44:1,45:1,46:1,47:1,48:1,49:1,50:1,51:10,52:10,53:10,54:10,55:10,56:1,57:1,58:1,59:1,60:1,61:0,62:1,63:1,64:1,65:1,66:1,67:1,68:1,69:1,70:1,71:1,72:1,73:1,74:1,75:1,76:1,77:1,78:1,79:1,80:1,81:1,82:1,83:1,84:1,85:1,86:1,87:1,88:1,89:1,90:1,91:1,92:1,93:1,94:1,95:1,96:1,97:1,98:1,99:1,100:1,101:1,102:1,103:1,104:1,105:1,106:1,107:1,108:1,109:1,110:1,111:1,112:1,113:1,114:1,115:1,116:1,117:1,118:1,119:1,120:1,121:1,122:1,123:1,124:1,125:1,126:1,127:1,128:1,129:1,130:1,131:1,132:1,133:1,134:1,135:1,136:1,137:1,138:1,139:1,140:1,141:1,142:1,143:1,144:1,145:1,146:1,147:1,148:1,149:1,150:1,151:1,152:1,153:1,154:1,155:1,156:1,157:1,158:1,159:1,160:1,161:1,162:1,163:1,164:1,165:1,166:1,167:1,168:1,169:1,170:1,171:1,172:1,173:1,174:1,175:1,176:1,177:1,178:1,179:1,180:1,181:1,182:1,183:1,184:9,185:9,186:9,187:0,188:2,189:1,190:1,191:1,192:1,193:0,194:1,195:3,196:1,197:1,198:1,199:1,200:1,201:10,202:0,203:0,204:2,205:0,206:0,207:3,208:7,209:0,210:0,211:0,212:0,213:0,214:7,215:0,216:0,217:0,218:0,219:0,220:0,221:0,222:0,223:7,224:7,225:0,226:0,227:0,228:7,229:0,230:0,231:0,232:7,233:0,234:7,235:0,236:4,237:2,238:2,239:1,240:1,241:1,242:1,243:1,244:1,245:1,246:0,247:3,248:7,249:7,250:6,251:9,252:2,253:0,254:1,255:1,256:1,257:5,258:0,259:0,260:1,261:0,262:1,263:0,264:0,265:0,266:0,267:0,268:0,269:0,270:1,271:1,272:1,273:1,274:1,275:1,276:1,277:0,278:0,279:0,280:0,281:0,282:3,283:0,284:2,285:0,286:0,287:0,288:0,289:0,290:0,291:0,292:0,293:0,294:6,306:11,307:11};


SHR4P.tooltips_suffix = {
    1:'Buzzster!',
    2:'Delicious',
    3:'Digg',
    4:'Mixx',
    5:'Facebook',
    6:'Mister-Wong',
    7:'Twitter',
    8:'Netlog',
    9:'Pownce',
    10:'Technorati Favorites',
    11:'Furl',
    12:'Shoutwire',
    13:'CiteULike',
    14:'Jumptags',
    15:'Windows Live Spaces',
    16:'Hemidemi',
    17:'FunP',
    18:'Instapaper',
    19:'PhoneFavs',
    20:'Xerpi',
    21:'Netvouz',
    22:'Wink',
    23:'Ma.gnolia',
    24:'Diigo',
    25:'BibSonomy',
    26:'Taggly',
    27:'BlogMarks',
    28:'Tailrank',
    29:'StartAid',
    30:'Kledy',
    31:'Khabbr',
    32:'Yahoo My Web',
    33:'Meneame',
    34:'Yoolink',
    35:'Bookmarks.fr',
    36:'Technotizie',
    37:'Windows Live Favorites',
    38:'StumbleUpon',
    39:'MySpace',
    40:'Reddit',
    41:'NewsVine',
    42:'Multiply',
    43:'FriendFeed',
    44:'Plaxo Pulse',
    45:'Ping',
    46:'Squidoo',
    47:'Protopage Bookmarks',
    48:'Blinklist',
    49:'Faves',
    50:'AIM',
    51:'E-mail program',
    52:'Gmail',
    53:'Hotmail',
    54:'Yahoo Mail',
    55:'AOL Mail',
    56:'YiGG',
    57:'Webnews',
    58:'Segnalo',
    59:'Pusha',
    60:'YouMob',
    61:'Slashdot',
    62:'Fark',
    63:'Allvoices',
    64:'Jamespot',
    65:'Imera Brazil',
    66:'Twiddla',
    67:'LinkaGoGo',
    68:'MindBodyGreen',
    69:'Feedmarker Bookmarks',
    70:'unalog',
    71:'Hugg',
    72:'Diglog',
    73:'Yahoo Buzz',
    74:'Google Bookmarks',
    75:'NowPublic',
    76:'Yahoo Bookmarks',
    77:'Propeller',
    78:'Tumblr',
    79:'LiveJournal',
    80:'Current',
    81:'HelloTxt',
    82:'Spurl',
    83:'Yample',
    84:'Oneview',
    85:'Linkatopia',
    86:'Simpy',
    87:'Yahoo Messenger',
    88:'LinkedIn',
    89:'Global Grind',
    90:'BuddyMarks',
    91:'Ask.com MyStuff',
    92:'Viadeo',
    93:'Maple',
    94:'Wists',
    95:'Gravee',
    96:'Connotea',
    97:'Backflip',
    98:'MyLinkVault',
    99:'SiteJot',
    100:'Sphinn',
    101:'Health Ranker',
    102:'DZone',
    103:'Symbaloo Feeds',
    104:'Care2 News',
    105:'Hyves',
    106:'Design Float',
    107:'Sphere',
    108:'Bitty Browser',
    109:'My Yahoo',
    110:'Google',
    111:'Excite MIX',
    112:'iTunes',
    113:'Zune',
    114:'FeedM8',
    115:'PodNova',
    116:'WINKsite',
    117:'NewsGator',
    118:'Hubdog',
    119:'BUZmob',
    120:'NewsIsFree',
    121:'KlipFolio',
    122:'NETime Channel',
    123:'Feed Mailer',
    124:'Symbaloo Bookmarks',
    125:'Rocket RSS Reader',
    126:'Blogger',
    127:'Flurry',
    128:'FireAnt',
    129:'Sofomo',
    130:'Netomat HUB',
    131:'FeedMarker',
    132:'FeedBucket',
    133:'SendMeRSS',
    134:'Bloglines',
    135:'Windows Live',
    136:'Protopage News Feeds',
    137:'My AOL',
    138:'The Free Library',
    139:'The Free Dictionary',
    140:'Wikio',
    141:'BlogRovR',
    142:'Webwag',
    143:'Daily Rotation',
    144:'Outlook',
    145:'Google Toolbar',
    146:'Bitty Browser Preview',
    147:'RSS 2 PDF',
    148:'LiteFeeds',
    149:'Gritwire',
    150:'FeedLounge',
    151:'FeedReader',
    152:'FeedOnSite',
    153:'i metaRSS',
    154:'RssFwd',
    155:'SimplyHeadlines',
    156:'Zhua Xia',
    157:'Xian Guo',
    158:'mobilerss',
    159:'Netvibes',
    160:'Pageflakes',
    161:'My MSN',
    162:'Odeo',
    163:'AideRSS',
    164:'Fwicki',
    165:'RapidFeeds',
    166:'Miro',
    167:'Shyftr',
    168:'ZapTXT',
    169:'Newgie',
    170:'NewsAlloy',
    171:'Plusmo',
    172:'Yourminis',
    173:'Eskobo',
    174:'Alesti',
    175:'Rasasa',
    176:'AvantGo',
    177:'FeedShow',
    178:'Xanga',
    179:'MySpace Profile',
    180:'Friendster',
    181:'Hi5',
    182:'FeedBlitz',
    183:'Gabbr',
    184:'MSDN',
    185:'Microsoft TechNet',
    186:'Microsoft Expression',
    187:'Tagza',
    188:'Tipd',
    189:'Agregator',
    190:'Strands',
    191:'Evernote',
    192:'Stumpedia',
    193:'Foxiewire',
    194:'Arto',
    195:'Netvibes',
    196:'Bebo',
    197:'Folkd',
    198:'VodPod',
    199:'NewsTrust',
    200:'Amazon (US) Wish List',
    201:'E-mail program',
    202:'YC Hacker News',
    203:'Truemors',
    204:'Techmeme Tip',
    205:'Identi.ca',
    206:'SmakNews',
    207:'Google Reader',
    208:'Bit.ly',
    209:'Kaboodle',
    210:'Posterous',
    211:'TipJoy',
    212:'I Heart It',
    213:'Google Notebook',
    214:'Tr.im',
    215:'Streakr',
    216:'Twine',
    217:'Soup',
    218:'Plurk',
    219:'Blogger',
    220:'TypePad',
    221:'AttentionMeter',
    222:'Smush.it',
    223:'TinyURL',
    224:'Digg',
    225:'BzzScapes',
    226:'Tweetie',
    227:'Diigo',
    228:'Is.gd',
    229:'vi.sualize.us',
    230:'WordPress Blog',
    231:'Mozillaca',
    232:'Su.pr',
    233:'TBUZZ',
    234:'Hub.tm',
    235:'Followup.cc',
    236:'PrintFriendly',
    237:'DailyMe',
    238:'NUjij',
    239:'Read It Later',
    240:'Box.net',
    241:'Balatarin',
    242:'Favoriten',
    243:'Oknotizie',
    244:'diHITT',
    245:'Svejo',
    246:'Hatena',
    247:'Orkut',
    248:'Clicky',
    249:'j.mp',
    250:'ReadWriteWeb',
    251:'Dwellicious',
    252:'Google Translate',
    253:'Yammer',
    254:'Yahoo Buzz India',
    255:'Boxee',
    256:'Pinboard',
    257:'Google Buzz',
    258:'Readability',
    259:'Social.com',
    260:'Google Apps Email',
    261:'HootSuite',
    262:'Google Wave',
    263:'iZeby',
    264:'Ning',
    265:'SpringPad',
    266:'BobrDobr',
    267:'Yandex',
    268:'Moemesto',
    269:'Memori.ru',
    270:'Amazon (UK) Wish List',
    271:'Amazon (CA) Wish List',
    272:'Amazon (DE) Wish List',
    273:'Amazon (FR) Wish List',
    274:'Amazon (JP) Wish List',
    275:'Google Sidewiki',
    276:'Marginize',
    277:'Twittley',
    278:'Script & Style',
    279:'PFBuzz',
    280:'Fwisp',
    281:'100 bookmarks',
    282:'Design Bump',
    283:'eKudos',
    284:'Web Blend',
    285:'Wykop',
    286:'BlogEngage',
    287:'FAQpal',
    288:'Bitacoras',
    289:'N4G',
    290:'Kaevur',
    291:'Virb',
    292:'BonzoBox',
    293:'Zabox',
    294:'ToMuse',
    306: 'More',
    307: 'All'
};

//
//tooltip prefix mapping
//iso codes: http://www.w3schools.com/tags/ref_language_codes.asp
SHR4P.locales = {
    en:{
        0:"Post to", // english (default)
        1:"Add to",
        2:"Submit to",
        3:"Share on",
        4:"Print with",
        5:"Post on",
        6:"Suggest this article to",
        7:"Shorten URL with",
        8:"Push this on",
        9:"Bookmark on",
        10:"Send via",
        11:""
    },
    es:{
        0:"Publicarlo a", // spanish
        1:"Añadirlo a",
        2:"Enviar a",
        3:"Compartir con",
        4:"Imprimir con",
        5:"Publicarlo en",
        6:"Sugiere este artículo a",
        7:"Acortar URL con",
        8:"Pulse este en",
        9:"Agregar a marcador en",
        10:"Enviar via",
        11:""
    },
    fr:{
        0:"Publiez-le sur", // french
        1:"Ajoutez ce lien à",
        2:"Soumettez ce lien à",
        3:"Partagez-le sur",
        4:"Imprimez-le avec",
        5:"Publiez-le sur",
        6:"Suggérer cet article à",
        7:"Raccourcir l'URL avec",
        8:"Poussez cet article sur",
        9:"Ajoutez-le à vos favoris sur",
        10:"Envoyez-le avec",
        11:""
    },
    de:{
        0:"Senden an", // german
        1:"Hinzufügen zu",
        2:"Übertragen zu",
        3:"Teilen bei",
        4:"Drucken mit",
        5:"Veröffentlichen bei",
        6:"Empfehlen bei",
        7:"URL kürzen mit",
        8:"Schiebe dies auf",
        9:"Lesezeichen speichern auf",
        10:"Senden mit",
        11:""
    },
    tr:{
        0:"Bunu postala:", // turkish
        1:"Bunu ekle:",
        2:"Bu makaleyi paylaş:",
        3:"Bunu paylaş:",
        4:"Baskı ile",
        5:"Bunu postala:",
        6:"Bu makaleyi öner:",
        7:"Kısaltmak Url ile",
        8:"Bunu paylaş:",
        9:"Bookmark on",
        10:"Send via",
        11:""
    },
    it:{
        0:"Pubblicalo su", // italian
        1:"Aggiungilo a",
        2:"Invia questa storia a",
        3:"Condividi su",
        4:"Stampa con",
        5:"Pubblicalo su",
        6:"Suggerisci questo articolo a",
        7:"Accorciare URL con",
        8:"Sparalo in",
        9:"Bookmark on",
        10:"Send via",
        11:""
    },
    pt:{
        0:"Publicar no", // portuguese
        1:"Adicionar ao",
        2:"Enviar história para o",
        3:"Compartilhar no",
        4:"Imprima com",
        5:"Publicar no",
        6:"Sugerir este artigo para",
        7:"Encurtar url com",
        8:"Publicar no",
        9:"Bookmark on",
        10:"Send via",
        11:""
    },
    et:{
        0:"Postita", // estonian
        1:"Lisa",
        2:"Saada",
        3:"Jaga",
        4:"Prindi",
        5:"Postita",
        6:"Soovita seda artiklit",
        7:"Lühenda URL",
        8:"Sparalo in",
        9:"Bookmark on",
        10:"Send via",
        11:""
    },
    hu:{
        0:"Elküldés:", // hungarian
        1:"Hozzáadás:",
        2:"Továbbküldés:",
        3:"Megosztás:",
        4:"Nyomtatás:",
        5:"Publikálás:",
        6:"Ajánlás valakinek:",
        7:"Cím (URL) rövidítése:",
        8:"Kiküldés:",
        9:"Könyvjelző felvétele:",
        10:"Küldés:",
        11:""
    },
    bg:{
        0:"Публикувай в", // bulgarian
        1:"Прибави към",
        2:"Представи към",
        3:"Сподели по",
        4:"Принтирай с",
        5:"Публикувай на",
        6:"Предложи тази статия на",
        7:"Съкратен URL с",
        8:"Бутни това към",
        9:"Отбележи в",
        10:"Изпрати чрез",
        11:""
    },
    el:{
        0:"Αναρτήστε στο", // greek
        1:"Προσθέστε στο",
        2:"Υποβάλλετε στο",
        3:"Μοιραστείτε στο",
        4:"Εκτυπώστε με",
        5:"Αναρτήστε στο",
        6:"Προτείνετε αυτό το άρθρο σε",
        7:"Συντομεύστε το URL με",
        8:"Προωθήστε στο",
        9:"Προσθέστε σελιδοδείκτη στο",
        10:"Αποστείλετε μέσω",
        11:""
    },
    lt:{
        0:"Paskelbti", // lithuanian
        1:"Pridėti į",
        2:"Pateikti",
        3:"Dalintis",
        4:"Spausdinti per",
        5:"Įrašyti",
        6:"Pasiūlyti šį straipsnį į",
        7:"Trumpinti URL su",
        8:"Kilstelėti",
        9:"Pasižymėti per",
        10:"Siųsti per",
        11:""
    },
    nl:{
        0:"Publiceer op",  // dutch
        1:"Voeg toe aan",
        2:"Stuur in op",
        3:"Deel op",
        4:"Print met",
        5:"Publiceer op",
        6:"Suggereer dit artikel op",
        7:"Verkort de URL met",
        8:"Push dit op",
        9:"Maak een bladwijzer op",
        10:"Verzend met",
        11:""
    }
};

SHR4P.load();
