var csslink = document.createElement('link');
var script_tags = document.getElementsByTagName('script');
var curscriptsrc=script_tags[script_tags.length-1].src;
csslink.setAttribute('rel', 'stylesheet');
csslink.setAttribute('type', 'text/css');
csslink.setAttribute('href', curscriptsrc.replace('/loader.js', '/style.css'));
document.getElementsByTagName("head")[0].appendChild(csslink);