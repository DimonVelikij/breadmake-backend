(function (angular) {
    "use strict";

    angular
        .module('content.homepage')
        .service('CartResource', CartResourceService);

    CartResourceService.$inject = [
        'EntityResource',
        'Initializer',
        'Cart',
        '_',
        '$http'
    ];

    function CartResourceService(
        EntityResource,
        Initializer,
        Cart,
        _,
        $http
    ) {
        function CartResource() {
            this.resource = new EntityResource();
        }

        CartResource.prototype.query = function () {
            return this.resource
                .setResourceUrl(Initializer.Path.CartResource)
                .setBuilder(function (data) {
                    return _.map(data, Cart.build);
                })
                .query()
            ;

        };

        CartResource.prototype.update = function (args) {
            return $http({
                url: Initializer.Path.CartResource + '/update/' + args.Product.getId(),
                method: 'GET',
                params: {
                    price: args.Product.getPrice(),
                    count: args.Count
                },
                transformResponse: function (response) {
                    return _.map(JSON.parse(response), Cart.build);
                }
            });
        };

        CartResource.prototype.delete = function (args) {
            //при удалении объекта нужно его удалить из пула объектов в js
            delete Cart.objectPool[args.Product.getId()];

            return $http({
                url: Initializer.Path.CartResource + '/remove/' + args.Product.getId(),
                method: 'GET',
                transformResponse: function (response) {
                    return _.map(JSON.parse(response), Cart.build);
                }
            });
        };

        return new CartResource();
    }

})(angular);