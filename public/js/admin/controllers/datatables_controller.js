angular.module('futureed.controllers')
	.controller('DatatableController', DatatableController)

function DatatableController($scope, $resource) {
    var vm = this;
    $resource('/js/admin/controllers/data.json').query().$promise.then(function(persons) {
        vm.persons = persons;
    });
}
