<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\ModuleContent\ModuleContentRepositoryInterface;
use FutureEd\Models\Repository\TeachingContent\TeachingContentRepositoryInterface;
use FutureEd\Http\Requests\Api\TeachingContentRequest;
use Illuminate\Support\Facades\Input;

class TeachingContentController extends ApiController {

	/**
	 * Initialize teaching_content
	 * @var TeachingContentRepositoryInterface
	 */
    protected $teaching_content;

	/**
	 * Initialize module_content
	 * @var ModuleContentRepositoryInterface
	 */
	protected $module_content;

    /**
     * Initialized Teaching Content.
     * @param TeachingContentRepositoryInterface $teachingContentRepositoryInterface
     */
    public function __construct(
        TeachingContentRepositoryInterface $teachingContentRepositoryInterface,
		ModuleContentRepositoryInterface $moduleContentRepositoryInterface
    ){

		$this->teaching_content = $teachingContentRepositoryInterface;
		$this->module_content = $moduleContentRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $criteria = [];

        if(Input::get('teaching_module')){
            $criteria['teaching_module'] = Input::get('teaching_module');
        }

        if(Input::get('teaching_module_id')){
            $criteria['teaching_module_id'] = Input::get('teaching_module_id');
        }

        if(Input::get('learning_style')){
            $criteria['learning_style'] = Input::get('learning_style');
        }

        $limit = (Input::get('limit')) ? Input::get('limit') : 0;
        $offset = (Input::get('offset')) ? Input::get('offset') : 0;

        return $this->respondWithData(
            $this->teaching_content->getTeachingContents($criteria,$limit,$offset)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(TeachingContentRequest $request)
    {
        $data = $request->all();

		$teaching_content = $this->teaching_content->addTeachingContent($data);



		//Add module_contents
		$data['content_id'] = $teaching_content->id;

		//Add seq_no
		$data['seq_no'] = $this->module_content->getCount($data['module_id']) +1;

		$this->module_content->addModuleContent($data);

        return $this->respondWithData(
           $this->teaching_content->getTeachingContent($teaching_content->id)
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

        return $this->respondWithData(
            $this->teaching_content->getTeachingContent($id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(TeachingContentRequest $request,$id)
    {
        $data = $request->all();

		$teaching_content =  $this->teaching_content->updateTeachingContent($id,$data);


		if($request->get('seq_no')){

			$module_content = [ 'seq_no' => $request->get('seq_no')];

			$this->module_content->updateModuleContentByTeachingContent($teaching_content->id,$module_content);
		}

        return $this->respondWithData(
            $this->teaching_content->getTeachingContent($id)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->respondWithData($this->teaching_content->deleteTeachingContent($id));
    }

}
