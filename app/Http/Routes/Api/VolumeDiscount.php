<?php

Routes::group([
	'middleware' => ['api_user', 'api_after'],
	'permission' => ['student','client','admin'],
	'role' => ['principal','parent','admin','super admin'],
], function () {


	Routes::resource('/volume-discount', 'Api\v1\VolumeDiscountController', ['except' => ['create', 'edit']]);

	Routes::group(['prefix' => '/volume-discount'], function () {
		Routes::get('/rounded-off-discount/{min_seats}', [
			'uses' => 'Api\v1\VolumeDiscountController@getRoundedOffDiscount',
			'as' => 'api.v1.volume-discount.get.rounded-off-disccount']);
	});
});