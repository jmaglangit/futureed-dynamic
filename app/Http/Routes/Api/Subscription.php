<?php 
Routes::group(['prefix' => '/subscription'], function()
{
    Routes::patch('/update-status/{id}','Api\v1\SubscriptionController@updateStatus');
});
Routes::resource('/subscription','Api\v1\SubscriptionController', ['except' => ['create','edit']]);
