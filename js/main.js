;(function($) {

	window.main = {
		vars: {},
		init: function(){

			var header = main.vars.header = $('#header'),
				mainNavigation = header.mainNavigation = $('.main-navigation', header);

			if($.fn.scroller){
				$('.scroller').each(function(){
					var scroller = $(this);
					var options = {};

					if(scroller.hasClass('gallery-scroller') || scroller.data('scroll-all') === true) options.scrollAll = true;
					if(scroller.data('auto-scroll') === true ) options.autoScroll = true;
					if(scroller.data('resize') === true ) options.resize = true;
					if(scroller.data('callback')) {
						scroller.bind('onChange', function(e, nextItem){
							var func = window[scroller.data('callback')];
							func($(this), nextItem);
						});
					}

					scroller.scroller(options);
				});
			}

			$('a[href^=#].scroll-to-btn').on('click', function(){
				var target = $($(this).attr('href'));
				var offsetTop = (target.length != 0) ? target.offset().top : 0;
				//$('body, html').animate({scrollTop: offsetTop}, 500, 'easeInOutQuad');
				return false;
			});

			$('.share-popup-btn').on('click', function(){
				var url = $(this).attr('href');
				var width = 640;
				var height = 305;
				var left = ($(window).width() - width) / 2;
				var top = ($(window).height() - height) / 2;
				window.open(url, 'sharer', 'toolbar=0,status=0,width='+width+',height='+height+',left='+left+', top='+top);
				return false;
			});

			$('.print-btn').on('click', function(e){
				console.log('hello');
				e.preventDefault();
				window.print();
			});

			this.lightbox.init();
			this.ajaxPage.init();

		
			$('.mobile-navigation-btn', header).on('click', function(){
				$('.main-navigation', header).slideToggle(200);
			});

			var countrySelectorForm = $('.country-selector-form');
			$('select.country', countrySelectorForm).on('change', function(){
				countrySelectorForm.submit();
			});

			$('select.currency').on('change', function(){
				var currencyCode = $('option:selected', $(this)).data('currencycode');
				$('ul.currency_switcher li a[data-currencycode='+currencyCode+']').trigger('click');
			}).trigger('click');

			$('body').bind('currency_converter_switch', function(){
				setTimeout(function(){
					currencyCode = $('ul.currency_switcher li a.active').data('currencycode');
					$('select.currency').val(currencyCode);
				}, 100);
			}).trigger('currency_converter_switch');

			if($.fn.fancybox){
				$('.fancybox-btn').fancybox();
			}

			if($.fn.threeSixty){
				var threeSixty = $('.threesixty');
				threeSixty.threeSixty();
				$('.spin-btn').on('click', function(){
					console.log(threeSixty);
					threeSixty.threeSixty('spin');
				});

			}

			var productScroller = $('.product .scroller'),
				variationForm = $('form.variations_form');
			
			if(productScroller.length != 0){
				productScroller.bind('onChange', function(e, nextItem){
					if(nextItem){
						if(nextItem.data('id') == 360){
							var threeSixty = $('.threesixty:visible', nextItem),
								items = $('li', threeSixty);

							items.each(function(i){
								var item = $(this);
								var image = $('img', item);
								image.attr('src', image.data('src'));
							});
						}

						if(variationForm.length > 0){
							var variations = variationForm.data( 'product_variations' );
							for(i in variations){
								var variation = variations[i];
								if(variation.variation_id == nextItem.data('id')){
									for(key in variation.attributes){
										var attribute = variation.attributes[key];
										$('.variations select[name='+key+']', variationForm).val(attribute);

										var currVariation360 = $('.variation-360[data-variation-id='+variation.variation_id+']');
										if(currVariation360.length > 0){
											setTimeout(function(){
												$('.variation-360').removeClass('current');
												currVariation360.addClass('current');
											}, 500);
										}
									}
								}
							}
						}
					}
				}).trigger('onChange', null);
			}


			
			if(variationForm.length > 0){
				$('form.variations_form').on('found_variation', function(e, variation){
					var currVariation360 = $('.variation-360[data-variation-id='+variation.variation_id+']');
					if(currVariation360.length > 0){
						setTimeout(function(){
							$('.variation-360').removeClass('current');
							currVariation360.addClass('current');
						}, 500);
					}
				});
			}


			$(window).resize(this.resize);
			this.resize();



			this.photos.init();
			this.tabs.init();

			$('.checkout-button').on('click', function(){
				var form = $('.cart-form');
				$('.proceed').val(1);
				form.submit();
			})
		},

		loaded: function(){
			$('body').addClass('loaded');
			this.equalHeight();
		},

		lightbox: {
			init: function(){

			}
		},

		ajaxPage: {
			init: function(){
				main.ajaxPage.container = $('#ajax-page');
				$('.ajax-btn').on('click', function(e){
					e.preventDefault();
					main.ajaxPage.load($(this).attr('href'));
				});
			},
			load: function(url){

				var container = main.ajaxPage.container,
					regex = new RegExp('(\\?|\\&)ajax=.*?(?=(&|$))'),
		        	qstring = /\?.+$/;

			    if (regex.test(url)){
			        ajaxUrl = url.replace(regex, '$1ajax=true');
			    } else if (qstring.test(url)) {
			        ajaxUrl = url + '&ajax=true';
			    } else {
			        ajaxUrl =  url + '?ajax=true';
			    }
			    history.pushState(null, null, url);
			    $('html, body').animate({scrollTop: container.offset().top - 200}, 800, 'easeInOutQuad');
			    if($('.content', container).length == 0){

					loader = $('<div class="loader"></div>').hide();
					container.append(loader);
					
					container.delay(200).animate({height: loader.actual('outerHeight')}, function(){
						loader.fadeIn();

						$.get(ajaxUrl, function(data) {
							var content = $('<div class="content"></div>').hide();

							container.append(content);
							content.html(data);
							loader.fadeOut(function(){
								if($.fn.imagesLoaded){
									content.imagesLoaded(function(){
										main.resize();
										container.animate({'height': content.height()}, function(){
											container.css({'height': 'auto'});
											content.fadeIn();
										});
									});
								} else {
									container.animate({'height': content.actual('height')}, function(){
										container.css({'height': 'auto'});
										content.fadeIn();
										main.resize();
									});
								}
								
							});
						});
					});
				} else {
					var content = $('.content', container),
						loader = $('.loader', container);
					content.fadeOut(function(){
						loader.fadeIn();
						
						$.get(ajaxUrl, function(data) {
							content.html(data);
							loader.fadeOut(function(){
								if($.fn.imagesLoaded){
									content.imagesLoaded(function(){
										main.resize();
										container.animate({'height': content.height()}, function(){
											container.css({'height': 'auto'});
											content.fadeIn();
										});
									});
								} else {
									container.animate({'height': content.actual('height')}, function(){
										container.css({'height': 'auto'});
										content.fadeIn();
										main.resize();
									});
								}
								
							});
						});
					});
				}
			}
		},

		equalHeight: function(){
			if($('.equal-height').length !== 0){
		
				var currTallest = 0,
				currRowStart = 0,
				rowDivs = new Array(),
				topPos = 0;

				$('.equal-height').each(function() {

					var element = $(this);
					topPos = element.position().top;
					if (currRowStart != topPos) {

						for (i = 0 ; i < rowDivs.length ; i++) {
							rowDivs[i].height(currTallest);
						}

						rowDivs.length = 0;
						currRowStart = topPos;
						currTallest = element.height();
						rowDivs.push(element);

					} else {
						rowDivs.push(element);
						currTallest = (currTallest < element.height()) ? (element.height()) : (currTallest);
					}

					for (i = 0 ; i < rowDivs.length ; i++) {
						rowDivs[i].height(currTallest);
					}

				});
			}
		},

		resize: function(){
			// var scroller = $('.scroller');
			var windowWidth = $(window).width(),
				mainNavigation = main.vars.header.mainNavigation;
			// if(scroller.length){
				
			// 	var scrollerWidth = scroller.width(),
			// 		scrollItemWidth = Math.round(scrollerWidth - ((scrollerWidth * 0.12) * 2)),
			// 		marginLeft = Math.round(scrollItemWidth  -  (scrollerWidth * 0.12));
			// 		scrollItems = $('.scroll-item', scroller);

			// 	var	scrollerHeight = scroller.height();
			// 	$('.scroll-items-container', scroller).css({'margin-left': -marginLeft});
			// 	scrollItems.width(scrollItemWidth);
			// 	//scroller.height(setScrollItemsHeight);
			// }

			if(windowWidth <= 600 && mainNavigation.is(':visible')){
				mainNavigation.hide();
			} else if(windowWidth > 600 && !mainNavigation.is(':visible')) {
				mainNavigation.show();
			}
		},

		photos: {
			init: function(){
				var container = main.photos.container = $('#photos'),
					scroller = main.photos.scroller = $('.photo-list-container', container),
					currXPos = main.photos.currXPos = 0,
					itemWidth = main.photos.itemWidth = ($('.item:eq(0)', scroller).outerWidth(true) + 3) * 2;
				
				scroller.on('scroll', function(e){
					main.photos.currXPos = scroller.scrollLeft();
				});

				$('.photos-navigation a', container).on('click', function(){
					main.photos.scroll($(this).data('direction'));
				});
			},
			scroll: function(direction){
				var	scroller = main.photos.scroller,
					currXPos = main.photos.currXPos,
					newXPos	 = currXPos;
					itemWidth = main.photos.itemWidth;

				switch(direction){
					case 'left':
						newXPos -= itemWidth;
						break
					case 'right':

						newXPos += itemWidth;
						break;
				}
				scroller.animate({scrollLeft: newXPos});
				main.photos.currXPos = newXPos;
			}
		},

		tabs: {
			init: function() {
				var container = main.tabs.container = $('.tabs'),
					content = main.tabs.content = $('.tab-content', container),
					navigationItems = main.tabs.navigationItems = $('.tab-navigation li', container);

				$('a', navigationItems).on('click', function(){
					main.tabs.goto($(this).data('id'));
				});
			},
			goto: function(id){
				var navigationItems = main.tabs.navigationItems,
					content = main.tabs.content;
				navigationItems.removeClass('current');
				$('a[data-id='+id+']').parent().addClass('current');

				$('.tab', content).hide();
				$('.tab[data-id='+id+']', content).fadeIn();


			}
		}
	}

	$(function(){
		main.init();
	});

	$(window).load(function(){
		main.loaded();
	});
})(jQuery);