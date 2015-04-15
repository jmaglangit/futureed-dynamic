<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services\AvatarServices;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AvatarController extends ApiController {

	public function __construct(AvatarServices $avatar){

        $this->avatar = $avatar;

    }
    
    public function selectAvatars(){
        
        $input = Input::only('gender');
        
        
        if(!$input['gender']){

            return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                         'message'=>'Parameter validation failed'
                                     ]);

        }else{
        	
			$avatar= $this->avatar->getAvatars($input['gender']);
			return $this->respondWithData($avatar);
        }
        
        
    }

}
