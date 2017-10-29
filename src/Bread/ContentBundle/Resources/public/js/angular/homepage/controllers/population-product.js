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
        PopulationProductResource.query().then(function (products) {
            $scope.products = products;
        }, function () {
            $scope.populationProductsLoadError = true;
        });
    }

})(angular);