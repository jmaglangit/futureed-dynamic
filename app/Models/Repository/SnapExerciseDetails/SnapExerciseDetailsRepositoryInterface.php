<?php

namespace FutureEd\Models\Repository\SnapExerciseDetails;

interface SnapExerciseDetailsRepositoryInterface
{
	public function addSnapExerciseDetails($data);
	public function getSnapExerciseDetails($question_id);
	public function findOrderByClassroomId($classroom_id);
	public function getCompletedExercises();
	public function getQuestionByModuleId($module_id);
	public function getModuleByQuestionId($question_id);
}