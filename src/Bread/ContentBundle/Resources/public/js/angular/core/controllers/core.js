(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .controller('CoreCtrl', CoreController);

    CoreController.$inject = [
        '$scope'
    ];
    
    function CoreController($scope) {
        
    }

})(angular);