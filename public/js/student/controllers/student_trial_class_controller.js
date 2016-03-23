angular.module('futureed.controllers')
    .controller('StudentTrialClassController', StudentTrialClassController);

StudentTrialClassController.$inject = ['$window'];

function StudentTrialClassController($window) {
    var self = this;

    self.redirect = function(url) {
            $window.location.href = url;
    }

    self.updateBackground = function() {
        angular.element('body.student').css({
            'background-image' : 'url("/images/class-student/mountain-full-bg.png")'
        });
    }
}