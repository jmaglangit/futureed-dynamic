angular.module('futureed.controllers')
    .controller('ManageLocalizationTranslationController', ManageLocalizationTranslationController);

ManageLocalizationTranslationController.$inject = ['$scope', 'ManageLocalizationService', 'apiService', 'TableService', 'SearchService'];

function ManageLocalizationTranslationController($scope, ManageLocalizationTranslationService, apiService, TableService, SearchService) {

    var self = this;

    TableService(self);
    self.tableDefaults();

    SearchService(self);
    self.searchDefaults();

    self.setActive = function(active){
        self.errors = Constants.FALSE;

        switch(active) {
            case Constants.LOCALIZATION_TRANSLATION:
                self.active_translation = Constants.TRUE;
                break;

            case Constants.LOCALIZATION_SETTINGS:
                self.active_settings = Constants.TRUE;
                break;

            default:
                self.active_translation = Constants.FALSE;
                self.active_settings = Constants.FALSE;
                break;
        }

    }

}