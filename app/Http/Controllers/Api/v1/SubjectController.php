<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use FutureEd\Models\Repository\Subject\SubjectRepositoryInterface as Subject;
use FutureEd\Models\Repository\SubjectArea\SubjectAreaRepositoryInterface as SubjectArea;

use FutureEd\Services\ErrorServices as Errors;

use FutureEd\Http\Requests\Api\SubjectRequest;

class SubjectController extends ApiController {

	//holds the subject repository
	protected $subject;
	protected $subject_area;

	/**
	 * Subject Controller constructor
	 *
	 * @return void
	 */
	public function __construct(Subject $subject, SubjectArea $subject_area) 
	{
		$this->subject = $subject;
		$this->subject_area = $subject_area;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = array();
		$limit = 0;
		$offset = 0;
			
		if(Input::get('name')) {
			$criteria['name'] = Input::get('name');
		}

		if(Input::get('status')) {
			$criteria['status'] = Input::get('status');
		}
				
		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}
		
		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}
			
		$subjects = $this->subject->getSubjects($criteria, $limit, $offset);

		return $this->respondWithData($subjects);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SubjectRequest $request)
	{
		$data = $request->all();
	
		$subject = $this->subject->addSubject($data);
		
		return $this->respondWithData(['id' => $subject->id]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->subject->getSubject($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, SubjectRequest $request)
	{
		$data = $request->all();
	
		$subject = $this->subject->updateSubject($id, $data);
		
		return $this->respondWithData(['id' => $subject->id]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$subject_areas = $this->subject_area->getAreasBySubjectId($id);
		
		if($subject_areas->count() > 0) {
			
			return $this->respondErrorMessage(2600);
			
		} else {
			return $this->respondWithData($this->subject->deleteSubject($id));
		}
	
	}

}
