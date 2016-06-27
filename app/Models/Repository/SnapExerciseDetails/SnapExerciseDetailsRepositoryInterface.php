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
	public function findOrderIdByClassroomId($classroom_id);
	public function getCompletedExercisesByOrder($order_id);
	public function getFirstCompletedExercises($order_id);
	public function getFirstSnapExerciseDetails($question_id, $order_id);
	public function getCountCompletedExercise($order_id);
	public function getCompletedExercisesListByQuestionId($order_id);
	public function getModuleIdByQuestionId($question_id);
	public function getQuestionIdsByModuleId($module_id);
}