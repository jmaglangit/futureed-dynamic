<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\SnapExerciseDetails\SnapExerciseDetailsRepositoryInterface;
use Illuminate\Support\Facades\File;
use FutureEd\Http\Requests\Api\SnapExerciseDetailsRequest;

class StudentSnapModuleController extends ApiController
{
	protected $snapExerciseDetails;

	public function __construct(SnapExerciseDetailsRepositoryInterface $snapExerciseDetails)
	{
		$this->snapExerciseDetails = $snapExerciseDetails;
	}

	/**
	 * Checks whether the current exercise is completed
	 * @param $request
	 * @param $question_id
	 *
	 * @return mixed
	 */
	public function update(SnapExerciseDetailsRequest $request, $question_id)
	{
		//Retrieve from request
		$class_id = $request->get('class');
		//Find order_id with given $class_id
		$order_id = $this->snapExerciseDetails->findOrderIdByClassroomId($class_id);
		//Find SnapExerciseDetail by given $question_id and $order_id
		$exercise_details = $this->snapExerciseDetails->getFirstSnapExerciseDetails($question_id, $order_id);

		return $this->respondWithData(
			[
				'snap' => $exercise_details,
				'all_exercises_completed' => $this->checkIfSnapExerciseFinished($question_id, $order_id),
				'completed_exercises_count' => $this->snapExerciseDetails->getCountCompletedExercise($order_id)
			]
		);
	}

	/**
	 * Display the specified resource.
	 * @param $question_id
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function show($question_id)
	{
		if(File::exists(storage_path('app/snap/'.$question_id.'/cod.xml'))) {
			return response()->download(storage_path('app/snap/'.$question_id.'/cod.xml'), 'cod.xml',['Content-Type' => 'text/xml']);
		}
		return $this->respondWithData(true);
	}

	/**
	 * Store the specified resource.
	 *
	 * @param SnapExerciseDetailsRequest $request
	 */
	public function store(SnapExerciseDetailsRequest $request)
	{
		$from_request = $request->all();
		$is_completed = $this->checkIfSnapExerciseFinished($from_request['question_id'], $from_request['classroom_id']);
		$order_id = $this->snapExerciseDetails->findOrderIdByClassroomId($from_request['classroom_id']);

		if(!$is_completed)
		{
			$data = [
				'classroom_id' => $from_request['classroom_id'],
				'order_id' => $order_id,
				'module_id' => $from_request['module_id'],
				'question_id' => $from_request['question_id'],
				'question_seq_no' => $from_request['seq_no'],
				'student_module_id' => $from_request['student_module_id'],
				'student_id' => $from_request['student_id'],
				'is_exercise_completed' => $from_request['answer_text'],
				'created_by' => $from_request['student_id'],
				'updated_by' => $from_request['student_id'],
				'date_start' => $from_request['date_start'],
				'date_end' => $from_request['date_end']
			];

			$this->snapExerciseDetails->addSnapExerciseDetails($data);
		}

		return $this->respondWithData([
			'all_exercises_completed' => $this->checkIfSnapExerciseFinished($from_request['question_id'], $order_id),
			'completed_exercises_count' => $this->snapExerciseDetails->getCountCompletedExercise($order_id)
		]);
	}

	/**
	 * Checks whether All SNAP Exercises are complete
	 * @param $question_id
	 * @param $order_id
	 *
	 * @return bool
	 */
	private function checkIfSnapExerciseFinished($question_id, $order_id) {
		$is_completed = true;

		//Get completed exercises by with given $order_id
		$completed_exercise = $this->snapExerciseDetails->getCompletedExercisesListByQuestionId($order_id);
		//Get module id
		$module_id = $this->snapExerciseDetails->getModuleIdByQuestionId($question_id);
		//Get question with question_type COD
		$question_ids = $this->snapExerciseDetails->getQuestionIdsByModuleId($module_id);

		foreach($question_ids as $q_id)
		{
			//Compare completed_exercise from question_ids
			if(!(in_array($q_id, $completed_exercise)))
			{
				$is_completed = false;
			}
		}

		return $is_completed;
	}


}
