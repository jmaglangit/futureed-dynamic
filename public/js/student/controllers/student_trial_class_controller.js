angular.module('futureed.controllers')
    .controller('StudentTrialClassController', StudentTrialClassController);

StudentTrialClassController.$inject = ['$scope','$window','StudentClassService'];

function StudentTrialClassController($scope,$window,StudentClassService) {
    var self = this;

    self.redirect = function(url) {
            $window.location.href = url;
    }

    self.updateBackground = function() {
        $("footer").css('background-image', 'none');

        StudentClassService.getStudentBackgroundImage($scope.user.user.id).success(function(response){
            if(response.data){
                angular.element('body.student').css({
                    'background-image' : 'url("' + response.data.url + '")'
                });
            }else{
                angular.element('body.student').css({
                    'background-image' : 'url("/images/class-student/mountain-full-bg.png")'
                });
            }
        }).error(function(response){
            self.error = $scope.internalError();
        });
    }
}