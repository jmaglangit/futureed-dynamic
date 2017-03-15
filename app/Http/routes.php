<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


include('Routes/FutureLesson/Futurelesson.php');


Routes::group([
	'prefix' => 'api/v1',
	'middleware' => 'log'
], function () {
	Routes::get('/', 'Api\v1\ApiController@index');

	include('Routes/Api/Admin.php');
	include('Routes/Api/AgeGroup.php');
	include('Routes/Api/Announcement.php');
	include('Routes/Api/AnswerExplanation.php');
	include('Routes/Api/AnswerExplanationTranslation.php');
	include('Routes/Api/Assess.php');
	include('Routes/Api/AvatarAccessory.php');
	include('Routes/Api/AvatarPose.php');
	include('Routes/Api/AvatarWiki.php');
	include('Routes/Api/BackgroundImage.php');
	include('Routes/Api/Classroom.php');
	include('Routes/Api/ClassStudent.php');
	include('Routes/Api/Client.php');
	include('Routes/Api/ClientDiscount.php');
	include('Routes/Api/ClientStudent.php');
	include('Routes/Api/Countries.php');
	include('Routes/Api/DataLibrary.php');
	include('Routes/Api/Event.php');
	include('Routes/Api/Facebook.php');
	include('Routes/Api/Game.php');
	include('Routes/Api/Grade.php');
	include('Routes/Api/Google.php');
	include('Routes/Api/HelpRequest.php');
	include('Routes/Api/HelpRequestAnswer.php');
	include('Routes/Api/HelpRequestAnswerRating.php');
	include('Routes/Api/IconImage.php');
	include('Routes/Api/Image.php');
	include('Routes/Api/Invoice.php');
	include('Routes/Api/Job.php');
	include('Routes/Api/Language.php');
	include('Routes/Api/LearningStyle.php');
	include('Routes/Api/MediaType.php');
	include('Routes/Api/Module.php');
	include('Routes/Api/ModuleCountry.php');
	include('Routes/Api/ModuleGroup.php');
	include('Routes/Api/ModuleTranslation.php');
	include('Routes/Api/Order.php');
	include('Routes/Api/OrderDetail.php');
	include('Routes/Api/Payment.php');
	include('Routes/Api/PointLevel.php');
	include('Routes/Api/Question.php');
	include('Routes/Api/QuestionAnswer.php');
	include('Routes/Api/QuestionAnswerTranslation.php');
	include('Routes/Api/QuestionTemplate.php');
	include('Routes/Api/QuestionTranslation.php');
	include('Routes/Api/Quote.php');
	include('Routes/Api/QuoteTranslation.php');
	include('Routes/Api/School.php');
	include('Routes/Api/Student.php');
	include('Routes/Api/StudentBadge.php');
	include('Routes/Api/StudentGame.php');
	include('Routes/Api/StudentModule.php');
	include('Routes/Api/StudentModuleAnswer.php');
	include('Routes/Api/StudentPoint.php');
	include('Routes/Api/Subject.php');
	include('Routes/Api/SubjectArea.php');
	include('Routes/Api/Subscription.php');
	include('Routes/Api/TeachingContent.php');
	include('Routes/Api/Tip.php');
	include('Routes/Api/TipRating.php');
	include('Routes/Api/User.php');
	include('Routes/Api/VolumeDiscount.php');
});

/**
 * Report Routes
 */
Routes::group(['prefix' => 'api'], function () {

	include('Routes/Api/Reports.php');

});

/**
 * Log Routes
 */
Routes::group(['prefix' => 'api'], function () {

	include('Routes/Api/Logs.php');

});

Routes::get('/lang/{lang}', [
	'uses' => 'Api\v1\LanguageController@setLanguage',
	'as' => 'student.set.language',
]);