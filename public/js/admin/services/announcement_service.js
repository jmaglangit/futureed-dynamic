angular.module('futureed.services')
	.factory('announcementApiService', announcementApiService);

function announcementApiService($http){
	var announcementApi = {};
	var announceApiUrl = '/api/v1/announcement';

	announcementApi.saveAnnounce = function(start, end, message){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {date_start : start, date_end : end, announcement : message}
			, url 	: announceApiUrl
		});
	}

	announcementApi.getAnnouncement = function(){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: announceApiUrl
		});
	}

	return announcementApi;
}