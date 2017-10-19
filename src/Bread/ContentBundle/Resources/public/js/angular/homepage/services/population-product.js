(function (angular) {
    "use strict";

    angular
        .module('content.homepage')
        .service('PopulationProduct', PopulationProductService);

    PopulationProductService.$inject = [
        'EntityResource'
    ];
    
    function PopulationProductService(
        EntityResource
    ) {
        function PopulationProduct() {}

        var resource = new EntityResource();

        resource
            .setResourceUrl('test');

        return resource;
    }

})(angular);