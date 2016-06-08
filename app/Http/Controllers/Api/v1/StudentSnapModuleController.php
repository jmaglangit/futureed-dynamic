<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StudentSnapModuleController extends ApiController {

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
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * @param $module
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function show($module)
	{
		if(File::exists(storage_path('seeders/snap/'.$module.'.xml'))) {
			return response()->download(storage_path('seeders/snap/'.$module.'.xml'), $module.'.xml',['Content-Type' => 'text/xml']);
		}
		return response('');
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
