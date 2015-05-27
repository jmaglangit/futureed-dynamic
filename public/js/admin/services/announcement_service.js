angular.module('futureed.services')
	.factory('announcementApiService', announcementApiService);

function announcementApiService($http){
	var announcementApi = {};
	var announceApiUrl = '/api/v1/';

	announcementApi.saveAnnounce = saveAnnounce;
	announcementApi.getAnnouncement = getAnnouncement;

	function saveAnnounce(start, end, message){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {date_start : start, date_end : end, announcement : message}
			, url 	: announceApiUrl + 'announcement'
		});
	}

	function getAnnouncement(){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: announceApiUrl + 'announcement'
		});
	}

	return announcementApi;
}