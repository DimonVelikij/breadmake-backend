(function (angular) {
    "use strict";

    angular
        .module('content.homepage')
        .controller('PopulationProductsCtrl', PopulationProductsController);

    PopulationProductsController.$inject = [
        '$scope',
        'PopulationProductResource',
        '_'
    ];

    function PopulationProductsController(
        $scope,
        PopulationProductResource,
        _
    ) {
        PopulationProductResource.query().then(function (products) {
            _.forEach(products, function (product) {
                console.log(product.getUnit().getTitle());
            });
        }, function (error) {
            console.log(error);
        });
    }

})(angular);