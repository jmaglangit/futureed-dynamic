angular.module('futureed.controllers')
    .controller('ManageSubscriptionDaysController', ManageSubscriptionDaysController);

ManagePriceController.$inject = ['$scope','salesService', 'TableService'];

function ManageSubscriptionDaysController($scope, salesService, TableService){
    var self = this;

    TableService(self);
    self.tableDefaults();

    self.setActive = function(active, id) {
        self.errors = Constants.FALSE;
        self.success = Constants.FALSE;

        self.record = {};
        self.fields = [];

        self.tableDefaults();

        self.active_list = Constants.TRUE;
        self.active_add = Constants.FALSE;
        self.active_edit = Constants.FALSE;

        switch(active) {
            case	Constants.ACTIVE_ADD :
                self.active_add = Constants.TRUE;
                break;

            case	Constants.ACTIVE_EDIT :
                self.active_edit = Constants.TRUE;
                self.details(id);
                break;

            case	Constants.ACTIVE_CANCEL :
                self.active_list = Constants.TRUE;
                break;

            default	:
                self.active_list = Constants.TRUE;
                self.list();
                break;
        }

    }

    self.list = function(){
        self.errors = Constants.FALSE;

        salesService.getSubscriptionDays().success(function(response){
            self.table.loading = Constants.TRUE;

            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);
                }else if(response.data){
                    self.records = response.data.records;
                    self.updatePageCount(response.data);
                }
            }

        }).error(function(response){
            $scope.ui_unblock();
            self.errors = $scope.internalError();
        });
    };

    self.add = function(){
        self.errors = Constants.FALSE;
        self.fields = [];

        $scope.ui_block();
        salesService.addSubscriptionDay(self.record).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);

                    angular.forEach(response.errors, function(value, key){
                        self.fields[value.field] = Constants.TRUE;
                    });
                }else if(response.data){
                    self.setActive();
                    self.success = Constants.MSG_CREATED(Constants.SUBSCRIPTION_DAYS);
                }
            }
            $scope.ui_unblock();
        }).error(function(response){
            $scope.ui_unblock();
            self.errors = $scope.internalError();
        });

    };

    self.details = function(id){
        self.errors = Constants.FALSE;

        $scope.ui_block();
        salesService.getSubscriptionDay(id).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);
                }else if(response.data){
                    self.record = response.data;
                }
            }

            $scope.ui_unblock();
        }).error(function(response){
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    };

    self.update = function(){
        self.errors = Constants.FALSE;
        self.success = Constants.FALSE;
        self.fields = [];

        //self.record.days = Math.abs(self.record.days);

        $scope.ui_block();
        salesService.updateSubscriptionDay(self.record).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)){
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);

                    angular.forEach(response.errors, function(value, key){
                        self.fields[value.field] = Constants.TRUE;
                    });
                }else if(response.data) {
                    self.setActive();
                    self.success = Constants.MSG_UPDATED(Constants.SUBSCRIPTION_DAYS);
                }
            }
            $scope.ui_unblock();
        }).error(function(response){
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    };

    self.delete = function(id){
        self.errors = Constants.FALSE;
        self.success = Constants.FALSE;

        $scope.ui_block();
        salesService.deleteSubscriptionDay(id).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)){
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);
                }else if(response.data) {
                    self.setActive();
                    self.success = Constants.MSG_DELETED(Constants.SUBSCRIPTION_DAYS);
                }
            }
            $scope.ui_unblock();
        }).error(function(response){
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    };

}