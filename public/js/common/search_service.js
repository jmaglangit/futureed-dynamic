angular.module('futureed.services')
	.factory('SearchService', SearchService);

function SearchService() {
	return function (scope) {
		angular.extend(scope, {

			searchDefaults : function() {
				scope.search = {
					  area					: 	Constants.EMPTY_STR
					, api_accessed			: 	Constants.EMPTY_STR

					, client_id				: 	Constants.EMPTY_STR
					, country_id			: 	Constants.EMPTY_STR
					, class_id				: 	Constants.EMPTY_STR
					
					, date_start			: 	Constants.EMPTY_STR
					, date_end				: 	Constants.EMPTY_STR

					, email					: 	Constants.EMPTY_STR
					, help_request			: 	Constants.EMPTY_STR
					, help_request_type 	: 	Constants.EMPTY_STR
					, grade 				: 	Constants.EMPTY_STR
					, grade_id				: 	Constants.EMPTY_STR
					, learning_style		: 	Constants.EMPTY_STR
					, link_type				: 	Constants.EMPTY_STR
					, module				: 	Constants.EMPTY_STR
					, module_name			: 	Constants.EMPTY_STR
					, module_status			: 	Constants.EMPTY_STR
					, name					: 	Constants.EMPTY_STR
					, order_no				: 	Constants.EMPTY_STR
					, page_accessed			: 	Constants.EMPTY_STR
					, payment_status		: 	Constants.EMPTY_STR
					
					, request_answer_status	: 	Constants.EMPTY_STR
					, request_status		: 	Constants.EMPTY_STR
					, role					: 	Constants.EMPTY_STR
					, school_code			: 	Constants.EMPTY_STR
					, question_status		: 	Constants.EMPTY_STR
					, status				: 	Constants.EMPTY_STR
					, result_response		:	Constants.EMPTY_STR
					, student_id			: 	Constants.EMPTY_STR
					, subscription			: 	Constants.EMPTY_STR
					, subscription_id		: 	Constants.EMPTY_STR
					, subscription_name		: 	Constants.EMPTY_STR
					, subject				: 	Constants.EMPTY_STR
					, subject_area			: 	Constants.EMPTY_STR
					, subject_id			: 	Constants.EMPTY_STR
					, teaching_module		: 	Constants.EMPTY_STR
					, title					: 	Constants.EMPTY_STR
					, user					: 	Constants.EMPTY_STR
					, username				: 	Constants.EMPTY_STR
					, user_id				: 	Constants.EMPTY_STR
					, user_type				: 	Constants.EMPTY_STR

					, created				: 	Constants.EMPTY_STR
					, question_type			: 	Constants.EMPTY_STR
					, questions_text		: 	Constants.EMPTY_STR
				}
			}
		})
	}
}
