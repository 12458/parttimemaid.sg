var rzyMetaTag = document.createElement('meta');rzyMetaTag.name = 'viewport';rzyMetaTag.content = 'width=device-width, initial-scale=1';    document.getElementsByTagName('head')[0].appendChild(rzyMetaTag);var rzyIframe=document.getElementById('rzy-embed');var rzyEmbedURL=document.getElementById('rzy-embed').getAttribute('data-url');var rzyEmbedURLparm = '?if=y';if(rzyEmbedURL.indexOf('?')>=0){	if(rzyEmbedURL.indexOf('if=y')==0){		var rzyEmbedURLparm = '&if=y';	}else{		var rzyEmbedURLparm = '';	}}rzyIframe.innerHTML = "<iframe id='rzy_iframe_object' src='"+rzyEmbedURL+rzyEmbedURLparm+"' frameborder='0' allowfullscreen='' width='100%' style='overflow:hidden;width: 100%;' onload='resizeCrossDomainIframe();' onscroll='resizeCrossDomainIframe();'></iframe>";//setInterval(rzyResize, 1000);function rzyResize() {	if(document.getElementById('rzy_iframe_object').contentWindow.document.body !== null){		document.getElementById('rzy_iframe_object').style.height = (document.getElementById('rzy_iframe_object').contentWindow.document.body.offsetHeight + 100) + 'px';	}}function resizeCrossDomainIframe(other_domain) {    var iframe = document.getElementById('rzy_iframe_object');	var other_domain = document.getElementById('rzy_iframe_object').getAttribute('src');    window.addEventListener('message', function(event) {			   if (other_domain.indexOf(event.origin)=='-1') return;		       if (isNaN(event.data)) return;       var height = parseInt(event.data) + 50;       iframe.height = height + "px";    }, false);}