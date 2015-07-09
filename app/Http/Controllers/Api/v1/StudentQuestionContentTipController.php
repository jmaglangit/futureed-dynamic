<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests\Api\StudentQuestionContentTipRequest;
use FutureEd\Models\Repository\Tip\TipRepositoryInterface;

use Illuminate\Http\Request;

class StudentQuestionContentTipController extends ApiController {

	protected $tip;

	public function __construct(TipRepositoryInterface $tip ){

		$this->tip = $tip;


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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(StudentQuestionContentTipRequest $request)
	{
		$data =  $request->only('class_id','student_id','title','content','module_id','subject_id',
								'subject_area_id','link_type','link_id');

		//add data to tips
		$return = $this->tip->addTip($data);

		return $this->respondWithData(['id'=>$return['id']]);
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
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
