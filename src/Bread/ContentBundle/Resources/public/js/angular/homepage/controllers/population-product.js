(function (angular) {
    "use strict";

    angular
        .module('content.homepage')
        .controller('PopulationProductCtrl', PopulationProductController);

    PopulationProductController.$inject = [
        '$scope',
        'PopulationProductResource'
    ];

    function PopulationProductController(
        $scope,
        PopulationProductResource
    ) {
        $scope.productLoad = true;
        
        PopulationProductResource.query()
            .then(function (products) {
                $scope.products = products;
            }, function () {
                $scope.populationProductsLoadError = true;
            })
            .finally(function () {
                $scope.productLoad = false;
            })
        ;
    }

})(angular);