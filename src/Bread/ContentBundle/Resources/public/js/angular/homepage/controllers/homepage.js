(function (angular) {
    "use strict";

    angular
        .module('content.homepage')
        .controller('PopulationProductsCtrl', PopulationProductsController);

    PopulationProductsController.$inject = [
        '$scope'
    ];

    function PopulationProductsController($scope) {
        console.log('population products');
    }

})(angular);