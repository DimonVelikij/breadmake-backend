(function (angular) {
    "use strict";

    angular
        .module('app.core')
        .controller('CommonCtrl', CommonController);

    CommonController.$inject = [
        '$scope'
    ];
    
    function CommonController($scope) {
        
    }

})(angular);