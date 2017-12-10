(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .service('Map', MapService);

    MapService.$inject = [
        '$timeout'
    ];

    function MapService(
        $timeout
    ) {
        function Map () {}

        Map.prototype.configs = {};
        Map.prototype.isLoad = false;

        Map.prototype.setConfigs = function (configs) {
            this.configs = configs;

            return this;
        };

        Map.prototype.load = function () {
            if (!this.configs['id']) {
                throw new Error('Не установлен id для карты');
            }

            if (this.isLoad) {
                return;
            }

            //нужно подгрузить компанию, и вставить данные в баллон
            this.isLoad = true;
            var self = this;

            $timeout(function () {
                open();
            });

            function open() {
                var map,
                    mapElement = document.getElementById(self.configs['id']);

                if (mapElement) {
                    breadMap.ready(function () {
                        map = new breadMap.Map(mapElement, {
                            center: [57.5375, 60.2929],
                            zoom: 14
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
            }
        };

        return Map;
    }

})(angular);