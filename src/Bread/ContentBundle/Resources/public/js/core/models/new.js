(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('New', NewFactory)
        .service('NewResource', NewResourceService);

    NewFactory.$inject = [
        'Entity',
        'Image',
        '_'
    ];

    function NewFactory(
        Entity,
        Image,
        _
    ) {
        Entity.extend(New);

        function New(data) {
            this.Id = data.Id;
            this.Title = data.Title;
            this.Description = data.Description;
            this.CreatedAt = data.CreatedAt;
            this.Images = data.Images ? _.map(data.Images, Image.build) : null;
        }

        New.prototype.getId = function () {
            return this.Id;
        };

        New.prototype.getTitle = function () {
            return this.Title;
        };

        New.prototype.getDescription = function () {
            return this.Description;
        };

        New.prototype.getCreatedAt = function () {
            return this.CreatedAt;
        };

        New.prototype.getCreatedAtDate = function () {
            return this.CreatedAt.split(' ')[0];
        };

        New.prototype.getCreatedAtTime = function () {
            return this.CreatedAt.split(' ')[1];
        };

        New.prototype.getImages = function () {
            return this.Images;
        };

        New.prototype.getCountImages = function () {
            return this.Images.length;
        };

        New.build = function (data) {
            return Entity.build(New, data);
        };

        return New;
    }

    NewResourceService.$inject = [
        'EntityResource',
        'Initializer',
        'New',
        '_'
    ];

    function NewResourceService(
        EntityResource,
        Initializer,
        New,
        _
    ) {
        function NewResource() {
            this.resource = new EntityResource();
        }

        NewResource.prototype.query = function () {
            return this.resource
                .setResourceUrl(Initializer.Path.NewResource)
                .setBuilder(function (data) {
                    return _.map(data, New.build);
                })
                .query();
        };

        NewResource.prototype.get = function (id) {
            return this.resource
                .setResourceUrl(Initializer.Path.NewResource + '/:id')
                .setDefaultParams({id: '@id'})
                .setBuilder(function (data) {
                    return New.build(data);
                })
                .get(id);
        };

        return new NewResource();
    }

})(angular);