(function () {
    "use strict";

    angular
        .module('content.core')
        .factory('FilterBuilder', FilterBuilderFactory);

    FilterBuilderFactory.$inject = [
        '_',
        '$q',
        '$location'
    ];

    function FilterBuilderFactory (
        _,
        $q,
        $location
    ) {
        /**
         * @constructor
         */
        function FilterBuilder() {
            this.isInit = false;//инициализирован ли фильтр
            this.isReady = false;//готов ли фильтр к работе
            this.data = null;//исходные данные
            this.filterData = {};//данные для фильтров
            this.filteredData = null;//отфильтрованные данные
            this.filterConfiguration = {};//конфигурация фильтра
            this.sortConfiguration = null;//конфигурация сортировки
            this.defaultFilterData = null;//дефолтные данные для фильтра
            this.currentFilterData = null;//текущие данные фильтра
            this.previewFilterData = null;//предыдущие данные фильтра
            this.watchVariable = null;//название переменной, изменения которой нужно отслеживать
        }

        /**
         * установка данных для фильтрации
         * @param data
         * @returns {FilterBuilder}
         */
        FilterBuilder.prototype.setData = function (data) {
            if (!this.isInit) {
                throw new Error('Фильтр неинициализирован');
            }

            this.data = data;
            this.isReady = true;//после установки данных фильтр готов к работе

            return this;
        };

        /**
         * установка конфигурации
         * @param filterConfiguration
         * @returns {FilterBuilder}
         */
        FilterBuilder.prototype.setFilterConfiguration = function (filterConfiguration) {
            this.filterConfiguration = filterConfiguration;

            return this;
        };

        /**
         * установка параматров сортировки
         * @param sortConfiguration
         * @returns {FilterBuilder}
         */
        FilterBuilder.prototype.setSortConfiguration = function (sortConfiguration) {
            this.sortConfiguration = sortConfiguration;

            return this;
        };

        /**
         * установка дефолтных параметров фильтра
         * @param defaultFilterData
         * @returns {FilterBuilder}
         */
        FilterBuilder.prototype.setDefaultFilterData = function (defaultFilterData) {
            this.defaultFilterData = defaultFilterData;

            return this;
        };

        /**
         * установка переменной, которая отслеживает изменения фильтра
         * @param watchVariable
         * @returns {FilterBuilder}
         */
        FilterBuilder.prototype.setWatchVariable = function (watchVariable) {
            this.watchVariable = watchVariable;

            return this;
        };

        /**
         * инициализация фильтра
         * @param scope
         * @returns {FilterBuilder}
         */
        FilterBuilder.prototype.init = function (scope) {
            var self = this;

            if (!this.filterConfiguration) {
                throw new Error('Фильтр не сконфигурирован');
            }

            if (!this.defaultFilterData) {
                throw new Error('Не установлены дефолтные данные для фильтра');
            }

            if (!this.watchVariable) {
                throw new Error('Не установлена переменная отслеживания фильтра');
            }

            scope[this.watchVariable] = this.defaultFilterData;
            this.currentFilterData = scope[this.watchVariable];

            scope.$watchCollection(this.watchVariable, function () {
                if (!self.isReady) {
                    return;
                }

                scope.technicalLoad = true;

                var currentDiff = {};

                _.forEach(self.currentFilterData, function (value, name) {
                    if (self.previewFilterData[name] != value) {
                        currentDiff[name] = value;
                    }
                });

                self.filter(currentDiff)
                    .then(function () {})
                    .finally(function () {
                        scope.technicalLoad = false;
                    });
            });

            this.isInit = true;

            return this;
        };

        /**
         * префильтрация
         */
        FilterBuilder.prototype.preFilter = function () {
            var locationParams = $location.search(),
                self = this;

            _.forEach(this.filterConfiguration, function (filterParams, filterName) {
                self.currentFilterData[filterName] = locationParams[filterName] ?
                    locationParams[filterName] :
                    self.currentFilterData[filterName];
            });

            return this.filter(this.currentFilterData);
        };

        /**
         * фильтрация
         */
        FilterBuilder.prototype.filter = function (currentFilterChange) {
            var defer = $q.defer(),
                self = this,
                selectedFilterValues = this.currentFilterData;

            if (!this.data) {
                throw new Error('Не установлены данные для фильтра');
            }

            this.filteredData = this.data;

            if (selectedFilterValues) {
                /**
                 * непосредственно фильтрация
                 */
                _.forEach(this.filterConfiguration, function (filterParams, filterName) {
                    self.filteredData = _.filter(self.filteredData, function (data) {
                        if (selectedFilterValues[filterName]) {//если фильтруем по текущему фильтру
                            if (selectedFilterValues[filterName] != filterParams.allValue) {
                                $location.search(filterName, selectedFilterValues[filterName]);//установка в строку браузера параметра
                            } else {
                                $location.search(filterName, null);//убираем из строки браузера параметр
                            }
                            var filterValue = selectedFilterValues[filterName],
                                filterFunction = 'filterBy' + filterName.charAt(0).toUpperCase() + filterName.slice(1);
                            return (filterParams.allValue && filterParams.allValue === filterValue) || data[filterFunction](filterValue);
                        } else {
                            return true;
                        }
                    });
                });
            }

            /**
             * собираем данные для фильтра
             */
            _.forEach(this.filterConfiguration, function (filterParams, filterName) {
                self.filterData[filterName] = filterParams.filteringFn(self.filteredData);
            });

            /**
             * устанавливаем значения все, в фильтре значение все и еще один пункт
             */
            _.forEach(this.filterData, function (filterData, filterName) {
                if (
                    self.filterConfiguration[filterName].allValue && filterData.length == 2 &&
                    (!self.previewFilterData || currentFilterChange[filterName] != self.filterConfiguration[filterName].allValue)
                ) {
                    self.currentFilterData[filterName] = filterData[filterData.length - 1].getId().toString();
                }
            });

            this.previewFilterData = _.clone(selectedFilterValues);

            defer.resolve(true);

            return defer.promise;
        };

        return new FilterBuilder();
    }

})(angular);