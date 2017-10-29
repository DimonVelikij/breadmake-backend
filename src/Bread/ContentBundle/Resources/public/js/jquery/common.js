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

    var map,
        mapElement = document.getElementsByClassName('about-map')[0];
    if (mapElement) {
        breadMap.ready(function () {
            map = new breadMap.Map(mapElement, {
                center: [57.5375, 60.2929],
                zoom: 15
            });
            map.controls.add(new breadMap.control.ZoomControl(), {top: 40});
            map.controls.add(new breadMap.control.RouteEditor());
            map.controls.add(new breadMap.control.TypeSelector([
                'yandex#map',
                'yandex#satellite',
                'yandex#hybrid'
            ]));
            map.controls.add(new breadMap.control.ScaleLine());
            map.controls.add(new breadMap.control.MapTools());
            var geoObject = new breadMap.GeoObject({
                geometry: {
                    type: "Point",
                    coordinates: [57.5375, 60.2929]
                },
                properties: {
                    "balloonContent": "<div class='balloon'><p class='balloon-title'>Быньговское потребительское общество</p><a href='tel:89222271420' class='text orange'>89222271420</a><p class='brown-light'>Невьянский район, с.Быньги, ул.Мартьянова, 22</p><p class='brown-dark'>пн-пт: <span class='orange'>08:00-17:00</span></p><p class='brown-dark'>сб-вс: <span class='orange'>выходной</span></p></div>",
                    "hintContent": "Быньговское потребительское общество"
                }
            });
            map.geoObjects.add(geoObject);
        });
    }

});