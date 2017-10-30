(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .directive('slide', SlideDirective);

    SlideDirective.$inject = [];

    function SlideDirective () {
        return {
            restrict: 'E',
            templateUrl: 'slide-directive.html',
            scope: {
                slide: '=source'
            }
        };
    }

})(angular);