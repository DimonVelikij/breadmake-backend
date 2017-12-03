(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .filter('weight', WeightFilter);

    WeightFilter.$inject = [];

    function WeightFilter () {
        return function (weight) {
            if (
                !weight ||
                typeof weight != 'number'
            ) {
                return 0;
            }

            return weight.toFixed(3);
        }
    }

})(angular);