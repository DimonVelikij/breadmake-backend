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
        'FilterStorage',
        'Sort'
    ];

    function FilterBuilderFactory(
        Filter,
        FilterStorage,
        Sort
    ) {
        function FilterBuilder() {
            this.filterConfiguration = {};//конфигурация фильтра
            this.sortConfiguration = {};//конфигурация сортировки
            this.filterFields = [];//фильтруемые поля
            this.sortFields = [];//сортируемые поля
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

        FilterBuilder.prototype.addSortFields = function (sortFields) {
            this.sortFields = sortFields;

            return this;
        };

        FilterBuilder.prototype.extend = function (extensions) {
            if (extensions.filter) {
                extensions.filter.extend(Filter);
            }

            if (extensions.sort) {
                extensions.sort.extend(Sort);
            }

            return this;
        };

        FilterBuilder.prototype.createStorage = function () {
            var storage = new FilterStorage();

            if (this.filterFields && this.filterConfiguration) {
                storage.filter = Filter
                    .create()
                    .setStorage(storage)
                    .addFields(this.filterFields)
                    .setConfiguration(this.filterConfiguration)
                    .init();
            }

            if (this.sortFields && this.sortConfiguration) {
                storage.sort = Sort
                    .create()
                    .setStorage(storage)
                    .addFields(this.sortFields)
                    .setConfiguration(this.sortConfiguration)
                    .init();
            }

            if (!storage.filter && !storage.sort) {
                throw new Error('Не настроен ни фильтр, ни сортировка');
            }

            return storage;
        };

        FilterBuilder.create = function () {
            return new FilterBuilder();
        };

        return FilterBuilder;
    }

})(angular);