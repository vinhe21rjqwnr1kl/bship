(function($) {
	"use strict";
	/**
		Template Name 	 : BodyShape
		Author			 : DexignZone
		Version			 : 1.0
		File Name	     : custom.js
		Author Portfolio : https://themeforest.net/user/dexignzone/portfolio
		
		Core script to handle the entire theme and core functions
		
	**/

	var BodyShape = function(){
		/* Search Bar ============ */
		var siteUrl = '';
		
		var screenWidth = $( window ).width();
		
		/* Home Search ============ */
		var handleHomeSearch = function() {
			/* top search in header on click function */
			var quikSearch = jQuery("#quik-search-btn");
			var quikSearchRemove = jQuery("#quik-search-remove");
			
			quikSearch.on('click',function() {
				jQuery('.dz-quik-search').fadeIn(500);
				jQuery('.dz-quik-search').addClass('On');
			});
			
			quikSearchRemove.on('click',function() {
				jQuery('.dz-quik-search').fadeOut(500);
				jQuery('.dz-quik-search').removeClass('On');
			});	
			/* top search in header on click function End*/
		}
		
		/* Header Height ============ */
		var handleResizeElement = function(){
			var headerTop = 0;
			var headerNav = 0;
			
			$('.header .sticky-header').removeClass('is-fixed');
			$('.header').removeAttr('style');
			
			if(jQuery('.header .top-bar').length > 0 &&  screenWidth > 991)
			{
				headerTop = parseInt($('.header .top-bar').outerHeight());
			}

			if(jQuery('.header').length > 0 )
			{
				headerNav = parseInt($('.header').height());
				headerNav =	(headerNav == 0)?parseInt($('.header .main-bar').outerHeight()):headerNav;
			}	
			
			var headerHeight = headerNav + headerTop;
			
			jQuery('.header').css('height', headerHeight);
		}
		
		/* Resize Element On Resize ============ */
		var handleResizeElementOnResize = function(){
			var headerTop = 0;
			var headerNav = 0;
			
			$('.header .sticky-header').removeClass('is-fixed');
			$('.header').removeAttr('style');
			
			
			setTimeout(function(){
				
				if(jQuery('.header .top-bar').length > 0 &&  screenWidth > 991)
				{
					headerTop = parseInt($('.header .top-bar').outerHeight());
				}

				if(jQuery('.header').length > 0 )
				{
					headerNav = parseInt($('.header').height());
					headerNav =	(headerNav == 0)?parseInt($('.header .main-bar').outerHeight()):headerNav;
				}	
				
				var headerHeight = headerNav + headerTop;
				
				jQuery('.header').css('height', headerHeight);
			
			}, 500);
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
			
			jQuery('.sidenav-nav .navbar-nav > li > a').next('.sub-menu,.mega-menu').slideUp();
			jQuery('.sidenav-nav .sub-menu > li > a').next('.sub-menu').slideUp();
			
			jQuery('.sidenav-nav .navbar-nav > li > a, .sidenav-nav .sub-menu > li > a').unbind().on('click', function(e){
				if(jQuery(this).hasClass('dz-open')){
					jQuery(this).removeClass('dz-open');
					jQuery(this).parent('li').children('.sub-menu,.mega-menu').slideUp();
				}else{
					jQuery(this).addClass('dz-open');
					
					if(jQuery(this).parent('li').children('.sub-menu,.mega-menu').length > 0){
						
						e.preventDefault();
						jQuery(this).next('.sub-menu,.mega-menu').slideDown();
						jQuery(this).parent('li').siblings('li').find('a').removeClass('dz-open');
						jQuery(this).parent('li').siblings('li').children('.sub-menu,.mega-menu').slideUp();
					}else{
						jQuery(this).next('.sub-menu,.mega-menu').slideUp();
					}
				}
			});
		}
		
		/* Magnific Popup ============ */
		var handleMagnificPopup = function(){	
			
			if(jQuery('.mfp-gallery').length > 0){
				/* magnificPopup function */
				jQuery('.mfp-gallery').magnificPopup({
					delegate: '.mfp-link',
					type: 'image',
					tLoading: 'Loading image #%curr%...',
					mainClass: 'mfp-img-mobile',
					gallery: {
						enabled: true,
						navigateByImgClick: true,
						preload: [0,1] // Will preload 0 - before current, and 1 after the current image
					},
					image: {
						tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
						titleSrc: function(item) {
							return item.el.attr('title') + '<small></small>';
						}
					}
				});
				/* magnificPopup function end */
			}
			
			if(jQuery('.mfp-video').length > 0){
				/* magnificPopup for Play video function */		
				jQuery('.mfp-video').magnificPopup({
					type: 'iframe',
					iframe: {
						markup: '<div class="mfp-iframe-scaler">'+
								'<div class="mfp-close"></div>'+
								'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
								'<div class="mfp-title">Some caption</div>'+
								'</div>'
					},
					callbacks: {
						markupParse: function(template, values, item) {
							values.title = item.el.attr('title');
						}
					}
				});	
			}

			if(jQuery('.popup-youtube, .popup-vimeo, .popup-gmaps').length > 0){
				/* magnificPopup for Play video function end */
				$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
					disableOn: 700,
					type: 'iframe',
					mainClass: 'mfp-fade',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false
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
		
		/* Masonry Box ============ */
		var handleMasonryBox = function(){
			/* masonry by  = bootstrap-select.min.js */
			if(jQuery('#masonry, .masonry').length > 0){
				var self = jQuery("#masonry, .masonry");
		 
				if(jQuery('.card-container').length > 0){
					var gutterEnable = self.data('gutter');
					
					var gutter = (self.data('gutter') === undefined)?0:self.data('gutter');
					gutter = parseInt(gutter);
					
					
					var columnWidthValue = (self.attr('data-column-width') === undefined)?'':self.attr('data-column-width');
					if(columnWidthValue != ''){columnWidthValue = parseInt(columnWidthValue);}
					
					self.imagesLoaded(function () {
						self.masonry({
							gutterWidth: 15,
							isAnimated: true,
							itemSelector: ".card-container",
						});
						
					}); 
				} 
			}
			if(jQuery('.filters').length){
				jQuery(".filters li:first").addClass('active');
				
				jQuery(".filters").on("click", "li", function() {
					jQuery('.filters li').removeClass('active');
					jQuery(this).addClass('active');
					
					var filterValue = $(this).attr("data-filter");
					self.isotope({ filter: filterValue });
				});
			}
			/* masonry by  = bootstrap-select.min.js end */
		}
		
		/* Counter Number ============ */
		var handleCounter = function(){
			if(jQuery('.counter').length){
				jQuery('.counter').counterUp({
					delay: 10,
					time: 3000
				});	
			}
		}
		
		/* Video Popup ============ */
		var handleVideo = function(){
			/* Video responsive function */	
			jQuery('iframe[src*="youtube.com"]').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
			jQuery('iframe[src*="vimeo.com"]').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');	
			/* Video responsive function end */
		}
		
		/* Gallery Filter ============ */
		var handleFilterMasonary = function(){
			/* gallery filter activation = jquery.mixitup.min.js */ 
			if (jQuery('#image-gallery-mix').length) {
				jQuery('.gallery-filter').find('li').each(function () {
					$(this).addClass('filter');
				});
				jQuery('#image-gallery-mix').mixItUp();
			};
			if(jQuery('.gallery-filter.masonary').length){
				jQuery('.gallery-filter.masonary').on('click','span', function(){
					var selector = $(this).parent().attr('data-filter');
					jQuery('.gallery-filter.masonary span').parent().removeClass('active');
					jQuery(this).parent().addClass('active');
					jQuery('#image-gallery-isotope').isotope({ filter: selector });
					return false;
				});
			}
		}
		
		/* BGEFFECT ============ */
		var reposition = function (){
			var modal = jQuery(this),
			dialog = modal.find('.modal-dialog');
			modal.css('display', 'block');
			
			/* Dividing by two centers the modal exactly, but dividing by three 
			 or four works better for larger screens.  */
			dialog.css("margin-top", Math.max(0, (jQuery(window).height() - dialog.height()) / 2));
		}
		
		var handelResize = function (){
			/* Reposition when the window is resized */
			jQuery(window).on('resize', function() {
				jQuery('.modal:visible').each(reposition);			
			});
		}
		
		/* Light Gallery ============ */
		var handleLightGallery = function (){
			if(($('#lightgallery, .lightgallery').length > 0)){
				$('#lightgallery, .lightgallery').lightGallery({
					selector : '.lightimg',
					loop:true,
					download:false,
					thumbnail:true,
					share:false,
					exThumbImage: 'data-exthumbimage'
				});
			}
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
		
		/* Select Picker ============ */
		var handleSelectpicker = function(){
			if(jQuery('.default-select').length > 0 ){
				jQuery('.default-select').selectpicker();
			}
		}

		/* Handle Placeholder ============ */
		var handlePlaceholderAnimation = function(){
			if(jQuery('.dz-form').length  > 0){
				$('input, textarea').focus(function(){
					$(this).parents('.input-area').addClass('focused');
				});

				if ( $('#input_search').val() != "" ) {
					$('#input_search').addClass('filled');
					$('#input_search').parents('.input-area').addClass('focused');
				}

				$('input, textarea').blur(function(){
					var inputValue = $(this).val();
					if ( inputValue == "" ) {
						$(this).removeClass('filled');
						$(this).parents('.input-area').removeClass('focused');  
					} else {
						$(this).addClass('filled');
					}
				})
			}
		}

		/* Icon Dropdowm ============ */
		var handleIconDropdowm = function(){
			jQuery(".icon-dropdown").on('click', function(){
				if($(this).hasClass("show")){
					$(this).removeClass("show");
				}else {
					jQuery(".icon-dropdown").removeClass("show");	
					$(this).addClass("show");
				}
		  	});
		}
		
		/* Perfect Scrollbar ============ */
		var handlePerfectScrollbar = function() {
			if(jQuery('.deznav-scroll').length > 0){
				const qs = new PerfectScrollbar('.deznav-scroll');
				qs.isRtl = false;
			}
		}
		
		/* Wow Animation ============ */
		var handleWowAnimation = function(){
			if($('.wow').length > 0){
				var wow = new WOW({
					boxClass:     'wow',      // Animated element css class (default is wow)
					animateClass: 'animated', // Animation css class (default is animated)
					offset:       0,          // Distance to the element when triggering the animation (default is 0)
					mobile:       false       // Trigger animations on mobile devices (true is default)
				});
				setTimeout(function(){
					wow.init();	
				}, 2100);
			}
		}
		
		/* Countdown Timer ============ */
		var handleFinalCountDown = function(){

			var WebsiteLaunchDate = new Date(); / Default website launch date one month plus in current date /

			var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
				WebsiteLaunchDate.setMonth(WebsiteLaunchDate.getMonth() + 1);
				WebsiteLaunchDate =  WebsiteLaunchDate.getDate() + " " + monthNames[WebsiteLaunchDate.getMonth()] + " " + WebsiteLaunchDate.getFullYear();

			var launchDate = jQuery('.countdown-timer').data('date');
			
			if(launchDate != undefined && launchDate != '')
			{
				WebsiteLaunchDate = launchDate;
					
			}

			if(jQuery('.countdown-timer').length > 0 )
			{
				var startTime = new Date(); // Put your website start time here
				startTime = startTime.getTime();
				
				var currentTime = new Date();
				currentTime = currentTime.getTime();
				
				var endTime = new Date(WebsiteLaunchDate); // Put your website end time here
				endTime = endTime.getTime();
				
				$('.countdown-timer').final_countdown({
					
					'start': (startTime/1000),
					'end': (endTime/1000), 
					'now': (currentTime/1000), 
					selectors: {
						value_seconds:'.clock-seconds .val',
						canvas_seconds:'canvas-seconds',
						value_minutes:'.clock-minutes .val',
						canvas_minutes:'canvas-minutes',
						value_hours:'.clock-hours .val',
						canvas_hours:'canvas-hours',
						value_days:'.clock-days .val',
						canvas_days:'canvas-days'
					},
					seconds: {
						borderColor:$('.type-seconds').attr('data-border-color'),
						borderWidth:'5',
					},
					minutes: {
						borderColor:$('.type-minutes').attr('data-border-color'),
						borderWidth:'5'
					},
					hours: {
						borderColor:$('.type-hours').attr('data-border-color'),
						borderWidth:'5'
					},
					days: {
						borderColor:$('.type-days').attr('data-border-color'),
						borderWidth:'5'
					}
				});
			}	
		}
		
		/* BMI Calculator ============ */
		var handleBmiCalculator = function(){
			if(jQuery('#BmiCalculator').length > 0 ){
				jQuery("#BmiCalculator").on('submit', function() {
					event.preventDefault();
					var age = jQuery("#age").val();
					var height = jQuery("#height").val();
					var weight = jQuery("#weight").val();
					var gender = jQuery("#gender").val();
					var form = jQuery(this);

					if(age == '' || height == '' || weight == '' || gender == '' || gender == false){
						alert("All fields are required!");
						return false;
					}

					form[0].reset();
					var bmi = Number(weight)/(Number(height)/100*Number(height)/100);
					
					var result = '';
					if(bmi < 18.5) {
						result = 'Underweight';
					} else if(18.5 <= bmi && bmi <= 24.9) {
						result = 'Healthy';
					} else if(25 <= bmi && bmi <= 29.9) {
						result = 'Overweight';
					} else if(30 <= bmi && bmi <= 34.9) {
						result = 'Obese';
					} else if(35 <= bmi) {
						result = 'Extremely obese';
					}

					jQuery('.dzFormBmi').html('<div class="dzFormInner"><h4 class="title text-white">'+result+'</h4><h5 class="bmi-result text-primary m-b0">BMI: '+parseFloat(bmi).toFixed(2)+'</h5></div>');
				});
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
				handleHomeSearch();
				handleBoxHover();
				handleDzTheme();
				handleMagnificPopup();
				handleScrollTop();
				handleHeaderFix();
				handleSelectpicker();
				handleVideo();
				handlePlaceholderAnimation();
				handleFilterMasonary();
				handleFinalCountDown();
				handelResize();
				handleLightGallery();
				jQuery('.modal').on('show.bs.modal', reposition);
				handleIconDropdowm();
				handleCurrentActive();
				handlePerfectScrollbar();
				handleWowAnimation();
				handleBmiCalculator();
				heartBlast();
			},

			load:function(){
				handleCounter();
				handleMasonryBox();
			},
			
			resize:function(){
				screenWidth = $(window).width();
				handleFinalCountDown();
				handleDzTheme();
			}
		}
		
	}();

	/* Document.ready Start */	
	jQuery(document).ready(function() {
		
		BodyShape.init();
		
		$('a[data-bs-toggle="tab"]').on('click',function(){
			// todo remove snippet on bootstrap v5
			$('a[data-bs-toggle="tab"]').on('click',function() {
				$($(this).attr('href')).show().addClass('show active').siblings().hide();
			})
		});
		
		jQuery('.navicon').on('click',function(){
			$(this).toggleClass('open');
		});
		
	});
	/* Document.ready END */

	/* Window Load START */
	jQuery(window).on('load',function () {
		
		BodyShape.load();
		
		setTimeout(function(){
			jQuery('#loading-area').fadeOut();
		}, 2000);
		
	});
	/*  Window Load END */

	/* Window Resize START */
	jQuery(window).on('resize',function () { 
		BodyShape.resize();
	});
	/*  Window Resize END */
	
})(jQuery);