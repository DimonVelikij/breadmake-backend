(function (angular) {
    "use strict";

    angular
        .module('content.layer')
        .controller('LayerCtrl', LayerController);

    LayerController.$inject = [
        '$scope'
    ];

    function LayerController (
        $scope
    ) {
        $scope.closeLayer = function () {
            $scope.layerClosed = true;
        }
    }

})(angular);