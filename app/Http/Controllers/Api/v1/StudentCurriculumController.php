<?php namespace FutureEd\Http\Controllers\Api\v1;

use Response;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Grade\GradeRepositoryInterface;
use FutureEd\Models\Repository\Country\CountryRepositoryInterface;
use FutureEd\Models\Repository\Subject\SubjectRepositoryInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Filesystem\Filesystem;

class StudentCurriculumController extends ApiController {

	protected $grade;

	protected $country;

	protected $subject_id;


	public function __construct(
		GradeRepositoryInterface $grade,
		CountryRepositoryInterface $country,
		SubjectRepositoryInterface $subject){

		$this->grade = $grade;

		$this->country = $country;

		$this->subject = $subject;

	}

	/**
	 * @param curriculum_country
	 * @param grade_id
	 * @param subject_id
	 * @param locale
	 * @return file
	 */
	public function downloadCurriculumPdf(){
		$filesystem = new Filesystem();

		$country_id = Input::get('curriculum_country');

		$country = $this->country->getCountry($country_id);

		if(isset($country)){
			$filename = $country[0]['name'];
		}

		$grade_id =Input::get('grade_id');

		$grade = $this->grade->getGradeById($grade_id);

		if (isset($grade)) {

			$filename = $filename.'_'.$grade->name;
		}

		$subject_id = Input::get('subject_id');

		$subject = $this->subject->getSubject($subject_id);

		if (isset($subject)) {

			$filename = $filename.'_'.$subject->name;
		}

		// filename curriculum_grade_subject_language;
		$filename = $filename.'_'.Input::get('locale').'.pdf';

		$filename = str_replace(' ','_',$filename);

		$filename = strtolower($filename);

		$filepath = storage_path().'/curriculum/'.Input::get('locale'). '/'.$filename;

		$headers = array(
              		'Content-Type: application/pdf',
         		);

		if ($filesystem->exists($filepath)) {
			return \Response::download($filepath,$filename,$headers);
		}

		return $this->respondErrorMessage(2053);

	}

}