(function (angular) {
    "use strict";

    /**
     * сервис, который хранит исходные и отфильтрованные данные
     */
    angular
        .module('content.core')
        .factory('FilterStorage', FilterStorageFactory);

    FilterStorageFactory.$inject = [

    ];

    function FilterStorageFactory(

    ) {
        function FilterStorage() {
            this.filter = null;
            this.data = [];//исходные данные
            this.filterData = {};//данные для фильтра
            this.filteredData = null;//отфильтрованные данные
            this.sort = null;
        }

        FilterStorage.prototype.setData = function (data) {
            this.data = data;

            if (!this.filter && !this.sort) {
                throw new Error('Не настроен ни фильтр, ни сортировка');
            }

            if (this.filter) {
                this.filter.preFilter();
            }

            if (this.sort) {
                this.sort.preSort();
            }

            return this;
        };

        return FilterStorage;
    }

})(angular);