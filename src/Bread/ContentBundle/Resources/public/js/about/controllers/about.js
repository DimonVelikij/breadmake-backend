(function (angular) {
    "use strict";

    angular
        .module('content.about')
        .controller('AboutCtrl', AboutController);

    AboutController.$inject = [
        '$scope',
        '$rootScope',
        '$location',
        '$timeout',
        '$document',
        'Map',
        'Layer',
        'Initializer',
        'CompanyResource'
    ];

    function AboutController(
        $scope,
        $rootScope,
        $location,
        $timeout,
        $document,
        Map,
        Layer,
        Initializer,
        CompanyResource
    ) {
        $scope.load = true;

        /**
         * загруженые ли данные для компании
         * @type {boolean}
         */
        var isLoadCompany = false;

        CompanyResource.query()
            .then(function (company) {
                $scope.company = company;

                var map = new Map();
                map
                    .setConfigs({
                        id: 'about-map-block',
                        company: company
                    })
                    .load();

                isLoadCompany = true;
                scrollToElement();
            })
            .finally(function () {
                $scope.load = false;
            });

        $rootScope.$on('$locationChangeSuccess', function () {
            scrollToElement();
        });

        /**
         * cкролим к нужному элементу
         */
        function scrollToElement() {
            var hash = $location.hash();

            if (hash && isLoadCompany) {
                $timeout(function () {
                    var element = angular.element('#_' + hash);

                    if (element.length) {
                        $document.scrollToElement(element, 10, 1000);
                    }
                });
            }
        }

        $scope.openFeedbackLayer = function (url) {
            Layer.open(url, $scope).then(function (response) {
                Layer.open(Initializer.Path.LayerThanks, $scope);
            }, function (error) {
                Layer.open(Initializer.Path.LayerError, $scope);
            });
        };
    }

})(angular);