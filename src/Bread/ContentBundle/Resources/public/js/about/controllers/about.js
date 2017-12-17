(function (angular) {
    "use strict";

    angular
        .module('content.about')
        .controller('AboutCtrl', AboutController);

    AboutController.$inject = [
        '$scope',
        'Map',
        'Layer',
        'Initializer'
    ];

    function AboutController(
        $scope,
        Map,
        Layer,
        Initializer
    ) {
        var map = new Map();
        map.setConfigs({id: 'about-map-block'})
            .load();

        $scope.openFeedbackLayer = function (url) {
            Layer.open(url, $scope).then(function (response) {
                Layer.open(Initializer.Path.LayerThanks, $scope);
            }, function (error) {
                Layer.open(Initializer.Path.LayerError, $scope);
            });
        };
    }

})(angular);