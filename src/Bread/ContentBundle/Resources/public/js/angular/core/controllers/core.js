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
        $scope.cartLoad = true;

        CartResource.query()
            .then(function (cart) {
                $scope.cart = cart;

                $scope.cartSum = 0;
                if (cart.length) {
                    _.forEach(cart, function (cartItem) {
                        $scope.cartSum += (cartItem.getPrice() * 10 * cartItem.getCount()) / 10;
                    });
                }
                $scope.cartSum = $scope.cartSum.toFixed(2);

            }, function () {
                $scope.cart = [];
            })
            .finally(function () {
                $scope.cartLoad = false;
            })
        ;

        $scope.$on('updateCart', function (event, args) {
            console.log(event, args);
        });
    }

})(angular);