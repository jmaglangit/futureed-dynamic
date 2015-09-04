
<?php

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
],function(){

	/**
	 * Sales Invoice
	 */
	Routes::group([
		'prefix' => '/sales-invoice'
	], function()
	{

		Routes::get('/details',[
			'uses' => 'Api\v1\InvoiceDetailController@viewInvoiceDetail',
			'as' =>'api.v1.sales.invoice' ]);

		Routes::post('/edit',[
			'uses' => 'Api\v1\InvoiceDetailController@editInvoiceDetails',
			'as' =>'api.v1.sales.edit' ]);
	});

	/**
	 * Invoice
	 */

	Routes::resource('/invoice','Api\v1\InvoiceController',
		['except' => ['create','edit']]);

	Routes::group([
		'prefix' => '/invoice'
	], function()
	{
		Routes::get('/client-invoice-discount/{id}', [
			'uses' => 'Api\v1\InvoiceController@getClientInvoiceDiscount',
			'as' => 'invoice.get.client-invoice-discount']);

		Routes::get('/get-next-invoice-no/{client_id}', [
			'uses' => 'Api\v1\InvoiceController@getNextInvoiceNo',
			'as' => 'invoice.get.next-invoice-no']);

		Routes::put('/cancel-invoice/{id}', [
			'uses' => 'Api\v1\InvoiceController@cancelInvoice',
			'as' => 'invoice.put.cancel-invoice']);
	});
});




