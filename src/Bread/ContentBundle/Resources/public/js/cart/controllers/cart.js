(function (angular) {
    "use strict";

    angular
        .module('content.cart')
        .controller('CartCtrl', CartController);

    CartController.$inject = [
        '$scope',
        'FormHelper',
        'Initializer',
        'Request'
    ];

    function CartController(
        $scope,
        FormHelper,
        Initializer,
        Request
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
            Agree: null,
            Data: {
                Delivery: false,
                Address: null,
                PreferenceDate: null,
                CartContent: []
            }
        };

        $scope.submitOrder = function ($event, form) {
            $event.preventDefault();

            if ($scope.load) {
                return;
            }

            FormHelper.forceDirty(form);

            if (form.$invalid) {
                return;
            }

            $scope.load = true;

            var formData = {
                Type: 'order',
                Token: Initializer.Config.FormToken,
                Name: $scope.userData.Name,
                Phone: $scope.userData.Phone,
                Email: $scope.userData.Email,
                Agree: $scope.userData.Agree,
                Data: {
                    Delivery: $scope.userData.Data.Delivery,
                    Address: $scope.userData.Data.Delivery ? $scope.userData.Data.Address : null,
                    PreferenceDate: prepareDate($scope.userData.Data.PreferenceDate),
                    CartContent: []
                }
            };

            _.forEach($scope.cartList, function (cartItem) {
                formData.Data.CartContent.push({
                    ProductId: cartItem.Product.getId(),
                    Count: parseInt(cartItem.Count)
                });
            });

            Request.save(formData)
                .then(function (response) {
                    console.log(response);
                    //чистка корзины
                }, function (error) {

                })
                .finally(function () {
                    $scope.load = false;
                });
        };

        function prepareDate (date) {
            if (!date) {
                return null;
            }

            return date.substr(0, 2) + '.' + date.substr(2, 2) + '.' + date.substr(4, 4);
        }
    }

})(angular);