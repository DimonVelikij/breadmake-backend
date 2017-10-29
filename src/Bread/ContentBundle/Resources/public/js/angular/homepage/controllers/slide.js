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
        SlideResource.query().then(function (slides) {
            $scope.slides = slides;
            Carousel.init();
        }, function () {

        });
    }

})(angular);