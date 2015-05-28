angular.module('futureed')
	.controller('AnnouncementController', AnnouncementController);

AnnouncementController.$inject = ['$scope', 'announcementApiService'];

function AnnouncementController($scope, announcementApiService){
	var self = this;

  self.data = {};

  self.afterDateStart = afterDateStart;
  self.beforeDate = beforeDate;

  self.getAnnouncement = getAnnouncement;
  self.clearAnnouncementForm = clearAnnouncementForm;

  self.saveAnnounce = saveAnnounce;

 function afterDateStart($dates){
    var maxDate = new Date(self.data.date_start).setHours(0,0,0,0); // Set minimum date to whatever you want here

    for(d in $dates){        
        if($dates[d].utcDateValue < maxDate){
            $dates[d].selectable = false;
        }
    }
  }

  function beforeDate($dates){
    var maxDate = new Date().setHours(0,0,0,0); // Set minimum date to whatever you want here

    for(d in $dates){        
        if($dates[d].utcDateValue < maxDate){
            $dates[d].selectable = false;
        }
    }
  }

  function getAnnouncement() {
    self.errors = Constants.FALSE;

    $scope.ui_block();
    announcementApiService.getAnnouncement().success(function(response) {
      if(angular.equals(response.status, Constants.STATUS_OK)) {
        if(response.errors) {
          self.errors = $scope.errorHandler(response.errors);
        } else if(response.data) {
          self.data = response.data;
          self.data.date_start = new Date(self.data.date_start).setHours(0,0,0,0);
          self.data.date_end = new Date(self.data.date_end).setHours(0,0,0,0);
        }
      }

      $scope.ui_unblock();
    }).error(function(response) {
      self.errors = $scope.internalError();
      $scope.ui_unblock();
    });
  }

  function clearAnnouncementForm() {
    self.errors = Constants.FALSE;
    self.data = {};

    $("input[name='hidden_start']").val('');
    $("input[name='hidden_end']").val('');
    $("html, body").animate({ scrollTop: 0 }, "slow");
  }

  function saveAnnounce(){
    self.data.success = Constants.FALSE;
    self.errors = Constants.FALSE;

    var date_start = $("input[name='hidden_start']").val();
    var date_end = $("input[name='hidden_end']").val();

    $scope.ui_block();
    announcementApiService.saveAnnounce(date_start, date_end, self.data.announcement).success(function(response){
      if(response.status == Constants.STATUS_OK){
        if(response.errors){
          self.errors = $scope.errorHandler(response.errors);
        }else if(response.data){
          self.data.success = Constants.TRUE;
        }
      }

      $scope.ui_unblock();
    }).error(function(response){
      $scope.ui_unblock();
      $scope.internalError();
    });


  }
}