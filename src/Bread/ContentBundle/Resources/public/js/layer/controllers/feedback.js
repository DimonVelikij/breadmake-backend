(function (angular) {
    "use strict";

    angular
        .module('content.layer')
        .controller('FeedbackCtrl', FeedbackController);

    FeedbackController.$inject = [
        '$scope',
        'FormHelper'
    ];

    function FeedbackController (
        $scope,
        FormHelper
    ) {
        $scope.submitFeedback = function ($event, form) {
            $event.preventDefault();

            FormHelper.forceDirty(form);

            if (form.$invalid) {
                return;
            }

            console.log(1);
        }
    }

})(angular);