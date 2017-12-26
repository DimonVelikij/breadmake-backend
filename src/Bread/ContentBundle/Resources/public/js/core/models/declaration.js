(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('Declaration', DeclarationFactory)
        .service('DeclarationResource', DeclarationResourceService);

    DeclarationFactory.$inject = [
        'Entity',
        'Image',
        '_'
    ];

    function DeclarationFactory(
        Entity,
        Image
    ) {
        Entity.extend(Declaration);

        function Declaration(data) {
            this.Id = data.Id;
            this.Title = data.Title;
            this.Description = data.Description;
            this.Image = data.Image ? Image.build(data.Image) : null;
        }

        Declaration.prototype.getId = function () {
            return this.Id;
        };

        Declaration.prototype.getTitle = function () {
            return this.Title;
        };

        Declaration.prototype.getDescription = function () {
            return this.Description;
        };

        Declaration.prototype.getImage = function () {
            return this.Image;
        };

        Declaration.build = function (data) {
            return Entity.build(Declaration, data);
        };

        return Declaration;
    }

    DeclarationResourceService.$inject = [
        'EntityResource',
        'Initializer',
        'Declaration',
        '_'
    ];

    function DeclarationResourceService(
        EntityResource,
        Initializer,
        Declaration,
        _
    ) {
        function DeclarationResource() {
            this.resource = new EntityResource();
        }

        DeclarationResource.prototype.query = function () {
            return this.resource
                .setResourceUrl(Initializer.Path.DeclarationResource)
                .setBuilder(function (data) {
                    return _.map(data, Declaration.build);
                })
                .query();
        };

        return new DeclarationResource();
    }

})(angular);