angular.module('futureed.services')
	.factory('SearchService', SearchService);

function SearchService() {
	return function (scope) {
		angular.extend(scope, {

			searchDefaults : function() {
				scope.search = {};

				scope.search.area = Constants.EMPTY_STR;
				scope.search.client_id = Constants.EMPTY_STR;
				scope.search.country_id = Constants.EMPTY_STR;
				scope.search.email = Constants.EMPTY_STR;
				scope.search.help_request = Constants.EMPTY_STR;
				scope.search.help_request_type = Constants.EMPTY_STR;
				scope.search.grade = Constants.EMPTY_STR;
				scope.search.grade_id = Constants.EMPTY_STR;
				scope.search.learning_style = Constants.EMPTY_STR;
				scope.search.link_type = Constants.EMPTY_STR;
				scope.search.module = Constants.EMPTY_STR;
				scope.search.name = Constants.EMPTY_STR;
				scope.search.order_no = Constants.EMPTY_STR;
				scope.search.payment_status = Constants.EMPTY_STR;
				scope.search.request_answer_status = Constants.EMPTY_STR;
				scope.search.request_status = Constants.EMPTY_STR;
				scope.search.school_code = Constants.EMPTY_STR;
				scope.search.question_status = Constants.EMPTY_STR;
				scope.search.status = Constants.EMPTY_STR;
				scope.search.student_id = Constants.EMPTY_STR;
				scope.search.subscription = Constants.EMPTY_STR;
				scope.search.subscription_id = Constants.EMPTY_STR;
				scope.search.subscription_name = Constants.EMPTY_STR;
				scope.search.subject = Constants.EMPTY_STR;
				scope.search.subject_area = Constants.EMPTY_STR;
				scope.search.subject_id = Constants.EMPTY_STR;
				scope.search.teaching_module = Constants.EMPTY_STR;
				scope.search.title = Constants.EMPTY_STR;
				scope.search.created = Constants.EMPTY_STR;
			}
		});
	};
}
