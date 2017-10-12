(function (angular) {
    "use strict";

    angular
        .module('content.homepage')
        .controller('SliderCtrl', SliderController);

    SliderController.$inject = [
        '$scope'
    ];

    function SliderController($scope) {
        console.log('slider');
    }

})(angular);