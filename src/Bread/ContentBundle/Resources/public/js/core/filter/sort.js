(function (angular) {
    "use strict";

    /**
     * сервис, который сортирует данные
     */
    angular
        .module('content.core')
        .factory('Sort', SortFactory);

    SortFactory.$inject = [
        '_',
        '$location'
    ];

    function SortFactory(
        _,
        $location
    ) {
        function Sort() {
            this.storage = null;
            this.fields = [];
            this.configuration = {};
            this.stateData = {};
        }

        Sort.prototype.setStorage = function (storage) {
            this.storage = storage;

            return this;
        };

        Sort.prototype.addFields = function (fields) {
            this.fields = fields;

            return this;
        };

        Sort.prototype.setConfiguration = function (configuration) {
            this.configuration = configuration;

            return this;
        };

        Sort.prototype.isValid = function () {
            if (!this.storage) {
                throw new Error('Отсутствует хранилище для сортировки');
            }
            if (!this.fields) {
                throw new Error('Отсутствуют поля для сортировки');
            }

            if (!this.configuration) {
                throw new Error('Отсутствует конфигурация сортировки');
            }

            return true;
        };

        Sort.prototype.init = function () {
            this.isValid();

            var self = this;

            _.forEach(this.fields, function (field) {
                self.addSort(field);
                self[field] = self.configuration[field].defaultValue;
                self.stateData[field] = self.configuration[field].defaultValue;

                if (self.configuration[field].defaultValue) {
                    $location.search(field, self.configuration[field].defaultValue);
                }
            });

            return this;
        };

        Sort.prototype.addSort = function (field) {
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

                    this.sort(field);
                }
            });
        };

        Sort.prototype.preSort = function () {
            var locationParams = _.clone($location.search()),
                self = this;

            _.forEach(locationParams, function (paramValue, paramName) {
                if (!self.configuration[paramName]) {
                    return;
                }
                self[paramName] = paramValue;
            });
        };

        Sort.prototype.sort = function (field) {
            var sortField = field.charAt(0).toUpperCase() + field.slice(1);
            $location.search(field, this[field]);

            this.storage.filteredData = _.orderBy(this.storage.filteredData, [sortField], [this[field]]);
        };

        Sort.create = function () {
            return new Sort();
        };

        return Sort;
    }

})(angular);