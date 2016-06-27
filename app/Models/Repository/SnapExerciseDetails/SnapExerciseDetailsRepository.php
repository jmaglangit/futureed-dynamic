<?php

namespace FutureEd\Models\Repository\SnapExerciseDetails;

use FutureEd\Models\Core\Classroom;
use FutureEd\Models\Core\Question;
use FutureEd\Models\Core\SnapExerciseDetail;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class SnapExerciseDetailsRepository implements SnapExerciseDetailsRepositoryInterface
{
	use LoggerTrait;

	public function addSnapExerciseDetails($data)
	{
		DB::transaction();
		try
		{
			$response = SnapExerciseDetail::create($data);
		}
		catch(\Exception $e)
		{
			DB::rollback();
			$this->errorLog($e->getMessage());

			return $e->getMessage();
		}

		return $response;
	}

	public function findOrderByClassroomId($classroom_id)
	{
		$response = Classroom::find($classroom_id)->order;
		return $response;
	}

	public function getCompletedExercises($order_id)
	{
		$response = SnapExerciseDetail::whereIsExerciseCompleted(1)->whereOrderId($order_id);
		return $response;
	}

	public function getQuestionByModuleId($module_id)
	{
		$response = Question::whereModuleId($module_id);
		return $response;
	}

	public function getSnapExerciseDetails($question_id, $order_id)
	{
		$response = SnapExerciseDetail::whereQuestionId($question_id)->whereOrderId($order_id);
		return $response;
	}

	public function getModuleByQuestionId($question_id)
	{
		$response = Question::find($question_id)->module;
		return $response;
	}

	public function findOrderIdByClassroomId($classroom_id)
	{
		$response = $this->findOrderByClassroomId($classroom_id)->id;
		return $response;
	}

	public function getCompletedExercisesByOrder($order_id)
	{
		$response = $this->getCompletedExercises($order_id)->orderBy('question_id', 'desc')->get();
		return $response;
	}

	public function getFirstCompletedExercises($order_id)
	{
		$response = $this->getCompletedExercisesByOrder($order_id)->first()->question_id;
		return $response;
	}

	public function getFirstSnapExerciseDetails($question_id, $order_id)
	{
		$response = $this->getSnapExerciseDetails($question_id, $order_id)->first();
		return $response;
	}

	public function getCountCompletedExercise($order_id)
	{
		$response = $this->getCompletedExercises($order_id)->count();
		return $response;
	}

	public function getCompletedExercisesListByQuestionId($order_id)
	{
		$response = $this->getCompletedExercises($order_id)->lists('question_id');
		return $response;
	}

	public function getModuleIdByQuestionId($question_id)
	{
		$response = $this->getModuleByQuestionId($question_id)->id;
		return $response;
	}

	public function getQuestionIdsByModuleId($module_id)
	{
		$response = $this->getQuestionByModuleId($module_id)->whereQuestionType(config('futureed.question_type_coding'))->lists('id');
		return $response;
	}

}