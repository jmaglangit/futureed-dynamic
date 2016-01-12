<?php namespace FutureEd\Services;

use FutureEd\Models\Repository\Badge\BadgeRepositoryInterface;
use FutureEd\Models\Repository\CountryGrade\CountryGradeRepositoryInterface;
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

	protected $country_grade;

	public function __construct(
		StudentRepositoryInterface $studentRepositoryInterface,
		StudentModuleRepositoryInterface $studentModuleRepositoryInterface,
		BadgeRepositoryInterface $badgeRepositoryInterface,
		StudentBadgeRepositoryInterface $studentBadgeRepositoryInterface,
		ModuleRepositoryInterface $moduleRepositoryInterface,
		CountryGradeRepositoryInterface $countryGradeRepositoryInterface
	){
		$this->student = $studentRepositoryInterface;
		$this->student_module = $studentModuleRepositoryInterface;
		$this->badge = $badgeRepositoryInterface;
		$this->student_badge = $studentBadgeRepositoryInterface;
		$this->module = $moduleRepositoryInterface;
		$this->country_grade = $countryGradeRepositoryInterface;
	}


	/**
	 * Check student candidate for badge.
	 * @param $student_id
	 * @param $subject_id
	 * @param $grade_id
	 * @return bool
	 */
	public function checkBadgeCandidate($student_id, $subject_id, $grade_id){

		$module = $this->module->getGradeModule($subject_id,$grade_id);
		$student_module = $this->student_module->getStudentModuleGradeCompleted($student_id,$subject_id,$grade_id);

		//check if module is complete.
		if(count($module->toArray()) == count($student_module->toArray())){

			$this->unlockBadge($student_id,$subject_id,$grade_id);
			return true;
		}

		return false;
	}


	/**
	 * Add student badge.
	 * @param $student_id
	 * @param $subject_id
	 * @param $grade_id
	 * @return bool
	 */
	public function unlockBadge($student_id,$subject_id, $grade_id){

		//get age_group_id
		$country_grade = $this->country_grade->getCountryGradeByGrade($grade_id);

		//get student's badge
		$student_badge = $this->student_badge->getStudentBadge($student_id,$subject_id,$grade_id);

		//Add student badge if it doesn't exist.
		if(empty($student_badge->toArray())){

			$this->student_badge->addStudentBadge([
				'student_id' => $student_id,
				'subject_id' => $subject_id,
				'age_group_id' => $country_grade->age_group_id
			]);

		}

		return true;
	}

}