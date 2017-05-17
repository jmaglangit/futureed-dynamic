<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;
use FutureEd\Models\Core\Module;
use FutureEd\Models\Core\School;
use FutureEd\Models\Core\Subject;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Country\CountryRepositoryInterface;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\School\SchoolRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use FutureEd\Models\Repository\Subject\SubjectRepositoryInterface;
use FutureEd\Services\SchoolServices;

class SchoolReportController extends ReportController {

	/**
	 * @var SchoolRepositoryInterface
	 */
	protected $school;

    /**
     * @var StudentRepositoryInterface
     */
	protected $student;

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
     * @param StudentRepositoryInterface $studentRepositoryInterface
	 * @param StudentModuleRepositoryInterface $studentModuleRepositoryInterface
	 * @param SchoolServices $schoolServices
     * @param ClientRepositoryInterface $clientRepositoryInterface
     * @param SubjectRepositoryInterface $subjectRepositoryInterface
     * @param CountryRepositoryInterface $countryRepositoryInterface
	 */
	public function __construct(
		SchoolRepositoryInterface $schoolRepositoryInterface,
		StudentRepositoryInterface $studentRepositoryInterface,
		StudentModuleRepositoryInterface $studentModuleRepositoryInterface,
		SchoolServices $schoolServices,
		ClientRepositoryInterface $clientRepositoryInterface,
		SubjectRepositoryInterface $subjectRepositoryInterface,
		CountryRepositoryInterface $countryRepositoryInterface
	) {
		$this->school = $schoolRepositoryInterface;
		$this->student = $studentRepositoryInterface;
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
        $progress = $this->school->getTeacherSubjectProgress($school_code, $grade_level);

        $additional_information = $this->getAdditionalInfo($school_code);

        $column_header = $this->mapSubjects($subjects);

        $rows = array();

        // iterates through each teacher to determine their student's progress in each subject
        foreach ($progress->teachers as $teacher) {

            // initialize teacher progress and total progress
            $teacher_progress = $this->initializeSubjectBins(array_keys($column_header));
            $total_progress = $this->initializeSubjectBins(array_keys($column_header));

            // collecting actual progress and total progress
            foreach ($teacher->classroom as $classroom) {

                $subject_id = $classroom->subject_id;

                $teacher_progress[$subject_id] += $this->getClassroomProgress($classroom);
                $total_progress[$subject_id] +=
                    $subjects[$column_header[$subject_id]]->moduleCount->count * $classroom->seats_taken *100;

            }

            // calculates progress
            foreach (array_keys($column_header) as $subject_id) {

                // if total progress is 0, no actual progress was made, so it results to 0
                if ($total_progress[$subject_id] !== 0) {

                    $teacher_progress[$subject_id] /= (float)$total_progress[$subject_id];
                    $teacher_progress[$subject_id] = floor($teacher_progress[$subject_id] * 100);

                }

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
     * Returns a set of rows, each represents the scores of a teacher's students in multiple subjects.
     * @param $school_code
     * @param $grade_level
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSchoolTeacherSubjectScores($school_code, $grade_level) {

        // query subjects with modules and classroom with student modules from database
        $subjects = $this->subject->getSubjectsWithModules($grade_level);
        $scores = $this->school->getTeacherSubjectProgress($school_code, $grade_level);

        $additional_information = $this->getAdditionalInfo($school_code);

        $column_header = $this->mapSubjects($subjects);

        $rows = array();

        // iterates through every teacher to determine their student's scores in each subject
        foreach ($scores->teachers as $teacher) {

            // initialize teacher scores and score count
            $teacher_scores = $this->initializeSubjectBins(array_keys($column_header));
            $score_count = $this->initializeSubjectBins(array_keys($column_header));

            // collecting scores and score count
            foreach ($teacher->classroom as $classroom) {

                $subject_id = $classroom->subject_id;

                $classroomScores = $this->getClassroomScores($classroom);

                $teacher_scores[$subject_id] += $classroomScores['score'];
                $score_count[$subject_id] += $classroomScores['count'];

            }

            // calculates scores
            foreach (array_keys($column_header) as $subject_id) {

                // if score count is 0, no modules were answered, so it results to 0
                if ($score_count[$subject_id] !== 0) {

                    $teacher_scores[$subject_id] /= (float) $score_count[$subject_id];
                    $teacher_scores[$subject_id] = floor($teacher_scores[$subject_id] * 100);

                }
            }

            // sets the array of scores to the corresponding teacher
            $rows[$teacher->first_name . ' ' . $teacher->last_name] = $teacher_scores;

        }

        return [
            'additional_information' => $additional_information,
            'column_header' => $column_header,
            'rows' => $rows
        ];

    }

    /**
     * Returns a set of rows, each represents the student's progress in multiple modules in a
     * particular subject and grade level.
     * @param $school_code
     * @param $teacher_id
     * @param $subject_id
     * @param $grade_level
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSchoolStudentSubjectProgress($school_code, $teacher_id, $subject_id, $grade_level) {

        // query subjects with modules and students with student modules from database
        $subject = $this->subject->getASubjectWithAreas($subject_id, $grade_level);
        $students = $this->student->getStudentsWithModules($school_code, $subject_id, $grade_level);

        $additional_information = $this->getAdditionalInfo($school_code);

        $numPages = $this->getNumPages(count($subject->subjectAreas));
        $column_header = $this->mapAreas($subject->subjectAreas, $numPages);

        $rows = array();

        $subject_area_count = $this->mapSubjectAreaCount($subject->subjectAreas);

        // iterates through each student to determine their progress in each module
        foreach ($students as $student) {

            $student_progress = $this->initializeAreaBins($column_header);

            // iterates though each of the student's modules
            foreach($student->studentModule as $student_module) {

                // filters the modules by grade_level and by teacher
                if ($student_module->classroom->grade_id == $grade_level &&
                    $student_module->classroom->client_id == $teacher_id) {

                    // iterates every page
                    foreach (array_keys($student_progress) as $page_num) {

                        // if the subject_area_id exists as a key, then adds the progress to student_progress
                        if (array_key_exists($student_module->module->subject_area_id, $student_progress[$page_num])) {

                            $student_progress[$page_num][$student_module->module->subject_area_id]
                                += $student_module->progress;

                            break;

                        }

                    }

                }

            }

            // iterates through each page via page_num
            foreach (array_keys($student_progress) as $page_num) {

                // iterates through the page's progress/records via subject_area_id
                foreach (array_keys($student_progress[$page_num]) as $subject_area_id) {

                    $student_progress[$page_num][$subject_area_id] /= $subject_area_count[$subject_area_id];
                    // drops the decimal value and converts to integer
                    $student_progress[$page_num][$subject_area_id] = (int)$student_progress[$page_num][$subject_area_id];

                }

            }

            $rows[$student->first_name . ' ' . $student->last_name] = $student_progress;

        }

        return [
            'additional_information' => $additional_information,
            'column_header' => $column_header,
            'rows' => $rows
        ];

    }

    /**
     * Returns a set of rows, each represents the student's scores in multiple modules in a
     * particular subject and grade level.
     * @param $school_code
     * @param $teacher_id
     * @param $subject_id
     * @param $grade_level
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSchoolStudentSubjectScores($school_code, $teacher_id, $subject_id, $grade_level) {

        // query subjects with modules and students with student modules from database
        $subject = $this->subject->getASubjectWithAreas($subject_id, $grade_level);
        $students = $this->student->getStudentsWithModules($school_code, $subject_id, $grade_level);

        $additional_information = $this->getAdditionalInfo($school_code);

        $numPages = $this->getNumPages(count($subject->subjectAreas));
        $column_header = $this->mapAreas($subject->subjectAreas, $numPages);

        $rows = array();

        // iterates through each student to determine their score in each module
        foreach ($students as $student) {

            $student_scores = $this->initializeAreaBins($column_header);
            $subject_area_count = $this->initializeAreaCountBins($subject->subjectAreas);

            // iterates though each of the student's modules
            foreach ($student->studentModule as $student_module) {

                // filters the modules by grade_level and by teacher
                if ($student_module->classroom->grade_id == $grade_level &&
                    $student_module->classroom->client_id == $teacher_id) {

                    // iterates every page
                    foreach (array_keys($student_scores) as $page_num) {

                        // if the subject_area_id exists as a key, then adds the progress to student_progress
                        if (array_key_exists($student_module->module->subject_area_id, $student_scores[$page_num])) {

                            $student_scores[$page_num][$student_module->module->subject_area_id]
                                += $student_module->correct_counter / $student_module->question_counter;

                            $subject_area_count[$student_module->module->subject_area_id]++;

                            break;

                        }

                    }

                }

            }

//            dd($subject_area_count);

            // iterates through each page via page_num
            foreach (array_keys($student_scores) as $page_num) {

                // iterates through the page's progress/records via subject_area_id
                foreach (array_keys($student_scores[$page_num]) as $subject_area_id) {

                    if ($subject_area_count[$subject_area_id] > 0) {

                        $student_scores[$page_num][$subject_area_id] /= $subject_area_count[$subject_area_id];
                        $student_scores[$page_num][$subject_area_id] *= 100;
                        // drops the decimal value and converts to integer
                        $student_scores[$page_num][$subject_area_id] = (int)$student_scores[$page_num][$subject_area_id];

                    }

                }

            }

            $rows[$student->first_name . ' ' . $student->last_name] = $student_scores;

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
     * Creates and array of key value pairs of module id (key) and module name (value)
     * @param $subject_areas
     * @param $num_pages
     * @return array
     */
    private function mapAreas($subject_areas, $num_pages) {

        $map = array();
        $sub_map = array();

        $max_per_page = $this->getMaxPerPage(count($subject_areas), $num_pages);

        $page_num = 1;

        $entry_count = 0;

        foreach ($subject_areas as $subject_area) {

            if ($entry_count >= $max_per_page) {

                $entry_count = 0;
                $map[$page_num++] = $sub_map;
                $sub_map = array();

            }

            $sub_map[$subject_area->id] = $subject_area->name;

            $entry_count++;

        }

        if (count($sub_map) > 0)
            $map[$page_num] = $sub_map;

        return $map;

    }

    /**
     *
     * @param $subject_areas
     * @return array
     */
    private function mapSubjectAreaCount($subject_areas) {

        $map = array();

        foreach ($subject_areas as $subject_area) {

            $map[$subject_area->id] = $subject_area->moduleCount->count;

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
     * Gets the summation of all scores in a classroom along with the number of scores
     * @param $classroom
     * @return array
     */
    private function getClassroomScores($classroom) {

        $response = array(
            'score' => 0,
            'count' => 0
        );

        foreach ($classroom->studentModule as $student_module) {

            if ($student_module->question_counter !== 0) {

                $response['score'] += $student_module->correct_counter / $student_module->question_counter;
                $response['count']++;

            }

        }

        return $response;

    }

    /**
     * Gets the maximum number of pages based on a MAX value.
     * @param $count
     * @return int
     */
    private function getNumPages($count) {

        $MAX = 10;

        return (int) ceil($count / $MAX);

    }

    /**
     * Gets the maximum number of pages given the number/count of items and maximum number of pages.
     * @param $count
     * @param $num_pages
     * @return int
     */
    private function getMaxPerPage($count, $num_pages) {

        return (int) ceil($count / $num_pages);

    }

    /**
     * Initializes an array of key value pairs of subject id (key) and initial values of 0.
     * @param $column_header
     * @return array
     */
    private function initializeSubjectBins($column_header) {

	    $arr = array();

        foreach ($column_header as $header) {

            $arr[$header] = 0;

        }

        return $arr;

    }

    /**
     * Initializes an array of key value pairs of module id (key) and initial values of 0.
     * Elements are paginated based on the column header.
     * @param $column_header
     * @return array
     * @internal param $modules
     */
    private function initializeAreaBins($column_header) {

        $arr = array();

        $pageNum = 1;

        foreach ($column_header as $page) {

            $sub_arr = array();

            foreach (array_keys($page) as $subject_area_id) {

                $sub_arr[$subject_area_id] = 0;

            }

            $arr[$pageNum++] = $sub_arr;

        }

        return $arr;

    }

    /**
     *
     * @param $subject_areas
     * @return array
     */
    private function initializeAreaCountBins($subject_areas) {

        $map = array();

        foreach ($subject_areas as $subject_area) {

            $map[$subject_area->id] = 0;

        }

        return $map;

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
