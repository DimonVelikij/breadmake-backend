(function (angular) {
    "use strict";

    angular
        .module('content.cart')
        .controller('CartCtrl', CartController);

    CartController.$inject = [
        '$scope',
        'FormHelper',
        'Initializer'
    ];

    function CartController(
        $scope,
        FormHelper,
        Initializer
    ) {
        $scope.load = true;

        $scope.$on('$cartContent', function (event, args) {
            $scope.cartList = args.Cart;
            $scope.cartSum = args.CartSum;

            $scope.load = false;
        });

        $scope.userData = {
            Name: null,
            Phone: null,
            Email: null,
            Date: null,
            Delivery: false,
            Agree: null,
            Data: {
                CartContent: []
            }
        };

        $scope.submitOrder = function ($event, form) {
            $event.preventDefault();

            FormHelper.forceDirty(form);

            if (form.$invalid) {
                return;
            }

            var formData = $scope.userData;
            formData['Type'] = 'order';
            _.forEach($scope.cartList, function (cartItem) {
                formData.Data.CartContent.push({
                    ProductId: cartItem.Product.getId(),
                    Count: parseInt(cartItem.Count)
                });
            });

            //отправка данных
            
            //чистка корзины
        };
    }

})(angular);