$(function () {
    //раскрывашки для меню
    $(".auth-button").click(function () {
        $('.user-links').slideToggle();
    });
    $(".menu-adaptive_bars").click(function () {
        $(".menu").slideToggle();
    });

    //галерея
    $("[data-fancybox]").fancybox();
    
    //выдвигашка для корзины

    $('#header-cart').hover(
        function () {
            $(this).stop().animate({
                right: '0'
            }, 700, 'easeInSine');
        },
        function () {
            $(this).stop().animate({
                right: '-230px'
            }, 700, 'easeOutBounce');
        }
    );
});