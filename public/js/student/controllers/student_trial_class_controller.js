angular.module('futureed.controllers')
    .controller('StudentTrialClassController', StudentTrialClassController);

StudentTrialClassController.$inject = ['$scope','$window','StudentClassService'];

function StudentTrialClassController($scope,$window,StudentClassService) {
    var self = this;
    self.has_subscription = Constants.FALSE;

    self.redirect = function(url) {
            $window.location.href = url;
    }

    self.updateBackground = function() {
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

    self.checkStudentSubscription = function() {
        $scope.ui_block();
        $scope.checkClassRecord(function(data)
        {
            if(data.records.length)
            {
                $window.location.href = '/student/dashboard?class=true';
                $scope.ui_unblock();
            } else {
                self.has_subscription = Constants.TRUE;

                self.updateBackground();
                $scope.ui_unblock();
            }
        });
    }
}