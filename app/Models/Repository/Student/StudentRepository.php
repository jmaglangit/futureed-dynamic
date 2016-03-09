<?php namespace FutureEd\Models\Repository\Student;

use FutureEd\Models\Core\Student;
use FutureEd\Models\Core\User;
use FutureEd\Models\Traits\LoggerTrait;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;

class StudentRepository implements StudentRepositoryInterface
{
	use LoggerTrait;

	/**
	 * Get students by criteria.
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getStudents($criteria = array(), $limit = 0, $offset = 0)
	{

		DB::beginTransaction();

		try {
			$student = new Student();

			if (isset($criteria['name'])) {

				$student = $student->name($criteria['name']);
			}

			if (isset($criteria['client_id'])) {

				$student = $student->parentid($criteria['client_id']);
			}

			$student = $student->with('user', 'parent');

			$count = $student->get()->count();

			if ($offset >= 0 && $limit > 0) {

				$student = $student->skip($offset)->take($limit);
			}

			$records = $student->get();

			$response = [
				'total' => $count,
				'record' => $records
			];

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * Get student information
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getStudent($id)
	{
		DB::beginTransaction();

		try {

			$response = Student::with('user')->find($id);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get student information by user_id.
	 * @param $user_id
	 * @return bool
	 */
	public function getStudentByUserId($user_id){
		DB::beginTransaction();

		try {

			$response = Student::with('user')->userId($user_id)->first();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}


	/**
	 * Get student's user id with the given student id
	 * @param $id
	 * @return mixed
	 */
	public function getUserId($id){

		DB::beginTransaction();

		try {

			$response = Student::whereId($id)->pluck('user_id');

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get student by user_id.
	 * @param $id
	 * @return mixed
	 */
	public function getStudentDetail($id)
	{

		DB::beginTransaction();

		try {

			$response = Student::where('user_id', $id)->first();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add Student.
	 * @param $student
	 * @return bool|string
	 */
	public function addStudent($student)
	{
		DB::beginTransaction();

		try {

			$response = Student::create($student);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Deleted student.
	 * @param $id
	 * @return bool|null|string
	 */
	public function deleteStudent($id)
	{
		DB::beginTransaction();

		try {

			$student = Student::find($id);

			$response = !is_null($student) ? $student->delete() : false;

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get students image password.
	 * @param $id
	 * @return mixed
	 */
	public function getImagePassword($id)
	{
		DB::beginTransaction();

		try {

			$response = Student::where('id', '=', $id)->pluck('password_image_id');

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update student image password.
	 * @param $data
	 * @return bool
	 * @throws Exception
	 */
	public function updateImagePassword($data)
	{
		DB::beginTransaction();

		try {

			$response = Student::where('id', $data['id'])
				->update(['password_image_id' => $data['password_image_id']]);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get student by parent_id
	 * @param $parent_id
	 * @return mixed
	 */
	public function getStudentParent($parent_id)
	{
		DB::beginTransaction();

		try {

			$response = Student::select('id', 'avatar_id', 'first_name', 'last_name')
				->where('parent_id', '=', $parent_id)->get()->toArray();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Save student avatar
	 * @param $data
	 * @return bool
	 * @throws Exception
	 */
	public function saveStudentAvatar($data)
	{
		DB::beginTransaction();

		try {

			Student::where('id', $data['id'])
				->update(['avatar_id' => $data['avatar_id']]);

			$response = true;

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get references.
	 * @param $id
	 * @return mixed
	 */
	public function getReferences($id)
	{

		DB::beginTransaction();

		try {

			$response = Student::select(
				'user_id',
				'grade_code',
				'avatar_id',
				'school_code',
				'learning_style_id',
				'password_image_id'
			)->where('id', '=', $id)->first();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update student details.
	 * @param $id
	 * @param $data
	 * @return \Illuminate\Support\Collection|null|string|static
	 */
	public function updateStudentDetails($id, $data)
	{
		DB::beginTransaction();

		try {

			$student = Student::find($id);

			$response = $student->update($data);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}


	/**
	 * Get student id by user_id.
	 * @param $user_id
	 * @return mixed
	 */
	public function getStudentId($user_id)
	{
		DB::beginTransaction();

		try {

			$response = Student::userId($user_id)->pluck('id');

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}


	/**
	 * Change student password image.
	 * @param $id
	 * @param $password_image_id
	 * @return bool
	 * @throws Exception
	 */
	public function changePasswordImage($id, $password_image_id)
	{

		DB::beginTransaction();

		try {

			$response = Student::where('id', $id)
				->update(['password_image_id' => $password_image_id]);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Check if student exists by id.
	 * @param $id
	 * @return mixed
	 */
	public function checkIdExist($id)
	{

		DB::beginTransaction();

		try {

			$response = Student::where('id', $id)
				->pluck('id');

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get student list by criteria.
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getStudentList($criteria = [], $limit = 0, $offset = 0)
	{
		DB::beginTransaction();

		try {

			$student = new Student();
			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $student->count();

			} else {

				if (count($criteria) > 0) {
					if (isset($criteria['name'])) {

						$student = $student->with('user')->name($criteria['name']);

					}
					if (isset($criteria['email'])) {

						$student = $student->with('user')->email($criteria['email']);

					}

				}

				$count = $student->count();

				if ($limit > 0 && $offset >= 0) {
					$student = $student->with('user')->offset($offset)->limit($limit);
				}

			}

			$student = $student->with('user')->orderBy('last_name', 'asc');

			$response = ['total' => $count, 'records' => $student->get()->toArray()];

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * Get student with relation to classroom and grade tables.
	 * @param $id
	 * @return Student
	 */
	public function viewStudent($id)
	{

		DB::beginTransaction();

		try {
			$student = new Student();

			$student = $student->with('user', 'school', 'grade', 'parent')->where('id', $id)->orderBy('created_at', 'desc');

			$response = $student->first();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get student with classroom and badges.
	 * @param $id
	 * @return Student
	 */
	public function viewStudentClassBadge($id)
	{

		DB::beginTransaction();

		try {
			$student = new Student();

			$response = $student->with('badge', 'classroom')->where('id', $id)->orderBy('created_at', 'desc')->first();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get student list under client.
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getStudentListByClient($criteria = [], $limit = 0, $offset = 0){

		DB::beginTransaction();

		try {
			$student = new Student();
			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $student->count();

			} else {

				if (count($criteria) > 0) {
					if (isset($criteria['name'])) {

						$student = $student->with('user')->name($criteria['name']);

					}
					if (isset($criteria['email'])) {

						$student = $student->with('user')->email($criteria['email']);

					}

					if (isset($criteria['client_id'])) {

						//check if client_role is a Parent
						if ($criteria['client_role'] === config('futureed.parent')) {

							$student = $student->with('parent')->parent($criteria['client_id']);
						}

						//check if client_role is a Teacher
						if ($criteria['client_role'] === config('futureed.teacher')) {

							$student = $student->with('studentclassroom')->teacher($criteria['client_id']);
							$student = $student->isDateRemovedNull();
						}

						$student = $student->noConfirmationCode();

					}

				}

				$count = $student->count();

				if ($limit > 0 && $offset >= 0) {
					$student = $student->with('user')->offset($offset)->limit($limit);
				}

			}

			$student = $student->with('user')->orderBy('last_name', 'asc');

			$response = ['total' => $count, 'records' => $student->get()->toArray()];

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get student details with registration token.
	 * @param $id
	 * @param $reg_token
	 * @return mixed
	 */
	public function viewStudentByToken($id,$reg_token){

		DB::beginTransaction();

		try {

			$student = new Student();

			$student = $student->with('user', 'school', 'grade')->token($reg_token)->id($id);

			$response = $student->get()->toArray();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get subscription
	 * @param $id
	 * @return mixed
	 */
	public function subscriptionExpired($id)
	{

		DB::beginTransaction();

		try {
			$student = new Student();

			$student = $student->with('studentclassroom')->subscription()->id($id);

			$response = $student->get()->toArray();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @param $school_code
	 * @return bool|int
	 * @throws Exception
	 */
	public function updateSchool($id,$school_code){

		DB::beginTransaction();

		try{

			$response = Student::find($id)
				->update([
					'school_code' => $school_code
				]);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update the learning style ID
	 * @param $id
	 * @param $learning_style_id
	 * @return Object
	 * @internal param $ls_banding
	 */
	public function updateLearningStyle($id, $learning_style_id) {

		DB::beginTransaction();

		try{

			$response = Student::find($id)
				->update([
					'learning_style_id' => $learning_style_id
				]);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add new Student Registered from Facebook
	 * @param $data
	 * @return string|static
	 */
	public function addStudentFromFacebook($data){

		DB::beginTransaction();

		try{

			//Add user table

			$data = array_add($data, 'name',$data['first_name'] . ' ' . $data['last_name']);

			//Set client to active.
			$data = array_add($data, 'is_account_activated', 1);

			//Default to USA -- No country code from login response.
			$data['country_id'] = ($data['country_id'] == null ) ?  840 : $data['country_id'];

			$user = User::create($data);

			$data = array_add($data,'user_id',$user->id);

			//Add student table
			$student = Student::create($data);

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e);

			return 0;

		}

		DB::commit();

		return $student;

	}

	/**
	 * Get Student by Facebook Id.
	 * @param $facebook_id
	 * @return mixed
	 */
	public function getStudentByFacebook($facebook_id) {

		DB::beginTransaction();

		try {

			$response = Student::with('user')->facebookId($facebook_id)->get();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add new Student from Google.
	 * @param $data
	 * @return int|static
	 */
	public function addStudentFromGoogle($data){

		DB::beginTransaction();

		try{

			//Add user table
			$data = array_add($data, 'name',$data['first_name'] . ' ' . $data['last_name']);

			//Set client to active.
			$data = array_add($data, 'is_account_activated', 1);

			//Default to USA -- No country code from login response.
			$data['country_id'] = ($data['country_id'] == null ) ?  840 : $data['country_id'];

			$user = User::create($data);

			$data = array_add($data,'user_id',$user->id);

			//Add student table
			$student = Student::create($data);

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e);

			return 0;

		}

		DB::commit();

		return $student;

	}

	/**
	 * @param $google_id
	 * @return mixed
	 */
	public function getStudentByGoogleId($google_id){

		DB::beginTransaction();

		try {

			$response = Student::with('user')->googleId($google_id)->get();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $student_id
	 * @return int
	 */
	public function getStudentPoints($student_id){

		DB::beginTransaction();

		try {

			$response = Student::whereId($student_id)->pluck('points');

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $student_id
	 * @return int
	 */
	public function getStudentPointsUsed($student_id){

		DB::beginTransaction();

		try {

			$response = Student::whereId($student_id)->pluck('points_used');
		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}


}