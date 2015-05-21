angular.module('futureed')
	.controller('AnnouncementController', AnnouncementController);

AnnouncementController.$inject = ['$scope', 'announcementApiService'];

function AnnouncementController($scope, announcementApiService){
	var self = this;

  this.saveAnnounce = saveAnnounce;
  this.afterDateStart = afterDateStart;
  this.beforeDate = beforeDate;

 function afterDateStart($dates){
    maxDate = new Date(this.date_start).setHours(0,0,0,0); // Set minimum date to whatever you want here

    for(d in $dates){        
        if($dates[d].utcDateValue < maxDate){
            $dates[d].selectable = false;
        }
    }
  }

  function beforeDate($dates){
    maxDate = new Date().setHours(0,0,0,0); // Set minimum date to whatever you want here

    for(d in $dates){        
        if($dates[d].utcDateValue < maxDate){
            $dates[d].selectable = false;
        }
    }
  }

  function saveAnnounce(){
    self.errors = Constants.FALSE;
    this.errors = Constants.FALSE;
    this.start = $("input[name='hidden_start']").val();
    this.end = $("input[name='hidden_end']").val();

    $scope.ui_block();
    announcementApiService.saveAnnounce(this.start, this.end, this.announce_message).success(function(response){
      if(response.status == Constants.STATUS_OK){
        if(response.errors){
          self.errors = $scope.errorHandler(response.errors);
        }else if(response.data){
          self.is_success = Constants.ANNOUNCE_SUCCESS;
        }
      }

      $scope.ui_unblock();
    }).error(function(response){
      $scope.ui_unblock();
      $scope.internalError();
    });


  }
}