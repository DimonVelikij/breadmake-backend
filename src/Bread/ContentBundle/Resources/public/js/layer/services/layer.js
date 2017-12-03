(function (angular) {
    "use strict";

    angular
        .module('content.layer')
        .service('Layer', LayerService);

    LayerService.$inject = [
        '$http',
        '$compile'
    ];

    function LayerService(
        $http,
        $compile
    ) {
        function Layer () {}

        Layer.prototype.open  = function (url, scope) {
            $http.get(url).then(function (response) {
                var html = response.data,
                    layer = angular.element('#layer');
                layer.html($compile(html)(scope));
            });
        };

        return new Layer;
    }
})(angular);