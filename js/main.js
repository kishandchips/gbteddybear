;(function($) {

	window.main = {
		init: function(){
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

			$('a[href^=#].scroll-to-btn').click(function(){
				var target = $($(this).attr('href'));
				var offsetTop = (target.length != 0) ? target.offset().top : 0;
				//$('body, html').animate({scrollTop: offsetTop}, 500, 'easeInOutQuad');
				return false;
			});

			$('.overlay-btn').hover(function(){
				$('.overlay', this).fadeIn();
			}, function(){
				$('.overlay', this).fadeOut();
			});
			
			
			$('.fade-btn').hover(function(){
				$(this).fadeTo(200, 0.6);
			}, function(){
				$(this).fadeTo(200, 1);
			});


			$('.share-popup-btn').click(function(){
				var url = $(this).attr('href');
				var width = 640;
				var height = 305;
				var left = ($(window).width() - width) / 2;
				var top = ($(window).height() - height) / 2;
				window.open(url, 'sharer', 'toolbar=0,status=0,width='+width+',height='+height+',left='+left+', top='+top);
				return false;
			});

			this.lightbox.init();
			this.ajaxPage.init();

			var header = $('#header');
			$('#search-form input[name=s]', header).focus(function(){
				header.addClass('search-focused');
			});

			$('#search-form input[name=s]', header).blur(function(){
				header.removeClass('search-focused');
			});

			$('.mobile-navigation-btn', header).on('click', function(){
				$('.main-navigation', header).slideToggle(200);
			});

			var launchDate = new Date(2013, 10, 31); 
			
			$('#countdown').countdown({until: launchDate, 
				labels: ['Years', 'Months', 'Weeks', 'Days', 'Hrs', 'Mins', 'Secs'],
				labels1: ['Year', 'Month', 'Week', 'Day', 'Hr', 'Min', 'Sec']
			});

			$(window).resize(this.resize);
			this.resize();

			var memorabiliaForm = $('#memorabilia-form');
			if(memorabiliaForm.length > 0){
				$('.gf_page_steps .gf_step', memorabiliaForm).each(function(){
					var step = $(this),
						pageId = step.attr('id').replace('gf_step_', '');

					$('.gform_body #gform_page_' + pageId, memorabiliaForm).before(step);
				});
			}
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
			// var windowWidth = $(window).width();
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
		}
	}

	$(function(){
		main.init();
	});

	$(window).load(function(){
		main.loaded();
	});
})(jQuery);