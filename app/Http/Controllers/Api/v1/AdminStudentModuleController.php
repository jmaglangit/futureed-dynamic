<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use FutureEd\Services\MailServices;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use Carbon\Carbon;

use Illuminate\Http\Request;

class AdminStudentModuleController extends ApiController {

	protected $student_module;
	protected $mail;
	protected $student;
	protected $module;


	public function __construct(
					StudentModuleRepositoryInterface $student_module,
					MailServices $mail,
					StudentRepositoryInterface $student,
					ModuleRepositoryInterface $module)
	{

		$this->student_module = $student_module;
		$this->mail = $mail;
		$this->student = $student;
		$this->module = $module;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function resetStudentModule($id)
	{

		$old_student_module = $this->student_module->getStudentModule($id);

		if($old_student_module){

			$data = [
				'class_id' => $old_student_module->class_id,
				'student_id' => $old_student_module->student_id,
				'subject_id' => $old_student_module->subject_id,
				'module_id' => $old_student_module->module_id,
				'module_status' => config('futureed.module_status_ongoing')
			];

			//create new data of old data
			$new_student_module = $this->student_module->addStudentModule($data);

			//delete old
			if(!$this->student_module->deleteStudentModule($id)){

				return $this->respondErrorMessage(2057);
			}

			$student_module = $this->student_module->viewStudentModule($new_student_module->id);

			//get student details
			$student_detail = $this->student->viewStudent($student_module['student_id']);

			//get module detatils
			$module_detail = $this->module->viewModule($student_module['module_id']);
			$email = $student_detail['user'];
			$email['module_name'] = $module_detail['name'];

			//send email to student
			$this->mail->resetStudentModule($email);


			return $this->respondWithData($this->student_module->viewStudentModule($new_student_module->id));

		}else {

			return $this->respondErrorMessage(2120);
		}





	}

}
