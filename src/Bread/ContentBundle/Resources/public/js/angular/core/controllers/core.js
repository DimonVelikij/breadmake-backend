(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .controller('CoreCtrl', CoreController);

    CoreController.$inject = [
        '$scope',
        'CartResource',
        '_'
    ];
    
    function CoreController(
        $scope,
        CartResource,
        _
    ) {
        $scope.cartError = false;
        $scope.cartLoad = true;

        function calcCart(cart) {
            $scope.cartSum = 0;
            $scope.cart = cart;

            _.forEach(cart, function (cartItem) {
                $scope.cartSum += (cartItem.getPrice() * 100 * cartItem.getCount()) / 100;
            });

            $scope.cartSum = $scope.cartSum.toFixed(2);
        }

        CartResource.query()
            .then(function (cart) {
                calcCart(cart);
            }, function () {
                $scope.cart = [];
            })
            .finally(function () {
                $scope.cartLoad = false;
            });

        $scope.$on('$updateCart', function (event, args) {
            $scope.cartLoad = true;

            CartResource.update(args)
                .then(function (response) {
                    calcCart(response.data);
                }, function () {
                    $scope.cartError = 'Ошибка добавления товара';
                })
                .finally(function () {
                    $scope.cartLoad = false;
                });
        });
        
        $scope.$on('$removeItemCart', function (event, args) {
            $scope.cartLoad = true;

            CartResource.delete(args)
                .then(function (response) {
                    calcCart(response.data);
                }, function () {
                    $scope.cartError = 'Ошибка удалеия товара';
                })
                .finally(function () {
                    $scope.cartLoad = false;
                });
        });
    }

})(angular);