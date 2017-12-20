(function (angular) {
    "use strict";

    angular
        .module('content.about')
        .controller('AboutCtrl', AboutController);

    AboutController.$inject = [
        '$scope',
        'Map',
        'Layer',
        'Initializer',
        'CompanyResource'
    ];

    function AboutController(
        $scope,
        Map,
        Layer,
        Initializer,
        CompanyResource
    ) {
        $scope.load = true;

        CompanyResource.query()
            .then(function (company) {
                $scope.company = company;

                var map = new Map();
                map
                    .setConfigs({
                        id: 'about-map-block',
                        company: company
                    })
                    .load();
            })
            .finally(function () {
                $scope.load = false;
            });

        $scope.openFeedbackLayer = function (url) {
            Layer.open(url, $scope).then(function (response) {
                Layer.open(Initializer.Path.LayerThanks, $scope);
            }, function (error) {
                Layer.open(Initializer.Path.LayerError, $scope);
            });
        };
    }

})(angular);