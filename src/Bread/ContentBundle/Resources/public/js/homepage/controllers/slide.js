(function (angular) {
    "use strict";

    angular
        .module('content.homepage')
        .controller('SlideCtrl', SlideController);

    SlideController.$inject = [
        '$scope',
        'SlideResource',
        'Carousel'
    ];

    function SlideController(
        $scope,
        SlideResource,
        Carousel
    ) {
        $scope.slideLoad = true;

        SlideResource.query()
            .then(function (slides) {
                $scope.slides = slides;
                Carousel.init();
            })
            .finally(function () {
                $scope.slideLoad = false;
            })
        ;
    }

})(angular);