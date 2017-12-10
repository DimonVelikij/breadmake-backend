(function (angular) {
    "use strict";

    angular
        .module('content.layer')
        .service('Layer', LayerService);

    LayerService.$inject = [
        '$http',
        '$compile',
        '$q'
    ];

    function LayerService(
        $http,
        $compile,
        $q
    ) {
        function Layer () {}

        Layer.prototype.load = angular.element('#load');//лоадер
        Layer.prototype.close = null;//крестик закрытия, доступен после загрузки слоя
        Layer.prototype.background = null;//фон

        Layer.prototype.open  = function (url, scope) {
            var defer = $q.defer();

            scope.load = true;

            var self = this;

            $http.get(url)
                .then(function (response) {
                    var html = response.data,
                        layer = angular.element('#layer');

                    layer.html($compile(html)(scope));

                    self.close = angular.element('#layer-close');
                    self.background = angular.element('#layer-background');

                    self.background.bind('click', function () {
                        layer.html('');
                    });
                    self.close.bind('click', function () {//закрываем слой
                        layer.html('');
                    });

                    defer.resolve(true);
                })
                .finally(function () {
                    scope.load = false;
                });

            return defer.promise;
        };

        return new Layer;
    }
})(angular);