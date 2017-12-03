(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .controller('CoreCtrl', CoreController);

    CoreController.$inject = [
        '$scope',
        'CartResource',
        '_',
        'FormHelper',
        'Initializer',
        'Request',
        'Layer'
    ];
    
    function CoreController(
        $scope,
        CartResource,
        _,
        FormHelper,
        Initializer,
        Request,
        Layer
    ) {
        //выдвигашка корзины на адаптиве
        angular.element('#header-cart').hover(
            function () {
                $(this).stop().animate({
                    right: '0'
                }, 700, 'easeInSine');
            },
            function () {
                $(this).stop().animate({
                    right: '-230px'
                }, 700, 'easeOutBounce');
            }
        );

        //галерея
        angular.element("[data-fancybox]").fancybox();

        //раскрывашка меню юзеров
        $scope.toggleUserMenu = function () {
            angular.element(".user-links").slideToggle();
        };

        //раскрывашка основного меню
        $scope.toggleMenu = function () {
            angular.element(".menu").slideToggle();
        };

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

        $scope.loadFooterMap = function (url) {
            Layer.open(url, $scope);
        };

        $scope.userData = {
            Name: null,
            Phone: null,
            Data: {
                Comment: null
            },
            Agree: null
        };

        $scope.submitFeedback = function ($event, form) {
            $event.preventDefault();

            FormHelper.forceDirty(form);

            if (form.$invalid) {
                return;
            }

            $scope.feedbackRequestSending = true;

            var formData = $scope.userData;
            formData['Type'] = 'feedback';
            formData['Token'] = Initializer.Config.FormToken;

            Request.save(formData)
                .then(function (response) {
                    if (response.success) {
                        $scope.feedbackRequestSend = true;
                    } else {
                        if (!response.errors) {
                            $scope.feedbackRequestSendError = true;
                        }
                        _.forEach(response.errors, function (message, fieldName) {
                            $scope.feedback[fieldName].errorMessages = {
                                backend: message
                            };
                            $scope.feedback[fieldName].$setValidity('backend', false);
                        });
                    }
                })
                .finally(function () {
                    $scope.feedbackRequestSending = false;
                });
        };
    }

})(angular);