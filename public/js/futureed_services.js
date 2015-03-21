angular.module('futureed.services', [])
.factory('futureedAPIservice', function($http) {
	
	var futureedAPI = {};
	var futureedAPIUrl = '/api/v1/';
/*
	
	futureEdAPI.getDrivers = function() {
		return $http({
		method: 'JSONP', 
		url: 'http://ergast.com/api/f1/2013/driverStandings.json?callback=JSON_CALLBACK'
		});
	}
	
*/
	
	return futureEdAPI;
});