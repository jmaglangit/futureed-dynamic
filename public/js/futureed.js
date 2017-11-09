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
					config.headers.Authorization = localStorage.authorization;
				}

				return config;
			} 

			, 'response': function (response) {
				localStorage.token_expire = Constants.FALSE;
				localStorage.multiple_session = Constants.FALSE;

				if(response && response.headers("Authorization")) {
					localStorage.authorization = response.headers("Authorization");
				}

				if(response.data.status == Constants.HTTP_UNAUTHORIZED) {
					localStorage.token_expire = Constants.TRUE;
				}

				if(response.data.status == Constants.HTTP_NOT_ACCEPTABLE) {
					localStorage.multiple_session = Constants.TRUE;
				}

				return response;
			}
		};
	}]);
}]);