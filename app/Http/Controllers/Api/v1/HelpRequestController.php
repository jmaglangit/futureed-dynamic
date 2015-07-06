<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\HelpRequestRequest;
use FutureEd\Models\Repository\HelpRequest\HelpRequestRepositoryInterface;
use FutureEd\Models\Repository\HelpRequestAnswer\HelpRequestAnswerRepositoryInterface;
use Illuminate\Support\Facades\Input;

class HelpRequestController extends ApiController{

    protected $help_request;
    protected $help_request_answer;

    public function __construct(HelpRequestRepositoryInterface $help_request, HelpRequestAnswerRepositoryInterface $help_request_answer){
        $this->help_request = $help_request;
        $this->help_request_answer = $help_request_answer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $criteria = [];

        if(Input::get('module')){
            $criteria['module'] = Input::get('module');
        }

        if(Input::get('subject')){
            $criteria['subject'] = Input::get('subject');
        }
        if(Input::get('subject_area')){
            $criteria['subject_area'] = Input::get('subject_area');
        }
        if(Input::get('status')){
            $criteria['status'] = Input::get('status');
        }
        if(Input::get('student')){
            $criteria['student'] = Input::get('student');
        }
        if(Input::get('title')){
            $criteria['title'] = Input::get('title');
        }
        if(Input::get('link_type')){
            $criteria['link_type'] = Input::get('link_type');
        }
        if(Input::get('order_by_date')){
            $criteria['order_by_date'] = Input::get('order_by_date');
        }

        if(Input::get('student_id') && Input::get('help_request_type')){
            $criteria['student_id'] = Input::get('student_id');
            $criteria['help_request_type'] = Input::get('help_request_type');
        }

        if(Input::get('subject_id')){
            $criteria['subject_id'] = Input::get('subject_id');
        }

        if(Input::get('class_id')){
            $criteria['class_id'] = Input::get('class_id');
        }

        if(Input::get('request_status')){
            $criteria['request_status'] = Input::get('request_status');
        }

        $limit = (Input::get('limit')) ? Input::get('limit') : 0;
        $offset = (Input::get('offset')) ? Input::get('offset') : 0;

        return $this->respondWithData($this->help_request->getHelpRequests($criteria , $limit, $offset ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(HelpRequestRequest $request)
    {
        $data = $request->all();
        $result = $this->help_request->addHelpRequest($data);
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
        return $this->respondWithData($this->help_request->getHelpRequest($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, HelpRequestRequest $request)
    {
        $data = $request->all();
        $result = $this->help_request->updateHelpRequest($id, $data);
        return $this->respondWithData($result);
    }

    /**
     * Remove the specified resource from storage.
     * Will Check if the help request has an help request answer. If it does have at least one, help request can't be deleted.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $help_request_answer = $this->help_request_answer->getHelpRequestAnswerByHelpRequestId($id);
        if(!is_null($help_request_answer)){
            return $this->respondErrorMessage(2137);
        }

        return $this->respondWithData($this->help_request->deleteHelpRequest($id));
    }
}