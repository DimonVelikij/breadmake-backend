(function (angular) {
    "use strict";

    angular
        .module('content.core')
        .factory('Company', CompanyFactory)
        .service('CompanyResource', CompanyResourceService);

    CompanyFactory.$inject = [
        'Entity'
    ];

    function CompanyFactory(
        Entity
    ) {
        Entity.extend(Company);

        function Company(data) {
            this.Title = data.Title;
            this.Phone = data.Phone;
            this.Email = data.Email;
            this.Address = data.Address;
            this.Data = data.Data;
        }

        Company.prototype.getTitle = function () {
            return this.Title;
        };

        Company.prototype.getPhone = function () {
            return this.Phone;
        };

        Company.prototype.getEmail = function () {
            return this.Email;
        };

        Company.prototype.getAddress = function () {
            return this.Address;
        };

        Company.prototype.getDelivery = function () {
            return this.Data.delivery;
        };

        Company.prototype.getPayment = function () {
            return this.Data.payment;
        };

        Company.prototype.getWeekend = function () {
            return this.Data.weekend;
        };

        Company.prototype.getWorkingDays = function () {
            return this.Data.working_days;
        };

        Company.prototype.getWorkingTime = function () {
            return this.Data.working_time;
        };

        Company.build = function (data) {
            return Entity.build(Company, data);
        };

        return Company;
    }

    CompanyResourceService.$inject = [
        'EntityResource',
        'Initializer',
        'Company',
        '_'
    ];

    function CompanyResourceService(
        EntityResource,
        Initializer,
        Company,
        _
    ) {
        function CompanyResource() {}

        var resource = new EntityResource();

        resource
            .setResourceUrl(Initializer.Path.CompanyResource)
            .setBuilder(function (data) {
                if (data.length) {
                    return Company.build(data[0]);
                }
            });

        return resource;
    }

})(angular);