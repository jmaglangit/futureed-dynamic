angular.module('futureed.controllers')
    .controller('ManageSubscriptionPackagesController', ManageSubscriptionPackagesController);

ManagePriceController.$inject = ['$scope','salesService', 'TableService'];

function ManageSubscriptionPackagesController($scope, salesService, TableService){
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

            default	:
                self.active_list = Constants.TRUE;
                self.list();
                break;
        }
    };

    self.list = function(){
        self.errors = Constants.FALSE;

        salesService.getSubscriptionPackages(self.table).success(function(response){
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

    //get subject
    self.getSubject = function() {
        $scope.ui_block();
        salesService.getSubject().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)){
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data){
                    self.subjects = response.data.records;
                }
            }
            $scope.ui_unblock();
        }).error(function(response){
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    };

    //get subscription
    self.getSubscriptions = function(){
        $scope.ui_block();
        salesService.getSubscriptions().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)){
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data){
                    self.subscriptions = response.data.records;
                }
            }
        }).error(function(response){
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    };

    //get countries
    self.getCountries = function(){
        $scope.ui_block();
        salesService.getCountries().success(function(response){
            if(angular.equals(response.status,Constants.STATUS_OK)){
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data){
                    self.countries = response.data;
                }
            }
        }).error(function(response){
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    };

    //get subscription days
    self.getSubscriptionDays = function(){
      $scope.ui_block();
        salesService.getSubscriptionDays().success(function(response){
            if(angular.equals(response.status,Constants.STATUS_OK)){
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);
                } else if (response.data) {
                    self.subscription_days = response.data.records;
                }
            }
        }).error(function(response){
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    };

    //add package
    self.add = function(){
        self.errors = Constants.FALSE;
        self.fields = [];

        $scope.ui_block();
        salesService.addSubscriptionPackage(self.record).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)){
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);
                    angular.forEach(response.errors, function(value,key){
                        self.fields[value.field] = Constants.TRUE;
                    });
                } else if (response.data){
                    self.setActive();
                    self.success = Constants.MSG_CREATED(Constants.SUBSCRIPTION_PACKAGES);
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
        salesService.getSubscriptionPackage(id).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);
                }else if(response.data){
                    self.record = response.data;
                    console.log(self.record);
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

        $scope.ui_block();
        salesService.updateSubscriptionPackage(self.record).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)){
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);

                    angular.forEach(response.errors, function(value, key){
                        self.fields[value.field] = Constants.TRUE;
                    });
                }else if(response.data) {
                    self.setActive();
                    self.success = Constants.MSG_UPDATED(Constants.SUBSCRIPTION_PACKAGES);
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
        salesService.deleteSubscriptionPackage(id).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)){
                if(response.errors){
                    self.errors = $scope.errorHandler(response.errors);
                }else if(response.data) {
                    self.setActive();
                    self.success = Constants.MSG_DELETED(Constants.SUBSCRIPTION_PACKAGES);
                }
            }
            $scope.ui_unblock();
        }).error(function(response){
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    };


}