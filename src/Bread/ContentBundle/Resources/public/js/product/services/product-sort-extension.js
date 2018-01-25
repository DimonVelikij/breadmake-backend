(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('ProductSortExtension', ProductSortExtensionFactory);

    ProductSortExtensionFactory.$inject = [

    ];

    function ProductSortExtensionFactory(

    ) {
        return {
            extend: extend
        };

        function extend(Sort) {
            
        }
    }

})(angular);