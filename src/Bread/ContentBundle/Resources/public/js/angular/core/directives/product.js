(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .directive('product', ProductDirective);

    ProductDirective.$inject = [];

    function ProductDirective () {
        return {
            restrict: 'E',
            templateUrl: 'css/product.html'
        };
    }

})(angular);