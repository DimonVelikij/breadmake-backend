(function (angular) {
    "use strict";

    angular
        .module('content.homepage')
        .service('PopulationProductResource', PopulationProductResourceService);

    PopulationProductResourceService.$inject = [
        'EntityResource',
        'Initializer',
        'Product',
        '_'
    ];

    function PopulationProductResourceService(
        EntityResource,
        Initializer,
        Product,
        _
    ) {
        function PopulationProductResource() {}

        var resource = new EntityResource();

        resource
            .setResourceUrl(Initializer.Routes.PopulationProduct)
            .setBuilder(function (data) {
                return _.map(data, Product.build);
            });

        return resource;
    }

})(angular);