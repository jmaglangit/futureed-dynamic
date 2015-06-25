<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Core\User;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\MailServices;
use Illuminate\Http\Request;
use FutureEd\Http\Requests\Api\ClientTeacherRegistrationRequest;
use Illuminate\Support\Facades\Input;

class ClientTeacherRegistrationController extends ApiController
{

	/**
	 * @var ClientRepositoryInterface
	 */
	protected $client;

	/**
	 * @var MailServices
	 */
	protected $mail;

	/**
	 * @var CodeGeneratorServices
	 */
	protected $code;

	/**
	 * @var
	 */
	protected $user;

	/**
	 * @param ClientRepositoryInterface $clientRepositoryInterface
	 */
	public function __construct(
		ClientRepositoryInterface $clientRepositoryInterface,
		UserRepositoryInterface $userRepositoryInterface,
		MailServices $mailServices,
		CodeGeneratorServices $codeGeneratorServices

	)
	{

		$this->client = $clientRepositoryInterface;
		$this->mail = $mailServices;
		$this->code = $codeGeneratorServices;
		$this->user = $userRepositoryInterface;

	}

	/**
	 * Get teacher initial information
	 * @param $id
	 * @param ClientTeacherRegistrationRequest $request
	 * @return mixed
	 */
	public function getTeacherInformation($id, ClientTeacherRegistrationRequest $request)
	{

		//return  teacher information
		$data = $this->client->getTeacher($id, Input::get('registration_token'));

		return $this->respondWithData($data);
	}

	/**
	 * Update teacher information -- registration process
	 * @param $id
	 * @param ClientTeacherRegistrationRequest $request
	 * @return mixed
	 */
	public function updateTeacherInformation($id, ClientTeacherRegistrationRequest $request)
	{

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
			'zip',
			'callback_uri'

		]);

        //apply name on user table.
        $name = ['name' => $input['first_name'].' '.$input['last_name']];
        $input = array_merge($input, $name);

		//apply code
		$input = array_merge($input, $this->code->getCodeExpiry());

		//update teacher information
		$data = $this->client->updateClient($id, $input);


		if (empty($data)) {

			return $this->respondWithData($data);
		} else {

			$data->callback_uri = $input['callback_uri'];

			//send email to teacher
			$this->mail->sendTeacherRegistration($data);

			//removed registration token.
			$this->user->deleteRegistrationToken($data->user->id);

			return $this->respondWithData($data);

		}
	}


}
