(function (angular) {
    "use strict";

    /**
     * сервис, который фильтрует данные
     */
    angular
        .module('content.core')
        .factory('Filter', FilterFactory);

    FilterFactory.$inject = [
        '_',
        '$location',
        '$q'
    ];

    function FilterFactory(
        _,
        $location,
        $q
    ) {
        function Filter() {
            this.storage = null;
            this.fields = [];
            this.configuration = {};
        }

        Filter.prototype.setStorage = function (storage) {
            this.storage = storage;

            return this;
        };

        Filter.prototype.addFields = function (fields) {
            this.fields = fields;

            return this;
        };

        Filter.prototype.setConfiguration = function (configuration) {
            this.configuration = configuration;

            return this;
        };

        Filter.prototype.isValid = function () {
            if (!this.storage) {
                throw new Error('Отсутствует хранилище для фильтра');
            }
            if (!this.fields) {
                throw new Error('Отсутствуют поля для фильтрации');
            }

            if (!this.configuration) {
                throw new Error('Отсутствует конфигурация фильтра');
            }

            return true;
        };

        Filter.prototype.init = function () {
            this.isValid();

            var self = this;

            _.forEach(this.fields, function (field) {
                self.addFilter(field);
                self[field] = self.configuration[field].defaultValue;
            });

            return this;
        };

        Filter.prototype.addFilter = function (field) {
            var fieldName = '_' + field;
            Object.defineProperty(this, field, {
                get: function () {
                    return this[fieldName];
                },
                set: function (value) {
                    this[fieldName] = value;

                    if (!this.storage.data.length) {
                        return;
                    }

                    this.filter();
                }
            });
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
        };

        Filter.prototype.filter = function () {
            var defer = $q.defer(),
                self = this;

            this.storage.filteredData = this.storage.data;

            _.forEach(this.configuration, function (filterParams, filterName) {
                self.storage.filteredData = _.filter(self.storage.filteredData, function (data) {
                    if (self[filterName] == filterParams.allValue || !self[filterName]) {
                        $location.search(filterName, null);
                        return true;
                    } else {
                        $location.search(filterName, self[filterName]);
                        var filterValue = self[filterName],
                            filterFunction = 'filterBy' + filterName.charAt(0).toUpperCase() + filterName.slice(1);

                        return data[filterFunction](filterValue);
                    }
                });
            });

            defer.resolve(true);

            return defer.promise;
        };

        Filter.create = function () {
            return new Filter();
        };

        return Filter;
    }
})(angular);