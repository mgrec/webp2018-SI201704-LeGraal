/*!
 * fastshell
 * Fiercely quick and opinionated front-ends
 * https://HosseinKarami.github.io/fastshell
 * @author Hossein Karami
 * @version 1.0.5
 * Copyright 2017. MIT licensed.
 */
/**
 * Created by StephaneGoyon on 18/04/2017.
 */
$(function() {
    // Smooth Scroll on clicking nav items
    $('a[href*="#"]:not([href="#"])').click(function() {
        var $href = $(this).attr('href');
        $('body').stop().animate({
            scrollTop: $($href).offset().top
        }, 1000);

        return false;
    });

    $(document).scroll(function () {

        // changing padding of nav a on scroll
        var scrollPos = $(document).scrollTop() + 100;
        if (scrollPos > 500) {
            $('header').css('box-shadow', '0px 0px 10px rgba(0,0,0, .1)');
        } else {
            $('header').css('box-shadow', '0px 0px 10px rgba(0,0,0,0)');
        }
    });
});