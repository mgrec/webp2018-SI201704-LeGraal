/*!
 * fastshell
 * Fiercely quick and opinionated front-ends
 * https://HosseinKarami.github.io/fastshell
 * @author Hossein Karami
 * @version 1.0.5
 * Copyright 2017. MIT licensed.
 */
(function ($, window, document, undefined) {

  'use strict';

$(function () {
	$('.panel-left-open').on('click', function(event){
		event.preventDefault();
		$('.block--left').addClass('open');
		$('.block--right').addClass('close');
	});
	$('.panel-right-open').on('click', function(event){
		event.preventDefault();
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
});

})(jQuery, window, document);