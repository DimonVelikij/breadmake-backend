(function (angular) {
    "use strict";
    
    angular
        .module('content.core')
        .service('EntityResource', EntityResourceService);

    EntityResourceService.$inject = [
    ];

    function EntityResourceService(
        $http
    ) {

        function EntityResource() {}

        EntityResource.prototype.resourceUrl = null;

        EntityResource.prototype.setResourceUrl = function (resourceUrl) {
            this.resourceUrl = resourceUrl;

            return this;
        };

        return EntityResource;
    }
    
})(angular);