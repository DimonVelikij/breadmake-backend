(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .config(config);

    config.$inject = [
        '$interpolateProvider',
        '$resourceProvider'
    ];

    function config(
        $interpolateProvider,
        $resourceProvider
    ) {
        $interpolateProvider
            .startSymbol('[[')
            .endSymbol(']]');

        $resourceProvider.defaults.stripTrailingSlashes = false;
    }

})(angular);