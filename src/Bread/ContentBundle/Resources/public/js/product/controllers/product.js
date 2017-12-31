(function (angular) {
    "use strict";

    angular
        .module('content.product')
        .controller('ProductCtrl', ProductController);

    ProductController.$inject = [
        '$scope',
        'ProductResource'
    ];

    function ProductController (
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
