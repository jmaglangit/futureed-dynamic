<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\ModuleContent\ModuleContentRepositoryInterface;
use FutureEd\Models\Repository\TeachingContent\TeachingContentRepositoryInterface;
use FutureEd\Http\Requests\Api\TeachingContentRequest;
use FutureEd\Services\ModuleContentServices;
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
	 * Initialized module_content_services
	 * @var ModuleContentServices
	 */
	protected $module_content_services;

    /**
     * Initialized Teaching Content.
     * @param TeachingContentRepositoryInterface $teachingContentRepositoryInterface
     */
    public function __construct(
        TeachingContentRepositoryInterface $teachingContentRepositoryInterface,
		ModuleContentRepositoryInterface $moduleContentRepositoryInterface,
		ModuleContentServices $moduleContentServices
    ){

		$this->teaching_content = $teachingContentRepositoryInterface;
		$this->module_content = $moduleContentRepositoryInterface;
		$this->module_content_services = $moduleContentServices;
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

		//add sequence

		$last_sequence = $this->module_content->getLastSequenceNo($data['module_id']);

		if(!array_key_exists('seq_no', $data)||$data['seq_no'] > $last_sequence){

			//get last sequence +1 to sequence.
			$seq_no = $last_sequence + 1 ;
			$data = array_merge($data,['seq_no' => $seq_no])  ;

		} else{

			//arrance current sequence
			$current_sequence = $this->module_content_services->updateSequence($data['module_id'],$data['seq_no']);

			//update sequence
			$this->module_content->updateSequence($current_sequence);
		}

		//add teaching_content_id to module.
		$data = array_merge($data,['content_id' => $teaching_content->id]);

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

		//update teaching_content
		$teaching_content = $this->teaching_content->updateTeachingContent($id,$data);



		if(array_key_exists('seq_no', $data)){

			//get current sequence
			$current_sequence = $this->module_content->getModuleContentSequenceNo($id);

			//get last sequence
			$last_sequence = $this->module_content->getLastSequenceNo($teaching_content->module_id);

			$data['seq_no'] = ($data['seq_no'] > $last_sequence)? $last_sequence : $data['seq_no'];


			if($data['seq_no'] <> $current_sequence[0]->seq_no){

				//pull sequence number.
				$pulled = $this->module_content_services->pullSequenceNo($data['module_id'],$current_sequence[0]->seq_no,$current_sequence[0]->id);

				//update sequence
				$this->module_content->updateSequence($pulled);


				//insert sequence number
				$current_sequence = $this->module_content_services->updateSequence($data['module_id'],$data['seq_no']);

				//update sequence
				$this->module_content->updateSequence($current_sequence);

			}

			$this->module_content->updateModuleContent($current_sequence[0]->id, ['seq_no'=> $data['seq_no']]);
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
