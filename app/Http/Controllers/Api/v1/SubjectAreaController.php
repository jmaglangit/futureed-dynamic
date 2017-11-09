<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use FutureEd\Models\Repository\SubjectArea\SubjectAreaRepositoryInterface as SubjectArea;

use FutureEd\Services\ErrorServices as Errors;

use FutureEd\Http\Requests\Api\SubjectAreaRequest;

class SubjectAreaController extends ApiController {

	//holds the subject arearepository
	protected $subject_area;

	/**
	 * Subject Area Controller constructor
	 *
	 * @return void
	 */
	public function __construct(SubjectArea $subject_area) 
	{
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
				
		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}
		
		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

        if(Input::get('subject_id')) {
            $criteria['subject_id'] = Input::get('subject_id');
        }

			
		$subjects = $this->subject_area->getSubjectAreas($criteria, $limit, $offset);

		return $this->respondWithData($subjects);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SubjectAreaRequest $request)
	{
		$data = $request->all();
	
		$subject_area = $this->subject_area->addSubjectArea($data);
		
		return $this->respondWithData(['id' => $subject_area->id]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->subject_area->getSubjectArea($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, SubjectAreaRequest $request)
	{
		$data = $request->all();
	
		$subject_area = $this->subject_area->updateSubjectArea($id, $data);
		
		return $this->respondWithData(['id' => $subject_area->id]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return $this->respondWithData($this->subject_area->deleteSubjectArea($id));
	}

}
