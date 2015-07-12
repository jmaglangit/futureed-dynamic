'use strict';

angular.module('futureed', [
	'ui.bootstrap',
	'evgenyneu.markdown-preview',
	'futureed.services',
	'futureed.controllers',
	'ui.bootstrap.datetimepicker'
]).config(['$interpolateProvider'
	, '$httpProvider'
	, function($interpolateProvider, $httpProvider) {

	$interpolateProvider.startSymbol('{!');
	$interpolateProvider.endSymbol('!}');

	$httpProvider.interceptors.push([function() {
		return {
			'request' : function(config) {
				if(localStorage.authorization) {
					config.headers.authorization = localStorage.authorization;
				}

				return config;
			} 

			, 'response': function (response) {
				if(response && response.headers("authorization")) {
					localStorage.authorization = response.headers("authorization");
				}

				return response;
			}
		};
	}]);
}]);