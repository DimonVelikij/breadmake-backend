(function (angular) {
    "use strict";

    angular
        .module('content.homepage')
        .controller('HomepageCtrl', HomepageController);

    HomepageController.$inject = [
        '$scope',
        '$q',
        'ProductResource',
        'SlideResource',
        'Carousel'
    ];

    function HomepageController(
        $scope,
        $q,
        ProductResource,
        SlideResource,
        Carousel
    ) {
        $scope.load = true;

        $q.all([
            ProductResource.queryPopulation(),
            SlideResource.query()
        ])
            .then(function (response) {
                $scope.products = response[0];
                $scope.slides = response[1];

                if ($scope.slides.length) {
                    Carousel.init();
                }
            }, function () {
                $scope.dataLoadError = true;
            })
            .finally(function () {
                $scope.load = false;
            });
    }

})(angular);