angular.module('futureed.controllers')
    .controller('ManagePrincipalContentController', ManagePrincipalContentController);

ManagePrincipalContentController.$inject = ['$scope','ManagePrincipalContentService','clientProfileService','apiService'];

function ManagePrincipalContentController(){
    var self = this;

    self.setActive = function(active, id){

    }
}