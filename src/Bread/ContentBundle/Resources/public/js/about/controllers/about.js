(function (angular) {
    "use strict";

    angular
        .module('content.about')
        .controller('AboutCtrl', AboutController);

    AboutController.$inject = [
        '$scope'
    ];

    function AboutController(
        $scope
    ) {
        $scope.openFeedbackLayer = function () {
            
        }
    }

})(angular);