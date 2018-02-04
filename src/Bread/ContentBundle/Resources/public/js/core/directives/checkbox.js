(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .directive('checkbox', CheckboxDirective);

    CheckboxDirective.$inject = [];

    function CheckboxDirective() {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function (scope, element, attrs) {
                var checkBoxId = attrs.id,
                    title = attrs.title;
                if (checkBoxId === undefined || checkBoxId === "") {
                    throw new Error('custom-checkbox directive need id!');
                }

                element.wrap('<div class="checkbox-wrapper"></div>');

                element.after('<label for="' + checkBoxId + '" class="fa checkbox-label"></label>' +
                    '<label class="checkbox-label" for="' + checkBoxId + '">' + title + '</label>');
            }
        };
    }

})(angular);