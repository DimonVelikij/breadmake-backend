(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .directive('product', ProductDirective);

    ProductDirective.$inject = [
        '$rootScope'
    ];

    function ProductDirective (
        $rootScope
    ) {
        return {
            restrict: 'E',
            templateUrl: 'product-directive.html',
            scope: true,
            link: function (scope, elem, attr) {
                scope.cartCount = undefined;

                scope.$watch('cartCount', function (newCartCount, oldCartCount) {
                    if (
                        typeof newCartCount != 'undefined' &&
                        !/^\d{0,3}$/.test(newCartCount)
                    ) {
                        scope.cartCount = oldCartCount;

                        return;
                    }

                    scope.cartCount = isNaN(parseInt(scope.cartCount)) ?
                        undefined :
                        parseInt(scope.cartCount)
                    ;
                });

                scope.addCartCount = function () {
                    scope.cartCount = typeof scope.cartCount == 'undefined' ? 1 : scope.cartCount += 1;
                };

                scope.reduceCartCount = function () {
                    if (typeof scope.cartCount != 'number') {
                        return;
                    }

                    scope.cartCount--;

                    if (!scope.cartCount) {
                        scope.cartCount = undefined;
                    }
                };

                scope.updateCart = function () {
                    $rootScope.$broadcast("$updateCart", {
                        Product: scope.product,
                        Count: scope.cartCount
                    });
                    scope.product.setIsInCart(true);
                };

                scope.removeItemCart = function () {
                    $rootScope.$broadcast("$removeItemCart", {
                        Product: scope.product
                    });
                    scope.product.setIsInCart(false);
                    scope.cartCount = undefined;
                };
            }
        };
    }

})(angular);