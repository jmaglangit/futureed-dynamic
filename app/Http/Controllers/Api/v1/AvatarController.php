<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services\AvatarServices;
use FutureEd\Services\StudentServices;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class AvatarController extends ApiController {
    
    public function selectAvatars(){
        
        $input = Input::only('gender');
        
        $this->addMessageBag($this->gender($input,'gender'));

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }

                    $avatar= $this->avatar->getAvatars($input['gender']);
                    return $this->respondWithData($avatar);
    }
    
    public function saveUserAvatar(){
        
        $input = Input::only('avatar_id','id');

        $this->addMessageBag($this->validateNumber($input,'avatar_id'));
        $this->addMessageBag($this->validateNumber($input,'id'));

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }
        

            $idExist = $this->student->checkIdExist($input['id']);
            
            if($idExist){
                
                $avatarExist = $this->avatar->checkAvatarExist($input['avatar_id']);
                
                if($avatarExist){
                    
                    $return =  $this->student->saveStudentAvatar($input);
        
                    if($return){
                        
                        $avatar = $this->avatar->getAvatar($input['avatar_id']);
                        $avatar_url=$this->avatar->getAvatarUrl($avatar['avatar_image']);

                        $reponse = ['id'=> $avatar['id'],
                                    'name' => $avatar['avatar_image'],
                                    'url' =>$avatar_url
                                   ];
                        
                        return $this->respondWithData($reponse);
                    }
                }else{
                    
                    return $this->respondErrorMessage(2009);
                }
            }else{
                
                return $this->respondErrorMessage(2001);
            }
    
         
           

    }
    
    
    

}
