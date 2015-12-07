var services = angular.module('futureed.services', []);

	services.factory('apiService', function($http, $q) {
		var futureedAPI = {};
		var futureedAPIUrl = '/api/v1/';

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

		futureedAPI.updateClientUserSession = function(user) {
			return $http({
				method	: 'POST',
				data 	: user,
				url		: '/client/update-user-session'
			});
		}

		futureedAPI.updateAdminUserSession = function(user) {
			return $http({
				method	: 'POST',
				data 	: user,
				url		: '/peaches/update-user-session'
			});
		}

		futureedAPI.getImagePassword = function() {
			return $http({
				method	: 'GET'
				, url	: futureedAPIUrl + 'student/password/image'
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

		futureedAPI.getCountries = function() {
			return $http({
				method	: 'GET'
				, url	: futureedAPIUrl + 'countries'
			});
		}

		futureedAPI.getGradeLevel =function(country_id) {
			return $http({
				method	: 'GET'
				, url	: futureedAPIUrl + 'grade?country_id=' + country_id
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

		futureedAPI.getAvatarAccessories = function(student_id) {
			return $http({
				method	: 'GET'
				, url	: futureedAPIUrl + 'avatar-accessory/get-accessories?student_id=' + student_id
			});
		}

		futureedAPI.buyAvatarAccessory = function(user_id, accessory_id) {
			return $http({
				method	: 'POST'
				, data	: {user_id : user_id, accessory_id : accessory_id}
				, url	: futureedAPIUrl + 'avatar-accessory/buy-accessory'
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

		futureedAPI.getAnnouncement = function(){
			return $http({
				method 	: Constants.METHOD_GET
				, url 	: futureedAPIUrl + 'announcement'
			});
		}

		futureedAPI.getCountryDetails = function(id) {
			return $http({
				method 	: Constants.METHOD_GET
				, url	: futureedAPIUrl + 'countries/' + id
			});
		}

		futureedAPI.getAgeGroup = function() {
			return $http({
				method 	: Constants.METHOD_GET
				, url	: futureedAPIUrl + 'age-group'
			});
		}

		futureedAPI.checkClass = function(id) {
			return $http({
				method 	: Constants.METHOD_POST
				, data 	: {student_id : id}
				, url	: futureedAPIUrl + 'class-student/student-join-class'
			});
		}

		futureedAPI.getStudentBadges = function(id) {
			return $http({
				method 	: Constants.METHOD_GET
				, url	: futureedAPIUrl + 'badge/student?student_id=' + id 
			});
		}

		futureedAPI.listClass = function(student_id) {
			return $http({
				method 	: Constants.METHOD_GET
				, url 	: futureedAPIUrl + 'class-student/student-class-list?student_id=' + student_id
			});
		}

		futureedAPI.getMyLastName = function() {
            var deferred = $q.defer();
            FB.api('/me', {
                fields: 'last_name'
            }, function(response) {
                if (!response || response.error) {
                    deferred.reject('Error occured');
                } else {
                    deferred.resolve(response);
                }
            });
            
            return deferred.promise;
        }

        futureedAPI.logout = function(data) {
        	return $http({
				method 	: Constants.METHOD_POST
				, data	: data
				, url 	: futureedAPIUrl + 'user/logout'
			});
        }

		futureedAPI.stopImpersonate = function(data) {
			return $http({
				method 	: Constants.METHOD_POST
				, data	: data
				, url 	: futureedAPIUrl + 'admin/impersonate/logout'
			});
		}

		return futureedAPI;
	});