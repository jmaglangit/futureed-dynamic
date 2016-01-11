<?php namespace FutureEd\Services;

use FutureEd\Models\Repository\Badge\BadgeRepositoryInterface;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\StudentBadge\StudentBadgeRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;

class BadgeServices {

	protected $student;

	protected $student_module;

	protected $badge;

	protected $student_badge;

	protected $module;

	public function __construct(
		StudentRepositoryInterface $studentRepositoryInterface,
		StudentModuleRepositoryInterface $studentModuleRepositoryInterface,
		BadgeRepositoryInterface $badgeRepositoryInterface,
		StudentBadgeRepositoryInterface $studentBadgeRepositoryInterface,
		ModuleRepositoryInterface $moduleRepositoryInterface
	){
		$this->student = $studentRepositoryInterface;
		$this->student_module = $studentModuleRepositoryInterface;
		$this->badge = $badgeRepositoryInterface;
		$this->student_badge = $studentBadgeRepositoryInterface;
		$this->module = $moduleRepositoryInterface;
	}

	//get all modules where subject, grade
	//get all student modules where subject, grade,student

	//compare modules and student_modules
		//if complete  unlock badge
		//else do nothing
	public function checkBadgeCandidate($student_id, $subject_id, $grade_id){

		$module = $this->module->getGradeModule($subject_id,$grade_id);
		$student_module = $this->student_module->getStudentModuleGrade($student_id,$subject_id,$grade_id);


	}


	//Unlock badge
		//if not exists add badge to student_badge

}