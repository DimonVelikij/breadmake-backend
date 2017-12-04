(function (angular) {
    "use strict";

    angular
        .module('content.about')
        .controller('AboutCtrl', AboutController);

    AboutController.$inject = [
        '$scope',
        'Map'
    ];

    function AboutController(
        $scope,
        Map
    ) {
        var map = new Map();
        map.setConfigs({id: 'about-map-block'})
            .load();

        $scope.openFeedbackLayer = function () {
            
        }
    }

})(angular);