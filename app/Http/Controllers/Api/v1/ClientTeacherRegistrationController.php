<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use Illuminate\Http\Request;
use FutureEd\Http\Requests\Api\ClientTeacherRegistrationRequest;

class ClientTeacherRegistrationController extends Controller {

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

	public function getTeacherInformation($id, ClientTeacherRegistrationRequest $request){

		//return  teacher information
		return $this->client->getTeacher($id,config('futureed.teacher'));

	}

}
