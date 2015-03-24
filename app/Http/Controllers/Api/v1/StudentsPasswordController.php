<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class StudentsPasswordController extends StudentsController {


    //get password images
    public function getPasswordImages(){

        //get images
        $response = $this->passwordImage->getNewPasswordImages();
        return $this->setStatusCode($response['status'])->respondWithData($response['data']);
    }

}
