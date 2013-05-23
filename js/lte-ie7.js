/* Load this script using conditional IE comments if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-tick' : '&#x61;',
			'icon-twitter' : '&#x37;',
			'icon-stars' : '&#x39;',
			'icon-shopping-bag' : '&#x30;',
			'icon-ribbon-bear' : '&#x71;',
			'icon-pinterest' : '&#x34;',
			'icon-phone' : '&#x35;',
			'icon-person' : '&#x36;',
			'icon-open-quote' : '&#x77;',
			'icon-info' : '&#x65;',
			'icon-google-plus' : '&#x72;',
			'icon-facebook' : '&#x74;',
			'icon-expand' : '&#x79;',
			'icon-camera' : '&#x75;',
			'icon-arrow-up-sml' : '&#x69;',
			'icon-arrow-right-sml' : '&#x6f;',
			'icon-arrow-left-sml' : '&#x31;',
			'icon-arrow-down-sml' : '&#x32;',
			'icon-alert' : '&#x33;',
			'icon-untitled' : '&#x70;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
};