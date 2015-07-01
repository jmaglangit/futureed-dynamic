<?php Routes::resource('/help-request','Api\v1\HelpRequestController',['except' => ['create','edit']]);

Routes::group(['prefix' => '/help-request'], function()
{
    Routes::patch('/update-request-status/{id}', [
        'uses' => 'Api\v1\HelpRequestController@update',
        'as' => 'help-request.put.update-request-status']);
});