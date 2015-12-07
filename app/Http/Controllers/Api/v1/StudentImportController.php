<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Requests;
use FutureEd\Models\Repository\Country\CountryRepositoryInterface;
use FutureEd\Services\ExcelServices;
use FutureEd\Http\Requests\Api\StudentImportRequest;
use FutureEd\Services\MailServices;
use FutureEd\Services\StudentServices;
use FutureEd\Services\UserServices;
use Illuminate\Support\Facades\Input;

class StudentImportController extends ApiController {

	/**
	 * @var ExcelServices
	 */
	protected $excel_services;

	/**
	 * @var UserServices
	 */
	protected $user;

	/**
	 * @var StudentServices
	 */
	protected $student;

	/**
	 * @var MailServices
	 */
	protected $mail;

	/**
	 * @var CountryRepositoryInterface
	 */
	protected $country;

	/**
	 * StudentImportController constructor.
	 * @param ExcelServices $excelServices
	 * @param UserServices $userServices
	 * @param StudentServices $studentServices
	 * @param MailServices $mailServices
	 * @param CountryRepositoryInterface $countryRepositoryInterface
	 */
	public function __construct(
		ExcelServices $excelServices,
		UserServices $userServices,
		StudentServices $studentServices,
		MailServices $mailServices,
		CountryRepositoryInterface $countryRepositoryInterface
	){
		$this->excel_services = $excelServices;
		$this->user = $userServices;
		$this->student = $studentServices;
		$this->mail = $mailServices;
		$this->country = $countryRepositoryInterface;
	}

	/**
	 * Import batch new student record.
	 * @param StudentImportRequest $request
	 * @return mixed
	 */
	public function studentImport(StudentImportRequest $request){

		$callback_uri = $request->get('callback_uri');

		$file = $request->file('file');

		//check csv file type
		if($file->getClientMimeType() <> 'text/csv'){

			return $this->respondErrorMessage(2149);
		}

		$headers = [
				'username',
				'email',
				'last_name',
				'first_name',
				'gender',
				'birth_date',
				'country',
				'state',
				'city',
				'school_code',
				'grade_code'
		];

		//generate services to import
		$records = $this->excel_services->importCsv($file,$headers);


		//insert records
		$success_records = [];
		$fail_records = [];

		foreach($records as $row){

			$student = $row->toArray();

			//data conversions
			$student['birth_date'] = Carbon::parse($student['birth_date'])->format('Ymd');
			$student['user_type'] = config('futureed.student');

			//Student fields validations
			$this->addMessageBag($this->firstName($student,'first_name'));
			$this->addMessageBag($this->lastName($student,'last_name'));
			$this->addMessageBag($this->gender($student,'gender'));
			$this->addMessageBag($this->validateDate($student,'birth_date'));
			$this->addMessageBag($this->validateGradeCode($student,'grade_code'));
			$this->addMessageBag($this->validateAlphaSpaceOptional($student,'state'));
			$this->addMessageBag($this->validateAlphaSpace($student,'city'));

			//User fields validations
			$this->addMessageBag($this->email($student,'email'));
			$this->addMessageBag($this->username($student, 'username'));

			$error_msg = $this->getMessageBag();

			//if validated insert to users and students table
			if(empty($error_msg)){

				//insert user
				$user_data = $this->user->addUser($student);

				$student_country = $this->country->getCountryCodeByISO2($student['country']);


				if(isset($user_data['status'])){
					$student_data = [
							'user_id' => $user_data['id'],
							'last_name' => $student['last_name'],
							'first_name' => $student['first_name'],
							'gender' => $student['gender'],
							'birth_date' => $student['birth_date'],
							'country_id' => $student_country[0]->id,
							'state' => $student['state'],
							'city' => $student['city'],
							'school_code' => $student['school_code'],
							'grade_code' => $student['grade_code']
					];

					//Add student
					$this->student->addStudent($student_data);

					//email student
					$this->mail->sendStudentRegister($student_data['user_id'],$callback_uri);

					//list record
					array_push($success_records,$student);
				}else {
					array_push($fail_records,$student);
				}

			}else {
				//iterate fail records
				array_push($fail_records,$student);
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
