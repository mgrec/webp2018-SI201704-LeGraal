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
        var scrollPos = $(document).scrollTop();
        if (scrollPos > 1) {
            $('header').css('box-shadow', '0px 0px 10px rgba(0,0,0, .1)');
            $('nav ul li a').css('color', '#000');
            $('nav ul li a:after').css('border-color', '#fff');
            $('.banner').css('background', '#fff');
        } else {
            $('header').css('box-shadow', '0px 0px 10px rgba(0,0,0,0)');
            $('nav ul li a').css('color', '#fff');
            $('nav ul li a:after').css('border-color', '#000');
            $('header').css('background', 'transparent');
            $('header').css('margin', '10px 0');
        }
    });
});