(function (angular) {
    "use strict";

    angular
        .module('content.product')
        .controller('ProductCtrl', ProductController);

    ProductController.$inject = [
        '$scope',
        'ProductResource',
        'FilterBuilder',
        'ProductFilterConfiguration',
        'ProductFilterExtension'
    ];

    function ProductController (
        $scope,
        ProductResource,
        FilterBuilder,
        ProductFilterConfiguration,
        ProductFilterExtension
    ) {
        $scope.load = true;

        var filterBuilder = FilterBuilder
            .create()
            .setFilterConfiguration(ProductFilterConfiguration)
            .extend({
                filter: ProductFilterExtension
            })
            .addFilterFields(['category', 'unit', 'flour', 'minPrice', 'maxPrice']);

        $scope.storage = filterBuilder.createStorage();

        $scope.$on("slideEnded", function(data) {
            var minPrice = data.targetScope.rzSliderModel,
                maxPrice = data.targetScope.rzSliderHigh;

            $scope.storage.filter.minPrice = minPrice;
            $scope.storage.filter.maxPrice = maxPrice;
            $scope.storage.filter.filter().then(function (response) {});
        });

        ProductResource.query()
            .then(function (products) {
                $scope.storage.setData(products);
            }, function () {
                $scope.dataLoadError = true;
            })
            .finally(function () {
                $scope.load = false;
            });
    }

})(angular);
