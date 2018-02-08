(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('ProductFilterExtension', ProductFilterExtensionFactory);

    ProductFilterExtensionFactory.$inject = [
        '_',
        '$location'
    ];

    function ProductFilterExtensionFactory(
        _,
        $location
    ) {
        return {
            extend: extend
        };

        function extend(Filter) {
            Filter.prototype.init = function () {
                this.isValid();

                var self = this;

                _.forEach(this.fields, function (field) {
                    if (field != 'minPrice' && field != 'maxPrice') {
                        self.addFilter(field);
                    }
                    self[field] = self.configuration[field].defaultValue;
                    self.stateData[field] = self.configuration[field].defaultValue;
                });

                return this;
            };

            Filter.prototype.preFilter = function () {
                var locationParams = _.clone($location.search()),
                    self = this;

                _.forEach(locationParams, function (paramValue, paramName) {
                    if (!paramName in self) {
                        return;
                    }
                    self[paramName] = paramValue;
                });

                _.forEach(this.configuration, function (filterParams, filterName) {
                    self.storage.filterData[filterName] = filterParams.filteringFn(self.storage.data);
                });

                var minPrice = this.configuration['minPrice'].filteringFn(this.storage.data),
                    maxPrice = this.configuration['maxPrice'].filteringFn(this.storage.data);

                this.configuration['minPrice'].allValue = minPrice;
                this.configuration['maxPrice'].allValue = maxPrice;

                this.stateData.minPrice = minPrice;
                this.stateData.maxPrice = maxPrice;

                if (!this['minPrice']) {
                    this['minPrice'] = minPrice;
                }

                if (!this['maxPrice']) {
                    this['maxPrice'] = maxPrice;
                }

                this.storage.priceSliderOptions = {
                    floor: minPrice,
                    ceil: maxPrice,
                    minRange: 1,
                    noSwitching: true,
                    minLimit: minPrice,
                    maxLimit: maxPrice,
                    translate: function (value) {
                        return value + '<i class="fa fa-rouble brown-dark"></i>';
                    }
                };

                this.filter().then(function (response) {});
            };
        }
    }

})(angular);