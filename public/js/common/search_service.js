angular.module('futureed.services')
	.factory('SearchService', SearchService);

function SearchService() {
	return function (scope) {
	    angular.extend(scope, {

	    	searchDefaults : function() {
	    		scope.search = {};
	    		scope.search.name = Constants.EMPTY_STR;
				scope.search.email = Constants.EMPTY_STR;
				scope.search.grade_id = Constants.EMPTY_STR;
	    	}
	    });
	};
}
