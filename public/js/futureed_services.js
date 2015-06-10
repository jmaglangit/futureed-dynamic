var services = angular.module('futureed.services', []);

	services.factory('apiService', function($http) {
		var futureedAPI = {};
		var futureedAPIUrl = '/api/v1/';

		/**
		* Common API Calls
		*/

		futureedAPI.forgotPassword = function(username, user_type, callback_uri) {
			return $http({
				method 	: Constants.METHOD_POST
				, data	: {username: username, user_type : user_type, callback_uri : callback_uri}
				, url	: futureedAPIUrl + 'user/password/forgot'
			});
		}

		futureedAPI.resendResetCode = function(email, user_type, callback_uri) {
			return $http({
				method 	: Constants.METHOD_POST
				, data	: {email: email, user_type : user_type, callback_uri : callback_uri}
				, url	: futureedAPIUrl + 'user/reset/code'
			});
		}

		futureedAPI.resendConfirmation = function(email, user_type, callback_uri) {
			return $http({
				method	: 'POST'
				, data 	: {email : email, user_type : user_type, callback_uri : callback_uri}
				, url	: futureedAPIUrl + 'user/confirmation/code'
			});
		}

		/**
		* Student Services
		*/
		futureedAPI.updateUserSession = function(user) {
			return $http({
				method	: 'POST',
				data 	: user,
				url		: '/student/update-user-session'
			});
		}

		futureedAPI.validateUser = function(username) {
			return $http({
				method 	: 'POST'
				, data	: { username : username } 
				, url	: futureedAPIUrl + 'student/login/username'
			});
		}

		futureedAPI.getLoginPassword = function(id) {
			return $http({
				method	: 'POST'
				, data	: {id : id}
				, url	: futureedAPIUrl + 'student/login/image'
			});
		}

		futureedAPI.getImagePassword = function() {
			return $http({
				method	: 'GET'
				, url	: futureedAPIUrl + 'student/password/image'
			});
		}

		futureedAPI.validatePassword = function(id, image_id) {
			return $http({
				method	: 'POST'
				, data	: {id : id, image_id : image_id}
				, url	: futureedAPIUrl + 'student/login/password'
			});
		}

		futureedAPI.validateCode = function(code, email, user_type) {
			return $http({
				method	: 'POST'
				, data 	: {email : email, user_type : user_type, reset_code : code}
				, url	: futureedAPIUrl + 'user/password/code'
			});
		}

		futureedAPI.changeValidate = function(id, email_new, image_id, callback_uri) {
			return $http({
				method	: 'PUT'
				, data	: {new_email : email_new, password_image_id : image_id, callback_uri : callback_uri}
				, url	: futureedAPIUrl + 'student/email/' + id
			});
		}

		futureedAPI.emailValidateCode = function(new_email, user_type, confirmation_code) {
			return $http({
				method	: 'POST'
				, data 	: {new_email : new_email, user_type : user_type, confirmation_code : confirmation_code}
				, url	: futureedAPIUrl + 'student/confirmation/email'
			});
		}

		futureedAPI.emailResendCode = function(id, new_email, user_type, callback_uri){
			return $http({
				method	: 'POST'
				, data 	: {new_email : new_email, user_type : user_type, callback_uri : callback_uri}
				, url 	: futureedAPIUrl + 'student/resend/email/' + id
			});
		}

		futureedAPI.confirmCode = function(email, email_code, user_type) {
			return $http({
				method	: 'POST'
				, data 	: {email : email, email_code : email_code, user_type : user_type}
				, url	: futureedAPIUrl + 'user/email/code'
			});
		}

		futureedAPI.resetPassword = function (id, code, image_id) {
			return $http({
				method	: 'POST'
				, data	: {id : id, reset_code : code, password_image_id : image_id}
				, url	: futureedAPIUrl + 'student/password/reset'
			});
		}

		futureedAPI.setPassword = function (id, image_id) {
			return $http({
				method	: 'POST'
				, data	: {id : id, password_image_id : image_id}
				, url	: futureedAPIUrl + 'student/password/new'
			});
		}

		futureedAPI.getCountries = function() {
			return $http({
				method	: 'GET'
				, url	: futureedAPIUrl + 'countries'
			});
		}

		futureedAPI.getGradeLevel =function(countryid) {
			return $http({
				method	: 'GET'
				, url	: futureedAPIUrl + 'grade?country_id=' + countryid
			});
		}

		// Student Please
		futureedAPI.validateUsername = function(username, user_type) {
			return $http({
				method 	: 'POST'
				, data 	: {username : username, user_type : user_type}
				, url 	: futureedAPIUrl + 'user/username'
			});
		}

		// Student Please
		futureedAPI.validateEmail = function(email, user_type) {
			return $http({
				method	: 'POST'
				, data 	: {email : email, user_type : user_type}
				, url	: futureedAPIUrl + 'user/email'
			});
		}

		futureedAPI.validateRegistration = function(registration) {
			return $http({
				method	: 'POST'
				, data	: registration
				, url	: futureedAPIUrl + 'student/register'
			});
		}

		futureedAPI.getAvatarImages = function(gender) {
			return $http({
				method	: 'POST'
				, data	: {gender : gender}
				, url	: futureedAPIUrl + 'user/avatar'
			});
		}

		futureedAPI.selectAvatar = function(id, avatar_id) {
			return $http({
				method	: 'POST'
				, data	: {id : id, avatar_id : avatar_id}
				, url	: futureedAPIUrl + 'user/avatar/new'
			});
		}

		/**
		* Profile related calls
		*/
		futureedAPI.studentDetails = function(id) {
			return $http({
				method 	: 'GET'
				, url	: futureedAPIUrl + 'student/' + id
			});
		}

		futureedAPI.saveProfile = function(data) {
			return $http.put(futureedAPIUrl + 'student/' + data.id, data);
		}

		futureedAPI.validateCurrentPassword = function(id, password_image_id) {
			return $http({
				method 	: 'POST'
				, data 	: {password_image_id : password_image_id}
				, url 	: futureedAPIUrl + 'student/password/confirm/' + id
			});
		}

		futureedAPI.changePassword = function(id, password_image_id, access_token) {
			return $http({
				method	: 'POST'
				, data 	: {password_image_id : password_image_id, access_token : access_token}
				, url 	: futureedAPIUrl + 'student/password/' + id
			});
		}

		futureedAPI.getAnnouncement = function(){
			return $http({
				method 	: Constants.METHOD_GET
				, url 	: futureedAPIUrl + 'announcement'
			});
		}
		
		return futureedAPI;
	});