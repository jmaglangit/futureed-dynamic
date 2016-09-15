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
        self.module_locale_code = Constants.NONE;
        self.locale_code = Constants.NONE;
        self.module_google_translate = Constants.FALSE;
        self.module_field = Constants.FALSE;
        self.translate_tag = Constants.TRUE;
        self.question_google_translate = Constants.FALSE;
        self.question_field = Constants.FALSE;
        self.question_answer_google_translate = Constants.FALSE;
        self.question_answer_field = Constants.FALSE;
        self.answer_explanation_google_translate = Constants.FALSE;
        self.answer_explanation_field = Constants.FALSE;
        self.quote_google_translate = Constants.FALSE;
        self.quote_field = Constants.FALSE;

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

    //to activate every accordion
    self.translationActive = function(active){

        switch (active) {
            case Constants.LOCALIZATION_MODULE:

                self.active_loc_module == Constants.TRUE ? self.active_loc_module = Constants.FALSE
                    : self.active_loc_module = Constants.TRUE;

                self.active_loc_question =
                    self.active_loc_question_ans =
                        self.active_loc_answer_exp =
                            self.active_loc_quote = Constants.FALSE;
                break;
            case Constants.LOCALIZATION_QUESTION:

                self.active_loc_question == Constants.TRUE ? self.active_loc_question = Constants.FALSE
                    : self.active_loc_question = Constants.TRUE;

                self.active_loc_module =
                    self.active_loc_question_ans =
                        self.active_loc_answer_exp =
                            self.active_loc_quote = Constants.FALSE;
                break;
            case Constants.LOCALIZATION_QUESTION_ANS:

                self.active_loc_question_ans == Constants.TRUE ? self.active_loc_question_ans = Constants.FALSE
                    : self.active_loc_question_ans = Constants.TRUE;

                self.active_loc_module =
                    self.active_loc_question =
                        self.active_loc_answer_exp =
                            self.active_loc_quote = Constants.FALSE;
                break;
            case Constants.LOCALIZATION_ANSWER_EXP:

                self.active_loc_answer_exp == Constants.TRUE ? self.active_loc_answer_exp = Constants.FALSE
                    : self.active_loc_answer_exp = Constants.TRUE;

                self.active_loc_module =
                    self.active_loc_question =
                        self.active_loc_question_ans =
                            self.active_loc_quote = Constants.FALSE;
                break;
            case Constants.LOCALIZATION_QUOTE:

                self.active_loc_quote == Constants.TRUE ? self.active_loc_quote = Constants.FALSE
                    : self.active_loc_quote = Constants.TRUE;

                self.active_loc_module =
                    self.active_loc_question =
                        self.active_loc_question_ans =
                            self.active_loc_answer_exp = Constants.FALSE;
                break;
            default:
                self.active_loc_module == Constants.TRUE ? self.active_loc_module = Constants.FALSE
                    : self.active_loc_module = Constants.FALSE;

                self.active_loc_question =
                    self.active_loc_question_ans =
                        self.active_loc_answer_exp =
                            self.active_loc_quote = Constants.FALSE;
                break;
        }
    }

    //get translatable module field
    self.getTranslatableModuleField = function(){

        ManageLocalizationService.getModuleTranslationFields().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.module_translated_field = response.data;
                }
            }
        }).error(function () {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    //set field for module translation options
    self.setModuleField = function(){

        self.module_google_translate = Constants.FALSE;

        //check of automated translation
        if(self.module_field && self.module_field.auto == Constants.TRUE){
            //activate google translate
            self.module_google_translate = Constants.TRUE;
        }
    }


    //get module languages available
    self.getModuleLanguages = function(){
        self.errors = Constants.FALSE;

        self.module_locale_code = Constants.NONE;

        ManageLocalizationService.getLanguages().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.module_languages = response.data;
                }
            }
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    //get all languages enabled by the app
    self.getAllLanguages = function(){
        self.errors = Constants.FALSE;

        self.locale_code = Constants.NONE;

        //get app call to get all languages.
        ManageLocalizationService.getAllLanguages().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.all_languages = response.data;
                }
            }
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });


    }

    //initialize language translation
    self.initializeTranslation = function(){
        self.errors = Constants.FALSE;

        $scope.ui_block();
        ManageLocalizationService.initializeTranslation(self.locale_code).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                } else {
                    self.success = response.data;
                }
            }
            $scope.ui_unblock();
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    //download translation per language
    self.moduleDownloadTranslation = function(){
        self.errors = Constants.FALSE;

        ManageLocalizationService.downloadTranslation(self.module_locale_code).success(function(data,status,headers,config){
            if (data.errors) {
                self.success = Constants.FALSE;
                self.errors = $scope.errorHandler(data.errors);
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
    self.moduleUploadTranslation = function(file){

        self.uploaded = Constants.FALSE;
        self.base_url = $("#base_url_form input[name='base_url']").val();

        if(file.length) {
            $scope.ui_block();
            Upload.upload({
                url: '/api/v1/module-translation/upload?target_lang=' + self.module_locale_code
                , file: file[0]
            }).success(function(response) {
                if(angular.equals(response.status, Constants.STATUS_OK)) {
                    if(response.errors) {
                        self.success = Constants.FALSE;
                        self.errors = $scope.errorHandler(response.errors);
                    }else if(response.data){
                        var data = response.data;
                        self.errors = Constants.FALSE;
                        self.success = data;
                    }
                }

                $scope.ui_unblock();
            }).error(function(response) {
                self.errors = $scope.internalError();
                $scope.ui_unblock();
            });
        }
    }

    //google translate
    self.moduleGoogleTranslate = function(){

        var data = {
            target_lang : self.module_locale_code,
            field   : self.module_field.field,
            tagged  : self.translate_tag
        };

        $scope.ui_block();
        ManageLocalizationService.googleTranslateField(data).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                }else if(response.data){
                    var data = response.data;
                    self.errors = Constants.FALSE;
                    self.success = data;
                }
            }
            $scope.ui_unblock();
        }).error(function () {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    //set translate tag
    self.moduleActiveTag = function(val){
        self.translate_tag = val;
    }

    //Questions

    //get question languages
    self.getQuestionLanguages = function(){
        self.errors = Constants.FALSE;

        self.question_locale_code = Constants.NONE;

        ManageLocalizationService.getQuestionLanguages().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.question_languages = response.data;
                }
            }
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.getTranslatableQuestionField = function(){
        ManageLocalizationService.getQuestionTranslatableFields().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.question_translated_field = response.data;
                }
            }
        }).error(function () {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.questionActiveTag = function(val){
        self.translate_tag = val;
    }

    self.questionGoogleTranslate = function(){
        var data = {
            target_lang : self.question_locale_code,
            field   : self.question_field.field,
            tagged  : self.translate_tag
        };

        $scope.ui_block();
        ManageLocalizationService.googleQuestionTranslateField(data).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                }else if(response.data){
                    var data = response.data;
                    self.errors = Constants.FALSE;
                    self.success = data;
                }
            }
            $scope.ui_unblock();
        }).error(function () {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    //Question Answer

    //get question answer languages
    self.getQuestionAnswerLanguages = function(){
        self.errors = Constants.FALSE;

        self.question_answer_locale_code = Constants.NONE;

        ManageLocalizationService.getQuestionAnswerLanguages().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.question_answer_languages = response.data;
                }
            }
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.getTranslatableQuestionAnswerField = function(){
        ManageLocalizationService.getQuestionAnswerTranslatableFields().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.question_answer_translated_field = response.data;
                }
            }
        }).error(function () {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.questionAnswerActiveTag = function(val){
        self.translate_tag = val;
    }

    self.questionAnswerGoogleTranslate = function(){
        var data = {
            target_lang : self.question_answer_locale_code,
            field   : self.question_answer_field.field,
            tagged  : self.translate_tag
        };

        $scope.ui_block();
        ManageLocalizationService.googleQuestionAnswerTranslateField(data).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                }else if(response.data){
                    var data = response.data;
                    self.errors = Constants.FALSE;
                    self.success = data;
                }
            }
            $scope.ui_unblock();
        }).error(function () {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    //Answer Explanation

    self.getAnswerExplanationLanguages = function(){
        self.errors = Constants.FALSE;

        self.answer_explanation_locale_code = Constants.NONE;

        ManageLocalizationService.getAnswerExplanationLanguages().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.answer_explanation_languages = response.data;
                }
            }
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.getTranslatableAnswerExplanationField = function(){
        ManageLocalizationService.getAnswerExplanationTranslatableFields().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.answer_explanation_translated_field = response.data;
                }
            }
        }).error(function () {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.answerExplanationActiveTag = function(val){
        self.translate_tag = val;
    }

    self.answerExplanationGoogleTranslate = function(){
        var data = {
            target_lang : self.answer_explanation_locale_code,
            field   : self.answer_explanation_field.field,
            tagged  : self.translate_tag
        };

        $scope.ui_block();
        ManageLocalizationService.googleAnswerExplanationTranslateField(data).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                }else if(response.data){
                    var data = response.data;
                    self.errors = Constants.FALSE;
                    self.success = data;
                }
            }
            $scope.ui_unblock();
        }).error(function () {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    //Quote

    self.getQuoteLanguages = function(){
        self.errors = Constants.FALSE;

        self.quote_locale_code = Constants.NONE;

        ManageLocalizationService.getQuoteLanguages().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.quote_languages = response.data;
                }
            }
        }).error(function (response) {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.getTranslatableQuoteField = function(){
        ManageLocalizationService.getQuoteTranslatableFields().success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                } else if(response.data) {
                    self.quote_translated_field = response.data;
                }
            }
        }).error(function () {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.quoteActiveTag = function(val){
        self.translate_tag = val;
    }

    self.quoteGoogleTranslate = function(){
        var data = {
            target_lang : self.quote_locale_code,
            field   : self.quote_field.field,
            tagged  : self.translate_tag
        };

        $scope.ui_block();
        ManageLocalizationService.googleQuoteTranslateField(data).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)) {
                if(response.errors) {
                    self.success = Constants.FALSE;
                    self.errors = $scope.errorHandler(response.errors);
                }else if(response.data){
                    var data = response.data;
                    self.errors = Constants.FALSE;
                    self.success = data;
                }
            }
            $scope.ui_unblock();
        }).error(function () {
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

}