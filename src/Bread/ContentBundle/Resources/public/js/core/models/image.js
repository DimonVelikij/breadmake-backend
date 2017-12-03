(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('Image', ImageFactory);

    ImageFactory.$inject = [
        'Entity'
    ];

    function ImageFactory(
        Entity
    ) {
        Entity.extend(Image);

        function Image(data) {
            this.Path = data.Path;
            this.CropPath = data.CropPath;
        }

        Image.prototype.getPath = function () {
            return this.Path;
        };

        Image.prototype.getCropPath = function () {
            return this.CropPath;
        };

        Image.build = function (data) {
            return Entity.build(Image, data);
        };

        return Image;
    }

})(angular);