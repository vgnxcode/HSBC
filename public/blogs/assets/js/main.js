(function ($) {
	$('.owl-carousel-feature').owlCarousel({
		loop:true,
		lazyLoad:true,
		margin:15,
		autoplay:true,
		autoplayTimeout:4000,
		smartSpeed: 500,
		touchDrag  : true,
		mouseDrag  : true,
		dots: false,
		nav: true,
		responsiveClass:true,
		responsive:{
			1366:{
				items:3,
			},
			1024:{
				items:3,
			},
			760:{
				items:2,
			},
			750:{
				
				dots: true,
				nav: false,
				items:2,
			},
			480:{
				mouseDrag  : true,
				touchDrag  : true,
				autoplay:true,
				dots:true,
				nav: false,
				items:1,
			},
			0:{
				mouseDrag  : true,
				touchDrag  : true,
				autoplay:true,
				dots: true,
				nav: false,
				items:1,
			}
		}
	})

	$('.owl-carousel-testimonials').owlCarousel({
		loop:true,
		lazyLoad:false,
		margin:15,
		autoplay:true,
		autoplayTimeout:5000,
		smartSpeed: 3000,
		touchDrag  : false,
		mouseDrag  : false,
		dots: false,
		nav: true,
		responsiveClass:true,
		responsive:{
			1366:{
				items:2,
			},
			1024:{
				items:1,
			},
			640:{
				
				nav: false,
				items:1,
			},
			0:{
			
				nav: false,
				items:1,
			}
		}
	})

	$('.owl-carousel-blog').owlCarousel({
		loop:true,
		lazyLoad:true,
		margin:15,
		autoplay:true,
		autoplayTimeout:5000,
		smartSpeed: 2000,
		touchDrag  : true,
		mouseDrag  : true,
		dots: false,
		nav: true,
		responsiveClass:true,
		responsive:{
			1366:{
				items:3,
			},
			1024:{
				items:3,
			},
			640:{
				items:2,
			},
			0:{
				nav:false,
				dots:true,
				items:1,
			}
		}
	})
	$('.owl-carousel-projectplan').owlCarousel({
		loop:true,
		lazyLoad:true,
		margin:10,
		autoplay:true,
		autoplayTimeout:4000,
		smartSpeed: 500,
		touchDrag  : true,
		mouseDrag  : true,
		dots: false,
		nav: true,
		responsiveClass:true,
		responsive:{
			1366:{
				items:1,
			},
			1024:{
				items:1,
			},
			760:{
				items:1,
			},
			750:{
			
				items:1,
			},
			480:{
				
				items:1,
			},
			0:{
				
				items:1,
			}
		}
	})


	



	$('.owl-carousel-statuss').owlCarousel({
		loop:true,
		lazyLoad:false,
		margin:15,
		autoplay:false,
		autoplayTimeout:6000,
		smartSpeed: 3000,
		touchDrag  : true,
		mouseDrag  : true,
		dots: false,
		nav: true,
		responsiveClass:true,
		responsive:{
			1366:{
				items:3,
			},
			1024:{
				items:3,
			},
			640:{
				items:1,
			},
			0:{
				items:1,
			}
		}
	})
	
	$('.owl-carousel-featuredamenities').owlCarousel({
		loop:true,
		lazyLoad:false,
		margin:15,
		autoplay:true,
		autoplayTimeout:3000,
		smartSpeed: 500,
		touchDrag  : true,
		mouseDrag  : true,
		dots: false,
		nav: true,
		responsiveClass:true,
		responsive:{
			1366:{
				items:3,
			},
			1024:{
				items:3,
			},
			640:{
				nav: false,
				dots: true,
				items:2,
			},
			0:{
				nav: false,
				dots: true,
				items:1,
			}
		}
	})
	$('.owl-carousel-banner').owlCarousel({
		loop:true,
		lazyLoad:false,
		margin:15,
		autoplay:true,
		autoplayTimeout:6000,
		smartSpeed: 3000,
		touchDrag  : true,
		mouseDrag  : true,
		dots: false,
		nav: true,
		responsiveClass:true,
		responsive:{
			1366:{
				items:1,
			},
			1024:{
				items:1,
			},
			640:{
				items:1,
			},
			0:{
				items:1,
			}
		}
	})

	$('.owl-carousel-awards').owlCarousel({
		loop:true,
		lazyLoad:true,
		margin:15,
		autoplay:true,
		autoplayTimeout:6000,
		smartSpeed: 3000,
		touchDrag  : true,
		mouseDrag  : true,
		dots: false,
		nav: true,
		responsiveClass:true,
		responsive:{
			1366:{
				items:4,
			},
			1024:{
				items:4,
			},
			640:{
			
				items:3,
			},
			0:{
			
				items:1,
			}
		}
	})



	$('.owl-carousel-managerial').owlCarousel({
		loop:true,
		lazyLoad:true,
		margin:15,
		autoplay:true,
		autoplayTimeout:6000,
		smartSpeed: 3000,
		touchDrag  : false,
		mouseDrag  : false,
		dots: false,
		nav: false,
		responsiveClass:true,
		responsive:{
			1366:{
				items:3,
			},
			1024:{
				items:3,
			},
			640:{
				nav: false,
				dots: true,
				items:3,
			},
			0:{
				touchDrag  : true,
				mouseDrag  : true,
				autoplay:true,
				nav: false,
				dots: true,
				items:1,
			}
		}
	})

	$('.owl-carousel-advantages').owlCarousel({
		loop:true,
		lazyLoad:false,
		margin:10,
		autoplay:true,
		autoplayTimeout:7000,
		smartSpeed: 500,
		touchDrag  : false,
		mouseDrag  : false,
		dots: false,
		nav: false,
		responsiveClass:true,
		responsive:{
			1366:{
				items:2,
			},
			1024:{
				items:2,
			},
			640:{
				items:2,
			},
			0:{
				
				items:2,
			}
		}
	})

	$('.owl-carousel-home-building').owlCarousel({
		loop:true,
		lazyLoad:false,
		margin:15,
		autoplay:true,
		autoplayTimeout:6000,
		smartSpeed: 3000,
		touchDrag  : true,
		mouseDrag  : true,
		dots: false,
		nav: true,
		// animateIn: 'fadeIn',
		// animateOut: 'fadeOut',
		responsiveClass:true,
		responsive:{
			1366:{
				items:1,
			},
			1024:{
				items:1,
			},
			640:{
				items:1,
			},
			0:{
				items:1,
			}
		}
	})




})(jQuery);



 $("#menu1").on('click', function(e) {
    e.stopPropagation();
   $("#menu1Con").fadeToggle();
   $("#menu2Con,#menu3Con,#menu4Con,#menu5Con").fadeOut();

   $("#menu1").toggleClass("add-bg-btn");
   $("#menu2,#menu3,#menu4,#menu5").removeClass("add-bg-btn");
   return false;
});

      $("#menu2").on('click', function(e) {
    e.stopPropagation();
   $("#menu2Con").fadeToggle();
   $("#menu1Con,#menu3Con,#menu4Con,#menu5Con").fadeOut();

      $("#menu2").toggleClass("add-bg-btn");
   $("#menu1,#menu3,#menu4,#menu5").removeClass("add-bg-btn");
  return false;
});

      $("#menu3").on('click', function(e) {
    e.stopPropagation();
   $("#menu3Con").fadeToggle();
   $("#menu2Con,#menu1Con,#menu4Con,#menu5Con").fadeOut();

      $("#menu3").toggleClass("add-bg-btn");
   $("#menu2,#menu1,#menu4,#menu5").removeClass("add-bg-btn");

   return false;
});

      $("#menu4").on('click', function(e) {
    e.stopPropagation();
   $("#menu4Con").fadeToggle();
   $("#menu2Con,#menu1Con,#menu3Con,#menu5Con").fadeOut();

      $("#menu4").toggleClass("add-bg-btn");
   $("#menu2,#menu3,#menu1,#menu5").removeClass("add-bg-btn");

   return false;
});

      $("#menu5").on('click', function(e) {
    e.stopPropagation();
   $("#menu5Con").fadeToggle();
   $("#menu2Con,#menu1Con,#menu3Con,#menu4Con").fadeOut();

      $("#menu5").toggleClass("add-bg-btn");
   $("#menu2,#menu3,#menu4,#menu1").removeClass("add-bg-btn");

   return false;
});      


    $(document).click(function() {
      $("#menu1Con,#menu2Con,#menu3Con,#menu4Con,#menu5Con").fadeOut();
      $("#menu1,#menu2,#menu3,#menu4,#menu5").removeClass("add-bg-btn");
     
  });