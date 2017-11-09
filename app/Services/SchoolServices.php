<?php


namespace FutureEd\Services;


use FutureEd\Models\Repository\School\SchoolRepositoryInterface;

class SchoolServices {

	/**
	 * @var int
	 */
	protected $stuck = 0;

	/**
	 * @var int
	 */
	protected $high_effort = 0;

	/**
	 * @var int
	 */
	protected $struggling = 0;

	/**
	 * @var int
	 */
	protected $excelling = 0;

	/**
	 * @var SchoolRepositoryInterface $schools
	 */
	protected $schools;

	/**
	 * @param SchoolRepositoryInterface $schools
	 */
	public function __construct(
		SchoolRepositoryInterface $schools) {
		$this->schools = $schools;

	}

	//get school details

	/**
	 * @param $school_id
	 * @return mixed
	 */
	public function getSchoolName($school_id) {

		return $getSchoolName = $this->schools->getSchoolName($school_id);
	}

	/**
	 * @param $school
	 * @return array
	 */
	public function addSchool($school) {
		$return = [];

		$addschool_response = $this->schools->addSchool($school);

		$school_id = $this->schools->getSchoolId($school['school_name']);

		$return = [
			'status' => 200,
			'id' => $school_id,
			'message' => $addschool_response,
		];

		return $return;
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function getSchoolDetails($id) {

		return $this->schools->getSchoolDetails($id);

	}


	/**
	 * @param $input
	 * @return mixed
	 */
	public function checkSchoolNameExist($input) {

		return $this->schools->checkSchoolNameExist($input);
	}

	/**
	 * @param $input
	 */
	public function updateSchoolDetails($input) {

		$this->schools->updateSchoolDetails($input);

	}

	/**
	 * @param $school_name
	 * @return mixed
	 */
	public function getSchoolCode($school_name) {

		return $this->schools->getSchoolCode($school_name);

	}

	/**
	 * @param $school_name
	 * @return mixed
	 */
	public function searchSchool($school_name) {

		return $this->schools->searchSchool($school_name);
	}


	/**
	 * @return int
	 */
	public function getStuck() {
		return $this->stuck;
	}

	/**
	 * @param int $stuck
	 */
	public function setStuck($stuck) {
		$this->stuck += $stuck;
	}

	/**
	 * @return int
	 */
	public function getHighEffort() {
		return $this->high_effort;
	}

	/**
	 * @param int $high_effort
	 */
	public function setHighEffort($high_effort) {
		$this->high_effort += $high_effort;
	}

	/**
	 * @return int
	 */
	public function getStruggling() {
		return $this->struggling;
	}

	/**
	 * @param int $struggling
	 */
	public function setStruggling($struggling) {
		$this->struggling += $struggling;
	}

	/**
	 * @return int
	 */
	public function getExcelling() {
		return $this->excelling;
	}

	/**
	 * @param int $excelling
	 */
	public function setExcelling($excelling) {
		$this->excelling += $excelling;
	}

	/**
	 * Get student progress by approve level.
	 * @param $students
	 * @return array
	 */
	public function getStudentProgress($students) {

		//Struggling = 20% and Below of the Progress of the Module Per Class
		//Excelling = 80% to 100% of the Progress of the Module Per Class
		//Stuck - if get more than 40% in module wrong and must redo (progress)
		//Mastered - If they get 80% above correct (progress)

		$standing = [];


		foreach ($students as $progress) {

			$data = new \stdClass();

			$data->first_name = $progress->first_name;
			$data->last_name = $progress->last_name;
			$data->progress = $this->getProgressStatusConverter($progress);

			array_push($standing, $data);

		}

		return $standing;
	}

	/**
	 * Get highest correct scorer.
	 * @param $student_scores
	 * @return array
	 */
	public function getHighCorrectScores($student_scores){

		$correct_score = [
			'id' => 0,
			'score' => 0,
			'student_first_name' => '',
			'student_last_name' => '',
			'teacher_first_name' => '',
			'teacher_last_name' => ''
		];

		$current_score = 0;

		foreach($student_scores as $score){

			if($score->Correct > $current_score){
				$correct_score = [
						'id' => $score->student_module_answer,
						'score' => $score->Correct,
						'student_first_name' => $score->stud_first_name,
						'student_last_name' => $score->stud_last_name,
						'teacher_first_name' => $score->client_first_name,
						'teacher_last_name' => $score->client_last_name
				];

				$current_score = $score->Correct;
			}
		}

		return $correct_score;
	}

	/**
	 * Get highest wrong scorer.
	 * @param $student_scores
	 * @return array
	 */
	public function getHighWrongScores($student_scores){

		$wrong_score = [
				'id' => 0,
				'score' => 0,
				'student_first_name' => '',
				'student_last_name' => '',
				'teacher_first_name' => '',
				'teacher_last_name' => ''
		];

		$current_score = 0;

		foreach($student_scores as $score){

			if($score->Wrong > $current_score){
				$wrong_score = [
						'id' => $score->student_module_answer,
						'score' => $score->Correct,
						'student_first_name' => $score->stud_first_name,
						'student_last_name' => $score->stud_last_name,
						'teacher_first_name' => $score->client_first_name,
						'teacher_last_name' => $score->client_last_name
				];

				$current_score = $score->Correct;
			}
		}

		return $wrong_score;
	}


	/**
	 * Convert progress status to approved format.
	 * @param $progress
	 * @return mixed|null
	 */
	public function getProgressStatusConverter($progress) {

		switch ($progress->percent_progress) {

			//Struggling 20 and below
			case $progress->percent_progress <= 20:

				$this->setStruggling(1);
				return config('futureed.student_struggling');
				break;

			//Excelling and Mastering/High Effort
			case $progress->percent_progress >= 80 && $progress->percent_progress <= 100:
				$this->setHighEffort(1);
				$this->setExcelling(1);
				return config('futureed.student_excelling');
				break;

			//None
			default:

				$this->setStuck(1);
				return null;
				break;
		}

	}

}