(function (angular) {
    "use strict";

    angular
        .module('content.news')
        .controller('NewsCtrl', NewsController);

    NewsController.$inject = [
        '$scope',
        'NewResource'
    ];

    function NewsController (
        $scope,
        NewResource
    ) {
        $scope.load = true;

        NewResource.query()
            .then(function (news) {
                $scope.news = news;
            }, function (error) {
                $scope.dataLoadError = true;
            })
            .finally(function () {
                $scope.load = false;
            });
    }

})(angular);