(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .directive('cartItem', CartItemDirective);

    CartItemDirective.$inject = [
        '$rootScope'
    ];

    function CartItemDirective (
        $rootScope
    ) {
        return {
            restrict: 'E',
            templateUrl: 'cart-item-directive.html',
            scope: {
                cartItem: '=source'
            },
            link: function (scope, elem, attr) {
                scope.removeItemCart = function (product) {
                    $rootScope.$broadcast("$removeItemCart", {
                        Product: product
                    });
                    product.setIsInCart(false);
                };

                scope.$watch('cartItem.Count', function (newCount) {
                    if (isNaN(parseInt(newCount))) {
                        scope.cartItem.Count = '';
                        return;
                    }

                    $rootScope.$broadcast("$updateCart", {
                        Product: scope.cartItem.Product,
                        Count: newCount
                    });
                });

                scope.incrementCount = function (cartItem) {
                    cartItem.Count = isNaN(parseInt(cartItem.Count)) ? 1 : parseInt(cartItem.Count) + 1;

                };

                scope.decrementCount = function (cartItem) {
                    if (parseInt(cartItem.Count) > 1) {
                        cartItem.Count = parseInt(cartItem.Count) - 1;
                    }
                };
            }
        };
    }

})(angular);