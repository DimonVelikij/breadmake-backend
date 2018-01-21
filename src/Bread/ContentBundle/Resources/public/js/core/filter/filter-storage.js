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
        }

        FilterStorage.prototype.setData = function (data) {
            this.data = data;
            this.filter.preFilter();

            return this;
        };

        return FilterStorage;
    }

})(angular);