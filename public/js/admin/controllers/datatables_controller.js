angular.module('futureed.controllers')
	.controller('DatatableController', DatatableController)

function DatatableController($resource, $scope) {
    var vm = this;
    $resource('../js/admin/controllers/data.json').query().$promise.then(function(persons) {
        vm.persons = persons;
    });
}
