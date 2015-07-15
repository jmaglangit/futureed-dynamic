<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\ModuleContent\ModuleContentRepositoryInterface;
use FutureEd\Models\Repository\TeachingContent\TeachingContentRepositoryInterface;
use FutureEd\Http\Requests\Api\TeachingContentRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Filesystem\Filesystem;

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

	protected $file;

    /**
     * Initialized Teaching Content.
     * @param TeachingContentRepositoryInterface $teachingContentRepositoryInterface
     */
    public function __construct(
        TeachingContentRepositoryInterface $teachingContentRepositoryInterface,
		ModuleContentRepositoryInterface $moduleContentRepositoryInterface,
		Filesystem $file
    ){

		$this->teaching_content = $teachingContentRepositoryInterface;
		$this->module_content = $moduleContentRepositoryInterface;
		$this->file = $file;
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
		$data['seq_no'] = $this->module_content->getModuleContentCount($data['module_id']) +1;

		$this->module_content->addModuleContent($data);

		//have image
		if($data['image'] && $data['media_type_id'] == 3){

			$update = NULL;

			$from = config('futureed.content_image_path');
			$to = config('futureed.content_image_path_final').'/'.$teaching_content->id;

			//check if directory don't exist, it will create new directory
			if (!$this->file->exists(config('futureed.content_image_path_final'))){

				$this->file->makeDirectory(config('futureed.content_image_path_final'));
			}

			$image = explode('/',$data['image']);
			$image_type = explode('.',$image[1]);

			$update['original_image_name'] = $image[1];
			$update['content_url'] = config('futureed.content').'_'.$teaching_content->id.'.'.$image_type[1];

			//move image to content directory
			$this->file->move($from.'/'.$image[0],$to);
			$this->file->copy($to.'/'.$image[1],$to.'/'.$update['content_url']);


			//add content_url and original_image_name
			$this->teaching_content->updateTeachingContent($teaching_content->id,$update);

		}


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

		if($data['image'] && $data['media_type_id'] == 3){

			$from = config('futureed.content_image_path');
			$to = config('futureed.content_image_path_final').'/'.$id;

			$image = explode('/',$data['image']);
			$image_type = explode('.',$image[1]);

			$data['original_image_name'] = $image[1];
			$data['content_url'] = config('futureed.content').'_'.$id.'.'.$image_type[1];

			$this->file->deleteDirectory($to);
			$this->file->move($from.'/'.$image[0],$to);
			$this->file->copy($to.'/'.$image[1],$to.'/'.$data['content_url']);

		}

		//update teaching_content
		$this->teaching_content->updateTeachingContent($id,$data);

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
