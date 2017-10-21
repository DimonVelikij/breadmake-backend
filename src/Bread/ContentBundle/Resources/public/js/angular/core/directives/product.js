(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .directive('product', ProductDirective);

    ProductDirective.$inject = [];

    function ProductDirective () {
        return {
            restrict: 'E',
            templateUrl: 'product-directive.html'
        };
    }

})(angular);