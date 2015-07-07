<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\TeachingContent\TeachingContentRepositoryInterface;
use FutureEd\Http\Requests\Api\TeachingContent;
use Illuminate\Support\Facades\Input;

class TeachingContentController extends ApiController {

    protected $teaching_content;

    /**
     * Initialized Teaching Content.
     * @param TeachingContentRepositoryInterface $teachingContentRepositoryInterface
     */
    public function __construct(
        TeachingContentRepositoryInterface $teachingContentRepositoryInterface
    ){
        $this->teaching_content = $teachingContentRepositoryInterface;
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
    public function store(TeachingContent $request)
    {
        $data = $request->all();
        return $this->respondWithData(
            $this->teaching_content->addTeachingContent($data)
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
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(TeachingContent $request,$id)
    {
        $data = $request->all();
        return $this->respondWithData(
            $this->teaching_content->updateTeachingContent($id,$data)
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
