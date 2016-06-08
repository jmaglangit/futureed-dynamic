<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StudentSnapModuleController extends ApiController
{

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
		return $this->respondWithData(true);
	}


}
