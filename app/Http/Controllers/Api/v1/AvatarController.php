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
        
        
        if(!$input['gender']){

            return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                         'message'=>'Parameter validation failed'
                                     ]);

        }else{
            
            if($this->avatar->genderCheck($input['gender'])===true){
                    $avatar= $this->avatar->getAvatars($input['gender']);
                    return $this->respondWithData($avatar);
            }
            else{
                return $this->setStatusCode(202)
                            ->respondWithData(['error_code'=>202,
                                               'message'=>'invalid gender']);
            }
        }
        
        
    }
    
    public function saveUserAvatar(){
        
        $input = Input::only('avatar_id','id');
        
         if( !$input['avatar_id'] ){
          
            return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                         'message'=>'Empty avatar_id'
                                     ]);
        }else if( !$input['id'] ){
          
            return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                         'message'=>'Empty id'
                                     ]);
        }else{
            
            $idExist = $this->student->checkIdExist($input['id']);
            
            if($idExist){
                
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
                
                return $this->setStatusCode(201)
                        ->respondWithError(['error_code'=>201,
                                         'message'=>"id doens't exist"
                                          ]);
            }
    
         
           
        }
        
    }
    
    
    

}
