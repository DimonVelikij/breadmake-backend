(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('Product', ProductFactory);

    ProductFactory.$inject = [
        'Entity',
        'Category',
        'Flour',
        'Unit'
    ];

    function ProductFactory(
        Entity,
        Category,
        Flour,
        Unit
    ) {
        Entity.extend(Product);

        function Product(data) {
            this.Id = data.Id;
            this.Title = data.Title;
            this.Description = data.Description;
            this.Price = data.Price;
            this.Weight = data.Weight;
            this.IsNew = data.IsNew;
            this.IsPopulation = data.IsPopulation;
            if (data.Category) {
                this.Category = Category.build.call(this, data.Category);
            }
            if (data.Flour) {
                this.Flour = Flour.build.call(this, data.Flour);
            }
            if (data.Unit) {
                this.Unit = Unit.build.call(this, data.Unit);
            }
        }

        Product.prototype.getId = function () {
            return this.Id;
        };

        Product.prototype.getTitle = function () {
            return this.Title;
        };

        Product.prototype.getDescription = function () {
            return this.Description;
        };

        Product.prototype.getPrice = function () {
            return this.Price;
        };

        Product.prototype.getWeight = function () {
            return this.Weight;
        };

        Product.prototype.getIsNew = function () {
            return this.IsNew;
        };

        Product.prototype.getIsPopulation = function () {
            return this.IsPopulation;
        };

        Product.prototype.getCategory = function () {
            return this.Category;
        };

        Product.prototype.getFlour = function () {
            return this.Flour;
        };

        Product.prototype.getUnit = function () {
            return this.Unit;
        };

        Product.build = function (data) {
            return Entity.build(Product, data);
        };

        return Product;
    }

})(angular);