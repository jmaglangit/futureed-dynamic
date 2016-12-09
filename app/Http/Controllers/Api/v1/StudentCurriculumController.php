<?php namespace FutureEd\Http\Controllers\Api\v1;

use \Response;
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
	 * @return file
	 */
	public function getCurriculumPDFDownloadLink(){

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

		$filename = strtolower(str_replace(' ','_', $filename.'_'.session('appLanguage','en').'.pdf'));

		$filepath = storage_path().'/curriculum/'.session('appLanguage','en'). '/'.$filename;

		$url_path = url().'/api/v1/student/curriculum/export?filename='.$filename.'&locale='.session('appLanguage','en');

		if ($filesystem->exists($filepath)) {

			$data['url'] = $url_path;

			$data['filename'] = $filename;

			return $this->respondWithData($data);

		}

		return $this->respondErrorMessage(2053);
	}

	public function downloadCurriculumPdf(){

		$filesystem = new Filesystem();

		$filename = Input::get('filename');

		$locale = Input::get('locale');

		$filepath = storage_path().'/curriculum/'.$locale. '/'.$filename;

		$headers = array(
              		'Content-Type: application/pdf',
         		);


		if ($filesystem->exists($filepath)) {

			return \Response::download($filepath,$filename,$headers);
		}

		return $this->respondErrorMessage(2053);
	}

}