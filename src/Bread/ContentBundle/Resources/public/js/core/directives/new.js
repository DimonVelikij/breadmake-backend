(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .directive('new', NewDirective);

    NewDirective.$inject = [];

    function NewDirective () {
        return {
            restrict: 'E',
            templateUrl: 'new-directive.html',
            scope: {
                new: '=source'
            }
        };
    }

})(angular);