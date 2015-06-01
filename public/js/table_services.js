angular.module('futureed.services')
	.factory('TableServices', TableServices);

TableServices.$inject = ['$http'];

function TableServices($http) {
	self.paginateBySize = function() {
		self.table.page = 1;
		self.table.offset = (self.table.page - 1) * self.table.size;
		self.getAdminList();
	}

	self.paginateByPage = function() {
		var page = self.table.page;
		
		self.table.page = (page < 1) ? 1 : page;
		self.table.offset = (page - 1) * self.table.size;

		self.getAdminList();
	}

	self.updateTable = function(data) {
		self.table.total_items = data.total;

		// Set Page Count
		var page_count = data.total / self.table.size;
			page_count = (page_count < Constants.DEFAULT_PAGE) ? Constants.DEFAULT_PAGE : Math.ceil(page_count);
		self.table.page_count = page_count;
	}
}