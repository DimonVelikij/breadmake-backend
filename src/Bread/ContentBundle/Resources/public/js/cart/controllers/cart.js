(function (angular) {
    "use strict";

    angular
        .module('content.cart')
        .controller('CartCtrl', CartController);

    CartController.$inject = [];

    function CartController(

    ) {
        console.log(1);
    }

})(angular);