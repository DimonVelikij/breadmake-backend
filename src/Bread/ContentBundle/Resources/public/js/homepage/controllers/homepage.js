(function (angular) {
    "use strict";

    angular
        .module('content.homepage')
        .controller('HomepageCtrl', HomepageController);

    HomepageController.$inject = [
        '$scope',
        '$q',
        'PopulationProductResource',
        'SlideResource',
        'Carousel'
    ];

    function HomepageController(
        $scope,
        $q,
        PopulationProductResource,
        SlideResource,
        Carousel
    ) {
        $scope.load = true;

        $q.all([
            PopulationProductResource.query(),
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