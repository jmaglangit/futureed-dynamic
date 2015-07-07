<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\TeachingContent\TeachingContentRepositoryInterface;
use FutureEd\Http\Requests\Api\TeachingContent;

class TeachingContentController extends ApiController {

	protected $teaching_content;

	/**
	 * Initialized Teaching Content.
	 * @param TeachingContentRepositoryInterface $teachingContentRepositoryInterface
	 */
	public function __construct(
		TeachingContentRepositoryInterface $teachingContentRepositoryInterface
	){
		$this->teaching_content = $teachingContentRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TeachingContent $request)
	{

		$data = $request->only(
			'module_id',
			'subject_id',
			'subject_area_id',
			'code',
			'teaching_module',
			'description',
			'learning_style_id',
			'content_url',
			'media_type_id'
		);

		return $this->respondWithData(
			$this->teaching_content->addTeachingContent($data)
		);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
