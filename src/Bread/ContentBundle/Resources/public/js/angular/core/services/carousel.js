(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .service('Carousel', CarouselFactory);

    CarouselFactory.$inject = [
        '$timeout',
        '$interval',
        '_'
    ];

    function CarouselFactory(
        $timeout,
        $interval,
        _
    ) {
        function Carousel() {}

        Carousel.prototype.configs = {
            loop:true,
            margin:10,
            pagination: true,
            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            responsive:{
                0:{
                    items:1
                },
                480:{
                    items:1
                },
                760:{
                    items:1
                }
            }
        };

        Carousel.prototype.setConfigs = function (configs) {
            if (!_.isObject(configs)) {
                throw new Error('Настройки слайдера не являются объектом');
            }

            var self = this;

            _.forEach(configs, function (configValue, configName) {
                if (configName in self.configs) {
                    self.configs[configName] = configValue;
                }
            });

            return this;
        };

        Carousel.prototype.init = function () {
            var self = this;
            $timeout(function () {
                angular.element('.owl-carousel').owlCarousel(self.configs);
            });
        };

        return new Carousel;
    }

})(angular);