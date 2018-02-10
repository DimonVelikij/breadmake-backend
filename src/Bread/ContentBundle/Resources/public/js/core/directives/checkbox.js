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
                    title = attrs.title,
                    checkboxLabelClass = attrs.checkboxLabelClass,
                    labelClass = attrs.labelClass,
                    labelWrapElement = attrs.labelWrapElement,
                    labelWrapClass = attrs.labelWrapClass;

                if (checkBoxId === undefined || checkBoxId === "") {
                    throw new Error('custom-checkbox directive need id!');
                }

                var labelWrapStartElement = labelWrapElement && labelWrapClass ?
                    '<' + labelWrapElement + ' class="' + labelWrapClass + '">' :
                    '',
                    labelWrapEndElement = labelWrapElement ? '</' + labelWrapElement + '>' : '';

                element.wrap('<div class="checkbox-wrapper"></div>');

                element.after('<label for="' + checkBoxId + '" class="fa checkbox-label ' + checkboxLabelClass + '"></label>' +
                    labelWrapStartElement + '<label class="checkbox-label ' + labelClass + '" for="' + checkBoxId + '">' + title + '</label>' + labelWrapEndElement);
            }
        };
    }

})(angular);