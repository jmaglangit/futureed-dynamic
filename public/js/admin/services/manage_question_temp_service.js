angular.module('futureed.services')
	.factory('ManageQuestionTempService', ManageQuestionTempService);

ManageQuestionTempService.$inject = ['$http'];

function ManageQuestionTempService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.list = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'question-template?question_type=' + search.question_type
				+ '&question_template_format=' + search.question_template_format
				+ '&question_equation=' + search.question_equation
				+ '&question_form=' + search.question_form
				+ '&operation=' + search.operation
				+ '&status=' + search.status
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}
	api.add  = function(data){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: apiUrl + 'question-template'
		});
	}

	api.details  = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'question-template/' + id
		});
	}

	api.update  = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: apiUrl + 'question-template/' + data.id
		});
	}

	api.deleteTemplate  = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: apiUrl + 'question-template/' + id
		});
	}

    // api/v1/module-question-template
	api.addModuleTemplates = function(data){
		return $http({
			method	: Constants.METHOD_POST
			, data	: data
			, url	: apiUrl + 'module/question-template'
		});
	}

    api.getModuleTemplates = function(module_id){
        return $http({
            method	: Constants.METHOD_GET
            , url	: apiUrl + 'module/question-template/' + module_id
        });
    }

    api.generateDynamicQuestions = function(module_id){
        return $http({
            method	:	Constants.METHOD_GET,
            url		:	apiUrl + 'generate-question?module_id=' + module_id
        });
    }

    api.questionPreview = function(data){
    	return $http({
			method	:	Constants.METHOD_GET
			, url	:	apiUrl + 'preview-question?question_template_format=' + data.question_template_format
					+ '&operation=' + data.operation
					+ '&question_form=' + data.question_form
		});
	}

    return api
}