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

//TODO: Drill down routing into directory.

include('Routes/FutureLesson/Futurelesson.php');


Routes::group(['prefix' => 'api/v1'], function()
{
    Routes::get('/','Api\v1\ApiController@index');

		include('Routes/Api/Admin.php');
		include('Routes/Api/Announcement.php');
		include('Routes/Api/Classroom.php');
		include('Routes/Api/ClassStudent.php');
		include('Routes/Api/Client.php');
		include('Routes/Api/ClientDiscount.php');
		include('Routes/Api/ClientStudent.php');
		include('Routes/Api/Countries.php');
		include('Routes/Api/Grade.php');
		include('Routes/Api/Invoice.php');
		include('Routes/Api/Order.php');
		include('Routes/Api/Payment.php');
		include('Routes/Api/School.php');
		include('Routes/Api/Student.php');
		include('Routes/Api/Subject.php');
		include('Routes/Api/SubjectArea.php');
		include('Routes/Api/Subscription.php');
		include('Routes/Api/User.php');
		include('Routes/Api/VolumeDiscount.php');
        include('Routes/Api/OrderDetail.php');

});
