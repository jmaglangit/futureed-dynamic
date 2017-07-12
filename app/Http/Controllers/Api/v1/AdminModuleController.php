<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\AdminModuleRequest;
use FutureEd\Models\Repository\ModuleCountry\ModuleCountryRepositoryInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Input;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;


class AdminModuleController extends ApiController {

	protected $module;

	protected $module_country;

	protected $file;

	public function __construct(
		ModuleRepositoryInterface $module,
		ModuleCountryRepositoryInterface $module_country,
		Filesystem $filesystem
	){

		$this->module = $module;

		$this->module_country = $module_country;

		$this->file = $filesystem;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];
		$limit = 0 ;
		$offset = 0;



		//for module name
		if(Input::get('name')){

			$criteria['module_name'] = Input::get('name');
		}

		//for area
		if(Input::get('area')){

			$criteria['subject_area_name'] = Input::get('area');
		}

		//for subject
		if(Input::get('subject')){

			$criteria['subject_name'] = Input::get('subject');
		}

		//for grade
		if(Input::get('grade_id')){
			$criteria['grade_id'] = Input::get('grade_id');
		}

		//TODO: Need fix for module_countries. Following code is a band-aid fix.
		$criteria['country_id'] = 840;

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}
//		dd($this->module_country->getModuleCountries($criteria,$limit,$offset));

		//get module list with relation to subject,subject_area,grade
		return $this->respondWithData($this->module_country->getModuleCountries($criteria , $limit, $offset ));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param AdminModuleRequest $request
	 * @return Response
	 */
	public function store(AdminModuleRequest $request)
	{
		$data = $request->only('subject_id','subject_area_id','name','code','description','common_core_area',
			'curriculum_country','common_core_url','status','points_to_unlock','points_to_finish','image','is_dynamic','no_difficulty');

		$return = $this->module->addModule($data);

		//TODO: admin icon image.
		if($data['image']){

			$update = NULL;

			$from = config('futureed.icon_image_path');
			$to = config('futureed.icon_image_path_final').'/';

			//check if directory don't exist, it will create new directory
			if (!$this->file->exists(config('futureed.icon_image_path_final'))){

				$this->file->makeDirectory(config('futureed.icon_image_path_final'));
			}

			$image = explode('/',$data['image']);
			$image_type = explode('.',$image[1]);

			$update['original_icon_image'] = $image[1];
			$update['icon_image'] = config('futureed.icon').'_'.$return['id'].'.'.$image_type[1];

			//move image to question directory
			$this->file->move($from.'/'.$image[0],$to.'/'.$return['id']);
			$this->file->move($to.'/'.$return['id'].'/'.$image[1],$to.'/'.$update['icon_image']);

			//add questions_image and original_image_name
			$this->module->updateModule($return['id'],$update);

		}

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
		$module = $this->module->viewModule($id);

		if(!$module){

			return $this->respondErrorMessage(2120);
		}

//		dd($module->toArray());
		return $this->respondWithData($module);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AdminModuleRequest $request)
	{
		$data = $request->only('subject_id','subject_area_id','name','description','common_core_area',
			'curriculum_country','common_core_url','status','points_to_unlock','points_to_finish','image','translatable','is_dynamic','no_difficulty');

		$module = $this->module->viewModule($id);

		if(!$module){

			return $this->respondErrorMessage(2120);
		}

		//update module
		$return = $this->module->updateModule($id,$data);

		//TODO: admin icon image.
		if($data['image']){

			$update = NULL;

			$from = config('futureed.icon_image_path');
			$to = config('futureed.icon_image_path_final').'/';

			//check if directory don't exist, it will create new directory
			if (!$this->file->exists(config('futureed.icon_image_path_final'))){

				$this->file->makeDirectory(config('futureed.icon_image_path_final'));
			}

			$image = explode('/',$data['image']);
			$image_type = explode('.',$image[1]);

			$update['original_icon_image'] = $image[1];
			$update['icon_image'] = config('futureed.icon').'_'.$id.'.'.$image_type[1];

			//move image to question directory
			$this->file->deleteDirectory($to.'/'.$return['id']);
			$this->file->move($from.'/'.$image[0],$to.'/'.$return['id']);
			$this->file->move($to.'/'.$return['id'].'/'.$image[1],$to.'/'.$update['icon_image']);

			//add questions_image and original_image_name
			$this->module->updateModule($id,$update);

		}

		return $this->respondWithData($this->module->viewModule($id));


	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//get module details
		$module = $this->module->viewModule($id);

		//check if module is empty
		if(!$module){

			return $this->respondErrorMessage(2120);
		}

		//check if has module_contents
		if($module['content']->toArray()){

			return $this->respondErrorMessage(2140);
		}

		//check if has question
		if($module['question']->toArray()){

			return $this->respondErrorMessage(2141);
		}

		//delete module
		return $this->respondWithData($this->module->deleteModule($id));

	}

}
