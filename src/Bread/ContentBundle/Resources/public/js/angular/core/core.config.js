(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .config(config);

    config.$inject = [
        '$interpolateProvider'
    ];

    function config(
        $interpolateProvider
    ) {
        $interpolateProvider
            .startSymbol('[[')
            .endSymbol(']]');
    }

})(angular);