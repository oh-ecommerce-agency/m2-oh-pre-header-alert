define([
    'jquery',
    'domReady',
    'slick'
], function ($, domReady) {
    "use strict"

    domReady(function () {
        const preTopWrapperEl = '.oh-top-wrapper';

        $(preTopWrapperEl).find('ul').slick({
            infinite: true,
            autoplay: true,
            autoplaySpeed: 5000,
            arrows: false,
            slidesToShow: 1,
            speed: 400,
            slidesToScroll: 1
        });

        $(preTopWrapperEl).find(' .item').show();

        $(preTopWrapperEl).find('.close').click(function () {
            $(preTopWrapperEl).hide('slow', function () {
                $(preTopWrapperEl).remove();
            });
        });
    });
});
