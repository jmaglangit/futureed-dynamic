angular.module('futureed.services')
	.factory('announcementApiService', announcementApiService);

function announcementApiService($http){
	var announcementApi = {};
	var announceApiUrl = '/api/v1/';

	announcementApi.saveAnnounce = saveAnnounce;

	function saveAnnounce(start, end, message){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {date_start : start, date_end : end, announcement : message}
			, url 	: announceApiUrl + 'announcement'
		});
	}

	return announcementApi;
}