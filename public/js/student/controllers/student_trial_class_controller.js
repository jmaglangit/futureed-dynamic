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
        console.log('blocking ui');
        console.log('has_subscription: ' + self.has_subscription);
        $scope.checkClassRecord(function(data) {
            console.log(data.records.length);
            if(data.records.length) {

                console.log('redirecting');
                $window.location.href = '/student/dashboard?class=true'
                console.log('unblocking ui');
                $scope.ui_unblock();
            }
            console.log('assigning has_subscription to true');
            self.has_subscription = Constants.TRUE;
            console.log('updating background');
            self.updateBackground();
            $scope.ui_unblock();
        });
    }
}