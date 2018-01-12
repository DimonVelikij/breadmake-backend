(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('ProductFilterConfiguration', ProductFilterConfiguration);

    ProductFilterConfiguration.$inject = [];

    function ProductFilterConfiguration (

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
            }
        }
    }

})(angular);