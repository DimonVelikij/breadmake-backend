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
        EntityResource.prototype.defaultParams = null;
        EntityResource.prototype.builder = null;

        EntityResource.prototype.setResourceUrl = function (resourceUrl) {
            this.resourceUrl = resourceUrl;

            return this;
        };

        EntityResource.prototype.setDefaultParams = function (defaultParams) {
            this.defaultParams = defaultParams;

            return this;
        };

        EntityResource.prototype.setBuilder = function (builder) {
            this.builder = builder;

            return this;
        };
        
        EntityResource.prototype.query = function (params) {
            if (!this.resourceUrl) {
                throw new Error('Не указан url, куда делать запрос');
            }

            var queryParams = {
                method: 'GET',
                isArray: true,
                cache: true
            };

            params = params || {};

            var defer = $q.defer(),
                self = this,
                response = $resource(
                    this.resourceUrl,
                    null,
                    queryParams
                ).query(params);

            response.$promise.then(function (data) {
                defer.resolve(self.builder(data));
            }, function () {
                defer.reject('Ошибка загрузки данных');
            });

            return defer.promise;
        };
        
        EntityResource.prototype.get = function (params) {
            if (!this.resourceUrl) {
                throw new Error('Не указан url, куда делать запрос');
            }

            if (!this.defaultParams) {
                throw new Error('Не указаны параметры для шаблона запроса');
            }

            var defer = $q.defer(),
                self = this,
                response = $resource(this.resourceUrl, this.defaultParams).get(params);

            response.$promise.then(function (data) {
                defer.resolve(self.builder(data));
            }, function () {
                defer.reject('Ошибка загрузки данных');
            });

            return defer.promise;
        };

        EntityResource.prototype.save = function (object) {
            if (!this.resourceUrl) {
                throw new Error('Не указан url, куда делать запрос');
            }

            if (!object) {
                throw new Error('Не указан объект для сохранеия');
            }

            var defer = $q.defer(),
                self = this,
                response = $resource(this.resourceUrl).save(object);

            response.$promise.then(function (data) {
                defer.resolve(self.builder(data));
            }, function () {
                defer.reject('Ошибка сохранеия объекта');
            });

            return defer.promise;
        };

        EntityResource.prototype.update = function (object) {
            if (!this.resourceUrl) {
                throw new Error('Не указан url, куда делать запрос');
            }

            if (!this.defaultParams) {
                throw new Error('Не указаны параметры для шаблона запроса');
            }

            if (!object) {
                throw new Error('Не указан объект для сохранеия');
            }

            var defer = $q.defer(),
                self = this,
                response = $resource(this.resourceUrl, this.defaultParams, {
                    update: {
                        method: 'PUT'
                    }
                }).update(object);

            response.$promise.then(function (data) {
                defer.resolve(self.builder(data));
            }, function () {
                defer.reject('Ошибка обновления объекта');
            });

            return defer.promise;
        };

        EntityResource.prototype.delete = function (object) {
            if (!this.resourceUrl) {
                throw new Error('Не указан url, куда делать запрос');
            }

            if (!this.defaultParams) {
                throw new Error('Не указаны параметры для шаблона запроса');
            }

            if (!object) {
                throw new Error('Не указан объект для сохранеия');
            }

            var defer = $q.defer(),
                response = $resource(this.resourceUrl, this.defaultParams).delete(object);

            response.$promise.then(function () {
                defer.resolve(true);
            }, function () {
                defer.reject('Ошибка удаления объекта');
            });

            return defer.promise;
        };

        return EntityResource;
    }
    
})(angular);