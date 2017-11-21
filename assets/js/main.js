$(document).ready(function(){
    $('#menu').slicknav({
        prependTo:'.header-mobile'
    });

    $('.slider').slick({
        infinite: true,
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3500
    });

    $('.slide').height(
        $(document).height() - $('.header').height()
    );
});

$( window ).resize(function() {
    $('.slide').height(
        $(document).height() - $('.header').height()
    );
});
