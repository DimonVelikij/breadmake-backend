(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('Unit', UnitFactory);

    UnitFactory.$inject = [
        'Entity'
    ];

    function UnitFactory(
        Entity
    ) {
        Entity.extend(Unit);

        function Unit(data) {
            this.Id = data.Id;
            this.Title = data.Title;
        }

        Unit.prototype.getId = function () {
            return this.Id;
        };

        Unit.prototype.getTitle = function () {
            return this.Title;
        };

        Unit.build = function (data) {
            return Entity.build(Unit, data);
        };

        return Unit;
    }

})(angular);