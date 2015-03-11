<?php namespace FutureEd\Http\Controllers;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Flysystem\Exception;

class StudentController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        try{
            $status = 200;
            //authenticate user
            $response = '';
        }catch (Exception $e){
            $status = 400;
            $response = $e->getMessage();
        }
        return [
            'status' => $status,
            'response' => $response
        ];

	}

    public function Email(){
        //return view

    }

    public function Password(){
        //return success
        $input = \Request::input('email');
        dd($input);
        try{

            //check if email exist
            //if exist load image password
            $status = 200;
            $response = 'email exist';
        }catch (Exception $e){
            //return error
            $status = 400;
            $response = 'email not exist';
        }

        //check user with password
        return [
            'status' => $status,
            'response' => $response
        ];
    }

    public function register(){

    }

    public function store(){

    }



}
