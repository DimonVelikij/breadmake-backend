(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('FormHelper', FormHelper);

    FormHelper.$inject = [
        '_'
    ];

    function FormHelper (
        _
    ) {
        return {
            forceDirty: forceDirty
        };

        function forceDirty (form) {
            if (!form) {
                return;
            }

            _.forEach(form, function (field, name) {
                if (name[0] !== '$' && field.$pristine && field.$setDirty) {
                    field.$setDirty();
                }
            });
        }
    }

})(angular);