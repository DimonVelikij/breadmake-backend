(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('Cart', CartFactory);

    CartFactory.$inject = [
        'Entity'
    ];

    function CartFactory(
        Entity
    ) {
        Entity.extend(Cart);

        Cart.getPoolKey = function (data) {
            return data.ProductId;
        };

        function Cart(data) {
            this.ProductId = data.ProductId;
            this.Price = data.Price;
            this.Count = data.Count;
        }

        Cart.prototype.getProductId = function () {
            return this.ProductId;
        };

        Cart.prototype.getPrice = function () {
            return parseFloat(this.Price).toFixed(2);
        };

        Cart.prototype.getCount = function () {
            return this.Count;
        };

        Cart.build = function (data) {
            return Entity.build(Cart, data);
        };

        return Cart;
    }

})(angular);