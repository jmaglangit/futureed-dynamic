<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests\Api\FacebookLoginRequest;


class FacebookLoginController extends Controller {

	/**
	 * REGISTRATION
	 */

	/*
	 * Get required variables
	 *
	 *
	 * USER
	 * 	facebook_app_id
	 *	email
	 *	name -- combined with first_name and last_name
	 * 	user_type
	 *
	 * STUDENT
	 * 	first_name
	 * 	last_name
	 * 	gender
	 * 	birth_date
	 * 	country_id
	 *
	 * CLIENT
	 * 	first_name
	 * 	last_name
	 * 	client_role
	 * 	country_id
	 *
	 */

	protected $student;

	protected $client;

	public function __construct(

	){

	}

	/**
	 * Through Facebook registration for Students and Client.
	 */
	public function facebookRegistration(FacebookLoginRequest $request){

		$data = $request->only(
			'facebook_app_id',
			'email',
			'user_type',
			'first_name',
			'last_name',
			'client_role',
			'gender',
			'birth_date',
			'country_id'
		);

		switch ($data['user_type']){

			case config('futureed.student'):

				//Registration of Student.



				break;

			case config('futureed.client'):

				//Registration for Client.

				break;
		}

	}

}
