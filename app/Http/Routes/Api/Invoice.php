<?php



Routes::resource('/invoice','Api\v1\InvoiceController',
    ['except' => ['create','edit']]);



//for sales invoice
Routes::group(['middleware' => 'api_user','prefix' => '/sales-invoice'], function()
{

    Routes::get('/details',[
        'uses' => 'Api\v1\SalesInvoiceDetailsController@invoiceDetails',
        'as' =>'api.v1.sales.invoice' ]);
    
});