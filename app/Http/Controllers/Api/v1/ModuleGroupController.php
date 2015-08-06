<?php
namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\ModuleGroupRequest;
use FutureEd\Models\Repository\ModuleGroup\ModuleGroupRepository;
use Illuminate\Support\Facades\Input;

class ModuleGroupController extends ApiController{

    protected $module_group;

    public function __construct(ModuleGroupRepository $module_group){
        $this->module_group = $module_group;
    }

	//TODO: Remove age_group requirement.

    /**
     * Display list of Age Group.
     *
     * @return Response
     */
    public function index()
    {
        $criteria = [];

        if(Input::get('module_name')){
            $criteria['module_name'] = Input::get('module_name');
        }

        if(Input::get('age_group')){
            $criteria['age_group'] = Input::get('age_group');
        }

        if (Input::get('module_id')) {
           $criteria['module_id'] = Input::get('module_id');
        }

        $limit = (Input::get('limit')) ? Input::get('limit') : 0;
        $offset = (Input::get('offset')) ? Input::get('offset') : 0;

        return $this->respondWithData(
            $this->module_group->getModuleGroups($criteria,$limit,$offset)
        );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ModuleGroupRequest $request)
    {
        $input = $request->all();
        $result = $this->module_group->addModuleGroup($input);
        return $this->respondWithData($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->respondWithData($this->module_group->getModuleGroup($id));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(ModuleGroupRequest $request, $id)
    {
        $input = $request->all();
        $result = $this->module_group->updateModuleGroup($id,$input);
        return $this->respondWithData($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->respondWithData($this->module_group->deleteModuleGroup($id));
    }
}