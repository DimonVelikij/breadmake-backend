(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('Flour', FlourFactory);

    FlourFactory.$inject = [
        'Entity'
    ];

    function FlourFactory(
        Entity
    ) {
        Entity.extend(Flour);

        function Flour(data) {
            this.Id = data.Id;
            this.Title = data.Title;
        }

        Flour.prototype.getId = function () {
            return this.Id;
        };

        Flour.prototype.getTitle = function () {
            return this.Title;
        };

        Flour.build = function (data) {
            return Entity.build(Flour, data);
        };

        return Flour;
    }

})(angular);