(function (angular) {
    "use strict";

    angular
        .module('content.search')
        .controller('SearchCtrl', SearchController);

    SearchController.$inject = [
        '$scope',
        '$http',
        '$location',
        'Initializer',
        '_'
    ];

    function SearchController (
        $scope,
        $http,
        $location,
        Initializer,
        _
    ) {
        $scope.searchString = Initializer.Search.SearchString;

        $scope.$on('$search', function (event, args) {
            $scope.searchString = args.Search;
            $location.search('search', args.Search);
            search();
        });

        function search () {
            $scope.load = true;

            $http.get(Initializer.Path.SearchData + '?search=' + $scope.searchString)
                .then(function (response) {
                    $scope.isResult = false;
                    $scope.result = {};

                    _.forEach(response.data, function (searchResult, name) {
                        if (!searchResult.result.length) {
                            return;
                        }
                        $scope.isResult = true;
                        $scope.result[name] = searchResult;
                    });
                })
                .finally(function () {
                    $scope.load = false;
                });
        }

        search();
    }

})(angular);