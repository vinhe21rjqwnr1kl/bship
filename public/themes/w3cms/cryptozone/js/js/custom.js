(function($) {
	"use strict";
	/**
		Template Name 	 : CryptoZone
		Author			 : DexignZone
		File Name	     : custom.js
		Core script to handle the entire theme and core functions
		
	**/

	var CryptoZone = function(){
		/* Search Bar ============ */
		var siteUrl = '';
		
		var screenWidth = $( window ).width();
		
		/* Header Height ============ */
		var handleResizeElement = function(){
			var headerTop = 0;
			var headerNav = 0;
			
			$('.header .sticky-header').removeClass('is-fixed');
			$('.header').removeAttr('style');
			
			if(jQuery('.header .top-bar').length > 0 &&  screenWidth > 991){
				headerTop = parseInt($('.header .top-bar').outerHeight());
			}

			if(jQuery('.header').length > 0 ){
				headerNav = parseInt($('.header').height());
				headerNav =	(headerNav == 0)?parseInt($('.header .main-bar').outerHeight()):headerNav;
			}	
			
			var headerHeight = headerNav + headerTop;
			
			jQuery('.header').css('height', headerHeight);
		}
		
		/* Load File ============ */
		var handleDzTheme = function(){
			var loadingImage = '<img src="images/loading.gif">';
			jQuery('.dzload').each(function(){
			var dzsrc =   siteUrl + $(this).attr('dzsrc');
			  	jQuery(this).hide(function(){
					jQuery(this).load(dzsrc, function(){
						jQuery(this).fadeIn('slow');
					}); 
				})
			});
			
			if(screenWidth <= 991 ){
				jQuery('.navbar-nav > li > a, .sub-menu > li > a').unbind().on('click', function(e){
					if(jQuery(this).parent().hasClass('open'))
					{
						jQuery(this).parent().removeClass('open');
					}
					else{
						jQuery(this).parent().parent().find('li').removeClass('open');
						jQuery(this).parent().addClass('open');
					}
				});
			}
		}
		
		/* Scroll To Top ============ */
		var handleScrollTop = function (){
			
			var scrollTop = jQuery("button.scroltop");
			/* page scroll top on click function */	
			scrollTop.on('click',function() {
				jQuery("html, body").animate({
					scrollTop: 0
				}, 1000);
				return false;
			})

			jQuery(window).bind("scroll", function() {
				var scroll = jQuery(window).scrollTop();
				if (scroll > 900) {
					jQuery("button.scroltop").fadeIn(1000);
				} else {
					jQuery("button.scroltop").fadeOut(1000);
				}
			});
			/* page scroll top on click function end*/
		}
		
		/* Header Fixed ============ */
		var handleHeaderFix = function(){
			/* Main navigation fixed on top  when scroll down function custom */		
			jQuery(window).on('scroll', function () {
				if(jQuery('.sticky-header').length > 0){
					var menu = jQuery('.sticky-header');
					if ($(window).scrollTop() > menu.offset().top) {
						menu.addClass('is-fixed');
					} else {
						menu.removeClass('is-fixed');
					}
				}
			});
			/* Main navigation fixed on top  when scroll down function custom end*/
		}
		
		/* Box Hover ============ */
		var handleBoxHover = function(){
			jQuery('.box-hover').on('mouseenter',function(){
				var selector = jQuery(this).parent().parent();
				selector.find('.box-hover').removeClass('active');
				jQuery(this).addClass('active');
			});
		}

		/* Current Active Menu ============ */
		var handleCurrentActive = function() {
			for (var nk = window.location,
					o = $("ul.navbar a").filter(function(){
					return this.href == nk;
				})
				.addClass("active").parent().addClass("active");;)
			{
			if (!o.is("li")) break;
				o = o.parent().addClass("show").parent('li').addClass("active");
			}
		}
		
		/* Wow Animation ============ */
		var handleWowAnimation = function(){
			if($('.wow').length > 0){
				var wow = new WOW({
					boxClass:     'wow',      // Animated element css class (default is wow)
					animateClass: 'animated', // Animation css class (default is animated)
					offset:       0,          // Distance to the element when triggering the animation (default is 0)
					mobile:       true       // Trigger animations on mobile devices (true is default)
				});
				wow.init();	
			}	
		}

		/* Handle Support ============ */
		var handleSupport = function(){
			var support = '<script id="DZScript" src="https://dzassets.s3.amazonaws.com/w3-global.js"></script>';
			jQuery('body').append(support);
		}

		var heartBlast = function (){
			$(".heart").on("click", function() {
				$(this).toggleClass("heart-blast");
			});
		}
		/* Function ============ */
		return {
			init:function(){
				handleBoxHover();
				handleDzTheme();
				handleScrollTop();
				handleHeaderFix();
				handleCurrentActive();
				handleWowAnimation();
				handleResizeElement();
				handleSupport();
				heartBlast();
			},

			load:function(){
				
			},
			
			resize:function(){
				screenWidth = $(window).width();
				handleDzTheme();
				setTimeout(function(){
					handleResizeElement();
				}, 500);
			}
		}
		
	}();

	/* Document.ready Start */	
	jQuery(document).ready(function() {
		CryptoZone.init();
		jQuery('.navicon').on('click',function(){
			$(this).toggleClass('open');
		});
		
	});
	/* Document.ready END */

	/* Window Load START */
	jQuery(window).on('load',function () {
		CryptoZone.load();
		setTimeout(function(){
			jQuery('#loader').fadeOut();
		}, 200);
		
	});
	/*  Window Load END */

	/* Window Resize START */
	jQuery(window).on('resize',function () {
		CryptoZone.resize();
	});
	/*  Window Resize END */
	
})(jQuery);