(function (angular) {
    "use strict";

    /**
     * сервис для сборки фильтра
     */
    angular
        .module('content.core')
        .factory('FilterBuilder', FilterBuilderFactory);

    FilterBuilderFactory.$inject = [
        'Filter',
        'FilterStorage'
    ];

    function FilterBuilderFactory(
        Filter,
        FilterStorage
    ) {
        function FilterBuilder() {
            this.filterConfiguration = {};//конфигурация фильтра
            this.sortConfiguration = {};//конфигурация сортировки
            this.filterFields = [];//фильтруемые поля
        }

        FilterBuilder.prototype.setFilterConfiguration = function (filterConfiguration) {
            this.filterConfiguration = filterConfiguration;

            return this;
        };

        FilterBuilder.prototype.setSortConfiguration = function (sortConfiguration) {
            this.sortConfiguration = sortConfiguration;

            return this;
        };

        FilterBuilder.prototype.addFilterFields = function (filterFields) {
            this.filterFields = filterFields;

            return this;
        };

        FilterBuilder.prototype.extend = function (extensions) {
            if (extensions.filter) {
                extensions.filter.extend(Filter);
            }

            return this;
        };

        FilterBuilder.prototype.createStorage = function () {
            var storage = new FilterStorage();
            storage.filter = Filter
                .create()
                .setStorage(storage)
                .addFields(this.filterFields)
                .setConfiguration(this.filterConfiguration)
                .init();

            return storage;
        };

        FilterBuilder.create = function () {
            return new FilterBuilder();
        };

        return FilterBuilder;
    }

})(angular);