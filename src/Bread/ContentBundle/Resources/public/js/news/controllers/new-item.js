(function (angular) {
    "use strict";

    angular
        .module('content.news')
        .controller('NewItemCtrl', NewItemController);

    NewItemController.$inject = [
        '$scope',
        'Initializer',
        'NewResource'
    ];

    function NewItemController (
        $scope,
        Initializer,
        NewResource
    ) {
        $scope.load = true;

        NewResource.get({id: Initializer.Data.NewId})
            .then(function (newItem) {
                $scope.newItem = newItem;
            })
            .finally(function () {
                $scope.load = false;
            });
    }

})(angular);