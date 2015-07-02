<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\HelpRequestRequest;
use FutureEd\Models\Repository\HelpRequest\HelpRequestRepositoryInterface;
use Illuminate\Support\Facades\Input;

class HelpRequestController extends ApiController{

    protected $help_request;

    public function __construct(HelpRequestRepositoryInterface $help_request){
        $this->help_request = $help_request;
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
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->respondWithData($this->help_request->deleteHelpRequest($id));
    }
}