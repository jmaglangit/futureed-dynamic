<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 5/4/15
 * Time: 5:28 PM
 */

namespace FutureEd\Http\Controllers\Api\Traits;


trait MessageBagTrait {

    public $messageBag = [];

    public function setMessageBag($message){
        $this->messageBag = $message;
        return $this;
    }

    public function getMessageBag(){
        return $this->messageBag;
    }

    public function addMessageBag($message){

        if(empty($this->messageBag) && !empty($message)){
            $this->setMessageBag([$message]);
        } elseif(!empty($message) ) {
            $this->messageBag = array_merge(
                $this->getMessageBag(),
                [$message]
            );
        }
    }

}