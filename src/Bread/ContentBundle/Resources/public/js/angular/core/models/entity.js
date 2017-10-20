(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('Entity', EntityFactory);

    EntityFactory.$inject = [];

    function EntityFactory() {

        function Entity() {}

        Entity.extend = function (Child) {
            Child.prototype = Object.create(Entity.prototype);
            Object.assign(Child, Entity);
            Child.objectPool = {};
        };

        Entity.getPoolKey = function (data) {
            return data.Id;
        };

        Entity.findInPool = function (constructor, key) {
            return constructor.objectPool[key];
        };

        Entity.build = function (constructor, data) {
            var poolKey = constructor.getPoolKey(data),
                pool = constructor.objectPool;

            if (!(poolKey in pool)) {
                pool[poolKey] = new constructor(data);
            }

            return pool[poolKey];
        };

        return Entity;
    }

})(angular);