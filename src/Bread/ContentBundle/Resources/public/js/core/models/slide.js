(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('Slide', SlideFactory);

    SlideFactory.$inject = [
        'Entity',
        'Image'
    ];

    function SlideFactory(
        Entity,
        Image
    ) {
        Entity.extend(Slide);

        function Slide(data) {
            this.Id = data.Id;
            this.Title = data.Title;
            this.Description = data.Description;
            this.Image = data.Image ? Image.build(data.Image) : null;
        }

        Slide.prototype.getId = function () {
            return this.Id;
        };

        Slide.prototype.getTitle = function () {
            return this.Title;
        };

        Slide.prototype.getDescription = function () {
            return this.Description;
        };

        Slide.prototype.getImage = function () {
            return this.Image;
        };

        Slide.build = function (data) {
            return Entity.build(Slide, data);
        };

        return Slide;
    }

})(angular);