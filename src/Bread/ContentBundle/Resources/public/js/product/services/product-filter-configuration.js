(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('ProductFilterConfiguration', ProductFilterConfiguration);

    ProductFilterConfiguration.$inject = [
        '$location'
    ];

    function ProductFilterConfiguration (
        $location
    ) {
        return {
            'category': {
                allValue: 'all',
                filteringFn: function (collection) {
                    var categories = _.values(_.reduce(collection, function (acc, product) {
                        acc[product.getCategory().getId()] = product.getCategory();
                        return acc;
                    }, {}));

                    categories.unshift({Id: 'all', Title: 'Все категории'});

                    return categories;
                }
            },
            'unit': {
                allValue: 'all',
                filteringFn: function (collection) {
                    var units = _.values(_.reduce(collection, function (acc, product) {
                        acc[product.getUnit().getId()] = product.getUnit();
                        return acc;
                    }, {}));

                    units.unshift({Id: 'all', Title: 'Все измерения'});

                    return units;
                }
            },
            'flour': {
                allValue: 'all',
                filteringFn: function (collection) {
                    var flours = _.values(_.reduce(collection, function (acc, product) {
                        acc[product.getFlour().getId()] = product.getFlour();
                        return acc;
                    }, {}));

                    flours.unshift({Id: 'all', Title: 'Все сорта муки'});

                    return flours;
                }
            },
            'minPrice': {
                filteringFn: function (collection) {
                    var minPrice = collection[0].getPrice(),
                        locationParams = $location.search();

                    _.forEach(collection, function (product) {
                        if (product.getPrice() < minPrice) {
                            minPrice = product.getPrice();
                        }
                    });

                    minPrice = Math.floor(minPrice);

                    if (!locationParams['minPrice']) {
                        $location.search('minPrice', minPrice);
                    }

                    return minPrice;
                }
            },
            'maxPrice': {
                filteringFn: function (collection) {
                    var maxPrice = collection[0].getPrice(),
                        locationParams = $location.search();

                    _.forEach(collection, function (product) {
                        if (product.getPrice() > maxPrice) {
                            maxPrice = product.getPrice();
                        }
                    });

                    maxPrice = Math.ceil(maxPrice);

                    if (!locationParams['maxPrice']) {
                        $location.search('maxPrice', maxPrice);
                    }

                    return maxPrice;
                }
            }
        }
    }

})(angular);