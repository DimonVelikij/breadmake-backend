(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('_', ['$window', function ($window) {
            return $window._;
        }])

})(angular);