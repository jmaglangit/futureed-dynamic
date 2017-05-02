<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;
use FutureEd\Models\Core\Module;
use FutureEd\Models\Core\School;
use FutureEd\Models\Core\Subject;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Country\CountryRepositoryInterface;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\School\SchoolRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use FutureEd\Models\Repository\Subject\SubjectRepositoryInterface;
use FutureEd\Services\SchoolServices;

class SchoolReportController extends ReportController {

	/**
	 * @var SchoolRepositoryInterface
	 */
	protected $school;

	/**
	 * @var StudentModuleRepositoryInterface
	 */
	protected $student_module;

	/**
	 * @var SchoolServices
	 */
	protected $school_service;

    /**
     * @var ClientRepositoryInterface
     */
	protected $client;

    /**
     * @var SubjectRepositoryInterface
     */
	protected $subject;

    /**
     * @var ModuleRepositoryInterface
     */
    protected $module;

    /**
     * @var CountryRepositoryInterface
     */
	protected $country;

	/**
	 * @param SchoolRepositoryInterface $schoolRepositoryInterface
	 * @param StudentModuleRepositoryInterface $studentModuleRepositoryInterface
	 * @param SchoolServices $schoolServices
     * @param ClientRepositoryInterface $clientRepositoryInterface
     * @param SubjectRepositoryInterface $subjectRepositoryInterface
     * @param CountryRepositoryInterface $countryRepositoryInterface
	 */
	public function __construct(
		SchoolRepositoryInterface $schoolRepositoryInterface,
		StudentModuleRepositoryInterface $studentModuleRepositoryInterface,
		SchoolServices $schoolServices,
		ClientRepositoryInterface $clientRepositoryInterface,
		SubjectRepositoryInterface $subjectRepositoryInterface,
		CountryRepositoryInterface $countryRepositoryInterface
	) {
		$this->school = $schoolRepositoryInterface;
		$this->student_module = $studentModuleRepositoryInterface;
		$this->school_service = $schoolServices;
		$this->client = $clientRepositoryInterface;
		$this->subject = $subjectRepositoryInterface;
		$this->country = $countryRepositoryInterface;
	}


	/**
	 * @param $school_code
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getSchoolProgress($school_code) {


		// Key Skills to watch
		$skill = $this->school->getSchoolAreaRanking($school_code);

		$skill_watch = [
			'highest_skill' => null,
			'lowest_skill' => null
		];

		if ($skill) {

			$skills = $skill->toArray();
			$skill_watch['highest_skill'] = (count($skills) > 0) ? reset($skills): null;
			$skill_watch['lowest_skill'] = (count($skills) > 0) ? end($skills) : null;
		}

		// Key classes to watch
		$class = $this->school->getSchoolClassRanking($school_code);

		$class_watch = [
			'highest_class' => null,
			'lowest_class' => null
		];

		if ($class) {

			$classes = $class->toArray();
			$class_watch['highest_class'] = (count($classes) > 0) ? reset($classes) : null;
			$class_lowest = end($classes);
			$class_watch['lowest_class'] = (count($classes) > 0
					&& $class_watch['highest_class']['class_name'] <> $class_lowest['class_name']) ? $class_lowest : null;
		}




		// Key student to watch - refer to previous query
		$student = $this->school->getSchoolStudentRanking($school_code);

		$student_progress = $this->school_service->getStudentProgress($student);

		$student_watch = $student_progress;

		//Correct Wrong -
		$student_scores = $this->school->getSchoolStudentScores($school_code);


		//Highest score
		$highest_correct_score = $this->school_service->getHighCorrectScores($student_scores);

		//lowest score
		$highest_wrong_score = $this->school_service->getHighWrongScores($student_scores);


		//additional information
		$school = $this->school->getSchoolByCode($school_code);

		//get country info
		$country = $this->country->getCountry($school[0]->country_id);


		//Principal Name, School, School Address (Address, City, state, Postal code, country)

		$school_address = (empty($school[0]->street_address)) ? '' : $school[0]->street_address;
		$school_address = (empty($school[0]->city))? $school_address : $school_address.", ".$school[0]->city;
		$school_address = (empty($school[0]->state))? $school_address : $school_address.", ".$school[0]->state;
		$school_address = (empty($school[0]->zip))? $school_address : $school_address.", ".$school[0]->zip;
		$school_address = (empty($country[0]['full_name']))? $school_address : $school_address.", ". $country[0]['full_name'];

		$additional_information = [
			'principal_name' => $school[0]->contact_name,
			'school_name' => $school[0]->name,
			'school_address' => $school_address
		];

		$column_header = [
			'skills_watch' => 'Key Skill areas to watch',
			'class_watch' => 'Key Classes to watch',
			'student_watch' => 'Key Student to watch',
			'highest_score' => 'Highest Score',
			'lowest_score' => 'Lowest Score'
		];

		$rows = [
			'skills_watch' => $skill_watch,
			'class_watch' => $class_watch,
			'student_watch' => $student_watch,
			'highest_score' => $highest_correct_score,
			'lowest_score' => $highest_wrong_score
		];

		return [
			'additional_information' => $additional_information,
			'column_header' => $column_header,
			'rows' => $rows
		];
	}

	/**
	 * @param $school_code
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getSchoolTeacherProgress($school_code){

		//Teacher progress.
		$class = $this->school->getSchoolClassRanking($school_code);

		//additional information
		$school = $this->school->getSchoolByCode($school_code);

		//get country info
		$country = $this->country->getCountry($school[0]->country_id);

		//get address -- filter if null data
		$school_address = (empty($school[0]->street_address)) ? '' : $school[0]->street_address;
		$school_address = (empty($school[0]->city))? $school_address : $school_address.", ".$school[0]->city;
		$school_address = (empty($school[0]->state))? $school_address : $school_address.", ".$school[0]->state;
		$school_address = (empty($school[0]->zip))? $school_address : $school_address.", ".$school[0]->zip;
		$school_address = (empty($country[0]['full_name']))? $school_address : $school_address.", ". $country[0]['full_name'];

		$additional_information = [
				'principal_name' => $school[0]->contact_name,
				'school_name' => $school[0]->name,
				'school_address' => $school_address
		];

		$column_header = [
			'teacher_list' => 'Teacher',
			'progress' => 'Progress'
		];

		$rows = $class->toArray();

		return [
			'additional_information' => $additional_information,
			'column_header' => $column_header,
			'rows' => $rows
		];
	}

    /**
     * Returns a set of rows, each represents a teachers progress in multiple subjects.
     * @param $school_code
     * @param $grade_level
     * @return \Symfony\Component\HttpFoundation\Response
     */
	public function getSchoolTeacherSubjectProgress($school_code, $grade_level) {

	    // query subjects with modules and classroom with student modules from database
        $subjects = $this->subject->getSubjectsWithModules($grade_level);
        $progress = $this->school->getSchoolSubjectProgress($school_code, $grade_level);

        $additional_information = $this->getAdditionalInfo($school_code);

        $column_header = $this->mapSubjects($subjects);

        $rows = array();

        // determine the progress of every teacher for each subject
        foreach ($progress->teachers as $teacher) {

            // initialize teacher progress and total progress
            $teacher_progress = $this->initializeSubjectProgress(array_keys($column_header));
            $total_progress = $this->initializeSubjectProgress(array_keys($column_header));

            // collecting actual progress and total progress
            foreach ($teacher->classroom as $classroom) {

                $subject_id = $classroom->subject_id;

                $teacher_progress[$subject_id] += $this->getClassroomProgress($classroom);
                $total_progress[$subject_id] +=
                    $subjects[$column_header[$subject_id]]->moduleCount->count * 100;

            }

            // calculates progress
            foreach (array_keys($column_header) as $subject_id) {

                // if total progress is 0, no actual progress was made, so it results to 0
                if ($total_progress[$subject_id] !== 0)
                    $teacher_progress[$subject_id] /= (float) $total_progress[$subject_id];

            }

            // sets the array of progress to the corresponding teacher
            $rows[$teacher->first_name . ' ' . $teacher->last_name] = $teacher_progress;

        }

        return [
            'additional_information' => $additional_information,
            'column_header' => $column_header,
            'rows' => $rows
        ];

    }

    /**
     * Creates an array of key value pairs of subject id (key) and subject name (value)
     * based on the parameter $subjects.
     * @param $subjects
     * @return array
     */
    private function mapSubjects($subjects) {

	    $map = array();

	    foreach ($subjects as $subject) {

	        $map[$subject->id] = $subject->name;

        }

	    return $map;

    }

    /**
     * Gets the sum of all the student modules that belong to a classroom
     * e.g. 3 student modules from the same classroom with eighty(80) progress will return 240.
     * @param $classroom
     * @return int
     */
    private function getClassroomProgress($classroom) {

	    $progress = 0;

	    foreach ($classroom->studentModule as $student_module) {

	        $progress += $student_module->progress;

        }

        return $progress;

    }

    /**
     * Initializes an array of key value pairs of subject id (key) and initial values of 0.
     * @param $column_header
     * @return array
     */
    private function initializeSubjectProgress($column_header) {

	    $arr = array();

        foreach ($column_header as $header) {

            $arr[$header] = 0;

        }

        return $arr;

    }

    /**
     * Gets the `Additional Information` of a school for reports.
     * @param $school_code
     * @return array
     */
    private function getAdditionalInfo($school_code) {
        //additional information
        $school = $this->school->getSchoolByCode($school_code);

        //get country info
        $country = $this->country->getCountry($school[0]->country_id);

        //get address -- filter if null data
        $school_address = (empty($school[0]->street_address)) ? '' : $school[0]->street_address;
        $school_address = (empty($school[0]->city))? $school_address : $school_address.", ".$school[0]->city;
        $school_address = (empty($school[0]->state))? $school_address : $school_address.", ".$school[0]->state;
        $school_address = (empty($school[0]->zip))? $school_address : $school_address.", ".$school[0]->zip;
        $school_address = (empty($country[0]['full_name']))? $school_address : $school_address.", ". $country[0]['full_name'];

        return [
            'principal_name' => $school[0]->contact_name,
            'school_name' => $school[0]->name,
            'school_address' => $school_address
        ];
    }

}
