(function (angular) {
    "use strict";

    angular
        .module('content.homepage')
        .service('CartResource', CartResourceService);

    CartResourceService.$inject = [
        'EntityResource',
        'Initializer',
        'Cart',
        '_'
    ];

    function CartResourceService(
        EntityResource,
        Initializer,
        Cart,
        _
    ) {
        function CartResource() {}

        var resource = new EntityResource();

        resource
            .setResourceUrl(Initializer.Path.CartResource)
            .setBuilder(function (data) {
                return _.map(data, Cart.build);
            });

        return resource;
    }

})(angular);