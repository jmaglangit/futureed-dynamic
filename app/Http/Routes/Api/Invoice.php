
<?php


Routes::resource('/invoice','Api\v1\InvoiceController',
    ['except' => ['create','edit']]);



//for sales invoice
Routes::group(['middleware' => 'api_user','prefix' => '/sales-invoice'], function()
{

    Routes::get('/details',[
        'uses' => 'Api\v1\InvoiceDetailController@invoiceDetails',
        'as' =>'api.v1.sales.invoice' ]);

     Routes::post('/edit',[
        'uses' => 'Api\v1\InvoiceDetailController@editInvoiceDetails',
        'as' =>'api.v1.sales.edit' ]);
});

Routes::group(['prefix' => '/invoice'], function()
{
    Routes::get('/client-invoice-discount/{id}', [
        'uses' => 'Api\v1\InvoiceController@getClientInvoiceDiscount',
        'as' => 'invoice.get.client-invoice-discount']);

    Routes::get('/get-next-invoice-no/{client_id}', [
        'uses' => 'Api\v1\InvoiceController@getNextInvoiceNo',
        'as' => 'invoice.get.next-invoice-no']);
});
