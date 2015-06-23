<?php
Routes::group(['prefix' => '/order'], function()
{
    Routes::get('/get-next-order-no/{client_id}', [
        'uses' => 'Api\v1\OrderController@getNextOrderNo',
        'as' => 'order.get.next-order-no']);
});

Routes::resource('/order','Api\v1\OrderController', ['except' => ['edit']]);
