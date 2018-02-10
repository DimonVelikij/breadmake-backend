(function (angular) {
    "use strict";

    angular
        .module('content.cart')
        .controller('CartCtrl', CartController);

    CartController.$inject = [
        '$scope'
    ];

    function CartController(
        $scope
    ) {
        $scope.load = true;

        $scope.$on('$cartContent', function (event, args) {
            $scope.cartList = args.Cart;
            $scope.cartSum = args.CartSum;

            $scope.load = false;
        });
    }

})(angular);