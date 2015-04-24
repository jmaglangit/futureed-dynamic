<?php namespace FutureEd\Http\Controllers\Api\Traits;

use Illuminate\Support\Facades\Validator;

trait ClientValidatorTrait {

    // use ErrorMessageTrait;

    // public $messageBag = [];

    // public function setMessageBag($message){
    // 	$this->messageBag = $message;
    // 	return $this;
    // }
    // public function getMessageBag(){
    //     return $this->messageBag;
    // }

    // public function addMessageBag($message){

    //     if(empty($this->messageBag) && !empty($message)){
    //         $this->setMessageBag([$message]);
    //     } elseif(!empty($message) ) {
    //         $this->messageBag = array_merge(
    //             $this->getMessageBag(),
    //             [$message]
    //         );
    //     }
    // }
    // //Check parameters of the fields.
    // public function parameterCheck($input, $paramName){

    //     if(is_null($input["$paramName"])){

    //         return $this->setErrorCode(1001)
    //             ->setField($paramName)
    //             ->setMessage("Required field not found.")
    //             ->errorMessage();


    //     } elseif(empty($input["$paramName"])){

    //         return  $this->setErrorCode(1002)
    //             ->setField($paramName)
    //             ->setMessage("Empty required field.")
    //             ->errorMessage();
    //     }

    // }
    //Validate Email
    public function clientEmail($input, $email){

    	// if(is_null($input['email']) || empty($input['email'])){

    	// 	return $this->parameterCheck($input,$email);
    	// }
    	echo "string";
    }
}