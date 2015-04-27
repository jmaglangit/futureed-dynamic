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
        
         if(!$input['avatar_id'] && !$input['id']){
           
            return $this->setStatusCode(422)
                        ->respondWithData(array(['error_code'=>422,
                                           'field'=>'avatar_id',
                                           'message'=>'missing required field avatar_id'
                                                       
                                         ],
                                         ['error_code'=>422,
                                           'field'=>'id',
                                           'message'=>'missing required field id'
                                         ]));
                        
         }elseif( !$input['avatar_id'] ){
          
            return $this->setStatusCode(422)
                        ->respondWithData(['error_code'=>422,
                                            'field'=>'avatar_id',
                                            'message'=>'missing required field avatar_id'
                                     ]);
        }elseif( !$input['id'] ){
          
            return $this->setStatusCode(422)
                        ->respondWithData(['error_code'=>422,
                                            'field'=>'id',
                                            'message'=>'missing required field id'
                                     ]);
        }else{
            
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
                    
                    return $this->setStatusCode(201)
                        ->respondWithData(['error_code'=>201,
                                            'field'=>'avatar_id',
                                            'message'=>"avatar_id doesn't exist"
                                          ]);
                }
                
                
            }else{
                
                return $this->setStatusCode(201)
                        ->respondWithData(['error_code'=>201,
                                            'field'=>'avatar_id',
                                            'message'=>"id doesn't exist"
                                          ]);
            }
    
         
           
        }
        
    }
    
    
    

}
