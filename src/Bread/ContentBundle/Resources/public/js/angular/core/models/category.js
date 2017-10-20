(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('Category', CategoryFactory);

    CategoryFactory.$inject = [
        'Entity'
    ];

    function CategoryFactory(
        Entity
    ) {
        Entity.extend(Category);

        function Category(data) {
            this.Id = data.Id;
            this.Title = data.Title;
        }

        Category.prototype.getId = function () {
            return this.Id;
        };

        Category.prototype.getTitle = function () {
            return this.Title;
        };

        Category.build = function (data) {
            return Entity.build(Category, data);
        };

        return Category;
    }

})(angular);