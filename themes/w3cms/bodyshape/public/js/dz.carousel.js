/**
	Template Name 	 : BodyShape
	Author			 : DexignZone
	Version			 : 1.0
	File Name	     : dz.carousel.js
	Author Portfolio : https://themeforest.net/user/dexignzone/portfolio
	
	Core script to handle the entire theme and core functions
	
**/

/* JavaScript Document */
jQuery(window).on('load', function() {
    'use strict';
	
	function changeItemBoxed() {
		if(jQuery("body").hasClass("boxed")) {
			return 3;
		} else {
			return 4;
		}
	}
	
	// Main Slider
	if(jQuery('.main-slider').length > 0){
		var swiperMain = new Swiper('.main-slider', {
			speed: 3000,
			effect: "fade",
			slidesPerView: 1,
			loop:true,
			autoplay: {
			  delay: 3000,
			},
			pagination: {
	         	el: ".main-pagination",
	         	clickable: true,
	         	renderBullet: function (index, className) {
					return '<span class="' + className + '">' +"0"+ (index + 1) + "</span>";
				},
	        },
			navigation: {
	          	nextEl: ".main-btn-next",
				prevEl: ".main-btn-prev",
	        },
		});
	}
	
	// Blog Slider Full
	if(jQuery('.blog-slider-full').length > 0){
		var swiper = new Swiper('.blog-slider-full', {
			speed: 1500,
			parallax: true,
			slidesPerView: changeItemBoxed(),
			centeredSlides: true,
			spaceBetween: 30,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			pagination: {
	         	el: ".swiper-blog-pagination",
	         	clickable: true,
	         	renderBullet: function (index, className) {
					return '<span class="' + className + '">' +"0"+ (index + 1) + "</span>";
				},
	        },
			navigation: {
				nextEl: '.swiper-blog-next',
				prevEl: '.swiper-blog-prev',
			},
			breakpoints: {
				1200: {
					slidesPerView: 3,
				},
				768: {
					slidesPerView: 2,
					centeredSlides: false,
				},
				320: {
					slidesPerView: 1,
					centeredSlides: false,
				},
			}
		});
	}
	
	// Team Slider
	if(jQuery('.team-slider').length > 0){
		var swiper = new Swiper('.team-slider', {
			speed: 1500,
			slidesPerView: 3,
			spaceBetween: 30,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			pagination: {
	         	el: ".team-slider-pagination",
	         	clickable: true,
	         	renderBullet: function (index, className) {
					return '<span class="' + className + '">' +"0"+ (index + 1) + "</span>";
				},
	        },
			navigation: {
				nextEl: '.team-slider-next',
				prevEl: '.team-slider-prev',
			},
			breakpoints: {
				1200: {
					slidesPerView: 3,
				},
				992: {
					slidesPerView: 3,
				},
				500: {
					slidesPerView: 2,
				},
				320: {
					slidesPerView: 1,
				},
			}
		});
	}
	
	// Testimonial Swiper
	if(jQuery('.testimonial-swiper').length > 0){
		var swiper = new Swiper('.testimonial-swiper', {
			speed: 1500,
			parallax: true,
			slidesPerView: 1,
			spaceBetween: 0,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			navigation: {
	          	nextEl: ".testimonial-button-next",
	         	 prevEl: ".testimonial-button-prev",
	        },
			pagination: {
	         	 el: ".swiper-pagination",
	         	 clickable: true,
	         	 renderBullet: function (index, className) {
	           	 return '<span class="' + className + '">' +"0"+ (index + 1) + "</span>";
	          	},
	        },
		});
	}
	
	// Testimonial Swiper 2
	if(jQuery('.testimonial-swiper-2').length > 0){
		var swiper = new Swiper('.testimonial-swiper-2', {
			speed: 1500,
			parallax: true,
			slidesPerView:"auto",
			spaceBetween: 0,
			centeredSlides: true,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			navigation: {
	          	nextEl: ".dz-swiper-next1",
	         	prevEl: ".dz-swiper-prev1",
	        },
			pagination: {
	         	el: ".dz-swiper-pagination1",
	         	clickable: true,
	         	renderBullet: function (index, className) {
					return '<span class="' + className + '">' +"0"+ (index + 1) + "</span>";
				},
	        },
		});
	}

	// Portfolio Slider
	if(jQuery('.portfolio-slider').length > 0){
		var swiper = new Swiper('.portfolio-slider', {
			speed: 1500,
			slidesPerView: "auto",
			spaceBetween: 0,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			navigation: {
	          	nextEl: ".portfolio-button-next",
	         	 prevEl: ".portfolio-button-prev",
	        },
			pagination: {
	         	 el: ".swiper-pagination",
	         	 clickable: true,
	         	 renderBullet: function (index, className) {
	           	 return '<span class="' + className + '">' +"0"+ (index + 1) + "</span>";
	          	},
	        },
		});
	}
	
	// Blog Slider
	if(jQuery('.blog-slider').length > 0){
		var swiper = new Swiper('.blog-slider', {
			speed: 1500,
			parallax: true,
			slidesPerView: 3,
			spaceBetween: 0,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			breakpoints: {
				1280: {
					slidesPerView: 3,
				},
				768: {
					slidesPerView: 2,
				},
				320: {
					slidesPerView: 1,
				},
			}
		});
	}
	
	// Post Swiper
	if(jQuery('.post-swiper').length > 0){
		var swiper = new Swiper('.post-swiper', {
			speed: 1500,
			parallax: true,
			slidesPerView: 1,
			spaceBetween: 0,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			navigation: {
				nextEl: '.next-post-swiper-btn',
				prevEl: '.prev-post-swiper-btn',
			}
		});
	}
	
	// Clients Swiper
	if(jQuery('.clients-swiper').length > 0){
		var swiper5 = new Swiper('.clients-swiper', {
			speed: 1500,
			parallax: true,
			slidesPerView: 5,
			spaceBetween: 30,
			autoplay: {
				delay: 3000,
			},
			loop:true,
			navigation: {
				nextEl: '.swiper-button-next5',
				prevEl: '.swiper-button-prev5',
			},
			breakpoints: {
				1200: {
					slidesPerView: 5,
				},
				992: {
					slidesPerView: 4,
				},
				768: {
					slidesPerView: 3,
				},
				575: {
					slidesPerView: 2,
				},
				320: {
					slidesPerView: 2,
				},
			}
		});
	}
	
});
/* JavaScript Document END */