(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .filter('price', PriceFilter);

    PriceFilter.$inject = [];

    function PriceFilter () {
        return function (price) {
            if (
                !price ||
                typeof price != 'number'
            ) {
                return 0;
            }

            return price.toFixed(2);
        }
    }

})(angular);