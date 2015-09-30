<?php namespace FutureEd\Models\Repository\Student;

use FutureEd\Models\Core\Student;
use FutureEd\Models\Core\User;
use FutureEd\Models\Traits\LoggerTrait;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;

class StudentRepository implements StudentRepositoryInterface
{
	use LoggerTrait;

	public function getStudents($criteria = array(), $limit = 0, $offset = 0)
	{

		$student = new Student();

		if(isset($criteria['name'])){

			$student = $student->name($criteria['name']);
		}

		if(isset($criteria['client_id'])){

			$student = $student->parentid($criteria['client_id']);
		}

		$student = $student->with('user','parent');

		$count = $student->get()->count();

		if ($offset >= 0 && $limit > 0) {

			$student = $student->skip($offset)->take($limit);
		}

		$records = $student->get();


		Return [
			'total' => $count,
			'record' => $records
		];


	}

	//get student basic details
	public function getStudent($id)
	{
		return Student::find($id);

	}

	//get student details
	public function getStudentDetail($id)
	{

		return Student::where('user_id', $id)->first();

	}

	public function addStudent($student)
	{
			try {

				 Student::create($student);

			} catch(Exception $e) {

				return $e->getMessage();

			}

			return true;

	}

	public function updateStudent($id)
	{

	}

	public function deleteStudent($id)
	{
		try {

			$student = Student::find($id);

			return !is_null($student) ? $student->delete() : false;

		} catch(Exception $e) {

			return $e->getMessage();

		}

	}

	public function getImagePassword($id)
	{

		return Student::where('id', '=', $id)->pluck('password_image_id');

	}

	//update student_image_password

	public function updateImagePassword($data)
	{

		try {
			Student::where('id', $data['id'])
				->update(['password_image_id' => $data['password_image_id']]);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	//get student according to parent id.
	public function getStudentParent($parent_id)
	{

		//student_id,
		//avatar_id,
		//avatar_url,
		//first_name,
		//last_name
		return Student::select('id', 'avatar_id', 'first_name', 'last_name')
			->where('parent_id', '=', $parent_id)->get()->toArray();

	}

	//save student avatar
	public function saveStudentAvatar($data)
	{

		try {
			Student::where('id', $data['id'])
				->update(['avatar_id' => $data['avatar_id']]);

			return true;

		} catch (Exception $e) {

			throw new Exception($e->getMessage());

		}


	}

	//get foreign key of student table grade_code,avatar_id,school_code,learning_style_id
	public function getReferences($id)
	{

		return Student::select(
			'user_id',
			'grade_code',
			'avatar_id',
			'school_code',
			'learning_style_id',
			'password_image_id'
		)->where('id', '=', $id)->first();
	}

	//update student details
	public function updateStudentDetails($id, $data)
	{
		try {

			$student = Student::find($id);

			$student->update($data);

		} catch(Exception $e) {

			return $e->getMessage();

		}
		return $student;
	}


	//return student id
	public function getStudentId($user_id)
	{
		return Student::where('user_id', '=', $user_id)->pluck('id');
	}


	//change password_image_id
	public function changePasswordImage($id, $password_image_id)
	{

		try {
			Student::where('id', $id)
				->update(['password_image_id' => $password_image_id]);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

	}

	//check if id exist
	public function checkIdExist($id)
	{

		return Student::where('id', $id)
			->pluck('id');
	}

	public function getStudentList($criteria = [], $limit = 0, $offset = 0)
	{


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

		return ['total' => $count, 'records' => $student->get()->toArray()];


	}

	//get student with relation to classroom and grade tables
	public function viewStudent($id)
	{

		$student = new Student();

		$student = $student->with('user', 'school', 'grade', 'parent')->where('id', $id)->orderBy('created_at', 'desc');

		$student = $student->first();

		return $student;


	}

	//get student with relation to class, badges
	public function viewStudentClassBadge($id)
	{

		$student = new Student();

		$student = $student->with('badge','classroom')->where('id', $id)->orderBy('created_at','desc')->first();

		return $student;


	}

	//get student who belong to a parent if client_role is parent
	// and get student who belong to a teacher if client role is teacher
	public function getStudentListByClient($criteria = [], $limit = 0, $offset = 0){

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

				if(isset($criteria['client_id'])){

					//check if client_role is a Parent
					if($criteria['client_role'] === config('futureed.parent')){

						$student = $student->with('parent')->parent($criteria['client_id']);
					}

					//check if client_role is a Teacher
					if($criteria['client_role'] === config('futureed.teacher')){

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

		return ['total' => $count, 'records' => $student->get()->toArray()];

	}

	//get student details with registration token
	public function viewStudentByToken($id,$reg_token){

		$student = new Student();

		$student = $student->with('user','school','grade')->token($reg_token)->id($id);

		return $student->get()->toArray();

	}


	//get subscription
	public function subscriptionExpired($id)
	{

		$student = new Student();

		$student = $student->with('studentclassroom')->subscription()->id($id);

		return $student->get()->toArray();
	}

	public function updateSchool($id,$school_code){

		try{

			return Student::find($id)
				->update([
					'school_code' => $school_code
				]);

		} catch (Exception $e) {

			throw new Exception($e->getMessage());
		}

	}
	
	/**
	 * Update the learning style ID
	 * @param $ls_banding
	 * @return Object
	 */

	public function updateLearningStyle($id, $learning_style_id) {

		try{

			return Student::find($id)
				->update([
					'learning_style_id' => $learning_style_id
				]);

		} catch (Exception $e) {

			throw new Exception($e->getMessage());
		}

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
//			$data = array_add($data,'username','NA');

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

		return Student::with('user')->facebookId($facebook_id)->get();
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
//			$data = array_add($data,'username','NA');

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

	public function getStudentByGoogleId($google_id){

		return Student::with('user')->googleId($google_id)->get();
	}


}