<?php

namespace FutureEd\Models\Repository\SnapExerciseDetails;

interface SnapExerciseDetailsRepositoryInterface
{
	public function addSnapExerciseDetails($data);
	public function getSnapExerciseDetails($question_id, $order_id);
	public function findOrderByClassroomId($classroom_id);
	public function getCompletedExercises($order_id);
	public function getQuestionByModuleId($module_id);
	public function getModuleByQuestionId($question_id);
}