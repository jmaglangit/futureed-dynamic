<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use Illuminate\Http\Request;
use FutureEd\Http\Requests\Api\ClientTeacherRegistrationRequest;
use Illuminate\Support\Facades\Input;

class ClientTeacherRegistrationController extends ApiController {

	/**
	 * @var ClientRepositoryInterface
	 */
	protected $client;

	/**
	 * @param ClientRepositoryInterface $clientRepositoryInterface
	 */
	public function __construct(ClientRepositoryInterface $clientRepositoryInterface){

		$this->client = $clientRepositoryInterface;

	}

	/**
	 * Get teacher initial information
	 * @param $id
	 * @param ClientTeacherRegistrationRequest $request
	 * @return mixed
	 */
	public function getTeacherInformation($id,ClientTeacherRegistrationRequest $request){

		//return  teacher information
		$data = $this->client->getTeacher($id,Input::get('registration_token'));

		return $this->respondWithData($data);
	}

	public function updateTeacherInformation($id,ClientTeacherRegistrationRequest $request){

		$input = $request->only([
			'email',
			'username',
			'password',
			'first_name',
			'last_name',
			'address',
			'city',
			'state',
			'country',
			'country_id',

		]);
		//update teacher information
		$data = $this->client->updateClient($id,$input);

		return $this->respondWithData($data);

	}



}
