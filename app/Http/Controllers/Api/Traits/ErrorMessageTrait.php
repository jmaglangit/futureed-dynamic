<?php namespace FutureEd\Http\Controllers\Api\Traits;


trait ErrorMessageTrait {


    private $error_code = 1000;
    private $field = 'Empty field';
    private $message = 'Empty message';

    public function setErrorCode($error_code){
        $this->error_code = $error_code;
        return $this;
    }

    public function getErrorCode(){
        return $this->error_code;
    }

    public function setField($field){
        $this->field = $field;
        return $this;
    }

    public function getField(){
        return $this->field;
    }

    public function setMessage($message){
        $this->message = $message;
        return $this;
    }

    public function getMessage(){
        return $this->message;
    }

    public function errorMessage(){

        return [
            'error_code' => $this->error_code,
            'field' => $this->field,
            'message' => $this->message
        ];
    }

}