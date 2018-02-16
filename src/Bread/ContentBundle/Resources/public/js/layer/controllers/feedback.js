(function (angular) {
    "use strict";

    angular
        .module('content.layer')
        .controller('FeedbackCtrl', FeedbackController);

    FeedbackController.$inject = [
        '$scope',
        'FormHelper',
        'Initializer',
        'Request',
        'Layer'
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
            Email: null,
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

            $scope.layerSubmitting = true;

            var formData = $scope.userData;
            formData['Type'] = 'feedback';
            formData['Token'] = Initializer.Config.FormToken;

            Request.save(formData)
                .then(function (response) {
                    if (response.success) {
                        $scope.Layer.ok(true);
                    } else {
                        if (!response.errors) {
                            $scope.Layer.cancel(true);
                        } else {
                            _.forEach(response.errors, function (message, fieldName) {
                                form[fieldName].errorMessages = {
                                    backend: message
                                };
                                form[fieldName].$setValidity('backend', false);
                            });
                        }
                    }
                })
                .finally(function () {
                    $scope.layerSubmitting = false;
                });
        }
    }

})(angular);