angular.module('futureed.services')
	.factory('ManageModuleService', ManageModuleService);

ManageModuleService.$inject = ['$http'];

function ManageModuleService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.list = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'module/admin?subject=' + search.subject
				+ '&name=' + search.name
				+ '&area=' + search.area
				+ '&grade_id=' + search.grade_id
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	api.questionList = function(search, table) {
        return $http({
            method  : Constants.METHOD_GET
            , url   : apiUrl + 'question/admin?module_id=' + search.module_id
                + '&question_type=' + search.question_type
                + '&questions_text=' + search.questions_text
                + '&limit=' + table.size
                + '&offset=' + table.offset
        });
    }

	api.getSubject = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'subject'
		});
	}

	api.searchArea = function(id, name) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'subject-area?subject_id=' + id
				+ '&name=' + name
		});
	}

	api.add  = function(data){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: apiUrl + 'module/admin'
		});
	}

	api.details  = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'module/admin/' + id
		});
	}

	api.update  = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: apiUrl + 'module/admin/' + data.id
		});
	}

	api.deleteModule  = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: apiUrl + 'module/admin/' + id
		});
	}

	api.getGraph = function(question_id) {
		return $http({
			method 	: Constants.METHOD_GET,
			url     : apiUrl + 'student/question/graph/' + question_id
		});
	}

	api.getAnswerExplanation = function(data){
		return $http({
			method	:	Constants.METHOD_GET,
			url	    :	apiUrl + 'answer-explanation?'
				+	'module_id=' +	data.module_id
				+	'&question_id='	+	data.question_id
				+	'&seq_no='	+	data.seq_no
		});
	}

	api.getPackageCountries = function(){
		return $http({
			method	:	Constants.METHOD_GET,
			url		:	apiUrl + 'subscription-package/countries'
		});
	}

	api.getGrade = function(id){
		return $http({
			method	:	Constants.METHOD_GET,
			url		:	apiUrl + 'grade/' + id
		});
	}

	return api
}