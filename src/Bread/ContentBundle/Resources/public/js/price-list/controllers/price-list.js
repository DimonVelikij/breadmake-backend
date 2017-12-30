(function (angular) {
    "use strict";

    angular
        .module('content.price-list')
        .controller('PriceListCtrl', PriceListController);

    PriceListController.$inject = [
        '$scope',
        'ProductResource'
    ];

    function PriceListController (
        $scope,
        ProductResource
    ) {
        $scope.load = true;
        
        ProductResource.query()
            .then(function (products) {
                $scope.products = products;
            }, function () {
                $scope.dataLoadError = true;
            })
            .finally(function () {
                $scope.load = false;
            });
    }

})(angular);