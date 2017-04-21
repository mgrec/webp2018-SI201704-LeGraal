(function ($, window, document, undefined) {

  'use strict';

$(function () {
	$('.link__open--left').on('click', function(event){
		event.preventDefault();
		$('.link__open--left').css("display", "none");
		$('.block--left').addClass('open');
		$('.block--right').addClass('close');
	});
	$('.link__open--right').on('click', function(event){
		event.preventDefault();
		$('.link__open--right').css("display", "none");
		$('.block--left').addClass('close');
		$('.block--right').addClass('open');
	});

	$('.sticky__navigation a').click(function() {
	  $('html, body').animate({
	    scrollTop: $($(this).attr('href'))
	      .offset().top
	  }, 700);
	  return false;
	});

	$('.st-burger-icon').on('click', function() {
	  $('.st-burger-icon-container').toggleClass('transformed');
	  $(this).toggleClass('st-burger-icon--transformed');
	  $('.header').toggleClass('mobile');
	});

	$(window).scroll(function() {
		var scrollPos = $(document).scrollTop();
		if (scrollPos < 700) {
			$(".sticky__navigation").css("display", "none");
		} else {
			$(".sticky__navigation").css("display", "flex");
			var x = $(".sticky__navigation").offset().top;
			$("section").each(function(index) {
				var z = $(this).attr("id");
				if (x > $(this).offset().top && x <= $(this).offset().top + $(this).height()) {
					$('a.' + z).addClass('active');
				} else {
					$('a.' + z).removeClass('active');
				}
			})
		}
	})

	$(".link__panel").each(function(index) {
		var z = $(this).attr("class").split(' ');
		for(var i=0; i<z.length; i++){
			$("."+z[1]).mouseover(function(){
				if (z[1] == 'nb1') {
					$('.nb1').addClass("active");
					$('.nb1').css("color", "#0a33e0");
					$('.description1').css('opacity', '1');
					$('.nb2').removeClass("active");
					$('.description2').css('opacity', '0');
					$('.nb3').removeClass("active");
					$('.description3').css('opacity', '0');
					$('.nb4').removeClass("active");
					$('.description4').css('opacity', '0'); 
				};
				if (z[1] == 'nb2') {
					$('.nb1').removeClass("active");
					$('.nb1').css("color", "#fff");
					$('.description1').css('opacity', '0');
					$('.nb2').addClass("active");
					$('.description2').css('opacity', '1');
					$('.nb3').removeClass("active");
					$('.description3').css('opacity', '0');
					$('.nb4').removeClass("active");
					$('.description4').css('opacity', '0'); 
				};
				if (z[1] == 'nb3') {
					$('.nb1').removeClass("active");
					$('.nb1').css("color", "#fff");
					$('.description1').css('opacity', '0');
					$('.nb2').removeClass("active");
					$('.description2').css('opacity', '0');
					$('.nb3').addClass("active");
					$('.description3').css('opacity', '1');
					$('.nb4').removeClass("active");
					$('.description4').css('opacity', '0'); 
				};
				if (z[1] == 'nb4') {
					$('.nb1').removeClass("active");
					$('.nb1').css("color", "#fff");
					$('.description1').css('opacity', '0');
					$('.nb2').removeClass("active");
					$('.description2').css('opacity', '0');
					$('.nb3').removeClass("active");
					$('.description3').css('opacity', '0');
					$('.nb4').addClass("active");
					$('.description4').css('opacity', '1'); 
				};

			});
		}

		$('.contactHeader').click(function(){
			$('.modalOverlay').removeClass('hiddenModal');
			$(window).scrollTop(0);
		});
		$('.contactFooter').click(function(){
			$('.modalOverlay').removeClass('hiddenModal');
			$(window).scrollTop(0);
		});
		$('.contactdevis').click(function(){
			$('.modalOverlay').removeClass('hiddenModal');
			$(window).scrollTop(0);
		});
		$('.crossContact').click(function(){
			$('.modalOverlay').addClass('hiddenModal');
		});
		$('.submitContact').click(function(){
			$('.modalOverlay').addClass('hiddenModal');
		});


	})

	$(document).ready(function(){
		if (window.innerWidth < 894) {
			$('.slick-block__content').slick({
				centerMode: true,
				dots: true,
				infinite: true,
				arrows: true
			});
		}
	});

});

})(jQuery, window, document);