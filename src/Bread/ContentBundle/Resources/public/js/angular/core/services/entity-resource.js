(function (angular) {
    "use strict";
    
    angular
        .module('content.core')
        .service('EntityResource', EntityResourceService);

    EntityResourceService.$inject = [
        '$resource',
        '$q'
    ];

    function EntityResourceService(
        $resource,
        $q
    ) {

        function EntityResource() {}

        EntityResource.prototype.resourceUrl = null;
        EntityResource.prototype.builder = null;

        EntityResource.prototype.setResourceUrl = function (resourceUrl) {
            this.resourceUrl = resourceUrl;

            return this;
        };

        EntityResource.prototype.setBuilder = function (builder) {
            this.builder = builder;

            return this;
        };

        EntityResource.prototype.getResource = function () {
            if (!this.resourceUrl) {
                throw new Error('Не указан url, куда делать запрос');
            }

            return $resource(this.resourceUrl, null, {
                method: 'GET',
                isArray: true,
                cache: true
            });
        };
        
        EntityResource.prototype.query = function (params) {
            params = params || {};

            var defer = $q.defer(),
                self = this;

            var response = this.getResource().query(params);

            response.$promise.then(function (data) {
                defer.resolve(self.builder(data));
            }, function () {
                defer.reject('Ошибка загрузки данных');
            });

            return defer.promise;
        };

        return EntityResource;
    }
    
})(angular);