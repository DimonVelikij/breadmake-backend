(function (angular) {
    "use strict";

    angular
        .module('content.layer')
        .controller('FeedbackCtrl', FeedbackController);

    FeedbackController.$inject = [
        '$scope',
        'FormHelper',
        'Initializer',
        'Request'
    ];

    function FeedbackController (
        $scope,
        FormHelper,
        Initializer,
        Request
    ) {
        $scope.userData = {
            Name: null,
            Phone: null,
            Data: {
                Comment: null
            },
            Agree: null
        };

        $scope.submitFeedback = function ($event, form) {
            $event.preventDefault();

            FormHelper.forceDirty(form);

            if (form.$invalid) {
                return;
            }

            $scope.feedbackRequestSending = true;

            var formData = $scope.userData;
            formData['Type'] = 'feedback';
            formData['Token'] = Initializer.Config.FormToken;

            Request.save(formData)
                .then(function (response) {
                    if (response.success) {
                        $scope.feedbackRequestSend = true;
                    } else {
                        if (!response.errors) {
                            $scope.feedbackRequestSendError = true;
                        }
                        _.forEach(response.errors, function (message, fieldName) {
                            $scope.feedback[fieldName].errorMessages = {
                                backend: message
                            };
                            $scope.feedback[fieldName].$setValidity('backend', false);
                        });
                    }
                })
                .finally(function () {
                    $scope.feedbackRequestSending = false;
                });
        }
    }

})(angular);