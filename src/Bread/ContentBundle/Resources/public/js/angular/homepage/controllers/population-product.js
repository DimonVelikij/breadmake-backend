(function (angular) {
    "use strict";

    angular
        .module('content.homepage')
        .controller('PopulationProductsCtrl', PopulationProductsController);

    PopulationProductsController.$inject = [
        '$scope',
        'PopulationProduct'
    ];

    function PopulationProductsController(
        $scope,
        PopulationProduct
    ) {

    }

})(angular);