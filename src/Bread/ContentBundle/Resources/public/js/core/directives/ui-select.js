(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .directive('uiSelect', UiSelectDirective)
        .controller('UiSelectCtrl', UiSelectCtrl);

    UiSelectDirective.$inject = [];

    function UiSelectDirective() {
        return {
            restrict: 'E',
            require: 'ngModel',
            scope: {
                ngModel: '=ngModel',
                items: '=items',
                trackBy: '@trackBy',
                showBy: '@showBy'
            },
            templateUrl: 'ui-select-directive.html',
            controller: UiSelectCtrl
        }
    }

    UiSelectCtrl.$inject = [
        '$scope',
        '$element',
        '$document',
        '_'
    ];

    function UiSelectCtrl(
        $scope,
        $element,
        $document,
        _
    ) {
        var isInitDirective = false;
        $scope.selectedItem = null;

        $scope.$watch('items', function (items) {
            if (isInitDirective || !items) {
                return;
            }

            _.forEach(items, function (item) {
                if (item[$scope.trackBy] == $scope.ngModel) {
                    $scope.selectedItem = item;
                    return;
                }
            });
            isInitDirective = true;
        });

        $scope.$watch('ngModel', function (newVal) {
            _.forEach($scope.items, function (item) {
                if (item[$scope.trackBy] == newVal) {
                    $scope.selectedItem = item;
                    return;
                }
            });
        });

        $scope.selectItem = function (item) {
            $scope.ngModel = item[$scope.trackBy];
            $scope.selectedItem = item;
        };

        function clickToUiSelect (e) {
            if (!$element.has(e.target).length) {
                $scope.toggleUiSelectOptions = false;
                $scope.$apply();
            }
        }

        $document.on('click', clickToUiSelect);

        $scope.$on('$destroy', function () {
            $document.off('click', clickToUiSelect);
        });
    }

})(angular);