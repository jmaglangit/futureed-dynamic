<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\School\SchoolRepositoryInterface;
use FutureEd\Services\ClientServices;
use FutureEd\Services\ExcelServices;
use FutureEd\Http\Requests\Api\ClientImportRequest;
use FutureEd\Services\MailServices;
use FutureEd\Services\UserServices;

class ClientImportController extends ApiController {

	/**
	 * @var ExcelServices
	 */
	protected $excel;

	/**
	 * @var SchoolRepositoryInterface
	 */
	protected $school;

	/**
	 * @var ClientServices
	 */
	protected $client_services;

	/**
	 * @var UserServices
	 */
	protected $user_services;

	/**
	 * @var MailServices
	 */
	protected $mail;

	/**
	 * ClientImportController constructor.
	 * @param ExcelServices $excelServices
	 * @param SchoolRepositoryInterface $schoolRepositoryInterface
	 * @param ClientServices $clientServices
	 * @param UserServices $userServices
	 * @param MailServices $mailServices
	 */
	public function __construct(
		ExcelServices $excelServices,
		SchoolRepositoryInterface $schoolRepositoryInterface,
		ClientServices $clientServices,
		UserServices $userServices,
		MailServices $mailServices
	){
		$this->excel = $excelServices;
		$this->school = $schoolRepositoryInterface;
		$this->client_services = $clientServices;
		$this->user_services = $userServices;
		$this->mail = $mailServices;
	}

	/**
	 * Import batch client records - Teacher
	 * @param ClientImportRequest $request
	 * @return mixed
	 */
	public function clientImport(ClientImportRequest $request){

		$callback_uri = $request->get('callback_uri');

		$file = $request->file('file');

		//check csv file type
		if(!in_array($file->getClientMimeType(), config('futureed.accepted_csv'))){

			return $this->respondErrorMessage(2149);
		}

		$headers = [
			'username',
			'email',
			'first_name',
			'last_name',
			'school_code'
		];

		$records = $this->excel->importCsv($file, $headers);

		//insert records
		$success_records = [];
		$fail_records = [];

		foreach($records as $row){

			$client = $row->toArray();


			//Data validation
			$email_check = $this->client_services->checkClientEmail($client);
			if (!$email_check) {

				$this->addMessageBag($this->setErrorCode(2200)
					->setField('email')
					->setMessage(config('futureed-error.error_messages.2200'))
					->errorMessage());

			}

			$username_check = $this->client_services->checkClientUsername($client);
			if (!$username_check) {

				$this->addMessageBag($this->setErrorCode(2201)
					->setField('username')
					->setMessage(config('futureed-error.error_messages.2201'))
					->errorMessage());

			}

			//Add school code check
			$check_school_code = $this->school->getSchoolByCode($client['school_code']);

			if(!$check_school_code){
				$this->addMessageBag($this->setErrorCode(2105)
					->setField('school_name')
					->setMessage(config('futureed-error.error_messages.2105'))
					->errorMessage());
			}

			$msg_bag = $this->getMessageBag();

			//Add client
			if(empty($msg_bag)){

				$client['user_type'] = config('futureed.client');

				$user_data = $this->user_services->addUser($client);

				if(isset($user_data['status'])){

					$client['user_id'] = $user_data['id'];

					$client_data = $this->client_services->addClient($client);

					if(isset($client_data['status'])){
						//send email
						$data = $this->user_services->getUser($user_data['id'], 'Client');

						$code = $this->user_services->getConfirmationCode($user_data['id']);

						$data['client_role'] = config('futureed.teacher');
						// send email to user
						$this->mail->sendClientRegister($data, $code['confirmation_code'], $callback_uri);

						//list to success
						array_push($success_records,$client);

					}else {
						//list to fail
						$client['errors'] = [$client_data];
						array_push($fail_records,$client);
					}
				}else {
					//list to fail
					$client['errors'] = [$user_data];
					array_push($fail_records,$client);
				}
			}else{
				//list to fail
				$client['errors'] = $msg_bag;
				array_push($fail_records,$client);
				$this->setMessageBag([]);
			}
		}

		return $this->respondWithData([
			'inserted_count' => count($success_records),
			'fail_count' => count($fail_records),
			'inserted_records' => $success_records,
			'failed_records' => $fail_records
		]);
	}

}
