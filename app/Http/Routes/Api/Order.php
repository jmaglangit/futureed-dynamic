<?php 
Routes::resource('/order','Api\v1\OrderController', ['except' => ['edit']]);

Routes::group(['prefix' => '/order'], function()
{
    Routes::get('/get-next-order-no/{client_id}', [
        'uses' => 'Api\v1\OrderController@getNextOrderNo',
        'as' => 'order.get.next-order-no']);

    Routes::get('/get-order-by-order-no/{order_no}', [
        'uses' => 'Api\v1\OrderController@getOrderByOrderNo',
        'as' => 'order.get.order-by-order-no']);
});