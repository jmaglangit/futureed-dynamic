angular.module('futureed.services')
	.factory('TableService', TableService);

TableService.$inject = ['$http'];

function TableService($http) {
	return function (scope) {
	    angular.extend(scope, {

	    	tableDefaults : function() {
	    		scope.table = {};
	    		scope.table.size = Constants.DEFAULT_SIZE;
				scope.table.page = Constants.DEFAULT_PAGE;
	    	}

			, paginateByPage: function() {
				var page = scope.table.page;
		
				scope.table.page = (page < 1) ? 1 : page;
				scope.table.offset = (page - 1) * scope.table.size;
				scope.list();
			}

			, paginateBySize: function() {
				scope.table.page = 1;
				scope.table.offset = (scope.table.page - 1) * scope.table.size;
				scope.list();
			}

			, updatePageCount: function(data) {
				scope.table.total_items = data.total;

				// Set Page Count
				var page_count = data.total / scope.table.size;
					page_count = (page_count < Constants.DEFAULT_PAGE) ? Constants.DEFAULT_PAGE : Math.ceil(page_count);
				scope.table.page_count = page_count;
			}
	    });
	};
}
