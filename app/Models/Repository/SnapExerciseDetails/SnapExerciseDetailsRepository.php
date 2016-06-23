<?php

namespace FutureEd\Models\Repository\SnapExerciseDetails;

use FutureEd\Models\Core\Classroom;
use FutureEd\Models\Core\Question;
use FutureEd\Models\Core\SnapExerciseDetail;
use FutureEd\Models\Traits\LoggerTrait;

class SnapExerciseDetailsRepository implements SnapExerciseDetailsRepositoryInterface
{
	use LoggerTrait;

	public function addSnapExerciseDetails($data)
	{
		$response = SnapExerciseDetail::create($data);
		return $response;
	}

	public function findOrderByClassroomId($classroom_id)
	{
		$response = Classroom::find($classroom_id)->order;
		return $response;
	}

	public function getCompletedExercises()
	{
		$response = SnapExerciseDetail::whereIsExerciseCompleted(1);
		return $response;
	}

	public function getQuestionByModuleId($module_id)
	{
		$response = Question::whereModuleId($module_id);
		return $response;
	}

	public function getSnapExerciseDetails($question_id)
	{
		$response = SnapExerciseDetail::whereQuestionId($question_id);
		return $response;
	}

	public function getModuleByQuestionId($question_id)
	{
		$response = Question::find($question_id)->module;
		return $response;
	}
}