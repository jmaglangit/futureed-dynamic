<?php 
Routes::group(['prefix' => '/subscription'], function()
{
    Routes::patch('/update-status/{id}', [
                'uses' => 'Api\v1\SubscriptionController@update',
                'as' => 'subscription.update.status']);
});
Routes::resource('/subscription','Api\v1\SubscriptionController', ['except' => ['create','edit']]);
