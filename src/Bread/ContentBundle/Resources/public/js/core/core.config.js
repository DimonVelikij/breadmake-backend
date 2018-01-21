(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .config(config);

    config.$inject = [
        '$interpolateProvider',
        '$resourceProvider',
        '$locationProvider'
    ];

    function config(
        $interpolateProvider,
        $resourceProvider,
        $locationProvider
    ) {
        $interpolateProvider
            .startSymbol('[[')
            .endSymbol(']]');

        $resourceProvider.defaults.stripTrailingSlashes = false;

        $locationProvider
            .html5Mode({
                enabled: true,
                requireBase: false,
                rewriteLinks: false
            });

        $locationProvider.hashPrefix('!');
    }

})(angular);