<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ClientParentController extends ApiController {

	public function getStudentList($id){

        $parent_role = config('futureed.parent');

        $this->addMessageBag($this->validateVarNumber($id));

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }


        $stud_list = $this->client->checkClient($id,$parent_role);

        if(is_null($stud_list)){

            return $this->respondErrorMessage(2010);
        }

        $students = $this->student->getStudentByParent($id);

		//check if parent has student
		if(!$students){

	      return $this->respondErrorMessage(2130);
        }

        foreach ($students as $key => $value) {

            $avatar[] = $this->avatar->getAvatar($value['avatar_id']);

        }

        foreach ($avatar as $key => $value) {

           $url = $this->avatar->getAvatarThumbnailUrl($value['avatar_image']);

           $students[$key]['url'] = $url;


        }      

        return $this->respondWithData($students);
    }

}
