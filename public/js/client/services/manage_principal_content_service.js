angular.module('futureed.services')
    .factory('ManagePrincipalContentService', ManagePrincipalContentService);

ManagePrincipalContentService.$inject = ['$http'];

function ManagePrincipalContentService($http) {

    var apiUrl = '/api/v1/';
    var reportUrl = '/api/report/';
    var managePrincipalApi = {};

    //get school report
    managePrincipalApi.schoolReport = function (school_code) {
        return $http({
            method  :   Constants.METHOD_GET
            , url   :   reportUrl + 'school/' + school_code
        });
    }

    //get school teacher report
    managePrincipalApi.schoolTeacherReport = function (school_code){
        return $http({
            method  :   Constants.METHOD_GET
            ,url    :   reportUrl + 'school/' + school_code + '/teachers'
        });
    }

    managePrincipalApi.schoolTeacherSubjectProgressReport = function (school_code, grade_id) {
        return $http({
            method  :   Constants.METHOD_GET
            , url   :   reportUrl + 'school/' + school_code + '/teachers/subjects/progress/' + grade_id
        });
    }

    managePrincipalApi.schoolTeacherSubjectScoresReport = function (school_code, grade_id) {
        return $http({
            method  :   Constants.METHOD_GET
            , url   :   reportUrl + 'school/' + school_code + '/teachers/subjects/scores/' + grade_id
        });
    }

    managePrincipalApi.schoolStudentSubjectProgressReport = function (school_code, teacher_id, subject_id, grade_id) {
        return $http({
            method  :   Constants.METHOD_GET
            , url   :   reportUrl + 'school/' + school_code + '/' + teacher_id + '/students/subject/' + subject_id + '/progress/' + grade_id
        });
    }

    managePrincipalApi.schoolStudentSubjectScoresReport = function (school_code, teacher_id, subject_id, grade_id) {
        return $http({
            method  :   Constants.METHOD_GET
            , url   :   reportUrl + 'school/' + school_code + '/' + teacher_id + '/students/subject/' + subject_id + '/scores/' + grade_id
        });
    }

    //download school progress
    managePrincipalApi.schoolReportDownload = function(school_code,file_type){
        return reportUrl + 'school/' + school_code + '/' + file_type;
    }

    //download school teacher progress
    managePrincipalApi.schoolTeacherReportDownload = function(school_code, file_type){
        return reportUrl + 'school/' + school_code + '/teachers/' + file_type
    }

    managePrincipalApi.schoolTeacherSubjectProgressReportDownload = function (school_code, grade_id, file_type) {
        return reportUrl + 'school/' + school_code + '/teachers/subjects/progress/' + grade_id + '/' + file_type;
    }

    managePrincipalApi.schoolTeacherSubjectScoresReportDownload = function (school_code, grade_id, file_type) {
        return reportUrl + 'school/' + school_code + '/teachers/subjects/scores/' + grade_id + '/' + file_type;
    }

    managePrincipalApi.schoolStudentSubjectProgressReportDownload = function (school_code, teacher_id, subject_id, grade_id, file_type) {
        return reportUrl + 'school/' + school_code + '/' + teacher_id + '/students/subject/' + subject_id + '/progress/' + grade_id + '/' + file_type;
    }

    managePrincipalApi.getGrades = function() {
        return $http({
            method  :   Constants.METHOD_GET
            ,url    :   apiUrl + 'grade'
        });
    }

    managePrincipalApi.getSubjects = function() {
        return $http({
            method  :   Constants.METHOD_GET
            ,url    :   apiUrl + 'subject'
        });
    }

    managePrincipalApi.getTeachers = function(school_code) {
        return $http({
            method  :   Constants.METHOD_GET
            ,url    :   apiUrl + 'client/teacher?school_code=' + school_code
        });
    }

    return managePrincipalApi;

}