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
		$data['module_status'] = config('futureed.module_status_ongoing');
		$data['date_start'] = Carbon::now();
		$data['date_end'] = Carbon::now();
		$data['last_viewed_content_id'] = 0;
		$data['progress'] = 0;
		$data['total_time'] = 0;
		$data['question_counter'] = 0;
		$data['wrong_counter'] = 0;
		$data['correct_counter'] = 0;
		$data['running_points'] = 0;
		$data['points_earned'] = 0;
		$data['last_answered_question_id'] = 0;

		$this->student_module->updateStudentModule($id,$data);
		$student_module = $this->student_module->viewStudentModule($id);

		//get student details
		$student_detail = $this->student->viewStudent($student_module['student_id']);

		//get module detatils
		$module_detail = $this->module->viewModule($student_module['module_id']);
		$email = $student_detail['user'];
		$email['module_name'] = $module_detail['name'];

		//send email to student
		$this->mail->resetStudentModule($email);

		return $this->respondWithData($this->student_module->viewStudentModule($id));
	}

}
