var $ = jQuery;

// callback after ready the document
$(document).ready(function(){


	$("#mobilecontact_btn").on("click", function(){
		setTimeout(function(){
			window.open('tel:04443439999');
		},3000);
 });



 $('.tooltipped').tooltip({delay: 10});
	$(".dropdown-button").dropdown({
		inDuration: 300,
outDuration: 225,
constrain_width: false, // Does not change width of dropdown to that of the activator
hover: true, // Activate on hover
gutter: 0, // Spacing from edge
belowOrigin: true // Displays dropdown below the button
	});


	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

		$("#mobile-demo").css('overflowY', 'scroll');
		$("#dropdown1").css('overflowY', 'scroll');
		$("#dropdown2").css('overflowY', 'scroll');
		$("#dropdown1").css('height', '200px');
		$("#dropdown2").css('height', '200px');
	
		$("body").on('click', function(){
			$("#dropdown1").hide();
			$("#dropdown2").hide();
		});
	}
	else
	{
	}
	
	



	  var pxScrolled = 200;
  var duration = 500;

  $(window).scroll(function() {
    if ($(this).scrollTop() > pxScrolled) {
      $('.fab-container').css({'bottom': '0px', 'transition': '.3s'});
    } else {
      $('.fab-container').css({'bottom': '-72px'});
    } 
  }); 

  $('.top').click(function() {
     $("html, body").animate({ scrollTop: 0 }, 600);
    return false;
  })

var enqurl = $(location).attr('href');
parts = enqurl.split("/"),
last_part = parts[3];

$("#enq").on('click', function(){
if($("#enquireformview").length == 0){
window.location.href="https://vgn.in/contact_us";
}
else{
console.log('project page')
}

});




	 $('select').material_select();

	$('.search-form-li').on('click',function(e){
		e.stopPropagation();
		$('.search-form-li').find('#initSearchIcon').addClass('hide');
		$('.search-form-wrap').removeClass('hide').find('input.search').focus();
		$('.side-nav').addClass('hide');
	});

	$(window).on('click',function(){
		$('.search-form-li').find('#initSearchIcon').removeClass('hide');
		$('.search-form-wrap').addClass('hide');
		$('.side-nav').removeClass('hide');
	});


$('#closetag').on('click',function(e){
		$('.button-collapse').sideNav('hide');
	});



	$(".blog-submenu-init").dropdown({
		inDuration: 300,
		outDuration: 225,
		constrain_width: true,
		hover: false,
		alignment: 'right',
		gutter: 10,
		belowOrigin: true
	});


	$(".primary-nav .button-collapse").sideNav();


	// jwplayer video post
	


	$("html").niceScroll({
		cursorwidth: '7px',
		zindex: '9999999'
	});

	// blog Mesonary
	if ( $('#blog-posts').length > 0 ) {
		window.blogMsnry = $('#blog-posts').isotope({
			itemSelector: '.single-post',
			isInitLayout: false,
			layoutMode: 'masonry'
		});
	}

});


// callback after loading the window
$(window).load(function(){

	// Preloader
    $('.loader').fadeOut();    
    $('#preloader').delay(350).fadeOut('slow');
    $('body').delay(350);



	// blog post slider
	(function(){
		var $blog_post_slider  = $('.thumb-slides-container');
		if ( $blog_post_slider.length > 0 ) {

			$blog_post_slider.each(function(){
				$(this).owlCarousel({
					singleItem : true,
				    autoPlay : true,
				    stopOnHover : true,
					slideSpeed : 800,
					transitionStyle : 'fade'
				});
			});

			$('.thumb-slides-controller a').on('click',function(e){
				e.preventDefault();

				var blog_post_slider_data = $(this).closest('.blog-post-thumb').children('.thumb-slides-container').data('owlCarousel');

				if ( $(this).hasClass('left-arrow') ) {
					blog_post_slider_data.prev();
				} else {
					blog_post_slider_data.next();
				}
			});
		}
	}());


	// favorite maker
	(function(){
		var lovedText = "You already love this", loveText = "Love this", loveClass = "active";
		$('.js-favorite').on('click', function(e){
			e.preventDefault();
			var favoriteNumb = parseInt( $(this).find('.numb').text(), 10 );
			if ( $(this).hasClass(loveClass) ) {
				$(this).removeClass(loveClass).attr('title', loveText);
				--favoriteNumb;
				$(this).find('.numb').text( favoriteNumb );
			} else {
				$(this).addClass(loveClass).attr('title', lovedText);
				++favoriteNumb;
				$(this).find('.numb').text( favoriteNumb );
			}
		});
	}());


	// Blog masonry re layout
	if ( typeof blogMsnry !== "undefined" ) {
		blogMsnry.isotope('layout');
	}

});


// callback after resize the window
$(window).resize(function(){

	// Blog masonry re layout

	var handler = setTimeout(function(){
		if ( typeof blogMsnry !== "undefined" ) {
			blogMsnry.isotope('layout');
		}
		clearTimeout(handler);
	}, 2000);

});








function setActiveStyleSheet(cssName){
    var scheme = $('link[href*="css/colors/color"]');
    scheme.attr('href','assets/css/colors/'+cssName+'.css');
}


$("#hide, #show").click(function (e) {
	e.preventDefault();

    if ($("#show").is(":visible")) {
       
        $("#show").animate({
            "margin-right": "-300px"
        }, 300, function () {
            $(this).hide();
        });
        
        $("#switch").animate({
            "margin-right": "0px"
        }, 300).show();
    } else {
        $("#switch").animate({
            "margin-right": "-300px"
        }, 300, function () {
            $(this).hide();
        });
        $("#show").show().animate({
            "margin-right": "0"
        }, 300);
    }
});