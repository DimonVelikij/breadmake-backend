(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .service('Request', RequestService);

    RequestService.$inject = [
        'EntityResource',
        'Initializer',
        '_'
    ];

    function RequestService(
        EntityResource,
        Initializer,
        _
    ) {
        function Request() {}

        var resource = new EntityResource();

        resource
            .setResourceUrl(Initializer.Path.RequestResource)
            .setBuilder(function (data) {
                return data;
            });

        return resource;
    }

})(angular);