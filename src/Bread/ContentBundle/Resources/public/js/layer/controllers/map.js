(function (angular) {
    "use strict";

    angular
        .module('content.layer')
        .controller('MapCtrl', MapController);

    MapController.$inject = [
        'Map',
        'CompanyResource'
    ];

    function MapController (
        Map,
        CompanyResource
    ) {
        CompanyResource.query()
            .then(function (company) {
                var map = new Map();
                map
                    .setConfigs({
                        id: 'layer-map-block',
                        company: company
                    })
                    .load();
            });
    }

})(angular);