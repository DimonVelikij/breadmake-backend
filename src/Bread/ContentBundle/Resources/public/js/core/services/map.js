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

            if (!this.configs['company']) {
                throw new Error('Не установлена компания');
            }

            if (this.isLoad) {
                return;
            }

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
                                "balloonContent": getBallonContent(),
                                "hintContent":  getHintContent()
                            }
                        });
                        map.geoObjects.add(geoObject);
                    });
                }

                function getBallonContent() {
                    var company = self.configs['company'],
                        content = "" +
                            "<div class='balloon'>" +
                                "<p class='balloon-title'>" + company.getTitle() + "</p>" +
                                "<a href='tel:" + company.getPhone() + "' class='text orange'>" + company.getPhone() + "</a>";

                    if (company.getEmail()) {
                        content += "<p class='text orange'>" + company.getEmail() + "</p>"
                    }

                    content += "<p class='brown-light'>" + company.getAddress() + "</p>";

                    if (company.getWorkingDays() && company.getWorkingTime()) {
                        content += "<p class='brown-dark'>" + company.getWorkingDays() + ": <span class='orange'>" + company.getWorkingTime() + "</span></p>"
                    }

                    if (company.getWeekend()) {
                        content += "<p class='brown-dark'>" + company.getWeekend() + ": <span class='orange'>выходные</span></p>";
                    }

                    content += "</div>";

                    return content;
                }

                function getHintContent() {
                    return self.configs['company'].getTitle();
                }
            }
        };

        return Map;
    }

})(angular);