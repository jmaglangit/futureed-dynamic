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
	 * @param $question_id
	 *
	 * @return mixed
	 */
	public function update($question_id) {
		$exercise_details = $this->snapExerciseDetails->getSnapExerciseDetails($question_id)->first();
		return $this->respondWithData(
			[
				'snap' => $exercise_details,
				'all_exercises_completed' => $this->checkIfSnapExerciseFinished($question_id),
				'completed_exercises_count' => $this->snapExerciseDetails->getCompletedExercises()->count()
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
		$is_completed = $this->checkIfSnapExerciseFinished($from_request['question_id']);

		if(!$is_completed)
		{
			$data = [
				'classroom_id' => $from_request['classroom_id'],
				'order_id' => $this->snapExerciseDetails->findOrderByClassroomId($from_request['classroom_id'])->id,
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
			'all_exercises_completed' => $this->checkIfSnapExerciseFinished($from_request['question_id']),
			'completed_exercises_count' => $this->snapExerciseDetails->getCompletedExercises()->count()
		]);
	}

	/**
	 * Checks whether All SNAP Exercises are complete
	 * @param $question_id
	 *
	 * @return bool
	 */
	private function checkIfSnapExerciseFinished($question_id) {
		$is_completed = true;

		$completed_exercise = $this->snapExerciseDetails->getCompletedExercises()->lists('question_id');
		$module_id = $this->snapExerciseDetails->getModuleByQuestionId($question_id)->id;
		$question_ids = $this->snapExerciseDetails->getQuestionByModuleId($module_id)->whereQuestionType(config('futureed.question_type_coding'))->lists('id');

		foreach($question_ids as $q_id)
		{
			if(!(in_array($q_id, $completed_exercise)))
			{
				$is_completed = false;
			}
		}

		return $is_completed;
	}


}
