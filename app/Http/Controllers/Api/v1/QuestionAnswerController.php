<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface;
use FutureEd\Http\Requests\Api\QuestionAnswerRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class QuestionAnswerController extends ApiController {

    protected $question_answer;

    public function __construct(QuestionAnswerRepositoryInterface $question_answer){

        $this->question_answer = $question_answer;

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function uploadQuestionAnswerImage()
    {
        $input = Input::only('file');
        $now = Carbon::now()->timestamp;
        $return = NULL;
        define('MB',1048576);
        //check if has images uploaded
        if($input['file'])
        {
            if($_FILES['file']['type'] != 'image/jpeg' && $_FILES['file']['type'] != 'image/png'){
                return $this->respondErrorMessage(2142);
            }
            if($_FILES['file']['size'] > 2 * MB){
                return $this->respondErrorMessage(2143);
            }
            //get image_name
            $image = $_FILES['file']['name'];
            //uploads image file
            $input['file']->move(config('futureed.answer_image_path').'/'.$now,$image);
            //return the original name of the image
            $return['image_name'] = $now.'/'.$image;
        }
        return $this->respondWithData($return);
    }

    /**
     *
     */
    public function index(){
        $criteria = [];

        if(Input::get('question_id')){
            $criteria['question_id'] = Input::get('question_id');
        }

        return $this->respondWithData($this->question_answer->getQuestionAnswers($criteria));
    }



}
