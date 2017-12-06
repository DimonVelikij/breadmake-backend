(function (angular) {
    "use strict";

    angular
        .module('content.about')
        .controller('AboutCtrl', AboutController);

    AboutController.$inject = [
        '$scope',
        'Map',
        'Layer'
    ];

    function AboutController(
        $scope,
        Map,
        Layer
    ) {
        var map = new Map();
        map.setConfigs({id: 'about-map-block'})
            .load();

        $scope.openFeedbackLayer = function (url) {
            Layer.open(url, $scope);
        }
    }

})(angular);