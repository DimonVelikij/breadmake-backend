(function (angular) {
    "use strict";

    angular
        .module('content.layer')
        .controller('MapCtrl', MapController);

    MapController.$inject = [
        'Map'
    ];

    function MapController (
        Map
    ) {
        var map = new Map();
        map
            .setConfigs({id: 'layer-map-block'})
            .load();
    }

})(angular);