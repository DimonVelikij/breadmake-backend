(function (angular) {
    "use strict";

    angular
        .module('content.layer')
        .factory('Layer', LayerFactory);

    LayerFactory.$inject = [
        '$http',
        '$compile',
        '$q'
    ];

    function LayerFactory(
        $http,
        $compile,
        $q
    ) {
        return {
            open: open,
            close: close
        };

        function isOpenLayer(isOpen) {
            var body = angular.element('body');

            if (isOpen) {
                body.addClass('modal');
            } else {
                body.removeClass('modal');
            }
        }

        function open(url, scope) {
            var defer = $q.defer();

            scope.load = true;

            angular.extend(scope, {
                Layer: {
                    ok: function (data) {
                        defer.resolve(data);
                        close();
                    },
                    cancel: function (data) {
                        defer.reject(data);
                        close();
                    }
                }
            });

            $http.get(url).then(function (response) {
                isOpenLayer(true);
                var html = response.data,
                    $layer = angular.element('#layer');

                $layer.html($compile(html)(scope));

                angular.element('#layer-close').bind('click', function () {
                    $layer.html('');
                    isOpenLayer(false);
                });

            }).finally(function () {
                scope.load = false;
            });

            return defer.promise;
        }

        function close() {
            angular.element('#layer-close').click();
            isOpenLayer(false);
        }
    }

})(angular);