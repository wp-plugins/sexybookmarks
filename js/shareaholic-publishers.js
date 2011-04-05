(function() {
  SHR4P.src = SHRSB_Globals['src'];

    var head = document.getElementsByTagName('head')[0];
    if (typeof(head) != 'undefined') {
      var script = document.createElement('script');
      script.src = SHRSB_Globals['src']+'/jquery.shareaholic-publishers-sb.min.js';
      script.type = "text/javascript";
      head.appendChild(script);
  }
})();
// vim: ts=2 sw=2

