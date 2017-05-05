<?php

namespace FutureEd\Services;


use Carbon\Carbon;
use FutureEd\Models\Core\StudentModule;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Models\Repository\Grade\GradeRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\PasswordImage\PasswordImageRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepository;
use FutureEd\Services\SchoolServices;
use FutureEd\Services\AvatarServices;

class StudentServices
{

	/**
	 * Initialized constructor.
	 * @param StudentRepositoryInterface $student
	 * @param PasswordImageServices $password
	 * @param UserRepositoryInterface $userRepositoryInterface
	 * @param UserServices $userServices
	 * @param ValidatorRepository $validator
	 * @param SchoolServices $school
	 * @param AvatarServices $avatar
	 * @param GradeRepositoryInterface $gradeRepositoryInterface
	 * @param ClassStudentRepositoryInterface $classStudentRepositoryInterface
	 * @param StudentModuleRepositoryInterface $studentModuleRepositoryInterface
	 * @internal param UserServices $user
	 */
	public function __construct(
		StudentRepositoryInterface $student,
		PasswordImageServices $password,
		UserRepositoryInterface $userRepositoryInterface,
		UserServices $userServices,
		ValidatorRepository $validator,
		SchoolServices $school,
		AvatarServices $avatar,
		GradeRepositoryInterface $gradeRepositoryInterface,
		ClassStudentRepositoryInterface $classStudentRepositoryInterface,
		StudentModuleRepositoryInterface $studentModuleRepositoryInterface
	)
	{
		$this->student = $student;
		$this->password = $password;
		$this->user = $userRepositoryInterface;
		$this->user_service = $userServices;
		$this->validator = $validator;
		$this->school = $school;
		$this->avatar = $avatar;
		$this->grade = $gradeRepositoryInterface;
		$this->class_student = $classStudentRepositoryInterface;
		$this->student_module = $studentModuleRepositoryInterface;
	}

	/**
	 * Get students.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return mixed
	 */
	public function getStudents($criteria, $limit, $offset)
	{

		return $this->student->getStudents($criteria, $limit, $offset);
	}

	/**
	 * Get student by id.
	 * @param $id
	 * @return mixed
	 */
	public function getStudent($id)
	{
		return $this->student->getStudent($id);
	}

	/*
	 * @desc Add new student
	 *  'first_name',
			'last_name',
			'gender',
			'birthday',
			'school_code',
			'grade_code',
			'country',
			'state',
			'city'
	 */
	//TODO: Add more validations on the each data variables.
	/**
	 * Add Student
	 * @param $student
	 * @return array
	 */
	public function addStudent($student)
	{

		$return = [];

		if (empty(array_filter($return))) {
			//if existing add student
			$student_response = $this->student->addStudent($student);

			// if not add user and add student

			return [
				'status' => 200,
				'message' => $student_response
			];
		}

		return $return;
	}

	public function getImagePassword($id)
	{

		//TODO: get image password.
		$imgId = $this->student->getImagePassword($id);
		if (is_null($imgId)) {

			return false;
		}
		//mix password id with selections
		$mix = $this->password->getMixImage($imgId);


		shuffle($mix);

		return [
			'status' => 200,
			'data' => $mix
		];
	}

	/**
	 * token is the indicator if it has login.
	 * @param $id is the student id, image_id is the image password, token is optional if it has a token.
	 * @param $image_id
	 * @param null $token
	 * @return array
	 */
	public function checkAccess($id, $image_id, $token = null)
	{

		$user_id = $this->student->getReferences($id);
		$is_disabled = $this->user_service->checkUserDisabled($user_id['user_id']);

		if (!$is_disabled) {
			$password_image = $this->student->getImagePassword($id);

			if ($image_id == $password_image) {
				$this->user_service->resetLoginAttempt($user_id['user_id']);
				return [
					'status' => 200,
					'data' => true
				];
			} else {

				//check if token has values.
				if (!$token) {

					$this->user_service->addLoginAttempt($user_id['user_id']);
				}

				if (!$this->user_service->exceedLoginAttempts($user_id['user_id'])) {
					$this->user_service->lockAccount($user_id['user_id']);
					return [
						'status' => $this->user_service->checkUserDisabled($user_id['user_id'])
					];
				} else {
					//check remaining attempts
					$attempts = $this->user->getLoginAttempts($user_id['user_id']);
					$err_message = trans('errors.2072', ['remaining_attempts' => (config('futureed.limit_attempt') - $attempts)]);

					return [
						'status' => 2072, 
						'message' => $err_message
						];
				}

				return [
					'status' => 2012
				];
			}
		} else {
			return [
				'status' => $is_disabled
			];
		}
	}


	/**
	 * Get student details.
	 * @param $id
	 * @return mixed
	 */
	public function getStudentDetails($id)
	{

		$student = $this->getStudent($id)->toArray();
		$student_reference = $this->student->getReferences($id)->toArray();

		//get age
		$age = $this->age($student['birth_date']);

		//get user username and email
		$user = $this->user_service->getUsernameEmail($student['user_id'])->toArray();

		$avatar_url = '';
		$avatar_url_background = '';
		$avatar_thumbnail_url = '';


		if ($student_reference['avatar_id']) {
			$avatar = $this->avatar->getAvatar($student_reference['avatar_id'])->toArray();
			$avatar_url = $this->avatar->getAvatarUrl($avatar['avatar_image']);
			$avatar_thumbnail_url = $this->avatar->getAvatarThumbnailUrl($avatar['avatar_image']);
			$avatar_url_background = $this->avatar->getAvatarUrl($avatar['background_image']);
		}

		$school = '';

		if ($student_reference['school_code']) {
			$school = $this->school->getSchoolName($student_reference['school_code']);
		}

		//get grade name
		if ($student_reference['grade_code']) {

			$grade = $this->grade->getGrade($student_reference['grade_code']);
		}

		$criteria['student_id'] = $id;
		$criteria['country_id'] = $student['user']['curriculum_country'];

		//get class_student
		$class_student = $this->class_student->getClassStudents($criteria);

		$student = array_merge(array('id' => $id)
			, $student
			, $user,
			array('age' => $age,
				'role' => config('futureed.student'),
				'avatar' => $avatar_url,
				'thumbnail' => $avatar_thumbnail_url,
				'background' => $avatar_url_background,
				'school' => $school,
				'grade' => isset($grade) ? $grade : null,
				'class' => isset($class_student['records'][0]) ? $class_student['records'][0]->class_id : null,
				'avatar_id' => $student_reference['avatar_id']));


		foreach ($student as $key => $value) {
			if ($key != 'user_id') {
				$studentdetails[$key] = $value;
			}
		}
		return $studentdetails;

	}

	/**
	 * Get current age based on birth_date
	 * @param $birth_date
	 * @return string
	 */
	public function age($birth_date)
	{
		$interval = date_diff(date_create(), date_create($birth_date));
		return $interval->format("%Y");
	}

	/**
	 * Get student birth_date
	 * @param $id
	 * @return int
	 */
	public function getAge($id)
	{

		$student = $this->student->getStudent($id);

		$age = Carbon::now();

		return $age->diffInYears(Carbon::parse($student['birth_date']));

	}

	/**
	 * Update student_image_password
	 * @param $data
	 * @return array
	 */
	public function resetPasswordImage($data)
	{

		$this->student->updateImagePassword($data);
		$return = ['status' => 200,
			'data' => $data['id']];
		return $return;
	}

	/**
	 * Get students of a parent.
	 * @param $parent_id
	 * @return mixed
	 */
	public function getStudentByParent($parent_id)
	{
		return $this->student->getStudentParent($parent_id);
	}

	/**
	 * Save Student avatar.
	 * @param $data
	 * @return mixed
	 */
	public function saveStudentAvatar($data)
	{

		return $this->student->saveStudentAvatar($data);

	}


	/**
	 * Update Student details.
	 * @param $id
	 * @param $input
	 */
	public function updateStudentDetails($id, $input)
	{

		$student_reference = $this->student->getReferences($id)->toArray();

		//update user username and email
		$this->user_service->updateUsernameEmail($student_reference['user_id'], $input);

		//update Student details
		$this->student->updateStudentDetails($id, $input);
	}


	/**
	 * Format return for student reset code.
	 * @param $user_id
	 * @return array
	 */
	public function resetCodeResponse($user_id)
	{
		$id = $this->student->getStudentId($user_id);
		$return = ['id' => $id,
			'user_type' => 'Student',
		];
		return $return;
	}

	/**
	 * Get Student references.
	 * @param $id
	 * @return mixed
	 */
	public function getStudentReferences($id)
	{

		return $this->student->getReferences($id);
	}

	/**
	 * Get student Id.
	 * @param $user_id
	 * @return mixed
	 */
	public function getStudentId($user_id)
	{

		return $this->student->getStudentId($user_id);
	}

	/**
	 * Change password images.
	 * @param $id
	 * @param $password_image_id
	 */
	public function changePasswordImage($id, $password_image_id)
	{

		$this->student->changePasswordImage($id, $password_image_id);
	}

	/**
	 * Check existing id.
	 * @param $id
	 * @return mixed
	 */
	public function checkIdExist($id)
	{

		return $this->student->checkIdExist($id);
	}

	/**
	 * Update School of student.
	 * @param $id
	 * @param $school_code
	 * @return mixed
	 */
	public function updateSchool($id, $school_code)
	{

		return $this->student->updateSchool($id, $school_code);
	}

	/**
	 * Student relationship to class
	 * Get current class of the student
	 * @param $student_id
	 * @return int
	 */
	public function getCurrentClass($student_id)
	{
		//get all active class.
		$active_class = $this->class_student->getActiveClassStudent($student_id);

		//mitigate to inactive
		foreach ($active_class as $list => $class) {


			if (!(Carbon::now()->between(
				Carbon::parse($class->classroom['order']['date_start']),
				Carbon::parse($class->classroom['order']['date_end'])))
			) {

				$this->class_student->setClassStudentInactive($class->id);

			}
		}

		//get inactive class whose class time has today.
		$inactive_class = $this->class_student->getInactiveClassStudent($student_id);

		//mitigate to active
		foreach ($inactive_class as $list => $class) {

			if (Carbon::now()->between(
				Carbon::parse($class->classroom['order']['date_start']),
				Carbon::parse($class->classroom['order']['date_end']))
			) {

				$this->class_student->setClassStudentActive($class->id);
			}
		}

		$class_student = $this->class_student->getStudentCurrentClassroom($student_id);

		return ($class_student) ? $class_student : null;
	}

	/**
	 * Check students if it has class on the module.
	 * @param $student_id
	 * @param $module_id
	 * @return bool
	 */
	public function checkStudentValidModule($student_id, $module_id){

		//get student curriculum country
		$student = $this->student->getStudent($student_id);

		$country_id = $student->user->curriculum_country;

		$modules = $this->class_student->getStudentValidModule($student_id,$module_id,$country_id);

		if(empty($modules->toArray())){

			return false;
		}else {

			return true;
		}
	}

	/**
	 * Check student if it has existing curriculum country else update record.
	 * @param $student_id
	 * @param $curriculum_country
	 * @return bool
	 */
	public function checkStudentCurriculum($student_id, $curriculum_country){

		//check curriculum country
		$student = $this->student->getStudent($student_id);

		//if exist return 0;
		if($student->user->curriculum_country > config('futureed.false')){
			return false;
		} else {
			return $this->user->updateUser($student->user_id,[
				'curriculum_country' => $curriculum_country
			]);
		}
	}

	/**
	 * Update student curriculum country
	 * @param $user_id
	 * @param $curriculum_country
	 * @return mixed
	 */
	public function updateStudentCurriculum($user_id,$curriculum_country){

		return $this->user->updateUser($user_id,['curriculum_country' => $curriculum_country]);
	}

}