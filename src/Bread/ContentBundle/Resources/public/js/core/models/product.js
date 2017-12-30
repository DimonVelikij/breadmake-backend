(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('Product', ProductFactory)
        .service('ProductResource', ProductResourceService);

    ProductFactory.$inject = [
        'Entity',
        'Category',
        'Flour',
        'Unit',
        'Image'
    ];

    function ProductFactory(
        Entity,
        Category,
        Flour,
        Unit,
        Image
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
            this.IsInCart = data.IsInCart;
            this.Category = data.Category ? Category.build(data.Category) : null;
            this.Flour = data.Flour ? Flour.build(data.Flour) : null;
            this.Unit = data.Unit ? Unit.build(data.Unit) : null;
            this.Image = data.Image ? Image.build(data.Image) : null;
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

        Product.prototype.isInCart = function () {
            return this.IsInCart;
        };

        Product.prototype.setIsInCart = function (value) {
            this.IsInCart = value;

            return this;
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

        Product.prototype.getImage = function () {
            return this.Image;
        };

        Product.build = function (data) {
            return Entity.build(Product, data);
        };

        return Product;
    }

    ProductResourceService.$inject = [
        'EntityResource',
        'Initializer',
        'Product',
        '_'
    ];

    function ProductResourceService(
        EntityResource,
        Initializer,
        Product,
        _
    ) {
        function ProductResource() {
            this.resource = new EntityResource();
        }
        
        ProductResource.prototype.queryPopulation = function () {
            return this.resource
                    .setResourceUrl(Initializer.Path.PopulationProductResource)
                    .setBuilder(function (data) {
                        return _.map(data, Product.build);
                    })
                    .query();
        };
        
        ProductResource.prototype.query = function () {
            return this.resource
                    .setResourceUrl(Initializer.Path.ProductResource)
                    .setBuilder(function (data) {
                        return _.map(data, Product.build);
                    })
                    .query();
        };
        
        return new ProductResource();
    }

})(angular);