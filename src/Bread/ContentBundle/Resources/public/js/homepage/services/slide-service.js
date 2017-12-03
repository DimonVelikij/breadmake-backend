(function (angular) {
    "use strict";

    angular
        .module('content.homepage')
        .service('SlideResource', SlideResourceService);

    SlideResourceService.$inject = [
        'EntityResource',
        'Initializer',
        'Slide',
        '_'
    ];

    function SlideResourceService(
        EntityResource,
        Initializer,
        Slide,
        _
    ) {
        function SlideResource() {}

        var resource = new EntityResource();

        resource
            .setResourceUrl(Initializer.Path.SlideResource)
            .setBuilder(function (data) {
                return _.map(data, Slide.build);
            });

        return resource;
    }

})(angular);