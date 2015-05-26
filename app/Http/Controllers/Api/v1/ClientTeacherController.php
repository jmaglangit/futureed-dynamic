<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;


use FutureEd\Services\ErrorServices as Errors;

use FutureEd\Http\Requests\Api\ClientTeacherRequest;

use FutureEd\Models\Repository\Client\ClientRepositoryInterface as Client;

use Illuminate\Support\Facades\Input;

class ClientTeacherController extends ApiController {

    protected $client;

    public function __construct(Client  $client){

        $this->client = $client;

    }



	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $criteria = array();
        $limit = 0;

        if(Input::get('limit')){

            $limit =  Input::get('limit');

        }

        if(Input::get('name')){

            $criteria['name'] = Input::get('name');

        }

        if(Input::get('email')){

            $criteria['email'] = Input::get('email');
        }

        $teacher = $this->client->getTeacherDetails($criteria,$limit);

        return $this->respondWithData($teacher);


	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ClientTeacherRequest $request){

        $data = $request    



	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $teacher = $this->client->getClientByUserId($id);

        if(!$teacher){

            return $this->respondErrorMessage(2001);

        }



        return $this->respondWithData($teacher);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
