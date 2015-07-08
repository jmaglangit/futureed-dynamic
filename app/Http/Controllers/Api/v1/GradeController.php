<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\CountryGrade\CountryGradeRepositoryInterface;

use FutureEd\Http\Requests\Api\GradeRequest;

use FutureEd\Models\Repository\Grade\GradeRepositoryInterface as Grade;

use Illuminate\Support\Facades\Input;

class GradeController extends ApiController
{

	protected $grade;

	protected $country_grade;

	public function __construct(
		Grade $grade,
		CountryGradeRepositoryInterface $countryGradeRepositoryInterface
	)
	{

		$this->grade = $grade;
		$this->country_grade = $countryGradeRepositoryInterface;

	}


	//get list of grade levels
	public function index()
	{

		$criteria = array();
		$limit = 0;
		$offset = 0;

		if (Input::get('name')) {
			$criteria['name'] = Input::get('name');
		}


		$country_exist = $this->grade->checkCountry(Input::get('country_id'));

		switch (Input::get('country_id')) {
			case 'all':
				$criteria['country_id'] = 'all';
				break;
			default:
				if ($country_exist) {
					$criteria['country_id'] = Input::get('country_id');
				} else {
					$criteria['country_id'] = config('futureed.default_country');
				}
				break;
		}

		if (Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if (Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		$grade = $this->grade->getGrades($criteria, $limit, $offset);


		return $this->respondWithData($grade);

	}

	public function show($id)
	{

		$grade = $this->grade->getGradeById($id);

		if (empty($grade)) {

			return $this->respondErrorMessage(2120);

		}

		$country_grade = $this->country_grade->getCountryGradeByGrade($grade->id);

		$grade->age_group_id = $country_grade->age_group_id;

		return $this->respondWithData($grade);

	}

	/**
	 * Add grades to be inserted to
	 * @param GradeRequest $request
	 * @return mixed
	 */
	public function store(GradeRequest $request)
	{

		$grade = $request->only('code', 'name', 'country_id', 'description', 'status');
		$country_grade = $request->only('age_group_id', 'country_id');

		$grade = $this->grade->addGrade($grade);

		//Add to Country Grade
		$country_grade = array_merge($country_grade, ['grade_id' => $grade->id]);

		$this->country_grade->addCountryGrade($country_grade);


		return $this->respondWithData(['id' => $grade->id]);

	}

	public function update($id, GradeRequest $request)
	{

		$data = $request->except(array('code'));
		$country_grade = $request->only('age_group_id');
		$grade = $this->grade->getGradeById($id);

		if (empty($grade)) {

			return $this->respondErrorMessage(2120);

		}

		//Update Country Grade
		$country_grade = $this->country_grade->updateAgeGroup($grade->id, $country_grade);

		$grade = $this->grade->updateGrade($id, $data);

		$grade->age_group_id = $country_grade->age_group_id;

		return $this->respondWithData([$grade]);

	}


	public function destroy($id)
	{

		//check if this record is related to student before deleting
		$relation = $this->grade->getStudentByCode($id);

		if (empty($relation)) {

			return $this->respondErrorMessage(2120);
		}

		if ($relation['students']->toArray()) {

			return $this->respondErrorMessage(2119);
		}

		return $this->respondWithData($this->grade->deleteGrade($id));
	}


}
