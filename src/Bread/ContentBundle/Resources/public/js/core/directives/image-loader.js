(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .directive('imageLoader', ImageLoaderDirective);

    ImageLoaderDirective.$inject = [
        '$timeout'
    ];

    function ImageLoaderDirective(
        $timeout
    ) {
        return {
            restrict: 'A',
            scope: true,
            link: function (scope, elem, attr) {
                scope.imageLoad = true;

                $timeout(function () {
                    var image = elem[0];
                    image.src = image.getAttribute('data-src');
                    image.onload = function () {
                        image.removeAttribute('data-src');
                        scope.imageLoad = false;
                        scope.$digest();
                    };
                });
            }
        };
    }

})(angular);