(function (angular) {
    "use strict";

    angular
        .module('content.product')
        .controller('ProductCtrl', ProductController);

    ProductController.$inject = [
        '$scope',
        'ProductResource',
        'FilterBuilder',
        'ProductFilterConfiguration'
    ];

    function ProductController (
        $scope,
        ProductResource,
        FilterBuilder,
        ProductFilterConfiguration
    ) {
        $scope.load = true;

        /**
         * натсройка фильтра
         */
        $scope.filterStorage = FilterBuilder
            .setFilterConfiguration(ProductFilterConfiguration)
            .setDefaultFilterData({
                category: 'all',
                unit: 'all',
                flour: 'all'
            })
            .setWatchVariable('filterValue')
            .init($scope);

        ProductResource.query()
            .then(function (products) {
                $scope.filterStorage
                    .setData(products)
                    .preFilter();
            }, function () {
                $scope.dataLoadError = true;
            })
            .finally(function () {
                $scope.load = false;
            });
    }

})(angular);
