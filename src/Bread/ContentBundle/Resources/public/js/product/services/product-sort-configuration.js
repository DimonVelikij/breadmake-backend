(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('ProductSortConfiguration', ProductSortConfiguration);

    ProductSortConfiguration.$inject = [

    ];

    function ProductSortConfiguration(

    ) {
        return {
            'price': {
                // defaultValue: 'desc'
            }
        };
    }

})(angular);