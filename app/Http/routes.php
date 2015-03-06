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

//Route::get('/', 'WelcomeController@index');
//Route::get('home', 'HomeController@index');
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/*
 * Home
 */
Route::get('/','DashboardController@index');
/*
 * Administrator
 *
 */
Route::get('/Admin','AdminController@index');

/*
 * Student
 * */
Route::get('/student','StudentController@index');
Route::get('/student/email','StudentController@email');
Route::get('/student/password','StudentController@password');

/*
 * Users (principal, teachers, and parents)
 */
Route::get('/users','UsersController@index');


