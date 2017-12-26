(function (angular) {
    "use strict";

    angular
        .module('content.declaration')
        .controller('DeclarationCtrl', DeclarationController);

    DeclarationController.$inject = [
        '$scope',
        'DeclarationResource'
    ];

    function DeclarationController(
        $scope,
        DeclarationResource
    ) {
        $scope.load = true;

        DeclarationResource.query()
            .then(function (declarations) {
                $scope.declarations = declarations;
            }, function (error) {
                $scope.dataLoadError = true;
            })
            .finally(function () {
                $scope.load = false;
            });
    }

})(angular);