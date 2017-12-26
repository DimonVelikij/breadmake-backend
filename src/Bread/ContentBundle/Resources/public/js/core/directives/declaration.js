(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .directive('declaration', DeclarationDirective);

    DeclarationDirective.$inject = [];

    function DeclarationDirective () {
        return {
            restrict: 'E',
            templateUrl: 'declaration-directive.html',
            scope: {
                declaration: '=source'
            }
        };
    }

})(angular);