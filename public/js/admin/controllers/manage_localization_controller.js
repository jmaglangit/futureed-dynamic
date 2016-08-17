angular.module('futureed.controllers')
    .controller('ManageLocalizationController', ManageLocalizationController);

ManageLocalizationController.$inject = ['$scope', 'ManageLocalizationService','apiService', 'TableService', 'SearchService','Upload'];

function ManageLocalizationController($scope, ManageLocalizationService, apiService, TableService, SearchService, Upload) {

    var self = this;

    TableService(self);
    self.tableDefaults();

    SearchService(self);
    self.searchDefaults();

    self.setActive = function(active){
        self.errors = Constants.FALSE;

        self.active_translation = Constants.FALSE;
        self.active_setting = Constants.FALSE;
        self.locale_code = Constants.NONE;

        switch(active) {
            case Constants.LOCALIZATION_TRANSLATION:
                self.active_translation = Constants.TRUE;
                break;

            case Constants.LOCALIZATION_SETTING:
                self.active_setting = Constants.TRUE;
                break;

            default:
                break;
        }

    }

    //get languages available
    self.getLanguages = function(){
        self.errors = Constants.FALSE;

        self.locale_code = Constants.NONE;

        ManageLocalizationService.getLanguages().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.languages = response.data;
                }
            }
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    //download translation per language
    self.downloadTranslation = function(){
        self.errors = Constants.FALSE;

        ManageLocalizationService.downloadTranslation(self.locale_code).success(function(data,status,headers,config){
            if (status != Constants.STATUS_OK) {
                self.errors = $scope.errorHandler(data);
            } else if (data) {
                var filename = headers('content-disposition').split(";")[1].trim().split("=")[1];

                var blob = new Blob([data], {type: "application/csv; charset=UTF-8"});
                saveAs(blob, filename.replace(/"/g, ''));
            }
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });

    }

    //upload translation
    self.uploadTranslation = function(file){

        self.uploaded = Constants.FALSE;
        self.base_url = $("#base_url_form input[name='base_url']").val();

        if(file.length) {
            $scope.ui_block();
            Upload.upload({
                url: '/api/v1/module-translation/upload?target_lang=' + self.locale_code
                , file: file[0]
            }).success(function(response) {
                if(angular.equals(response.status, Constants.STATUS_OK)) {
                    if(response.errors) {
                        self.errors = $scope.errorHandler(response.errors);
                    }else if(response.data){
                        var data = response.data;
                        self.errors = Constants.FALSE;
                        self.upload_records = data;
                        self.report_status = Constants.TRUE;

                        if(data.fail_count > 0){
                            self.fail_count = Constants.TRUE;
                        }

                        if(data.inserted_count > 0){
                            self.inserted_count = Constants.TRUE;
                        }
                    }
                }

                $scope.ui_unblock();
            }).error(function(response) {
                self.errors = $scope.internalError();
                $scope.ui_unblock();
            });
        }
    }
}